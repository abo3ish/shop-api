<?php

namespace App\Http\Controllers\Api\Auth;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $auth;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function login(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return response()->json([
                'success' => false,
                'errors' => [
                    'Yoou have been locked out'
                ]
            ]);
        }

        if ($token = $request->token) {
            $user = $this->loginWithToken($token);
            if ($user) {
                return response()->json([
                    'success' => true,
                    'token' => $token,
                    'user' => $this->auth->user(),
                ], 200);
            }
        } else {
            try {
                if (!$token = $this->auth->attempt($request->only(['email', 'password']))) {
                    return response()->json([
                        'success' => false,
                        'errors' => [
                            'Invalid Email or Password'
                        ]
                    ], 422);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'Something Went Wrong, Please try Agian'
                    ]
                ], 500);
            }
        }

        $this->incrementLoginAttempts($request);
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $this->auth->user(),
        ], 200);
    }

    protected function loginWithToken($token)
    {
        $this->auth->setToken($token);
        $user = $this->auth->authenticate();

        return $user;
    }
}
