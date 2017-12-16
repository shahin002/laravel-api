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

Route::prefix('v1')->group(function () {
    Route::post('sign-in', 'Api\UserController@login');
    Route::post('sign-up', 'Api\UserController@register');


    /*Authenticated routes */
    Route::group(['middleware' => 'auth:api'], function () {

//        Route::get('user-info', 'Api\UserController@userDetails');
//        Route::get('user-info/{id}', 'Api\UserController@userDetailsById');
        Route::post('logout', 'Api\UserController@logout');
        /*Post routes*/
//        Route::resource('post', 'Api\PostsController')->only('index', 'store', 'show', 'update', 'destroy');
//        Route::get('my-list', 'Api\PostsController@my_list');
//        /*End Post routes*/
//
//        /*Like routes*/
//        Route::resource('like', 'Api\LikeController')->only('store', 'destroy');
//        /*End Like Route*/
//
//        /*Comment Route*/
//        Route::resource('comment', 'Api\CommentController')->only('store', 'show', 'update', 'destroy');
//        /*End Comment routes*/
//
//        /*Comment Reply routes*/
//        Route::resource('comment-reply', 'Api\CommentReplyController')->only('store', 'show', 'update', 'destroy');
//        /*End Comment Reply routes*/
//
//        /*Follow routes*/
//        Route::resource('follow', 'Api\FollowController')->only('store', 'destroy');
//        Route::get('my-following', 'Api\FollowController@my_following');
//        /*End Follow routes*/
//
//        /*User Details routes*/
//        Route::resource('user-details', 'Api\UserDetailController')->only('store', 'show');
//        /*End User Details Routes*/
//
//        /*Share Routes*/
//        Route::resource('share', 'Api\ShareController')->only('store', 'show', 'update', 'destroy');
//        /*End Share Routes*/
    });

});
