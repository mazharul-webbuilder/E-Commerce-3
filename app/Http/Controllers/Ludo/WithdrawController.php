<?php

namespace App\Http\Controllers\Ludo;

use App\Models\CoinEarningHistory;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Settings;
use App\Models\OtpSendLimit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\WithdrawHistory;
use App\Models\WithdrawPayment;
use App\Models\SavePaymentMethod;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\BalanceTransferHistory;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\WithdrawPaymentList;
use App\Http\Resources\WithdrawPaymentResource;
use App\Http\Resources\SaveWithdrawPaymentResource;

class WithdrawController extends Controller
{

    protected $usd_rate=0.01;

//    public function withdraw(Request $request)
//    {
//        //return $request->withdraw_balance;
//        $validator = Validator::make($request->all(), [
//            'withdraw_balance' => 'required|numeric',
//            'balance_send_type' => 'required|numeric',
//        ]);
//        if (!$validator->fails()) {
//            if ($request->isMethod("POST")) {
//
//                try {
//                    DB::beginTransaction();
//                    $user = auth()->user();
//                    if ($request->withdraw_balance <= setting()->max_withdraw_limit && $request->withdraw_balance >= setting()->min_withdraw_limit) {
//                        if ($user->win_balance >= $request->withdraw_balance) {
//                            $withdraw = new WithdrawHistory();
//
//                            $withdraw->withdraw_balance = $request->withdraw_balance;
//                            $withdraw->user_received_balance = $request->withdraw_balance - setting()->balance_withdraw_charge;
//                            $withdraw->bdt_amount = $request->bdt_amount;
//                            $withdraw->charge = setting()->balance_withdraw_charge;
//                            $withdraw->balance_send_type = $request->balance_send_type;
//                            $withdraw->status = 1;
//                            $withdraw->user_id = $user->id;
//
//                            if ($request->balance_send_type == 1) {
//                                $mobile_account_detail = [
//                                    'mobile_account_number' => $request->mobile_account_number,
//                                    'mobile_account_type' => $request->mobile_account_type,
//                                ];
//                                $withdraw->mobile_account_detail = json_encode($mobile_account_detail);
//                            }
//                            if ($request->balance_send_type == 2) {
//                                $bank_detail = [
//                                    'bank_account_holder_name' => $request->bank_account_holder_name,
//                                    'bank_account_number' => $request->bank_account_number,
//                                    'bank_route_number' => $request->bank_route_number,
//                                    'bank_name' => $request->bank_name,
//                                    'branch_name' => $request->branch_name,
//                                ];
//                                $withdraw->bank_detail = json_encode($bank_detail);
//                            }
//
//                            if (!empty($request->user_note)) {
//                                $withdraw->user_note = $request->user_note;
//                            }
//                            $withdraw->save();
//                            $current_win_balance = $user->win_balance;
//                            $remain_win_balance = $current_win_balance - $request->withdraw_balance;
//                            $user->win_balance = $remain_win_balance;
//                            $user->save();
//                            DB::commit();
//                            return response()->json([
//                                'message' => "Your withdraw has been successfully completed",
//                                'type' => "success",
//                                'status' => Response::HTTP_OK
//                            ], Response::HTTP_OK);
//                        } else {
//                            return response()->json([
//                                'message' => "You have insufficient win balance",
//                                'type' => "error",
//                                'status' => Response::HTTP_BAD_REQUEST
//                            ], Response::HTTP_BAD_REQUEST);
//                        }
//                    } else {
//                        return response()->json([
//                            'message' => "Your withdraw balance should be between " . setting()->min_withdraw_limit . " to " . setting()->max_withdraw_limit,
//                            'type' => "error",
//                            'status' => Response::HTTP_BAD_REQUEST
//                        ], Response::HTTP_BAD_REQUEST);
//                    }
//                } catch (QueryException $e) {
//                    $error = $e->getMessage();
//                    //  return "dsfdsg";
//                    return response()->json([
//                        'message' => $error,
//                        'type' => "error",
//                        'status' => Response::HTTP_INTERNAL_SERVER_ERROR
//                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
//                }
//            }
//        } else {
//            return response()->json([
//                'message' => $validator->errors()->first(),
//                'type' => "error",
//                'status' => Response::HTTP_UNPROCESSABLE_ENTITY
//            ], Response::HTTP_UNPROCESSABLE_ENTITY);
//        }
//    }

