<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\AffiliateSetting;
use App\Models\CompanyCommission;
use App\Models\DueProduct;
use App\Models\Ecommerce\Product;
use App\Models\GameAssetCommission;
use App\Models\SellerProduct;
use App\Models\SellerProductBuyHistory;
use App\Models\Settings;
use App\Models\TopSellerCommission;
use App\Models\User;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Collection;


class ManageProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('seller');
    }
    public function datatable()
    {
        $auth_user=Auth::guard('seller')->user();

        $datas = Product::where(['status'=>1,'is_reseller'=>1])->orderBy('id','DESC')->get();

        return DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('thumbnail',function(Product $data){
                $url = $data->thumbnail ? asset("uploads/product/small/".$data->thumbnail)
                    : default_image();
                return '<img src='.$url.' border="0" width="120" height="50" class="img-rounded" />';
            })
            ->editColumn('merchant',function(Product $data){
                return '<div><p>Name: '.$data->merchant->name ?? "".'</p></div>';
            })
            ->editColumn('action',function(Product $data){
                return '
                       <a href="'.route('seller.merchant.product.details', $data->id).'"  class="delete_item text-white bg-purple-600 hover:bg-purple-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                            View Detail
                        </a>
                        <a href="javascript:;" data-action="'.route('seller.product.add_to_store').'" item_id="'.$data->id.'" type="button" class="add_to_store text-white bg-cyan-600 hover:bg-cyan-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                            Add To My Shop
                        </a>
                        ';
            })
            ->rawColumns(['thumbnail','merchant','action'])
            ->make(true);
    }

    public function index(){

        return view('seller.product.index');
    }

    /**
     * Store Merchant reseller allow product
     * to seller products
     */
    public function add_to_store(Request $request): JsonResponse
    {
        try {
            $auth_user = get_auth_seller();

            /*Get Product From DB*/
            $product = Product::find($request->item_id);

            $checker = SellerProduct::where(['seller_id'=>$auth_user->id,'product_id'=> $product->id])->first();

            $product_in_due_product = DueProduct::where(['seller_id' => $auth_user->id, 'status' => 1])->first();

            if (is_null($checker)){ // if product not in seller table then store it
                DB::beginTransaction();

                // Seller Product Purchase Control
                if (isset($auth_user->user_id)) {
                    // VIP Product Purchase Price
                    if ($auth_user->user->rank->priority != 0) {
                        $sellerProductPurchaseCharge = setting()->seller_product_purchase_charge_when_user_vip;
                    } else {
                        $sellerProductPurchaseCharge = setting()->seller_product_purchase_charge;

                        $countSellerProduct = DB::table('seller_products')->where('seller_id', $auth_user->id)->count();
                        if ($countSellerProduct >= getAffiliateSetting()->seller_user_rank_upgrade_require_product) {
                            $user = User::find($auth_user->user_id);
                            if ($user->rank->priority != 1) {
                                $previousRank = $user->rank_id;

                                $user->rank_id = DB::table('ranks')->where('priority', 1)->value('id');
                                $user->next_rank_id = DB::table('ranks')->where('priority', 2)->value('id');
                                $user->save();

                                DB::table('rank_update_histories')->insert([
                                    'user_id' => $auth_user->user_id,
                                    'previous_rank_id' => $previousRank,
                                    'current_rank_id' => $user->rank_id,
                                    'type' => 'seller_update',
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ]);
                            }
                        }

                    }
                } else {
                    // General Product Purchase Price
                    $sellerProductPurchaseCharge = setting()->seller_product_purchase_charge;
                }

                // If seller has due product
                if (isset($product_in_due_product) && $product_in_due_product->status == 1){
                    $product_in_due_product->status = 0;
                    $product_in_due_product->save();
                }
                // If no due product, balance will deduct
                elseif ($auth_user->balance >= $sellerProductPurchaseCharge ) {
                    $auth_user->balance -= $sellerProductPurchaseCharge;
                    $auth_user->save();

                    /*Distribute the Seller Product Purchase Charge below users*/

                    // Give Company Commission
                    companyCommission(calculatePercentage(number: $sellerProductPurchaseCharge, percentage: affiliateSetting()->company_commission),COMMISSION_SOURCE['seller']);

                    // Give Game Asset Commission
                    gameAssetCommission(calculatePercentage(number: $sellerProductPurchaseCharge, percentage: affiliateSetting()->game_asset_commission),COMMISSION_SOURCE['seller']);

                    // Give To Seller Commission
                    topSellerCommission(calculatePercentage(number: $sellerProductPurchaseCharge, percentage: affiliateSetting()->top_seller_commission),COMMISSION_SOURCE['seller']);

                    if ($auth_user->user_id !=null){
                        $generation_amount=calculatePercentage($sellerProductPurchaseCharge,affiliateSetting()->generation_commission);
                        provide_generation_commission_seller($auth_user->user,$generation_amount,COIN_EARNING_SOURCE['generation_commission']);
                    }


                    /**
                     * @TODO Generation Commission & Shareholder Commission
                    */

                    /*Insert Record Into Seller Product Buy History*/
                    SellerProductBuyHistory::create([
                        'seller_id' => $auth_user->id,
                        'merchant_id' => $product->merchant_id,
                        'product_id' => $request->item_id,
                        'amount' => $sellerProductPurchaseCharge,
                    ]);
                } else {
                    return response()->json([
                        'data'=>'Insufficient Balance Or No Due Product Left.',
                        'type'=>'warning',
                        'status'=>201
                    ],Response::HTTP_OK);
                }
                $data=new SellerProduct();
                $data->seller_id=$auth_user->id;
                $data->product_id=$request->item_id;
                $data->seller_price = $product->current_price; // Set Default Price
                $data->coin_from_merchant = $product->current_coin; // Set merchant product current coin
                $data->save();
                DB::commit();
                return response()->json([
                    'data'=>'Successfully added',
                    'type'=>'success',
                    'status'=>200
                ]);
            }else{
                return response()->json([
                    'data'=>'You have already added',
                    'type'=>'warning',
                    'status'=>201
                ]);
            }
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json([
                'data'=>$exception->getMessage(),
                'type'=>'error',
                'status'=>500
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function shop_datatable(){
        $auth_user=Auth::guard('seller')->user();
        $datas=SellerProduct::where('seller_id',$auth_user->id)->orderBy('id','DESC')->get();

        return DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('thumbnail',function(SellerProduct $data){
                $url=$data->product->thumbnail ? asset("uploads/product/small/".$data->product->thumbnail)
                    :default_image();
                return '<img src='.$url.' border="0" width="120" height="50" class="img-rounded" />';
            })
            ->editColumn('product_name',function(SellerProduct $data){
                return $data->product->title;
            })
            ->addColumn('config', function (SellerProduct $data){
                return '
                    <button data-id="'.$data->id.'" type="button" data-bs-toggle="modal"  class="ConfigBtn text-white bg-lime-500 hover:bg-red-950 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                             Config
                     </button>
                ';
            })
            ->addColumn('view-details', function (SellerProduct $data){
                return '
                    <a href="'.route('seller.product.view', $data->product_id).'" type="button" class="text-white bg-blue-700 hover:bg-blue-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                             View
                     </a>
                ';
            })
            ->editColumn('action',function(SellerProduct $data){
                $seller=Auth::guard('seller')->user();
                return '<a href="javascript:;" data-id="'.$data->id.'" class="delete_item text-white bg-red-500 hover:bg-red-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                             Remove
                         </a>
                         <a href="javascript:;" share_link="'.route('front.product_detail',['id'=>$data->product_id,'seller_or_affiliate'=>$seller->seller_number,'type'=>'seller']).'" class="copy_link text-white bg-purple-600 hover:bg-purple-700 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                             Copy Link
                         </a>
                         ';
            })
            ->rawColumns(['thumbnail','product_name', 'config', 'view-details','action'])
            ->make(true);


    }
    public function shop(): View
    {
        return view('seller.product.shop');
    }

    /**
     * Get Seller Product Details
     */
    public function details(Request $request): JsonResponse
    {
        $seller_product = SellerProduct::select('id', 'seller_price', 'seller_company_commission', 'product_id')->find($request->sellerProductId);

        /*Add Min Price*/
        $seller_product->min_price = $seller_product->product->current_price;

        return \response()->json($seller_product);
    }

    /**
     * Store Seller Configuration
     */
    public function configStore(Request $request): JsonResponse
    {
        $request->validate([
            'sellerProductId' => 'required|integer',
            'seller_price' => 'required|numeric|min:1',
            'seller_company_commission' => 'required|numeric|min:0|max:100',
        ]);
        try {
            DB::beginTransaction();
            $seller_product = SellerProduct::find($request->sellerProductId);
            $seller_product->seller_price = $request->seller_price;
            $seller_product->seller_company_commission = $request->seller_company_commission;

            /*Calculate Coin from seller*/
            $price_diff = $request->seller_price -  $seller_product->product->current_price;
            $seller_product->coin_from_seller = ((($price_diff * $request->seller_company_commission) / 100) * setting()->coin_per_dollar);
            $seller_product->save();
            DB::commit();
            return \response()->json([
                'type' => 'success',
                'response' => Response::HTTP_OK,
                'message' => 'Product Configured Successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return \response()->json([
                'type' => 'error',
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage()
            ]);

        }
    }

    /**
     * View Product Detail
     */
    public function viewProduct($id): View //id is products table product id
    {
        $product = Product::find($id);

        $sellerProduct = SellerProduct::where('product_id', $product->id)
            ->where('seller_id', \auth()->guard('seller')->id())->first();

        return  view('seller.product.details', compact('product', 'sellerProduct'));
    }

    /**
     * Delete PRoduct
     */
    public function deleteProduct(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $sellerProduct = SellerProduct::find($request->sellerProductId);
            $sellerProduct->delete();
            return \response()->json([
                'message' => 'Product Remove Successfully',
                'response' => Response::HTTP_OK,
                'type' => 'success'
            ]);
        }
        return \response()->json(null);
    }

    /**
     *  Get Details of Merchant Product
     */
    public  function merchantProductDetail($id): View
    {
        $product = Product::find($id);

        return  view('seller.product.merchant-product-details', compact('product'));
    }

}
