<?php

use App\Http\Controllers\Api\FrontSettingController;
use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Api\DoctorsController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PmJayController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\SpecialityController;
use App\Http\Controllers\Api\WorkPlaceController;
use App\Http\Controllers\API\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);



// contact apis
Route::post('/contact-us',[NotificationController::class,'store']);


// slider apis
Route::get('/sliders',[SliderController::class,'index']);
Route::get('/slider/{code?}',[SliderController::class,'show']);


// PMJAY resources apis
Route::get('/pmjay-resource/{id?}',[PmJayController::class,'show']);
Route::get('/pmjay-resource-list',[PmJayController::class,'index']);


// hospital apis
Route::post('/hospitals',[HospitalController::class,'index']);
Route::get('/hospital/{id?}',[HospitalController::class,'show']);

// hospital apis
Route::post('/doctors',[DoctorsController::class,'index']);
Route::get('/hospital/{id?}',[DoctorsController::class,'show']);


// speciality apis
Route::get('/specialities',[SpecialityController::class,'index']);

// work places api
Route::get('/work-place-types',[WorkPlaceController::class,'index']);


// front side counts apis
Route::get('/front-counts',[FrontSettingController::class,'index']);

