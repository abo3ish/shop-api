<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth', 'namespace' => 'Api'], function () {
    Route::post('/register', 'Auth\RegisterController@register');
    Route::post('/otp-register', 'Auth\OTPAuthController@register');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('/login/{service}', 'Auth\SocialLoginController@redirect');
    Route::get('/login/{service}/callback', 'Auth\SocialLoginController@callback');
});

Route::group(['namespace' => 'Api', 'middleware' => ['jwt.auth']], function () {
    Route::post('/auth/otp-login', 'Auth\OTPAuthController@login');
    Route::group(['middleware' => ['VerifiedUser']], function () {
        Route::get('/me', 'UserController@index');
        Route::put('/me', 'UserController@update');

        Route::get('auth/logout', 'Auth\LogoutController@logout');

        Route::apiResource('/products', 'ProductController');
        Route::apiResource('products/{product}/reviews', 'ReviewController');

        Route::apiResource('/categories', 'CategoryController');

        Route::resource('cart', 'CartController');

        Route::apiResource('shipping-addresses', 'ShippingAddressController');

        Route::post('/checkout', 'OrderController@checkout');
    });

});
