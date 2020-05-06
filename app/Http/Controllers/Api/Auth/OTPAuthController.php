<?php

namespace App\Http\Controllers\Api\Auth;

use App\OTP;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OTPAuthController extends Controller
{
    protected function register(Request $request)
    {
        $validator  = Validator::make($request->all(), [
            'mobile_number' => ['required'],
        ]);

        if (!$validator->fails()) {
            DB::beginTransaction();

            $user = User::where('mobile_number', $request->mobile_number)->first();
            if (!$user) {
                $user = User::create([
                    'mobile_number' => $request->mobile_number
                ]);
            }

            $token = auth('api')->login($user);

            $code = OTP::createCode();
            DB::commit();


            return response()->json([
                'success' => true,
                'data' => [
                    'token' => $token,
                    'code' => $code
                ]
            ]);
        }
        DB::rollBack();
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    protected function login(Request $request)
    {
        $otp = OTP::where('code', $request->code)->first();

        if ($otp && $otp->user_id == auth()->id()) {
            $token = auth()->refresh();

            $otp->delete();

            return response()->json([
                'success' => true,
                'token' => $token,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'errors' => "Invalide Code"
        ], 422);
    }
}
