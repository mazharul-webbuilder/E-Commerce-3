<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\AffiliatorProduct;
use App\Models\Ecommerce\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ManageProductController extends Controller
{

    public function __construct(){
        $this->middleware('affiliate');
    }

    public function datatable(){
        $datas=Product::where('is_affiliate',1)->orderBy('id','DESC')->get();

        return DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('thumbnail',function(Product $data){
                $url=$data->thumbnail ? asset("uploads/product/small/".$data->thumbnail)
                    :default_image();
                return '<img src='.$url.' border="0" width="120" height="50" class="img-rounded" />';
            })
            ->editColumn('merchant',function(Product $data){
                return '<div><p>Name:'.$data->merchant->name ?? "".'</p></div>';
            })
            ->editColumn('action',function(Product $data){
                return '
                        <a href="'.route('affiliate.merchant.product.details', $data->id).'"  class="delete_item text-white bg-purple-600 hover:bg-purple-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                            View Detail
                        </a>
                          <a href="javascript:;" data-action="'.route('affiliate.product.add_to_store').'" item_id="'.$data->id.'" type="button" class="add_to_store text-white bg-cyan-600 hover:bg-cyan-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                            Add To My Shop
                        </a>
                                        ';
            })
            ->rawColumns(['thumbnail','merchant','action'])
            ->make(true);
    }
    public function index()
    {

        return view('affiliate.product.index');
    }

    /**/
    public function shop(): View
    {
        return view('affiliate.product.shop');
    }


    /**
     * Get Affiliate Shop Product
    */
    public function shop_datatable(){
        $auth_user=Auth::guard('affiliate')->user();

        $datas=AffiliatorProduct::where('affiliator_id',$auth_user->id)->orderBy('id','DESC')->get();

        return DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('thumbnail',function(AffiliatorProduct $data){
                $url=$data->product->thumbnail ? asset("uploads/product/small/".$data->product->thumbnail)
                    :default_image();
                return '<img src='.$url.' border="0" width="120" height="50" class="img-rounded" />';
            })
            ->editColumn('product_name',function(AffiliatorProduct $data){
                return $data->product->title;
            })
            ->addColumn('view-details', function (AffiliatorProduct $data){
                return '
                    <a href="'.route('affiliate.product.view', $data->product_id).'" type="button" class="text-white bg-blue-700 hover:bg-blue-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                             View
                     </a>
                ';
            })
            ->editColumn('action',function(AffiliatorProduct $data){
                $affiliate = Auth::guard('affiliate')->user();
                return '<a href="javascript:;" data-id="'.$data->id.'" class="delete_item text-white bg-red-500 hover:bg-red-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                             Remove
                         </a>
                         <a href="javascript:;" share_link="'.route('front.product_detail',['id' => $data->product_id,'seller_or_affiliate' => $affiliate->id,'type'=>'affiliate']).'" class="copy_link text-white bg-purple-600 hover:bg-purple-700 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                             Copy Link
                         </a>
                         ';
            })
            ->rawColumns(['thumbnail','product_name', 'view-details','action'])
            ->make(true);


    }

    /**
     *  Get Details of Merchant Product
     */
    public  function merchantProductDetail($id): View
    {
        $product = Product::find($id);

        return  view('affiliate.product.merchant-product-details', compact('product'));
    }


    public function add_to_store(Request $request){

        if ($request->isMethod("POST")){
            try {

                $auth_user=Auth::guard('affiliate')->user();
                $checker=AffiliatorProduct::where(['affiliator_id'=>$auth_user->id,'product_id'=>$request->item_id])->first();

                if (is_null($checker)){
                    $data=new AffiliatorProduct();
                    $data->affiliator_id=$auth_user->id;
                    $data->product_id=$request->item_id;
                    $data->coin_from_merchant = Product::find($request->item_id)->current_coin; // Set merchant product current coin as coin from merchant
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

    /**
     * View Product Detail
     */
    public function viewProduct($id): View //id is products table product id
    {
        $product = Product::find($id);


        return  view('affiliate.product.details', compact('product'));
    }
    /**
     * Delete PRoduct
     */
    public function deleteProduct(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $sellerProduct = AffiliatorProduct::find($request->sellerProductId);
            $sellerProduct->delete();
            return \response()->json([
                'message' => 'Product Remove Successfully',
                'response' => Response::HTTP_OK,
                'type' => 'success'
            ]);
        }
        return \response()->json(null);
    }

}
