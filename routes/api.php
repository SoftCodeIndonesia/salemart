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

Route::group([
    'namespace' => 'App\Http\Controllers\api'
], function () {
    Route::post('rules', 'RulesController@store')->middleware('jwt.verify');
    Route::get('rules', 'RulesController@show')->middleware('jwt.verify');

    Route::post('auth', 'AuthController@store');
    Route::post('auth/verification', 'AuthController@verification');
    Route::post('auth/login', 'AuthController@login');
    Route::post('auth/logout', 'AuthController@logout')->middleware('jwt.verify');

    Route::get('user', 'UsersController@show')->middleware('jwt.verify');

    Route::post('category', 'CategoryController@store')->middleware('jwt.verify');
    Route::get('category', 'CategoryController@show')->middleware('jwt.verify');
    Route::put('category', 'CategoryController@update')->middleware('jwt.verify');
    Route::post('/category/delete', 'CategoryController@destroy')->middleware('jwt.verify');


    Route::post('/store', 'StoreController@store')->middleware('jwt.verify');
    Route::get('/store', 'StoreController@show')->middleware('jwt.verify');
    Route::delete('/store/destroy', 'StoreController@destroy')->middleware('jwt.verify');
    Route::put('/store/edit', 'StoreController@update')->middleware('jwt.verify');

    Route::post('/feature', 'FeatureController@store')->middleware('jwt.verify');
    Route::get('/feature', 'FeatureController@show')->middleware('jwt.verify');

    Route::get('/holder/feat', 'HolderFeatController@show')->middleware('jwt.verify');
    Route::get('/holder/feat/detail', 'HolderFeatController@detail')->middleware('jwt.verify');
    Route::get('/holder/myfeat', 'HolderFeatController@holderFeat')->middleware('jwt.verify');


    Route::post('/holder/permission_user', 'UserHolderPermissionController@store');
});