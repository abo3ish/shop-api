<?php

namespace App\Http\Controllers\Api;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserResource;

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
            'data' => new UserResource($this->auth->user())
        ], 200);
    }
}
