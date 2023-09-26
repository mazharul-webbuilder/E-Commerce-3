<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Payment;
use App\Models\WithdrawPayment;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class WithdrawPaymentController extends Controller
{


    public function index(){
        $payments=DB::table('withdraw_payments')->orderBy('priority','asc')->get();
        return view('webend.withdraw_payment.index',compact('payments'));
    }

    public function create()
    {
        return view('webend.withdraw_payment.create');
    }

    public function store(Request $request){

        $this->validate($request,[
            'name'=>'required|max:255',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'priority'=>'required|unique:withdraw_payments,priority',
            'type'=>'required'
        ]);
        if ($request->isMethod('POST'))
        {
            DB::beginTransaction();
            try{
                //Product create
                $payment = new WithdrawPayment();

                if($request->hasFile('image')){
                    $image=$request->image;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                    $original=null;
                    $resize=null;
                    if (!file_exists(public_path().'/uploads/withdraw_payment/original/')){
                        $original=File::makeDirectory(public_path().'/uploads/withdraw_payment/original/',0777,true);
                    }
                    if (!file_exists(public_path().'/uploads/withdraw_payment/resize/')){
                        $resize=File::makeDirectory(public_path().'/uploads/withdraw_payment/resize/',0777,true);
                    }
                    $original_image_path = public_path().'/uploads/withdraw_payment/original/'.$image_name;
                    $resize_image_path = public_path().'/uploads/withdraw_payment/resize/'.$image_name;
                    //Resize Image
                    Image::make($image)->save($original_image_path);
                    Image::make($image)->resize(500,300)->save($resize_image_path);
                    $payment->image = $image_name;
                }

                $payment->name= $request->name;
                $payment->priority= $request->priority;
                $payment->type= $request->type;
                $payment->save();

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

    public function edit($id){
        $payment=DB::table('withdraw_payments')->find($id);
        return view('webend.withdraw_payment.edit',compact('payment'));
    }

    public function update(Request $request)
    {
        $payment=WithdrawPayment::find($request->id);
        $this->validate($request,[
            'name'=>'required|max:255|unique:withdraw_payments,priority, '.$payment->id,
            'priority'=>'required|unique:withdraw_payments,priority,'.$payment->id,
            'type'=>'required'
        ]);

        if ($request->isMethod("POST")){
            try {
                DB::beginTransaction();
                $payment->name=$request->name;
                $payment->priority= $request->priority;
                $payment->type= $request->type;

                if($request->hasFile('image')){
                    $image=$request->image;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                    $original=null;
                    $resize=null;
                    if (file_exists(public_path().'/uploads/withdraw_payment/original/'.$payment->image)){
                        File::delete(public_path().'/uploads/withdraw_payment/original/'.$payment->image);
                    }
                    if (file_exists(public_path().'/uploads/withdraw_payment/resize/'.$payment->image)){
                        File::delete(public_path().'/uploads/withdraw_payment/resize/'.$payment->image);
                    }

                    $original_image_path = public_path().'/uploads/withdraw_payment/original/'.$image_name;
                    $resize_image_path = public_path().'/uploads/withdraw_payment/resize/'.$image_name;
                    //Resize Image
                    Image::make($image)->save($original_image_path);
                    Image::make($image)->resize(500,300)->save($resize_image_path);
                    $payment->image = $image_name;
                }
                $payment->save();
                DB::commit();;

                return response()->json([
                    'message'=>'Successfully updated',
                    'type'=>'success',
                    'status_code'=>Response::HTTP_OK,
                ],Response::HTTP_OK);

            }catch (QueryException $e){
                DB::rollBack();
                $error=$e->getMessage();
                return response()->json([
                    'message'=>$error,
                    'type'=>'error',
                    'status_code'=>Response::HTTP_INTERNAL_SERVER_ERROR,
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

    }

    public function delete(Request $request)
    {
        $payment=WithdrawPayment::find($request->item_id);
        if (!empty($payment)){
            if (file_exists(public_path().'/uploads/withdraw_payment/original/'.$payment->image)){
                File::delete(public_path().'/uploads/withdraw_payment/original/'.$payment->image);
            }
            if (file_exists(public_path().'/uploads/withdraw_payment/resize/'.$payment->image)){
                File::delete(public_path().'/uploads/withdraw_payment/resize/'.$payment->image);
            }
            $payment->delete();

            return response()->json([
                'message'=>'Successfully deleted',
                'type'=>'success',
                'status'=>Response::HTTP_OK,
            ],Response::HTTP_OK);
        }
    }

}
