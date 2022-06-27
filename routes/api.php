<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\HomeController;
use App\Http\Controllers\api\UserController;


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

Route::get('/home/index',[HomeController::class,'index'])->name('login');
Route::post('/home',[HomeController::class,'create']);
Route::put('/home/update',[HomeController::class,'update']);
Route::delete('/home/delete',[HomeController::class,'delete']);
Route::get('/home/search',[HomeController::class,'search']);

Route::post('login',[UserController::class,'login']);
Route::post('register',[UserController::class,'register']);
Route::group(['middleware'=> ['auth:api']],function(){
    Route::get('details',[UserController::class,'details']);
});
