<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\{
    HomeController,
    UserController,
    RelationshipController
};

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
// Route::group(['middleware'=>'auth.sanctum'],function(){

// });
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

//Relationships
Route::get('/members-company',[RelationshipController::class,'membersCompany']);
Route::get('/members-details',[RelationshipController::class,'membersDetails']);
Route::get('/company-details',[RelationshipController::class,'companyDetails']);
//Many To Many Relationships
Route::post('/add-companies',[RelationshipController::class,'add_company']);
Route::post('/add-members',[RelationshipController::class,'add_member']);
Route::get('show-companies',[RelationshipController::class,'show_companies']);
Route::get('show-members',[RelationshipController::class,'show_members']);

//hasOneThrough
Route::get('/member-companydetails',[RelationshipController::class,'member_companydetails']);

//hasOneOfMany
Route::get('/hasOneOfMany',[RelationshipController::class,'latest_oldest_offMany']);

//Polymorphic Relationships
Route::get('/morphOne',[RelationshipController::class,'morphOne']);
Route::get('/morphMany',[RelationshipController::class,'morphMany']);
Route::get('/morphedByMany',[RelationshipController::class,'morphedByMany']);
