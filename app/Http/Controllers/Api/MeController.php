<?php

namespace App\Http\Controllers\Api;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class MeController extends Controller
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => $this->auth->user(),
        ], 200);
    }
}
