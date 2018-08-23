<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login','AuthController@authenticate');
    Route::post('/logout','AuthController@logout');
    Route::post('/check','AuthController@check');
    Route::post('/register','AuthController@register');
    Route::get('/activate/{token}','AuthController@activate');
    Route::post('/password','AuthController@password');
    Route::post('/validate-password-reset','AuthController@validatePasswordReset');
    Route::post('/reset','AuthController@reset');
    Route::post('/social/token','SocialAuthController@getToken');
});

 //http://localhost:8084/auth/github/callback
 //Route::get('auth/github', 'Auth\AuthController@redirectToProvider');
 //Route::get('auth/github/callback', 'Auth\AuthController@handleProviderCallback');
 //Route::get('auth/github', 'AuthController@redirectToProvider');
 //Route::get('auth/github/callback', 'AuthController@handleProviderCallback');

Route::group(['middleware' => ['jwt.auth']], function () {
  Route::get('/auth/user','AuthController@getAuthUser');
  Route::get('/task','TaskController@index');
  Route::get('/task/{id}','TaskController@show');
  Route::post('/task','TaskController@store');
  Route::patch('/task/{id}','TaskController@update');
  Route::delete('/task/{id}','TaskController@destroy');
  
  Route::post('/task/status','TaskController@toggleStatus');

  Route::get('/saude','SaudeController@index');
  Route::get('/saude/{id}','SaudeController@show');
  Route::post('/saude','SaudeController@store');
  Route::patch('/saude/{id}','SaudeController@update');
  Route::delete('/saude/{id}','SaudeController@destroy');

    Route::get('/configuration/fetch','ConfigurationController@index');
    Route::post('/configuration','ConfigurationController@store');

    Route::get('/user','UserController@index');
    Route::post('/user/change-password','AuthController@changePassword');
    Route::post('/user/update-profile','UserController@updateProfile');
    Route::post('/user/update-avatar','UserController@updateAvatar');
    Route::post('/user/remove-avatar','UserController@removeAvatar');
    Route::delete('/user/{id}','UserController@destroy');
    Route::get('/user/dashboard','UserController@dashboard');

    Route::post('todo','TodoController@store');
    Route::get('/todo','TodoController@index');
    Route::delete('/todo/{id}','TodoController@destroy');
    Route::post('/todo/status','TodoController@toggleStatus');
});
