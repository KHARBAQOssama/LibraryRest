<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GenderController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'user'

], function ($router) {
    Route::match(['put','patch'],'account',[UserController::class,'updateSelf']);
    Route::put('change-password',[UserController::class,'changePassword']);
});

Route::group([
    'middleware' => 'api',
    'prefix' =>'password'
],function(){
    Route::post('forget',[AuthController::class , 'forgetPassword']);
    Route::post('reset',[AuthController::class , 'reset']);
});

Route::apiResource('user',UserController::class);
Route::apiResource('book',BookController::class);
Route::apiResource('gender',GenderController::class);
Route::post('role/assign-permissions/{id}',[RoleController::class,'assignPermissions']);
Route::get('role/{role}',[RoleController::class,'show']);
Route::get('role',[RoleController::class,'index']);
