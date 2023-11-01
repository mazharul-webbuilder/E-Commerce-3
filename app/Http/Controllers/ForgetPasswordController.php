<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordResetRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ForgetPasswordController extends Controller
{
    public function showForm(string $userType): View
    {
        return  \view('webend.forget_password', compact('userType'));
    }

    /**
     * If Valid Registered Email send a new password to user email
    */
    public function forgetPasswordPost(PasswordResetRequest $request): JsonResponse
    {
        try {
            $user_email = $request->email;
            $randomCode = rand(10000, 20000);

            $data = [
              'subject' => config('app.name') . ' ' . $request->userType . "New Login Password",
              'body' => "<h2>Greeting From Netelmart</h2>
                        <p>Your New Login Password is: $randomCode</p>
                        <p>Please change your password from profile settings</p>
                        <p>Have a Good Day!</p>
                        "
            ];
            mail_template(data: $data, to_mail: $user_email);

            return \response()->json([
                'response' => Response::HTTP_OK,
                'type' => 'success',
                'message' => 'Check you email to get your password.'
            ]);
        } catch (\Exception $exception) {
            return  response()->json([
                'message' => $exception->getMessage(),
                'type' => 'error',
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
