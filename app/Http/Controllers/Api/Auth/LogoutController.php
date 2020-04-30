<?php

namespace App\Http\Controllers\Api\Auth;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function logout()
    {
        $this->auth->invalidate();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ], 200);
    }
}
