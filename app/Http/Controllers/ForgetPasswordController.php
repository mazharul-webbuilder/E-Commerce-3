<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\Admin;
use App\Models\Affiliate\Affiliator;
use App\Models\Merchant\Merchant;
use App\Models\Seller\Seller;
use App\Models\VerificationCode;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgetPasswordController extends Controller
{
    public function showForm(string $userType): View
    {
        return  \view('webend.forget_password', compact('userType'));
    }

    /**
     * If Valid Registered Email send a validation code to user email
    */
    public function forgetPasswordPost(PasswordResetRequest $request): JsonResponse
    {
        try {
            $user_email = $request->email;
            $randomCode = rand(10000, 20000);
            DB::beginTransaction();

            VerificationCode::create([
                'type' => 'email',
                'email_or_phone' => $user_email,
                'verify_code' => $randomCode,
            ]);

            $data = [
              'subject' => config('app.name') . ' ' . $request->userType . "New Login Password",
              'body' => "<h2>Greeting From Netelmart</h2>
                        <p>Your New Login Password is: $randomCode</p>
                        <p>Please change your password from profile settings</p>
                        <p>Have a Good Day!</p>
                        "
            ];
            mail_template(data: $data, to_mail: $user_email);
            DB::commit();


            return \response()->json([
                'response' => Response::HTTP_OK,
                'type' => 'success',
                'message' => 'Check you email to get your password.'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return  response()->json([
                'message' => $exception->getMessage(),
                'type' => 'error',
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display Password reset form
    */
    public function passwordResetForm($userType): View
    {

        return \view('webend.password_reset_form', compact('userType'));
    }

    /**
     * Reset new Password
    */
    public function passwordResetPost(ResetPasswordRequest $request)
    {
        try {
            $verification = VerificationCode::where('verify_code', $request->verification_code)->first();

            DB::beginTransaction();

            switch ($request->userType){
                case 'admin':
                    $admin = Admin::where('email', '=' , $verification->email_or_phone)->first();
                    $admin->password = Hash::make($request->password);
                    $admin->save();
                    break;
                case 'merchant':
                    $merchant = Merchant::where('email', $verification->email_or_phone)->first();
                    $merchant->password = Hash::make($request->password);
                    $merchant->save();
                    break;
                case 'seller':
                    $seller = Seller::where('email', $verification->email_or_phone)->first();
                    $seller->password = Hash::make($request->password);
                    $seller->save();
                    break;
                case 'affiliator':
                    $affiliator = Affiliator::where('email', $verification->email_or_phone)->first();
                    $affiliator->password = Hash::make($request->password);
                    $affiliator->save();
                    break;
            }
            $verification->delete();

            DB::commit();

            return \response()->json([
                'type' => 'success',
                'response' => Response::HTTP_OK,
                'message' => 'Password Changed Successfully'
            ]);

        } catch (QueryException $exception) {
            DB::rollBack();

            return \response()->json([
                'type' => 'error',
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $exception->getMessage()
            ]);
        }

    }
}
