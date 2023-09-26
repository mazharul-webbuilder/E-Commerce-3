<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        //return "okay";
//        if ($request->expectsJson()){
//            'message'=>'Unauthenticated',
//                'status'=>Response::HTTP_UNAUTHORIZED,
//            ].Response::HTTP_UNAUTHORIZED);
//        }      return response()->json([

        $guard=Arr::get($exception->guards(),0);
        switch ($guard){
            case 'admin':
                $login='show.login';
                break;
            case 'api':
                 return response()->json(
                    [
                        'message'=>'Unauthenticated',
                        'status'=>Response::HTTP_UNAUTHORIZED,
                    ],Response::HTTP_UNAUTHORIZED);
                break;
            default:
                $login='show.login';
                break;
        }

        return redirect()->guest(route($login));

       // return parent::unauthenticated($request, $exception);
    }
}
