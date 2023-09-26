<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Payment;
use App\Models\Ecommerce\Product;
use App\Models\Ecommerce\Review_coin;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PaymentController extends Controller
{

    public function index()
    {
        $payments = Payment::latest()->get();
        return view('webend.ecommerce.payment.index',compact('payments'));
    }

    public function create(){
        return view('webend.ecommerce.payment.create');
    }

    public function store(Request $request)
    {
//        return $request->all();


        $this->validate($request,[
            'payment_name'=>'required|max:255',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'type'=>'required',
            'priority'=>'required|unique:payments,priority'
        ]);
        if ($request->isMethod('POST'))
        {
            DB::beginTransaction();
            try{
                //Product create
                $payment = new Payment();

                if($request->hasFile('image')){
                    $image=$request->image;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                    $original=null;
                    $resize=null;
                    if (!file_exists(public_path().'/uploads/payment/original/')){
                        $original=File::makeDirectory(public_path().'/uploads/payment/original/',0777,true);
                    }
                    if (!file_exists(public_path().'/uploads/payment/resize/')){
                        $resize=File::makeDirectory(public_path().'/uploads/payment/resize/',0777,true);
                    }
                    $original_image_path = public_path().'/uploads/payment/original/'.$image_name;
                    $resize_image_path = public_path().'/uploads/payment/resize/'.$image_name;
                    //Resize Image
                    Image::make($image)->save($original_image_path);
                    Image::make($image)->resize(500,300)->save($resize_image_path);
                    $payment->image = $image_name;
                }

                $payment->payment_name      = $request->payment_name;
                $payment->type              = $request->type;
                $payment->priority          = $request->priority;

                $payment->account_detail=json_encode(['bank_holder_name'=>$request->bank_holder_name,
                'bank_account_number'=>$request->bank_account_number,'bank_name'=>$request->bank_name,
                'bank_branch_name'=>$request->bank_branch_name,'bank_route_number'=>$request->bank_route_number,
                'bank_swift_code'=>$request->bank_swift_code,'code_or_number'=>$request->code_or_number,'online_email'=>$request->online_email,
                'account_number'=>$request->account_number,'ref_number'=>$request->ref_number]);

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

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('webend.ecommerce.payment.edit', compact('payment'));
    }


    public function update(Request $request, $id)
    {
        $payment=Payment::find($id);
        $this->validate($request,[
            'payment_name'=>'required|max:255',
            'type'=>'required',
            'status'=>'required',
            'priority'=>'required|unique:payments,priority,'.$payment->id,
        ]);

        if ($request->isMethod("POST")){
            try {
                DB::beginTransaction();
                $payment->payment_name=$request->payment_name;
                $payment->type=$request->type;
                $payment->priority= $request->priority;
                $payment->status=$request->status;

                if($request->hasFile('image')){
                    $image=$request->image;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                    $original=null;
                    $resize=null;
                    if (file_exists(public_path().'/uploads/payment/original/'.$payment->image)){
                       File::delete(public_path().'/uploads/payment/original/'.$payment->image);
                    }
                    if (file_exists(public_path().'/uploads/payment/resize/'.$payment->image)){
                        File::delete(public_path().'/uploads/payment/resize/'.$payment->image);
                    }

                    $original_image_path = public_path().'/uploads/payment/original/'.$image_name;
                    $resize_image_path = public_path().'/uploads/payment/resize/'.$image_name;
                    //Resize Image
                    Image::make($image)->save($original_image_path);
                    Image::make($image)->resize(500,300)->save($resize_image_path);
                    $payment->image = $image_name;
                }

                $account_data=[];

                if ($request->type==PAYMENT_TYPE[1]){

                    $account_data= ['bank_holder_name'=>null,
                        'bank_account_number'=>null,'bank_name'=>null,
                        'bank_branch_name'=>null,'bank_route_number'=>null,
                        'bank_swift_code'=>null,'code_or_number'=>null,'online_email'=>null,
                        'account_number'=>$request->account_number,'ref_number'=>$request->ref_number];
                }
                if ($request->type==PAYMENT_TYPE[2]){

                    $account_data= ['bank_holder_name'=>$request->bank_holder_name,
                        'bank_account_number'=>$request->bank_account_number,'bank_name'=>$request->bank_name,
                        'bank_branch_name'=>$request->bank_branch_name,'bank_route_number'=>$request->bank_route_number,
                        'bank_swift_code'=>$request->bank_swift_code,'code_or_number'=>null,'online_email'=>null,
                        'account_number'=>null,'ref_number'=>null];
                }
                if ($request->type==PAYMENT_TYPE[3]){

                    $account_data= ['bank_holder_name'=>null,
                        'bank_account_number'=>null,'bank_name'=>null,
                        'bank_branch_name'=>null,'bank_route_number'=>null,
                        'bank_swift_code'=>null,'code_or_number'=>$request->code_or_number,'online_email'=>null,
                        'account_number'=>null,'ref_number'=>null];
                }

                if ($request->type==PAYMENT_TYPE[4]){

                    $account_data= ['bank_holder_name'=>null,
                        'bank_account_number'=>null,'bank_name'=>null,
                        'bank_branch_name'=>null,'bank_route_number'=>null,
                        'bank_swift_code'=>null,'code_or_number'=>null,'online_email'=>$request->online_email,
                        'account_number'=>null,'ref_number'=>null];
                }
                $payment->account_detail=json_encode($account_data);
                $payment->save();
                DB::commit();;

                return response()->json([
                    'message'=>'Successfully updated',
                    'type'=>'success',
                    'status'=>Response::HTTP_OK,
                ],Response::HTTP_OK);

            }catch (QueryException $e){
                DB::rollBack();
                $error=$e->getMessage();
                return response()->json([
                    'message'=>$error,
                    'type'=>'error',
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

    }


    public function delete(Request $request)
    {
        $payment=Payment::find($request->item_id);
        if (!empty($payment)){
            if (file_exists(public_path().'/uploads/payment/original/'.$payment->image)){
                File::delete(public_path().'/uploads/payment/original/'.$payment->image);
            }
            if (file_exists(public_path().'/uploads/payment/resize/'.$payment->image)){
                File::delete(public_path().'/uploads/payment/resize/'.$payment->image);
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
