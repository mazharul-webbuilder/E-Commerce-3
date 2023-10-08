<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Product;
use App\Models\Ecommerce\Size;
use App\Models\Ecommerce\Stock;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Merchant Product Stock Page
    */
    public function index($product_id): View
    {
        $product = Product::find($product_id);

        $stocks = Stock::where('product_id',$product_id)->latest()->get();

        $sizes = Size::latest()->get();

        return view('merchant.stock.index',compact('stocks','sizes','product'));
    }

    /**
     * Store new Stock Record
    */
    public function store(Request $request)
    {
        $request->validate([
            'size_id' => 'required',
            'quantity' => 'required',
        ]);

        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{
                $check_stock=Stock::where(['product_id'=>$request->product_id,'size_id'=>$request->size_id])->first();
                if (!empty($check_stock)){
                    $check_stock->quantity=$request->quantity;
                    $check_stock->save();
                }else{
                    $stock = new Stock();
                    $stock->product_id = $request->product_id;
                    $stock->size_id = $request->size_id;
                    $stock->quantity = $request->quantity;
                    $stock->save();
                }
                DB::commit();
                return \response()->json([
                    'message' => 'Successfully added',
                    'response' => Response::HTTP_OK,
                    'type'=>'success',
                ], Response::HTTP_OK);

            }catch (QueryException $e){
                DB::rollBack();
                $error = $e->getMessage();
                return \response()->json([
                    'error' => $error,
                    'type'=>'error',
                    'status_code' => 500
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    /**
     * Edit Stock Record
     */
    public function edit($id)
    {
        $stock = Stock::find($id);
        if ($stock != null){
            $sizes = Size::latest()->get();
            return view('merchant.stock.edit',compact('stock','sizes'));
        }else{
            toast('This Stock Not Found!','warning');
            return redirect()->route('merchant.product.index');
        }

    }

    /**
     * Update Stock Record
    */
    public function update(Request $request)
    {
        $request->validate([
            'size_id' => 'required',
            'quantity' => 'required',
        ]);
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{
                $stock =Stock::find($request->stock_id);
                $stock->size_id = $request->size_id;
                $stock->quantity = $request->quantity;
                $stock->save();;
                DB::commit();
                return \response()->json([
                    'message' => 'Successfully update',
                    'response' => Response::HTTP_OK,
                    'type'=>'success',
                ], Response::HTTP_OK);
            }catch (QueryException $ex){
                DB::rollBack();
                return \response()->json([
                    'error' => $ex->getMessage(),
                    'type'=>'error',
                    'response' => Response::HTTP_INTERNAL_SERVER_ERROR
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function delete(Request $request){
        $data=Stock::findOrFail($request->item_id);
        $data->delete();
        return \response()->json([
            'message' => 'Stock Delete Successfully',
            'status_code' => 200,
            'type'=>'success'
        ], Response::HTTP_OK);
    }
}
