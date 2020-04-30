<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Tymon\JWTAuth\JWTAuth;
use App\Models\SocialLogin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }
    public function redirect($service)
    {
        return Socialite::driver($service)->stateless()->redirect();
    }

    public function callback($service)
    {
        $socialUser = Socialite::driver($service)->stateless()->user();
        $user = $this->getExistingUser($socialUser);

        $email = $socialUser->getId() . "@" . $service . ".com";
        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $email,
                'password' => '',
                'image' => $socialUser->getAvatar()
            ]);
            SocialLogin::create([
                'user_id' => $user->id,
                'service' => $service,
                'social_id' => $socialUser->getId()
            ]);
        }
        return redirect(env('CLIENT_BASE_URL') . '/auth/social-callback?token=' . $this->auth->fromUser($user));

    }

    public function getExistingUser($socialUser)
    {
        $socialUser = SocialLogin::where('social_id', $socialUser->getId())->first();
        return $socialUser->user ?? null;
    }
}
