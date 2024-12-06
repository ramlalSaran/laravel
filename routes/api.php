<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BlockController;
use App\Http\Controllers\Api\AttributeController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('block',BlockController::class);

Route::post('user',[UserController::class,'login']);
Route::post('logout',[UserController::class,'logout'])->middleware('auth:sanctum');
Route::resource('attribute',AttributeController::class);