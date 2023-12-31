<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\MerchentProductFlashDealRequest;
use App\Models\Brand;
use App\Models\Ecommerce\Category;
use App\Models\Ecommerce\Product;
use App\Models\Ecommerce\SubCategory;
use App\Models\Ecommerce\Unit;
use App\Models\ProductAffiliateCommission;
use App\Models\ProductCommission;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\DataTables;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{

    public function __construct(){
        $this->middleware('merchant');
    }


    /**
     * Merchant Product Datatable
    */
    public function datatable(Request $request): JsonResponse
    {
        $request->validate(['filter' => ['required', Rule::in(['all', 'published', 'unpublished'])]]);

        $auth_user=Auth::guard('merchant')->user();

        $datas = null;

        switch ($request->filter) {
            case 'all':
                $datas = Product::where('merchant_id', $auth_user->id)->orderBy('id','DESC')->get();
                break;
            case 'published':
                $datas = Product::where('merchant_id', $auth_user->id)->where('status', 1)->orderBy('id', 'DESC')->get();
                break;
            case 'unpublished':
                $datas = Product::where('merchant_id', $auth_user->id)->where('status', 0)->orderBy('id', 'DESC')->get();
                break;
        }

        return DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('thumbnail',function(Product $data){
                $url=$data->thumbnail ? asset("uploads/product/small/".$data->thumbnail)
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
                        <button href="#" data-id="'.$product->id. '"
                        style="background: #a9b2a7"
                         type="button"
                         data-toggle="modal" data-target="#flashDealModal"
                         class="FlashDealBtn
                         text-black
                         bg-amber-500
                         transition-all
                         ease-in-out font-medium
                         rounded-md text-sm
                         inline-flex items-center
                         px-3 py-2 text-center
                         deleteConfirmAuthor">'
                    . ($product->flash_deal == 1 ? "Yes" : "No") .
                    '</button>';
            })
            ->addColumn('control_panel', function ($product) {
                return '
                        <button type="button" data-id="'.$product->id. '"
                        style="background: #900bd0"
                        class="ControlPanelBtn text-white bg-emerald-500 hover:bg-sky-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                        Control
                    </button>';
            })
            ->addColumn('stock_manager', function ($product) {
                return '
                        <a href="'.route('merchant.stock.index',$product->id). '"
                        type="button"
                        style="background: #ce970b"
                        class="text-white bg-fuchsia-500 hover:bg-sky-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                        Stock
                    </a>';
            })
            ->addColumn('gallery', function ($product) {
                return '
                        <a href="'.route('merchant.gallery.index', $product->id).'" type="button" class="text-white bg-pink-500 hover:bg-lime-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                        Gallery
                    </a>';
            })
            ->editColumn('action', function (Product $data) {
                return '
        <div class="flex space-x-4">
            <a href="' . route('merchant.product.view', $data->slug) . '"
                        style="background: #176c04"
            type="button" class="text-white bg-teal-500 hover:bg-lime-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                View
            </a>
            <a href="' . route('merchant.product.edit', $data->id) . '" type="button"
                        style="background: #900bd0"
            class="text-white bg-purple-500 hover:bg-purple-700 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                Edit
            </a>
            <button type="button" data-id="' . $data->id .'" class="delete_item text-white bg-red-500 hover:bg-red-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                Delete
            </button>
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

        $brands = Brand::where('status', 1)->latest()->get();

        return view('merchant.product.create',compact('categories','units', 'brands'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|max:255',
            'short_description'=>'required',
            'weight'=>'nullable',
            'category_id'=>'required',
            'sub_category_id'=>'nullable',
            'unit_id'=>'nullable',
            'purchase_price'=>'required',
            'previous_price'=>'required',
            'current_price'=>'required',
            'current_coin'=>'required',
            'company_commission_m'=>'required|numeric',
            'delivery_charge_in_dhaka'=>'required',
            'delivery_charge_out_dhaka'=>'required',
            'thumbnail'=>'required',
            'description'=>'nullable',
            'is_reseller' => 'required|in:0,1',
            'reseller_commission' => 'nullable|required_if:is_reseller,1|numeric|min:1|max:100',
            'is_affiliate' => 'required|in:0,1',
            'affiliate_commission' => 'nullable|required_if:is_affiliate,1|numeric|min:1|max:100',
            'brand_id'=>'nullable|integer',
        ],['current_coin.required' => 'Enter Current Price and Company Commission Must.']);
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
                $product->current_coin     = $request->current_coin;
                $product->delivery_charge_in_dhaka= $request->delivery_charge_in_dhaka;
                $product->delivery_charge_out_dhaka= $request->delivery_charge_out_dhaka;
                $product->weight            = $request->weight;
                $product->description       = $request->description;
                $product->product_code       =rand(10000, 99999);
                $product->merchant_id=$auth_user->id;
                $product->is_reseller = $request->is_reseller;
                $product->is_affiliate = $request->is_affiliate;
                $product->company_commission = $request->company_commission_m;
                if ($request->brand_id){
                    $product->brand_id = $request->brand_id;
                }
                if ($request->sub_category_id)
                {
                    $product->sub_category_id   = $request->sub_category_id;
                }

                if($request->hasFile('thumbnail')){
                    $image=$request->thumbnail;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                    $original_image_path = public_path().'/uploads/product/original/'.$image_name;
                    $large_image_path = public_path().'/uploads/product/large/'.$image_name;
                    $medium_image_path = public_path().'/uploads/product/medium/'.$image_name;
                    $small_image_path = public_path().'/uploads/product/small/'.$image_name;

                    Image::make($image)->save($original_image_path);
                    /*large = 1080*675*/
                    Image::make($image)->resize(1080,675)->save($large_image_path);
                    /*medium = 512*320*/
                    Image::make($image)->resize(512,320)->save($medium_image_path);
                    /*small = 256*200*/
                    Image::make($image)->resize(256,200)->save($small_image_path);
                    $product->thumbnail = $image_name;

                }
                $product->save();

                /*Insert Data into Product_Commissions Table*/
                if ($request->is_reseller == 1 OR $request->is_affiliate) {
                    $product_commission = new ProductCommission();
                    $product_commission->product_id = $product->id;
                    $product_commission->reseller_commission = $request->reseller_commission;
                    $product_commission->affiliate_commission = $request->affiliate_commission;
                    $product_commission->save();
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

    /**
     * Show Merchant Product Edit Page
    */
    public function edit($id): View
    {
        $categories = Category::where('status',1)->latest()->get();
        $units = Unit::where('status',1)->latest()->get();
        $product = Product::find($id);
        $subcategories = SubCategory::where('category_id',$product->category_id)->get();
        $brands = Brand::where('status', 1)->latest()->get();

        return view('merchant.product.edit',compact("product","categories","units","subcategories", "brands"));
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|max:255',
            'short_description'=>'required',
            'weight'=>'nullable',
            'category_id'=>'required',
            'sub_category_id'=>'nullable',
            'unit_id'=>'nullable',
            'purchase_price'=>'required',
            'previous_price'=>'required',
            'company_commission_m'=>'required|numeric',
            'current_price'=>'required',
            'delivery_charge_in_dhaka'=>'required',
            'delivery_charge_out_dhaka'=>'required',
            'current_coin'=>'required',
            'thumbnail'=>'nullable',
            'description'=>'nullable',
            'is_reseller' => 'required|in:0,1',
            'reseller_commission' => 'nullable|required_if:is_reseller,1|numeric|min:1|max:100',
            'is_affiliate' => 'required|in:0,1',
            'affiliate_commission' => 'nullable|required_if:is_affiliate,1|numeric|min:1|max:100',
            'brand_id'=>'nullable|integer',
        ], ['current_coin.required' => 'Enter Current Price and Company Commission Must.']);

        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{
                //Product create

                $product =Product::findOrFail($request->id);
                $product->title             = $request->title;
                $product->short_description =$request->short_description;
                $product->category_id       = $request->category_id;
                $product->brand_id           = $request->brand_id;
                $product->unit_id           = $request->unit_id;
                $product->purchase_price    = $request->purchase_price;
                $product->previous_price    = $request->previous_price;
                $product->current_price     = $request->current_price;
                $product->current_coin      = $request->current_coin;
                $product->weight            = $request->weight;
                $product->description       = $request->description;
                $product->delivery_charge_in_dhaka= $request->delivery_charge_in_dhaka;
                $product->delivery_charge_out_dhaka= $request->delivery_charge_out_dhaka;
                $product->is_reseller = $request->is_reseller;
                $product->is_affiliate = $request->is_affiliate;
                $product->company_commission = $request->company_commission_m;

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
                    if (File::exists(public_path('/uploads/product/large/'.$product->thumbnail)))
                    {
                        File::delete(public_path('/uploads/product/large/'.$product->thumbnail));
                    }
                    if (File::exists(public_path('/uploads/product/medium/'.$product->thumbnail)))
                    {
                        File::delete(public_path('/uploads/product/medium/'.$product->thumbnail));
                    }
                    if (File::exists(public_path('/uploads/product/small/'.$product->thumbnail)))
                    {
                        File::delete(public_path('/uploads/product/small/'.$product->thumbnail));
                    }

                    $image_name          =strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                    $original_image_path = public_path().'/uploads/product/original/'.$image_name;
                    $large_image_path = public_path().'/uploads/product/large/'.$image_name;
                    $medium_image_path = public_path().'/uploads/product/medium/'.$image_name;
                    $small_image_path = public_path().'/uploads/product/small/'.$image_name;

                    Image::make($image)->save($original_image_path);
                    /*large = 1080*675*/
                    Image::make($image)->resize(1080,675)->save($large_image_path);
                    /*medium = 512*320*/
                    Image::make($image)->resize(512,320)->save($medium_image_path);
                    /*small = 256*200*/
                    Image::make($image)->resize(256,200)->save($small_image_path);
                    $product->thumbnail = $image_name;
                }


                /*Insert Data into Product_Commissions Table*/
                if ($request->is_reseller == 1 || $request->is_affiliate == 1) {
                    $product_commission = ProductCommission::where('product_id', $product->id)->first();
                    if (is_null($product_commission)){

                        $product_commission=new ProductCommission();
                        $product_commission->product_id = $product->id;
                        $product_commission->reseller_commission = $request->reseller_commission;
                        $product_commission->affiliate_commission = $request->affiliate_commission;
                        $product_commission->save();
                    }else{

                        $product_commission->product_id = $product->id;
                        $product_commission->reseller_commission = $request->reseller_commission;
                        $product_commission->affiliate_commission = $request->affiliate_commission;
                        $product_commission->save();
                    }

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
            /*Delete all Seller Product If Unpublished and give every seller a due point*/
            if ($product->status == 0) {
                seller_due_product($product->id);
            }
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

        return \response()->json($product);
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
            $product->deal_start_date = date("d-m-Y",strtotime($request->startDate));
            $product->deal_end_date = date("d-m-Y",strtotime($request->endDate));
            $product->deal_amount = $request->amount;
            $product->deal_type = $request->dealType;
            if ($product->flash_deal == 0) {
                $product->deal_start_date = null;
                $product->deal_end_date = null;
                $product->deal_amount = null;
                $product->deal_type = null;
            }
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

    /**
     * Control Panel
     */
    public function controlPanel(Request $request) : JsonResponse
    {

        try {
            DB::beginTransaction();
            $product = Product::find($request->productId);

            switch ($request->action) {
                case 'recent':
                    $product->recent = $product->recent == 1 ? 0 : 1;
                    break;
                case 'best-sale':
                    $product->best_sale = $product->best_sale == 1 ? 0 : 1;
                    break;
                case 'most-sale':
                    $product->most_sale = $product->most_sale == 1 ? 0 : 1;
                    break;
            }
            $product->save();
            DB::commit();
            return \response()->json([
                'response' => Response::HTTP_OK,
                'type' => 'success',
                'message' => 'Status Change Successfully'
            ]);
        } catch (QueryException $e) {
            DB::rollBack();

            return \response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Delete Merchant Product
    */
    public function delete(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $data = Product::find($request->item_id);
                DB::beginTransaction();
                /*Check is Merchant Delete Product*/
                if (\auth()->guard('merchant')->check()) {
                    seller_due_product($data->id);
                }

                if (File::exists(public_path('/uploads/product/original/' . $data->thumbnail))) {
                    File::delete(public_path('/uploads/product/original/' . $data->thumbnail));
                }
                if (File::exists(public_path('/uploads/product/large/' . $data->thumbnail))) {
                    File::delete(public_path('/uploads/product/large/' . $data->thumbnail));
                }
                if (File::exists(public_path('/uploads/product/medium/' . $data->thumbnail))) {
                    File::delete(public_path('/uploads/product/medium/' . $data->thumbnail));
                }
                if (File::exists(public_path('/uploads/product/small/' . $data->thumbnail))) {
                    File::delete(public_path('/uploads/product/small/' . $data->thumbnail));
                }
                if ($data->is_reseller == 1 OR $data->is_affiliate == 1) {
                    $product_commission = ProductCommission::where('product_id', $data->id)->first();
                    $product_commission?->delete();
                }
                $data->delete();

                DB::commit();

                return response()->json([
                    'message' => 'Successfully deleted',
                    'status_code' => Response::HTTP_OK,
                    'type' => 'success',
                ], Response::HTTP_OK);

            } catch (QueryException $e) {
                DB::rollBack();
            }

        }
        return response()->json([
            'message' => 'Something went wrong',
            'status_code' => 403,
            'type' => 'error',
        ], Response::HTTP_FORBIDDEN);
    }


    /**
     * Get Sub Categories
    */
    public function find_sub_category(Request $request): JsonResponse
    {
        $sub_categories=SubCategory::where(['category_id'=>$request->category_id,'status'=>1])->get();
        return \response()->json([
            'subcategoryes' => $sub_categories,
            'status_code' => 200
        ], Response::HTTP_OK);

    }


}
