<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Product;
use App\Models\SellerProduct;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ManageProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('seller');
    }
    public function datatable()
    {
        $auth_user=Auth::guard('seller')->user();

        $datas = Product::where('is_reseller',1)->orderBy('id','DESC')->get();

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
                       <a href="javascript:;"   type="button" class="delete_item text-white bg-purple-600 hover:bg-purple-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                            View Detail
                        </a>
                        <a href="javascript:;" data-action="'.route('seller.product.add_to_store').'" item_id="'.$data->id.'" type="button" class="add_to_store text-white bg-cyan-600 hover:bg-cyan-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                            Add My Store
                        </a>
                        ';
            })
            ->rawColumns(['thumbnail','merchant','action'])
            ->make(true);
    }

    public function index(){

        return view('seller.product.index');
    }

    public function add_to_store(Request $request){

        if ($request->isMethod("POST")){
            try {

                $auth_user=Auth::guard('seller')->user();
                $checker=SellerProduct::where(['seller_id'=>$auth_user->id,'product_id'=>$request->item_id])->first();

                if (is_null($checker)){
                    $data=new SellerProduct();
                    $data->seller_id=$auth_user->id;
                    $data->product_id=$request->item_id;
                    $data->seller_price = Product::find($request->item_id)->current_price; // Set Default Price
                    $data->save();

                    return response()->json([
                        'data'=>'Successfully added',
                        'type'=>'success',
                        'status'=>200
                    ],Response::HTTP_OK);
                }else{


                    return response()->json([
                        'data'=>'You have already added',
                        'type'=>'warning',
                        'status'=>201
                    ],Response::HTTP_OK);
                }


            }catch (\Exception $exception){
                return response()->json([
                    'data'=>$exception->getMessage(),
                    'type'=>'error',
                    'status'=>500
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
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
                return '<a href="javascript:;" class="delete_item text-white bg-red-500 hover:bg-red-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                             Remove
                         </a>
                         <a href="javascript:;" share_link="'.route('api.product_detail',['id'=>$data->product_id,'seller_or_affiliate'=>$seller->seller_number,'type'=>'seller']).'" class="copy_link text-white bg-purple-600 hover:bg-purple-700 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
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
        $seller_product = SellerProduct::select('id', 'seller_price', 'seller_company_commission')->find($request->sellerProductId);

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
            'seller_company_commission' => 'required|numeric|min:0',
        ]);
        try {
            DB::beginTransaction();
            $seller_product = SellerProduct::find($request->sellerProductId);
            $seller_product->seller_price = $request->seller_price;
            $seller_product->seller_company_commission = $request->seller_company_commission;
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
}
