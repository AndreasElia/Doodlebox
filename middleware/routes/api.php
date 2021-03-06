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

Route::group(['middleware' => 'api'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
    });

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('logout', 'AuthController@logout');
        });

        Route::get('user', 'UserController@user');

        Route::group(['prefix' => 'users'], function () {
            Route::put('details', 'UserController@details');
            Route::get('doodles/{user_id}', 'UserController@doodles');
        });

        Route::group(['prefix' => 'doodles'], function () {
            Route::get('all/{page?}/{limit?}/{search?}', 'DoodleController@all');
        });

        Route::resource('doodles', 'DoodleController');
        Route::resource('doodle-comments', 'DoodleCommentController');
        Route::resource('doodle-ratings', 'DoodleRatingController');
    });
});
