<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Orderdetails;
use App\Models\Brand;
use App\Models\Ecommerce\Category;
use App\Models\Ecommerce\Order;
use App\Models\Ecommerce\Order_detail;
use App\Models\Ecommerce\Product;
use App\Models\Ecommerce\SubCategory;
use App\Models\Ecommerce\Unit;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    public function index(): View
    {
//        $products = Product::where('admin_id', '!=' , null)->latest()->get();

        $count_deal = Product::where(['status'=>1,'flash_deal'=>1])->count();

        return view('webend.ecommerce.product.index',compact('count_deal'));
    }

    /**
     * Admin Product Datatable
    */
    public function adminProductDatatable()
    {
        $adminProducts = Product::where('admin_id', '!=', null)->get();

        return DataTables::of($adminProducts)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($product){
                return '<img style="width: 150px;height: 60px" src="'.asset('uploads/product/small/'.$product->thumbnail) .'">';
            })
            ->addColumn('stock', function ($product){
                return $product?->stocks->sum('quantity');
            })
            ->addColumn('status', function ($product){
                return '<select data-action="'. route('product_status_update') . '" product_id="'. $product->id . '" name="status"
                            class="change_product_status w-full h-6 h-10 pl-2 pr-2 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                            <option value="1"'.($product->status==1 ? 'selected' : '').'> Publish</option>
                            <option value="0"'. ($product->status==0 ? 'selected' : '') .'> Unpublish</option>
                        </select>';
            })
            ->addColumn('flash_deal', function ($product){
                return '<a  data-te-toggle="modal" data-te-target="#exampleModalDeal" data-te-ripple-init data-te-ripple-color="light"
                data-action="'.route('get_product_deal').'" product_id="'.$product->id.'" href="javascript:void(0)"
                class="flash_deal_product_status flash_deal_status'.$product->id.'
                text-white bg-red-500 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                '.($product->flash_deal==1 ? 'Yes' : 'No').'</a>';
            })
            ->addColumn('control_panel', function ($product){
                return ' <a  data-te-toggle="modal" data-te-target="#exampleModalControl" data-te-ripple-init data-te-ripple-color="light"
                data-action="'.route('show_product_status').'" product_id="'.$product->id.'" href="javascript:void(0)"
                class="show_product_status text-white bg-purple-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                <i class="fas fa-solid fa-tag px-2"></i>
                Control
            </a>';
            })
            ->addColumn('stock_management', function ($product){
                return '<a href="'.route('stock.index',$product->id).'" class="text-white bg-pink-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                <i class="fas fa-solid fa-warehouse px-2"></i>
                Stock
            </a>';
            })
            ->addColumn('action', function ($product){
                return '<div class="flex space-x-2">
                        <a href="'.route('gallery.index',$product->id).'" class="text-white bg-blue-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                            <i class="fas fa-solid fa-images px-2"></i>
                            Gallery
                        </a>
                        <a href="'.route('product.product_detail',$product->slug).'" class="text-white bg-indigo-400  hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                            <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                            View
                        </a>
                        <a href="'.route('product.edit',$product->id)  .'" class="text-white bg-sky-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                            <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                            Edit
                        </a>
                        <a href="javascriptL:;" data-action="'.route('product.delete').'"  item_id="'.$product->id.'" type="button" class="delete_item text-white bg-red-500 hover:bg-red-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                            <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            Delete
                        </a>
                        </div>';
            })
        ->rawColumns(['thumbnail', 'status', 'flash_deal', 'control_panel', 'stock_management', 'action'])->make('true');
    }

    /**
     * Display Merchant Product Page
     */
    public function merchantsProduct(): View
    {
        return view('webend.ecommerce.merchant.product.index');
    }

    /**
     * Datatable of Merchant Product in Admin Panel
    */
    public function merchantsProductDatatable(): JsonResponse
    {
        $products = Product::where('merchant_id', '!=', null)->latest()->get();

        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($product){
                return '<img src="'.asset('uploads/product/small/').'/'. $product->thumbnail.'" />';
            })
            ->addColumn('merchant', function ($product){
                return $product->merchant?->name;
            })
            ->addColumn('shop', function ($product){
                return $product->merchant?->shop_detail?->shop_name;
            })
            /*Status Column*/
            ->addColumn('status', function ($product) {
                $statusOptions = [
                    1 => 'Published',
                    0 => 'Unpublished',
                ];

                $statusSelect = '<select class="status-update form-control" style="background: #FFE5E5;
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
            ->addColumn('available_size', function ($product){
                return $product->stocks?->count();
            })
            ->addColumn('available_stock', function ($product){
               return $product?->stocks()->sum('quantity');
            })
            ->addColumn('action', function ($product){
                return '<a href="'.route('product.product_detail',$product->slug).'" class="text-white bg-indigo-400  hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                          <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                          View Details
                        </a>';
            })
            ->rawColumns(['thumbnail', 'merchant', 'shop', 'status', 'available_size', 'available_stock', 'action'])
            ->make(true);
    }

    /**
     * Change Merchant Product Status
    */
    public function merchantsProductStatusUpdate(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $product = Product::find($request->productId);
            $product->status = $request->newStatus;
            $product->save();
            DB::commit();
            return \response()->json([
                'message' => "Status Updated Successfully",
                'type' => 'success',
                'response' => Response::HTTP_OK
            ]);

        } catch (QueryException $exception) {
            DB::rollBack();
            return \response()->json([
                'message' => $exception->getMessage(),
                'type' => 'error',
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    public function create()
    {
        $categories=Category::where('status',1)->latest()->get();
        $units=Unit::where('status',1)->latest()->get();

        $brands = Brand::where('status', 1)->latest()->get();

        return view('webend.ecommerce.product.create',compact('categories','units', 'brands'));
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
            'previous_coin'=>'required',
            'current_coin'=>'required',
            'delivery_charge_in_dhaka'=>'required',
            'delivery_charge_out_dhaka'=>'required',
            'thumbnail'=>'required',
            'description'=>'nullable',
            'brand_id'=>'nullable|integer',
        ]);
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{
                //Product create
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
                $product->admin_id       =  auth()->guard('admin')->user()->id;

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


    /**
     * Show Product Edit page for admin
    */
    public function edit($id): View
    {
        $categories = Category::where('status',1)->latest()->get();
        $units = Unit::where('status',1)->latest()->get();
        $product = Product::find($id);
        $subcategories = SubCategory::where('category_id',$product->category_id)->get();
        $brands = Brand::where('status', 1)->latest()->get();

        return view('webend.ecommerce.product.edit',compact("product","categories","units","subcategories", "brands"));
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
            'current_price'=>'required',
            'previous_coin'=>'required',
            'delivery_charge_in_dhaka'=>'required',
            'delivery_charge_out_dhaka'=>'required',
            'current_coin'=>'required',
            'thumbnail'=>'nullable',
            'description'=>'nullable',
            'brand_id'=>'nullable|integer',

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
                $product->brand_id           = $request->brand_id;
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


    public function product_detail($slug)
    {
        $product=Product::where('slug',$slug)->first();
        return view('webend.ecommerce.product.detail',compact("product"));
    }

    public function all_flash_deal (){
        $products=Product::where(['status'=>1,'flash_deal'=>1])->get();
        return view('webend.ecommerce.product.all_deal_product',compact("products"));

    }

    public function delete(Request $request)
    {

        $data=Product::findOrFail($request->item_id);

        if (File::exists(public_path('/uploads/product/original/'.$data->thumbnail)))
        {
            File::delete(public_path('/uploads/product/original/'.$data->thumbnail));
        }
        if (File::exists(public_path('/uploads/product/large/'.$data->thumbnail)))
        {
            File::delete(public_path('/uploads/product/large/'.$data->thumbnail));
        }
        if (File::exists(public_path('/uploads/product/medium/'.$data->thumbnail)))
        {
            File::delete(public_path('/uploads/product/medium/'.$data->thumbnail));
        }
        if (File::exists(public_path('/uploads/product/small/'.$data->thumbnail)))
        {
            File::delete(public_path('/uploads/product/small/'.$data->thumbnail));
        }
        $data->delete();
        return \response()->json([
            'message' => 'Successfully deleted',
            'status_code' => 200,
            'type'=>'success',
        ], Response::HTTP_OK);

    }

public function product_status_update(Request $request)
{
        if ($request->isMethod("post")){
            DB::beginTransaction();
            try {
                $product=Product::find($request->product_id);
                $product->status=$request->status;
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


    public function show_product_status(Request $request)
    {
        $product=Product::findOrFail($request->product_id);
        return \response()->json([
            'product' => $product,
            'status_code' => 200
        ], Response::HTTP_OK);

    }

    public function show_flash_deal(Request $request)
    {
        $product=Product::findOrFail($request->product_id);
        return \response()->json([
            'product' => $product,
            'status_code' => 200
        ], Response::HTTP_OK);
    }


    public function control_product(Request $request)
    {
       // dd($request->all());
        if ($request->isMethod("POST")){
            DB::beginTransaction();
            try {
                $product=Product::findOrFail($request->product_id);
                if ($request->type=="best_sale")
                {
                    if ($product->best_sale==0)
                    {
                        $product->best_sale=1;
                    }else
                    {
                        $product->best_sale=0;
                    }
                }elseif ($request->type=="recent")
                {
                    if ($product->recent==0)
                    {
                        $product->recent=1;
                    }else
                    {
                        $product->recent=0;
                    }
                }elseif ($request->type=="most_sale")
                {
                    if ($product->most_sale==0)
                    {
                        $product->most_sale=1;
                    }else
                    {
                        $product->most_sale=0;
                    }
                }
                $product->save();
                DB::commit();
                return \response()->json([
                    'message' => "Successfully updated",
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

    public function set_flash_deal(Request $request)
    {
        $product_id=explode(',', $request->product_id[0]);
        foreach ($product_id as $id)
        {
            $product=Product::findOrFail($id);

            if ($request->has('flash_deal'))
            {
                $product->flash_deal=$request->flash_deal;
                $product->end_date=date("Y-m-d",strtotime($request->end_date));
                $product->discount=$request->discount;
                $product->save();
            }else
            {
                $product->flash_deal=1;
                $product->end_date=null;
                $product->discount=0;
                $product->save();
            }
        }
        // $product->save();
        return \response()->json([
            'message' => "Successfully updated",
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    public function find_sub_category(Request $request)
    {
        $sub_categories=SubCategory::where(['category_id'=>$request->category_id,'status'=>1])->get();
        return \response()->json([
            'subcategoryes' => $sub_categories,
            'status_code' => 200
        ], Response::HTTP_OK);

    }


    public function set_product_flash(Request $request){

        if ($request->isMethod("POST")){
            DB::beginTransaction();
            try {
                $product=Product::find($request->deal_product_id);

                if ($request->deal_status==1){
                    $product->flash_deal=$request->deal_status;
                    $product->deal_start_date=$request->deal_start_date;
                    $product->deal_end_date=$request->deal_end_date;
                    $product->deal_type=$request->deal_type;
                    $product->deal_amount=$request->deal_amount;

                }else{
                    $product->flash_deal=$request->deal_status;
                    $product->deal_start_date=null;
                    $product->deal_end_date=null;
                    $product->deal_type=null;
                    $product->deal_amount=null;
                }
                $product->save();
                DB::commit();
//                toast('Successfully updated!','success');
//                return redirect()->route('product.index');

                return \response()->json([
                    'message' => "Successfully updated",
                    'status_code' => 200,
                    'flash_deal' => $product->flash_deal,
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

    public function get_product_deal(Request $request)
    {
        if ($request->isMethod("post")){
            $product=Product::find($request->product_id);
            return \response()->json([
                'product' => $product,
                'status_code' => 200
            ], Response::HTTP_OK);
        }
    }

    /**
     * View Product Sale History Page
    */
    public function product_sale_history(){
        $sale_histories=Order_detail::whereHas('order',function ($query){
            $query->where('status','delivered');
        })->get();

        $total_purchase_price=0;
        $total_sale_price=0;
        $total_profit=0;
        $total_provided_coin=0;

        foreach ($sale_histories as $sale_history){
            $total_purchase_price=$total_purchase_price+($sale_history->product_quantity*$sale_history->product->purchase_price);
            $total_sale_price=$total_sale_price+($sale_history->product_quantity*$sale_history->product_price);
            $total_provided_coin=$total_provided_coin+($sale_history->product_quantity*$sale_history->product_coin);
        }
        $total_profit=$total_sale_price-$total_purchase_price;

        return view('webend.ecommerce.order.sale_history',compact("sale_histories","total_purchase_price","total_sale_price","total_profit","total_provided_coin"));
    }

    public function search_by_date(Request  $request){

        $sale_histories=Order_detail::whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->whereHas('order',function ($query){
                $query->where('status','delivered');
            })->get();
        $total_purchase_price=0;
        $total_sale_price=0;
        $total_profit=0;
        $total_provided_coin=0;

        foreach ($sale_histories as $sale_history){
            $total_purchase_price=$total_purchase_price+($sale_history->product_quantity*$sale_history->product->purchase_price);
            $total_sale_price=$total_sale_price+($sale_history->product_quantity*$sale_history->product_price);
            $total_provided_coin=$total_provided_coin+($sale_history->product_quantity*$sale_history->product_coin);
        }
        $total_profit=$total_sale_price-$total_purchase_price;
           // $date_range=$request->start_date."-".$request->end_date;
        return view('webend.ecommerce.order.sale_history',compact("sale_histories","total_purchase_price","total_sale_price","total_profit","total_provided_coin"));

    }

}
