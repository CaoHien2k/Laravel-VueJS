<?php

use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'users','as' => 'users.'], function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/','index');;
        Route::get('/create','create');
        Route::post('/store','store');
        Route::get('/{id}/edit','edit');
        Route::post('/{id}/update','update');
        Route::post('/{id}/delete','delete');
    });
});