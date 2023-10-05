<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\MerchentProductFlashDealRequest;
use App\Models\Ecommerce\Category;
use App\Models\Ecommerce\Product;
use App\Models\Ecommerce\SubCategory;
use App\Models\Ecommerce\Unit;
use App\Models\ProductAffiliateCommission;
use App\Models\ProductCommission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\DataTables;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{

    public function __construct(){
        $this->middleware('merchant');
    }


    public function datatable(){

        $auth_user=Auth::guard('merchant')->user();
        $datas=Product::where('merchant_id',$auth_user->id)->orderBy('id','DESC')->get();

        return DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('thumbnail',function(Product $data){
                $url=$data->thumbnail ? asset("uploads/product/resize/".$data->thumbnail)
                    :default_image();
                return '<img src='.$url.' border="0" width="120" height="50" class="img-rounded" />';
            })
            ->addColumn('current_price', function ($product){
                return default_currency()->currency_code. ' ' . $product->current_price;
            })
            /*Status Column*/
            ->addColumn('status', function ($product) {
                $statusOptions = [
                    1 => 'Published',
                    0 => 'Unpublished',
                ];

                $statusSelect = '<select class="status-select form-control" style="background: #FFE5E5;
                                    padding: 7px;
                                    border: 1px solid transparent;
                                    border-radius: 10px;
                                    color: black;" data-id="' . $product->id . '">';

                foreach ($statusOptions as $value => $label) { // $value = array_key && $label = published or unpublished
                    $selected = $product->status == $value ? 'selected' : '';
                    $statusSelect .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                }
                $statusSelect .= '</select>';
                return $statusSelect;
            })
            ->addColumn('flash_deal', function ($product) {
                return '
                        <button href="#" data-id="'.$product->id.'"
                         type="button"
                         data-toggle="modal" data-target="#flashDealModal"
                         class="FlashDealBtn text-white bg-amber-500 hover:bg-lime-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">'
                    . ($product->flash_deal == 1 ? "Yes" : "No") .
                    '</button>';
            })
            ->addColumn('control_panel', function ($product) {
                return '
                        <button type="button" data-id="'.$product->id.'" class="ControlPanelBtn text-white bg-emerald-500 hover:bg-sky-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                        Control
                    </button>';
            })
            ->addColumn('stock_manager', function ($product) {
                return '
                        <a href="'.route('merchant.product.view', $product->id).'" type="button" class="text-white bg-fuchsia-500 hover:bg-sky-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                        Stock
                    </a>';
            })
            ->addColumn('gallery', function ($product) {
                return '
                        <a href="'.route('merchant.product.view', $product->id).'" type="button" class="text-white bg-pink-500 hover:bg-lime-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                        Gallery
                    </a>';
            })
            ->editColumn('action', function (Product $data) {
                return '
        <div class="flex space-x-4">
            <a href="' . route('merchant.product.view', $data->slug) . '" type="button" class="text-white bg-teal-500 hover:bg-lime-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                View
            </a>
            <a href="' . route('merchant.product.edit', $data->id) . '" type="button" class="text-white bg-purple-500 hover:bg-purple-700 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                Edit
            </a>
            <a href="' . route('merchant.product.delete') . '" type="button" class="delete_item text-white bg-red-500 hover:bg-red-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                Delete
            </a>
        </div>
    ';
            })

            ->rawColumns(['thumbnail', 'current_price', 'status','action', 'flash_deal', 'control_panel', 'stock_manager', 'gallery'])
            ->make(true);
    }


    public function index()
    {
        return view('merchant.product.index');
    }

    public function create(){
        $categories=Category::where('status',1)->latest()->get();
        $units=Unit::where('status',1)->latest()->get();
        return view('merchant.product.create',compact('categories','units'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|max:255',
            'short_description'=>'required',
            'weight'=>'required',
            'category_id'=>'required',
            'sub_category_id'=>'nullable',
            'unit_id'=>'required',
            'purchase_price'=>'required',
            'previous_price'=>'required',
            'current_price'=>'required',
            'previous_coin'=>'required',
            'current_coin'=>'required',
            'delivery_charge_in_dhaka'=>'required',
            'delivery_charge_out_dhaka'=>'required',
            'thumbnail'=>'required',
            'description'=>'nullable',
            'reseller_commission'=>'required_if:is_reseller,1',
            'company_commission'=>'required_if:is_reseller,1',
            'company_commission_af'=>'required_if:is_affiliate,1',
            'affiliate_commission'=>'required_if:is_affiliate,1',
        ]);
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{
                //Product create
                $auth_user=Auth::guard('merchant')->user();
                $product = new Product();
                $product->title             = $request->title;
                $product->short_description =$request->short_description;
                $product->category_id       = $request->category_id;
                $product->unit_id = $request->unit_id;
                $product->purchase_price    = $request->purchase_price;
                $product->previous_price    = $request->previous_price;
                $product->current_price     = $request->current_price;
                $product->previous_coin    = $request->previous_coin;
                $product->current_coin     = $request->current_coin;
                $product->delivery_charge_in_dhaka= $request->delivery_charge_in_dhaka;
                $product->delivery_charge_out_dhaka= $request->delivery_charge_out_dhaka;
                $product->weight            = $request->weight;
                $product->description       = $request->description;
                $product->product_code       =rand(10000, 99999);
                $product->merchant_id=$auth_user->id;
                $product->is_reseller = $request->is_reseller;
                $product->is_affiliate = $request->is_affiliate;

                if ($request->sub_category_id)
                {
                    $product->sub_category_id   = $request->sub_category_id;
                }

                if($request->hasFile('thumbnail')){
                    $image=$request->thumbnail;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                    $original_image_path = public_path().'/uploads/product/original/'.$image_name;
                    $resize_image_path = public_path().'/uploads/product/resize/'.$image_name;
                    //Resize Image
                    Image::make($image)->save($original_image_path);
                    Image::make($image)->resize(250,200)->save($resize_image_path);
                    $product->thumbnail = $image_name;

                }
                $product->save();

                /*Insert Data into Product_Commissions Table*/
                if ($request->is_reseller == 1) {
                    $product_commission = new ProductCommission();
                    $product_commission->product_id = $product->id;
                    $product_commission->reseller_commission = $request->reseller_commission;
                    $product_commission->company_commission = $request->company_commission;
                    $product_commission->save();
                }
                /*Insert Data into Product Affiliate_Commissions Table*/
                if ($request->is_affiliate == 1) {
                    $product_affiliate_com = new ProductAffiliateCommission();
                    $product_affiliate_com->product_id = $product->id;
                    $product_affiliate_com->affiliate_commission = $request->affiliate_commission;
                    $product_affiliate_com->company_commission = $request->company_commission_af;
                    $product_affiliate_com->save();
                }


                $data=Product::findOrFail($product->id);
                $data->slug = Str::slug($request->title,'-').'-'.strtolower(Str::random(3).$data->id.Str::random(3));
                $data->save();

                DB::commit();
                return \response()->json([
                    'message' => 'Successfully added',
                    'status_code' => 200,
                    'type'=>'success',
                ], Response::HTTP_OK);

            }catch (QueryException $e){
                DB::rollBack();
                $error = $e->getMessage();
                return \response()->json([
                    'error' => $error,
                    'status_code' => 500,
                    'type'=>'error',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

    }

    /*
     * View Merchant Product Details
    */
    public function view($slug)
    {
        $product = Product::where('slug', $slug)->where('merchant_id', \auth()->guard('merchant')->id())->first();

        return  view('merchant.product.details', compact('product'));
    }

    public function edit($id)
    {

        $categories=Category::where('status',1)->latest()->get();
        $units=Unit::where('status',1)->latest()->get();
        $product=Product::find($id);
        $subcategories = SubCategory::where('category_id',$product->category_id)->get();
        return view('merchant.product.edit',compact("product","categories","units","subcategories"));
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|max:255',
            'short_description'=>'required',
            'weight'=>'required',
            'category_id'=>'required',
            'sub_category_id'=>'nullable',
            'unit_id'=>'required',
            'purchase_price'=>'required',
            'previous_price'=>'required',
            'current_price'=>'required',
            'previous_coin'=>'required',
            'delivery_charge_in_dhaka'=>'required',
            'delivery_charge_out_dhaka'=>'required',
            'current_coin'=>'required',
            'thumbnail'=>'nullable',
            'description'=>'nullable',
        ]);

        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{
                //Product create

                $product =Product::findOrFail($request->id);
                $product->title             = $request->title;
                $product->short_description =$request->short_description;
                $product->category_id       = $request->category_id;
                $product->unit_id           = $request->unit_id;
                $product->purchase_price    = $request->purchase_price;
                $product->previous_price    = $request->previous_price;
                $product->current_price     = $request->current_price;
                $product->previous_coin     = $request->previous_coin;
                $product->current_coin      = $request->current_coin;
                $product->weight            = $request->weight;
                $product->description       = $request->description;
                $product->delivery_charge_in_dhaka= $request->delivery_charge_in_dhaka;
                $product->delivery_charge_out_dhaka= $request->delivery_charge_out_dhaka;
                if ($request->sub_category_id)
                {
                    $product->sub_category_id   = $request->sub_category_id;
                }
                if($request->hasFile('thumbnail')){

                    $image=$request->thumbnail;

                    if (File::exists(public_path('/uploads/product/original/'.$product->thumbnail)))
                    {
                        File::delete(public_path('/uploads/product/original/'.$product->thumbnail));
                    }
                    if (File::exists(public_path('/uploads/product/resize/'.$product->thumbnail)))
                    {
                        File::delete(public_path('/uploads/product/resize/'.$product->thumbnail));
                    }

                    $image_name          =strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                    $original_image_path = public_path().'/uploads/product/original/'.$image_name;
                    $resize_image_path    = public_path().'/uploads/product/resize/'.$image_name;

                    //Resize Image
                    Image::make($image)->save($original_image_path);
                    Image::make($image)->resize(465,465)->save($resize_image_path);
                    $product->thumbnail = $image_name;
                }
                $product->save();
                DB::commit();
                return \response()->json([
                    'message' => 'Successfully Updated',
                    'status_code' => 200,
                    'type'=>'success',
                ], Response::HTTP_OK);

            }catch (QueryException $e){
                DB::rollBack();
                $error = $e->getMessage();
                return \response()->json([
                    'error' => $error,
                    'status_code' => 500,
                    'type'=>'error',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    /*
     * */
    public function updateStatus(Request $request)
    {
        try {
            DB::beginTransaction();
            $product = Product::find($request->id);
            $product->status = $product->status == 1 ? 0 : 1;
            $product->save();
            DB::commit();
            return \response()->json([
               'message' => 'Status Updated',
               'response' => Response::HTTP_OK,
               'type' => 'success'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return \response()->json([
                'message' => $exception->getMessage(),
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'type' => 'error'
            ]);
        }
    }

    /**
     * Get Product Meta Information
    */
    public function getMetaInfo(Request $request)
    {
        $product = Product::find($request->id);

        return \response()->json($product->flash_deal);
    }

    /**
     * Store Flash Deal
    */
    public function storeFlashDeal(MerchentProductFlashDealRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $product = Product::find($request->product_id);
            $product->flash_deal = $request->flashDealStatus;
            $product->deal_start_date = $request->startDate;
            $product->deal_end_date = $request->endDate;
            $product->deal_amount = $request->amount;
            $product->deal_type = $request->dealType;
            $product->save();

            DB::commit();
            return \response()->json([
                'message' => 'Successfully Done',
                'response' =>  Response::HTTP_OK,
                'type' => 'success'
            ]);

        } catch (QueryException $e) {
            DB::rollBack();
            return \response()->json([
                'message' => $e->getMessage(),
                'response' =>  Response::HTTP_INTERNAL_SERVER_ERROR,
                'type' => 'error'
            ]);
        }
    }

    /**
     * Get Product
    */
    public function getProduct(Request $request)
    {
        $product = Product::find($request->id);

        return \response()->json($product);
    }
}
