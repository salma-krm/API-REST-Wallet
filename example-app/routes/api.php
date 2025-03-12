<?php

use App\Http\Controllers\HelloController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserAuthController;
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
Route::get('/helloWorld',[HelloController::class,'index']);
Route::get('/getData',[HelloController::class,'getData']);

Route::post('register',[UserAuthController::class,'register']);
Route::middleware('auth:sanctum')->post('/transaction',[TransactionController::class,'create']);
Route::post('logout',[UserAuthController::class,'logout'])
  ->middleware('auth:sanctum');