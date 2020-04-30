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
Route::get("/", function () {
    dd(env('CLIENT_BASE_URL'));
    return response()->json([
        "message" => "Hello World!"
    ]);
});

Route::group(['prefix' => 'auth', 'namespace' => 'Api'], function () {
    Route::post('/register', 'Auth\RegisterController@register');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('/login/{service}', 'Auth\SocialLoginController@redirect');
    Route::get('/login/{service}/callback', 'Auth\SocialLoginController@callback');
});

Route::group(['namespace' => 'Api', 'middleware' => ['jwt.auth']], function () {
    Route::get('/me', 'MeController@index');
    Route::get('auth/logout', 'Auth\LogoutController@logout');

    Route::apiResource('/products', 'ProductController');
    Route::apiResource('products/{product}/reviews/', 'ReviewController');
});