    public function get_commission($type)
    {
        if ($type != null) {
            if ($type == 'gift_to_win') {
                $data['charge'] = setting()->gift_to_win_charge;
                return api_response('success', 'Commission amount of gift to win', $data, 200);
            } elseif ($type == 'win_to_gift') {
                $data['charge'] = setting()->win_to_gift_charge;
                return api_response('success', 'Commission amount of win to gift', $data, 200);
            } elseif ($type == 'marketing_to_win') {
                $data['charge'] = setting()->marketing_to_win_charge;
                return api_response('success', 'Commission amount marketing to win', $data, 200);
            } elseif ($type == 'marketing_to_gift') {
                $data['charge'] = setting()->marketing_to_gift_charge;
                return api_response('success', 'Commission amount marketing to gift', $data, 200);
            }
        } else {
            return api_response('warning', 'type not found', null, 200);
        }
    }

    public function commission_result($type, $amount)
    {
        if ($type != null) {
            if ($type == 'gift_to_win') {
                if ($amount > Auth::user()->paid_coin) {
                    return api_response('warning', 'Not dont have enough coin', null, 200);
                } else {
                    $commission  =  transfer_commission($amount, setting()->gift_to_win_charge);
                    $data['amount'] =  ($amount - $commission);
                    return api_response('success', 'Commission amount of gift to win', $data, 200);
                }
            } elseif ($type == 'win_to_gift') {
                if ($amount > Auth::user()->win_balance) {
                    return api_response('warning', 'Not dont have enough coin', null, 200);
                } else {
                    $commission  =  transfer_commission($amount, setting()->win_to_gift_charge);
                    $data['amount'] = ($amount - $commission);
                    return api_response('success', 'Commission amount of win to gift', $data, 200);
                }
            } elseif ($type == 'marketing_to_win') {
                if ($amount > Auth::user()->marketing_balance) {
                    return api_response('warning', 'Not dont have enough coin', null, 200);
                } else {
                    $commission  =  transfer_commission($amount, setting()->marketing_to_win_charge);
                    $data['amount'] = ($amount - $commission);
                    return api_response('success', 'Commission amount marketing to win', $data, 200);
                }
            } elseif ($type == 'marketing_to_gift') {
                if ($amount > Auth::user()->marketing_balance) {
                    return api_response('warning', 'Not dont have enough coin', null, 200);
                } else {
                    $commission  =  transfer_commission($amount, setting()->marketing_to_gift_charge);
                    $data['amount'] =  ($amount - $commission);
                    return api_response('success', 'Commission amount marketing to gift', $data, 200);
                }
            }
        } else {
            return api_response('warning', 'type not found', null, 200);
        }
    }

