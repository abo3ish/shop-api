<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserResource;

class UserController extends Controller
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

    public function update(Request $request)
    {
        $this->auth->user()->update([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number
        ]);

        return response()->json([
            'success' => true,
            'data' => new UserResource($this->auth->user())
        ], 200);
    }
}
