<?php

namespace App\Http\Controllers;

use App\Http\Resources\Userprofile;
use App\Models\Free2pgame;
use App\Models\Free3pgame;
use App\Models\Free4playergame;
use App\Models\Settings;
use App\Models\User;
use App\Models\Rank;
use App\Models\UserDevice;
use App\Models\VersionUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Mail\GmailSend;
use Mail;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{

    //    public function login(){
    //        return redirect()->route('club_owner.login.show');
    //    }

    public function login_step_one(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loginType' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        } else {
            DB::beginTransaction();
            if ($request->loginType == 'phone') {
                $validator = Validator::make($request->all(), [
                    'mobile' => 'required|regex:/(01)[0-9]{9}$/',
                    'country' => 'required',
                    'device_token' => 'required',
                ]);

                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors()->all()]);
                }
                $user = User::where('mobile', $request->mobile)->first();
                if ($user == null) {

                    $newuser = User::create([
                        'playerid' =>  rand(10000000, 99999999),
                        'mobile' => $request->mobile,
                        'country' => $request->country,
                        'otp' => rand(10000, 99999),
                        'free_coin' => Settings::first()->free_login_coin,
                        'paid_coin' => 0, //test perpose
                        'free_diamond' => Settings::first()->free_login_diamond,
                        'rank_id' => Rank::where('priority', 0)->first()->id,
                        'next_rank_id' => Rank::where('priority', 1)->first()->id,
                        'last_rank_update_date' => Carbon::now()->format('Y-m-d H:m:s'),
                    ]);
                    if ($newuser) {
                        $device_id = UserDevice::create([
                            'device_token' => $request->device_token,
                            'user_id' => $newuser->id,
                            'status' => 0, //0 means not verified
                        ]);
                        DB::commit();
                        $text = "You have sent request to create new account on  Netelmart" . '' . " .  Your verification code " . $newuser->otp . ". Please dont share it with others.";
                        send_sms($newuser->mobile, $text);
                        return response()->json(['type' => "phone-step-1", 'message' => "We send otp in your Phone. Please verify your account by OTP!"]);
                    }
                } elseif (verify_status($request->device_token, $user->id)) {
                    if ($user->last_login != null) {
                        if (Carbon::parse($user->last_login)->isToday()) {
                            $user->update([
                                'last_login' => Carbon::now(),
                                'free_coin' => $user->free_coin + 0,
                                'free_diamond' => $user->free_diamond + 0,
                            ]);
                            DB::commit();
                        } else {
                            $user->update([
                                'last_login' => Carbon::now(),
                                'free_coin' => $user->free_coin + Settings::first()->free_login_coin,
                                'free_diamond' => $user->free_diamond + Settings::first()->free_login_diamond,
                            ]);
                            DB::commit();
                        }
                    } else {
                        $user->update([
                            'last_login' => Carbon::now(),
                            'free_coin' => $user->free_coin + Settings::first()->free_login_coin,
                            'free_diamond' => $user->free_diamond + Settings::first()->free_login_diamond,
                        ]);
                        DB::commit();
                    }
                    $success =  $user;
                    Auth::login($user);
                    $success['token'] =  Auth::user()->createToken('MyApp')->accessToken;
                    return response()->json(['type' => "verified-user", 'data' => $success], 200);
                } else {
                    $update =  $user->update([
                        'otp' => rand(10000, 99999),
                    ]);
                    DB::commit();
                    $text = "You have sent request to create new account on  Netelmart" . '' . ".  Your verification code " . $user->otp . ". Please dont share it with others.";
                    send_sms($user->mobile, $text);
                    return response()->json(['type' => "phone-step-2", 'message' => "You already have an account!. Please verify your account by OTP!"]);

                }
            } else {
                return response()->json(['error' => ['Invalid Login Type.']], 200);
            }
        }
    }

    public function user_profile()
    {
        $data = Auth::user();
        $user = new Userprofile($data);
        return api_response('success', 'My Profile', $user, 200);
    }

    public function otp_verification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|regex:/(01)[0-9]{9}$/',
            'otp' => 'nullable',
            'device_token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        } else {
            $user = User::where('mobile', $request->mobile)->first();
            if (!is_null($user)) {
                if ($user->max_hit < 5) {
                    $user->update([
                        'max_hit' => $user->max_hit + 1,
                    ]);
                       if ($user->otp == $request->otp) {
                    if (UserDevice::where(['device_token' => $request->device_token, 'user_id' => $user->id])->first() != null) {

                        if (!verify_status($request->device_token, $user->id)) {
                            $user_device = UserDevice::where(['device_token' => $request->device_token, 'user_id' => $user->id])->update([
                                'status' => 1,
                            ]);
                            $user->update([
                                'max_hit' => 0,
                            ]);
                            if ($user->name == null) {
                                if ($user->last_login != null) {
                                    if (Carbon::parse($user->last_login)->isToday()) {
                                        $user->update([
                                            'last_login' => Carbon::now(),
                                            'free_coin' => $user->free_coin + 0,
                                            'free_diamond' => $user->free_diamond + 0,
                                        ]);
                                    } else {
                                        $user->update([
                                            'last_login' => Carbon::now(),
                                            'free_coin' => $user->free_coin + Settings::first()->free_login_coin,
                                            'free_diamond' => $user->free_diamond + Settings::first()->free_login_diamond,
                                        ]);
                                    }
                                } else {
                                    $user->update([
                                        'last_login' => Carbon::now(),
                                        'free_coin' => $user->free_coin + Settings::first()->free_login_coin,
                                        'free_diamond' => $user->free_diamond + Settings::first()->free_login_diamond,
                                    ]);
                                }
                                $success = $user;
                                Auth::login($user);
                                $success['token'] = Auth::user()->createToken('MyApp')->accessToken;
                                return response()->json(['type' => "verified-without-userinfo", 'data' => $success], 200);
                            } else {
                                if ($user->last_login != null) {
                                    if (Carbon::parse($user->last_login)->isToday()) {
                                        $user->update([
                                            'last_login' => Carbon::now(),
                                            'free_coin' => $user->free_coin + 0,
                                            'free_diamond' => $user->free_diamond + 0,
                                        ]);
                                    } else {
                                        $user->update([
                                            'last_login' => Carbon::now(),
                                            'free_coin' => $user->free_coin + Settings::first()->free_login_coin,
                                            'free_diamond' => $user->free_diamond + Settings::first()->free_login_diamond,
                                        ]);
                                    }
                                } else {
                                    $user->update([
                                        'last_login' => Carbon::now(),
                                        'free_coin' => $user->free_coin + Settings::first()->free_login_coin,
                                        'free_diamond' => $user->free_diamond + Settings::first()->free_login_diamond,
                                    ]);
                                }
                                $success = $user;
                                Auth::login($user);
                                $success['token'] = Auth::user()->createToken('MyApp')->accessToken;
                                return response()->json(['type' => "verified-user", 'data' => $success], 200);
                            }
                        } else {
                            if ($user->name == null) {
                                if ($user->last_login != null) {
                                    if (Carbon::parse($user->last_login)->isToday()) {
                                        $user->update([
                                            'last_login' => Carbon::now(),
                                            'free_coin' => $user->free_coin + 0,
                                            'free_diamond' => $user->free_diamond + 0,
                                        ]);
                                    } else {
                                        $user->update([
                                            'last_login' => Carbon::now(),
                                            'free_coin' => $user->free_coin + Settings::first()->free_login_coin,
                                            'free_diamond' => $user->free_diamond + Settings::first()->free_login_diamond,
                                        ]);
                                    }
                                } else {
                                    $user->update([
                                        'last_login' => Carbon::now(),
                                        'free_coin' => $user->free_coin + Settings::first()->free_login_coin,
                                        'free_diamond' => $user->free_diamond + Settings::first()->free_login_diamond,
                                    ]);
                                }
                                $success = $user;
                                Auth::login($user);
                                $success['token'] = Auth::user()->createToken('MyApp')->accessToken;
                                return response()->json(['type' => "verified-without-userinfo", 'data' => $success], 200);
                            } else {
                                if ($user->last_login != null) {
                                    if (Carbon::parse($user->last_login)->isToday()) {
                                        $user->update([
                                            'last_login' => Carbon::now(),
                                            'free_coin' => $user->free_coin + 0,
                                            'free_diamond' => $user->free_diamond + 0,
                                        ]);
                                    } else {
                                        $user->update([
                                            'last_login' => Carbon::now(),
                                            'free_coin' => $user->free_coin + Settings::first()->free_login_coin,
                                            'free_diamond' => $user->free_diamond + Settings::first()->free_login_diamond,
                                        ]);
                                    }
                                } else {
                                    $user->update([
                                        'last_login' => Carbon::now(),
                                        'free_coin' => $user->free_coin + Settings::first()->free_login_coin,
                                        'free_diamond' => $user->free_diamond + Settings::first()->free_login_diamond,
                                    ]);
                                }
                                $success = $user;
                                Auth::login($user);
                                $success['token'] = Auth::user()->createToken('MyApp')->accessToken;
                                return response()->json(['type' => "verified-user", 'data' => $success], 200);
                            }
                        }
                    } else {
                        return response()->json(['type' => 'error', 'message' => ["Device Not Found Of this user."]], 200);
                    }
                } else {
                    return response()->json(['type' => 'error', 'message' => ["OTP Doesn't. Matched"]], 200);
                }
                } else {
                    return response()->json(['type' => "error", 'message' => 'You Cross the limit of OTP Maximum hit', 'data' => 'null'], 200);
                }
            }else{
                return response()->json(['type' => "error", 'message' => 'No account found. Please register first', 'data' => 'null'], 200);
            }
        }
    }

    public function user_info(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email',
            'mobile' => 'required|regex:/(01)[0-9]{9}$/',
            'name' => 'required',
            'gender' => 'required',
            'avatar' => 'required',
            'dob' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $user_update = User::where('mobile', $request->mobile)->first();
        DB::beginTransaction();
        if ($user_update != null) {
            $user_update->email  = $request->email;
            $user_update->name  = $request->name;
            $user_update->gender  = $request->gender;
            $user_update->avatar  = $request->avatar;
            $user_update->dob  = Carbon::parse($request->dob);
            $user_update->used_reffer_code  = $request->refercode != null ? $request->refercode : 0;
            $user_update->save();
            DB::commit();
            $success = $user_update;
            Auth::login($user_update);
            $success['token'] =  Auth::user()->createToken('MyApp')->accessToken;
            return response()->json(['type' => "verified-user-create", 'data' => $success], 200);
        } else {
            DB::rollBack();
            return response()->json(['type' => 'error', 'message' => ["Not user found!, try again"]], 200);
        }
    }


    public function gmail_Login(Request $request)
    {
        $login_Type = 'email';
        if ($login_Type == 'email') {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email:rfc,dns',
                //                'country' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->all()]);
            }
            $user = User::where('email', $request->email)->first();

            if ($user == null) {
                $newuser = User::create([
                    'playerid' =>  rand(10000000, 99999999),
                    'email' => $request->email,
                    'name' => $request->DisplayName,
                    'country' => $request->country != null ? $request->country : null,
                    'otp' => rand(10000, 99999),
                    'avatar' => $request->avatar != null ? $request->avatar : null,
                    'otp_verified_at' => Carbon::now(),
                    'last_login' => Carbon::now(),
                    'free_coin' => Settings::first()->free_login_coin,
                    'paid_coin' => 0, //test perpose
                    'free_diamond' => Settings::first()->free_login_diamond,
                    'rank_id' => Rank::where('priority', 0)->first()->id,
                    'next_rank_id' => Rank::where('priority', 1)->first()->id,
                    'last_rank_update_date' => Carbon::now()->format('Y-m-d H:m:s'),
                ]);
                if ($newuser) {
                    $success = $newuser;
                    Auth::login($newuser);
                    $success['token'] =  Auth::user()->createToken('MyApp')->accessToken;
                    return response()->json(['type' => "verified-user", 'message' => "Your Account Creation successfully done!.", 'data' => $success]);
                }
            } else if ($user->otp_verified_at == null) {
                if ($user->last_login != null) {
                    if (Carbon::parse($user->last_login)->isToday()) {
                        $user->update([
                            'last_login' => Carbon::now(),
                            'free_coin' => $user->free_coin + 0,
                            'free_diamond' => $user->free_diamond + 0,
                        ]);
                    } else {
                        $user->update([
                            'last_login' => Carbon::now(),
                            'free_coin' => $user->free_coin + Settings::first()->free_login_coin,
                            'free_diamond' => $user->free_diamond + Settings::first()->free_login_diamond,
                        ]);
                    }
                } else {
                    $user->update([
                        'last_login' => Carbon::now(),
                        'free_coin' => $user->free_coin + Settings::first()->free_login_coin,
                        'free_diamond' => $user->free_diamond + Settings::first()->free_login_diamond,
                    ]);
                }
                $user->update([
                    'otp_verified_at' => Carbon::now(),
                ]);
                $success =  $user;
                Auth::login($user);
                $additional_info = $this->user_incomplete_game($user);
                //$success['additional_info']=$additional_info;
                $success['token'] =  Auth::user()->createToken('MyApp')->accessToken;

                return response()->json(['type' => "verified-user", 'data' => $success], 200);
            } else {
                if ($user->last_login != null) {
                    if (Carbon::parse($user->last_login)->isToday()) {
                        $user->update([
                            'last_login' => Carbon::now(),
                            'free_coin' => $user->free_coin + 0,
                            'free_diamond' => $user->free_diamond + 0,
                        ]);
                    } else {
                        $user->update([
                            'last_login' => Carbon::now(),
                            'free_coin' => $user->free_coin + Settings::first()->free_login_coin,
                            'free_diamond' => $user->free_diamond + Settings::first()->free_login_diamond,
                        ]);
                    }
                } else {
                    $user->update([
                        'last_login' => Carbon::now(),
                        'free_coin' => $user->free_coin + Settings::first()->free_login_coin,
                        'free_diamond' => $user->free_diamond + Settings::first()->free_login_diamond,
                    ]);
                }
                $success =  $user;
                Auth::login($user);

                $additional_info = $this->user_incomplete_game($user);
                // $success['additional_info']=$additional_info;
                $success['token'] =  Auth::user()->createToken('MyApp')->accessToken;

                return response()->json(['type' => "verified-user", 'message' => "Login Successfully!.", 'data' => $success]);
            }
        } else {
            return response()->json(['type' => 'error', 'message' => "Something went a wrong!, try again"], 200);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user_device = UserDevice::where(['device_token' => $request->device_token, 'user_id' => Auth::user()->id])->first();
            if ($user_device != null) {
                $user_device->status = 0;
                $user_device->save();
            }
            $token = Auth::user()->token();
            $token->revoke();
            return response()->json(['type' => 'success', 'message' => "User loged out"], 200);
        } else {
            return  response()->json(['type' => 'error', 'message' => "Unauthenticated"], 200);
        }
    }

    public function user(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            return response()->json(['type' => 'success', 'message' => "User data", 'data' => $user], 200);
        } else {
            return  response()->json(['type' => 'error', 'message' => "Unauthorized"], 200);
        }
    }


    protected function  user_incomplete_game($user)
    {
        $incomplete_game = false;

        $two_player_game = Free2pgame::query()
            ->where('status', 0)->where(function ($query) use ($user) {

                $query->orWhere('player_one', $user->id);
                $query->orWhere('player_two', $user->id);;
            })->get();

        $three_player_game = Free3pgame::query()
            ->where('status', 0)->where(function ($query) use ($user) {
                $query->orWhere('player_one', $user->id);
                $query->orWhere('player_two', $user->id);
                $query->orWhere('player_three', $user->id);
            })->get();

        $four_player_game = Free4playergame::query()
            ->where('status', 0)->where(function ($query) use ($user) {

                $query->orWhere('player_one', $user->id);
                $query->orWhere('player_two', $user->id);
                $query->orWhere('player_three', $user->id);
                $query->orWhere('player_four', $user->id);
            })->get();

        //return count($four_player_game);

        if (count($two_player_game) > 0 || count($three_player_game) > 0 || count($four_player_game) > 0) {
            $incomplete_game = true;
        }

        $additional_info = [
            'incomplete_game' => $incomplete_game,
            'two_player_game' => $two_player_game,
            'three_player_game' => $three_player_game,
            'four_player_game' => $four_player_game,
        ];


        return $additional_info;
    }

    public function user_manage()
    {
        return "okay";
    }


}