    public function balance_transfer(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'transfer_type' => 'required',
        ]);
        try {
            DB::beginTransaction();
            if ($request->transfer_type == 'gift_to_win') {
                $commission  =  transfer_commission($request->amount, setting()->gift_to_win_charge);
                if (Auth::user()->paid_coin >= $request->amount) {
                    $history = new BalanceTransferHistory();
                    $history->user_id = Auth::user()->id;
                    $history->depart_from = 'paid_coin';
                    $history->destination_to = 'win_coin';
                    $history->transfer_balance = $request->amount;
                    $history->deduction_charge = $commission;
                    $history->stored_balance = $request->amount - $commission;
                    $history->constant_title = BalanceTransferHistory::balance_transfer_constant[0];
                    $history->save();
                    Auth::user()->update([
                        'paid_coin' => Auth::user()->paid_coin - $request->amount,
                        'win_balance' => Auth::user()->win_balance + ($request->amount - $commission),
                        'earning_balance' => Auth::user()->earning_balance + ($request->amount - $commission),
                    ]);
                    DB::commit();
                    return api_response('success', 'Coin Transfer Successfully from Paid coin to Win Coin', null, 200);
                } else {
                    return api_response('warning', 'You dont have enough coin to transfer.', null, 200);
                }
            } elseif ($request->transfer_type == 'win_to_gift') {
                $commission  =  transfer_commission($request->amount, setting()->win_to_gift_charge);
                if (Auth::user()->win_balance >= $request->amount) {
                    $history = new BalanceTransferHistory();
                    $history->user_id = Auth::user()->id;
                    $history->depart_from = 'win_coin';
                    $history->destination_to = 'paid_coin';
                    $history->transfer_balance = $request->amount;
                    $history->deduction_charge = $commission;
                    $history->stored_balance = $request->amount - $commission;
                    $history->constant_title = BalanceTransferHistory::balance_transfer_constant[1];
                    $history->save();
                    Auth::user()->update([
                        'paid_coin' => Auth::user()->paid_coin + ($request->amount - $commission),
                        'win_balance' => Auth::user()->win_balance - $request->amount,
                    ]);
                    DB::commit();
                    return api_response('success', 'Coin Transfer Successfully from Win coin to Paid Coin', null, 200);
                } else {
                    return api_response('warning', 'You dont have enough coin to transfer.', null, 200);
                }
            } elseif ($request->transfer_type == 'marketing_to_win') {
                $commission  =  transfer_commission($request->amount, setting()->marketing_to_win_charge);
                if (Auth::user()->marketing_balance >= $request->amount) {
                    $history = new BalanceTransferHistory();
                    $history->user_id = Auth::user()->id;
                    $history->depart_from = 'marketing_balance';
                    $history->destination_to = 'win_coin';
                    $history->transfer_balance = $request->amount;
                    $history->deduction_charge = $commission;
                    $history->stored_balance = $request->amount - $commission;
                    $history->constant_title = BalanceTransferHistory::balance_transfer_constant[2];
                    $history->save();
                    Auth::user()->update([
                        'win_balance' => Auth::user()->win_balance + ($request->amount - $commission),
                        'marketing_balance' => Auth::user()->marketing_balance - $request->amount,
                    ]);
                    DB::commit();
                    return api_response('success', 'Coin Transfer Successfully from Marketing Balance to Win Balance', null, 200);
                } else {
                    return api_response('warning', 'You dont have enough Balance to transfer.', null, 200);
                }
            } elseif ($request->transfer_type == 'marketing_to_gift') {
                $commission  =  transfer_commission($request->amount, setting()->marketing_to_gift_charge);
                if (Auth::user()->marketing_balance >= $request->amount) {
                    $history = new BalanceTransferHistory();
                    $history->user_id = Auth::user()->id;
                    $history->depart_from = 'marketing_balance';
                    $history->destination_to = 'paid_coin';
                    $history->transfer_balance = $request->amount;
                    $history->deduction_charge = $commission;
                    $history->stored_balance = $request->amount - $commission;
                    $history->constant_title = BalanceTransferHistory::balance_transfer_constant[3];
                    $history->save();
                    Auth::user()->update([
                        'paid_coin' => Auth::user()->paid_coin + ($request->amount - $commission),
                        'marketing_balance' => Auth::user()->marketing_balance - $request->amount,
                    ]);
                    DB::commit();
                    return api_response('success', 'Coin Transfer Successfully from Marketing Balance to Paid Coin', null, 200);
                } else {
                    return api_response('warning', 'You dont have enough Balance to transfer.', null, 200);
                }
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return $ex->getMessage();
        }
    }

    public function all_balance_transfer_history()
    {
        $histories = BalanceTransferHistory::latest()->get();
        return view('webend.balance_transfer_history', compact('histories'));
    }

    public function user_balance_transfer_history($id)
    {
        $histories = BalanceTransferHistory::where('user_id', $id)->latest()->get();
        return view('webend.balance_transfer_history', compact('histories'));
    }

    public function coin_detail()
    {
        $user = auth()->user();
        $balance_data = DB::table('users')->where('id', $user->id)->select('paid_coin', 'win_balance', 'marketing_balance','earning_balance')->first();
        $available = DB::table('users')->where('id', $user->id)->select(DB::raw('sum(paid_coin + win_balance+marketing_balance) as total'))->first()->total;
        $withdraw = DB::table('withdraw_histories')->where('user_id', $user->id)->get()->sum('withdraw_balance');


        return \response()->json([
            'balance_data' => $balance_data,
            'available' => $available,
            'withdraw' => $withdraw,
            'status' => Response::HTTP_OK,
            'type' => 'success'
        ], Response::HTTP_OK);
    }

    public function transfer_balance_list($type = null)
    {
        $user = auth()->user();
        $transfer_histories = [];
        if ($type === BalanceTransferHistory::balance_transfer_constant[0]) {
            $transfer_histories = DB::table('balance_transfer_histories')
                ->where(['user_id' => $user->id, 'constant_title' => BalanceTransferHistory::balance_transfer_constant[0]])->latest()->get()->map(function ($q) {
                    return [
                        'id' => $q->id,
                        'transfer_route' => $q->transfer_balance,
                        'created_at' => date('d M Y h:i:s a', strtotime($q->created_at)),
                        'transfer_balance' => ucwords(str_replace('_', ' ', $q->constant_title)),
                    ];
                });
        } elseif ($type === BalanceTransferHistory::balance_transfer_constant[1]) {
            $transfer_histories = DB::table('balance_transfer_histories')->where(['user_id' => $user->id, 'constant_title' => BalanceTransferHistory::balance_transfer_constant[1]])->latest()->get()->map(function ($q) {
                return [
                    'id' => $q->id,
                    'transfer_route' => $q->transfer_balance,
                    'created_at' => date('d M Y h:i:s a', strtotime($q->created_at)),
                    'transfer_balance' => ucwords(str_replace('_', ' ', $q->constant_title)),
                ];
            });
        } elseif ($type === BalanceTransferHistory::balance_transfer_constant[2]) {
            $transfer_histories = DB::table('balance_transfer_histories')->where(['user_id' => $user->id, 'constant_title' => BalanceTransferHistory::balance_transfer_constant[2]])->latest()->get()->map(function ($q) {
                return [
                    'id' => $q->id,
                    'transfer_route' => $q->transfer_balance,
                    'created_at' => date('d M Y h:i:s a', strtotime($q->created_at)),
                    'transfer_balance' => ucwords(str_replace('_', ' ', $q->constant_title)),
                ];
            });
        } elseif ($type === BalanceTransferHistory::balance_transfer_constant[3]) {
            $transfer_histories = DB::table('balance_transfer_histories')->where(['user_id' => $user->id, 'constant_title' => BalanceTransferHistory::balance_transfer_constant[3]])->latest()->get()->map(function ($q) {
                return [
                    'id' => $q->id,
                    'transfer_route' => $q->transfer_balance,
                    'created_at' => date('d M Y h:i:s a', strtotime($q->created_at)),
                    'transfer_balance' => ucwords(str_replace('_', ' ', $q->constant_title)),
                ];
            });
        } elseif (is_null($type)) {
            $transfer_histories = DB::table('balance_transfer_histories')->where(['user_id' => $user->id])->latest()->get()->map(function ($q) {
                return [
                    'id' => $q->id,
                    'transfer_route' => $q->transfer_balance,
                    'created_at' => date('d M Y h:i:s a', strtotime($q->created_at)),
                    'transfer_balance' => ucwords(str_replace('_', ' ', $q->constant_title)),
                ];
            });
        }
        return \response()->json([
            'transfer_histories' => $transfer_histories,
            'status' => Response::HTTP_OK,
            'type' => 'success',
        ], Response::HTTP_OK);
    }



    public function withdraw_balance_list()
    {
        $user = auth()->user();
        $withdraw_histories = DB::table('withdraw_histories')->where(['user_id' => $user->id,])
            ->select('id', 'withdraw_balance', 'balance_send_type','status', DB::raw('DATE_FORMAT(created_at,"%d %b %Y %h %i %s") as created_at'))
            ->latest()->get();
        return \response()->json([
            'withdraw_histories' => $withdraw_histories,
            'status' => Response::HTTP_OK,
            'type' => 'success',
        ], Response::HTTP_OK);
    }


    public function withdraw_payment_list()
    {
        $payments = WithdrawPayment::orderBy('priority', 'asc')->get();
        $value = [];
        foreach ($payments as $data) {
            $checker = SavePaymentMethod::where('withdraw_payment_id', $data->id)
                ->where('user_id', auth()->user()->id)
                ->first();
            if (empty($checker)) {
                array_push($value, $data);
            }
        }
        $data = WithdrawPaymentResource::collection($value);

        return \response()->json([
            'data' => $data,
            'status' => Response::HTTP_OK,
            'type' => 'success',
        ], Response::HTTP_OK);
    }

    public function withdraw_detail_info()
    {

        $coin_for_return_bdt = setting()->coin_convert_to_bdt;
        $withdraw_charge = setting()->balance_withdraw_charge;

        return \response()->json([
            'coin_for_return_bdt' => $coin_for_return_bdt,
            'withdraw_charge' => $withdraw_charge,
            'available_balance' => auth()->user()->win_balance,
            'status' => Response::HTTP_OK,
            'type' => 'success',
        ], Response::HTTP_OK);
    }

    public function coin_convert_to_bdt(Request $request)
    {
        //return setting();
        $request->validate([
            'withdraw_balance' => 'required|numeric|min:'.setting()->min_withdraw_limit.'',
        ]);

        if ($request->isMethod('POST')) {
            $coin_set = setting()->coin_convert_to_bdt;
          //  return $coin_set;
            $remain_coin = $request->withdraw_balance - setting()->balance_withdraw_charge;
           //  return $remain_coin;
            $total_usd = $remain_coin *$this->usd_rate/$coin_set;
            // return $total_usd;

            $total_bdt= currency_code('BDT')->currency_code." ".number_format(currency_convertor($total_usd,'convert_to_bdt'),2);
            $total_inr=currency_code('INR')->currency_code." ".number_format(currency_convertor($total_usd,'convert_to_inr'),2);
            return \response()->json([
                'total_USD'=>currency_code('USD')->currency_code." ".number_format($total_usd,2),
                'total_BDT' => $total_bdt,
                'total_INR'=>$total_inr,
                'status' => 'success',
                'type' => Response::HTTP_OK
            ], Response::HTTP_OK);
        }
    }

    public function saved_payment_list()
    {
        $saved_payments = SavePaymentMethod::where(['user_id' => auth()->user()->id])
            ->latest()->get();
        $data = SaveWithdrawPaymentResource::collection($saved_payments);

        return \response()->json([
            'saved_payments' => $data,
            'type' => 'success',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function add_payment_method(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'withdraw_payment_id' => 'required',
            'account_number' => 'required',
            'name' => 'required'
        ]);
        if ($request->isMethod("POST")) {
            if (!$validator->fails()) {
                try {
                    $checker = SavePaymentMethod::where(['withdraw_payment_id' => $request->withdraw_payment_id,
                        'user_id' => auth()->user()->id, 'account_number' => $request->account_number])->first();
                    // return $checker;
                    if (empty($checker)) {
                        DB::beginTransaction();
                        $otp_number = rand(10000, 99999);

                        $saved = new SavePaymentMethod();
                        $saved->withdraw_payment_id = $request->withdraw_payment_id;
                        $saved->account_number = $request->account_number;
                        $saved->otp = $otp_number;
                        $saved->user_id = auth()->user()->id;
                        DB::commit();
                        $saved->save();

                        return response()->json([
                            'message' => 'Your payment has been added successfully',
                            'type' => 'success',
                            'status' => Response::HTTP_OK
                        ], Response::HTTP_OK);
                    } else {
                        return response()->json([
                            'message' => 'This phone number already added',
                            'type' => 'warning',
                            'status' => Response::HTTP_ALREADY_REPORTED
                        ], Response::HTTP_ALREADY_REPORTED);
                    }
                } catch (QueryException $e) {
                    DB::rollBack();
                    $error = $e->getMessage();
                    return response()->json([
                        'message' => $error,
                        'type' => 'error',
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            } else {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'type' => 'error',
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function verify_payment_account_number(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp_number' => 'required',
        ]);
        if ($request->isMethod("POST")) {
            if (!$validator->fails()) {
                DB::beginTransaction();
                try {

                    $checker = SavePaymentMethod::where('otp', $request->otp_number)->first();

                    if (!empty($checker)) {
                        $checker->update(['is_verify' => 0, 'otp' => null]);
                        OtpSendLimit::where('save_payment_method_id', $checker->id)->delete();
                        DB::commit();
                        return response()->json([
                            'message' => "Successfully Verified",
                            'status' => Response::HTTP_OK,
                            'type' => 'success'
                        ], Response::HTTP_OK);
                    } else {
                        return response()->json([
                            'message' => "OTP not found",
                            'status' => Response::HTTP_NOT_FOUND,
                            'type' => 'success'
                        ], Response::HTTP_OK);
                    }
                } catch (QueryException $e) {
                    DB::rollBack();
                    $error = $e->getMessage();
                    return response()->json([
                        'message' => $error,
                        'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                        'type' => 'success'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            } else {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'type' => 'error',
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function resend_otp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'saved_payment_id' => 'required',
        ]);
        if ($request->isMethod("Post")) {
            if (!$validator->fails()) {
                $checker = OtpSendLimit::where('save_payment_method_id', $request->saved_payment_id)
                    ->where('user_id', auth()->user()->id)
                    ->whereDate('created_at', Carbon::today())
                    ->count();
                if ($checker < 3) {
                    try {
                        DB::beginTransaction();
                        $payment = SavePaymentMethod::find($request->saved_payment_id);
                        if (!empty($payment)) {

                            $otp_number = rand(10000, 99999);
                            $payment->otp = $otp_number;
                            $payment->save();
                            DB::commit();

                            OtpSendLimit::create([
                                'save_payment_method_id' => $payment->id,
                                'user_id' => \auth()->user()->id,
                            ]);

                            $message = "Dear customer, You have been sent an OTP code to verify your account number. Please use " . $otp_number . " code to verify account number. Thank You.";
                            send_sms($payment->account_number, $message);

                            return response()->json([
                                'message' => "You have been sent otp code",
                                'type' => 'success',
                                'status' => Response::HTTP_OK
                            ], Response::HTTP_OK);
                        } else {
                            return response()->json([
                                'message' => "Data not fount",
                                'type' => 'error',
                                'status' => Response::HTTP_NOT_FOUND
                            ], Response::HTTP_OK);
                        }
                    } catch (QueryException $e) {
                        DB::rollBack();
                        $error = $e->getMessage();
                        return response()->json([
                            'message' => $error,
                            'type' => 'error',
                            'status' => Response::HTTP_UNPROCESSABLE_ENTITY
                        ], Response::HTTP_UNPROCESSABLE_ENTITY);
                    }
                } else {
                    return response()->json([
                        'message' => "You OTP Limit has been over",
                        'type' => 'error',
                        'status' => Response::HTTP_LOCKED
                    ], Response::HTTP_OK);
                }
            } else {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'type' => 'error',
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function delete_saved_payment_method(Request $request)
    {
        if ($request->isMethod("POST")) {
            $data = SavePaymentMethod::find($request->saved_payment_id);
            if (!empty($data)) {
                $data->delete();
                if ($data) {
                    return response()->json([
                        'message' => "Successfully Deleted",
                        'type' => 'success',
                        'status' => Response::HTTP_OK
                    ], Response::HTTP_OK);
                }
            } else {
                return response()->json([
                    'message' => "Data not found",
                    'type' => 'error',
                    'status' => Response::HTTP_NOT_FOUND
                ], Response::HTTP_OK);
            }
        }
    }

    public function coin_earning_history(){
         $user=auth()->user();
        $earning_histories=CoinEarningHistory::where('user_id',$user->id)->orderBy('id','DESC')->get();

        return response()->json([
            'datas' => $earning_histories,
            'type' => 'success',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }



    public function withdraw_balance_detail($id){
        $data=WithdrawHistory::find($id);

        return response()->json([
            'data'=>$data,
            'status'=>200,
            'type'=>'success'
        ],Response::HTTP_OK);
    }


    public function withdraw_balance_delete(Request $request){
        if ($request->isMethod("POST")){
            $withdraw=WithdrawHistory::find($request->id);
            if (!is_null($withdraw)){
                $user=User::find($withdraw->user_id);
                $user->win_balance +=$withdraw->withdraw_balance;

                $data=$user->save();
                if ($data){
                    $withdraw->delete();
                }


                return response()->json([
                    'message'=>"Successfully deleted",
                    'status'=>200,
                    'type'=>'success'
                ],Response::HTTP_OK);
            }else{
                return response()->json([
                    'message'=>"Record not found",
                    'status'=>402,
                    'type'=>'warning'
                ],Response::HTTP_OK);
            }


        }
    }

}
