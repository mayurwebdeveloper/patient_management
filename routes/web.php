<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontSettingController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PmJayController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SpecialityController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/privacy-policy', function () {
    return view('home.privacy');
});

Route::get('/', function () {
    return view('home.landing');
});

Auth::routes();

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
  ]);


Route::prefix('/admin')->middleware(['auth'])->group(function () {

    // dashboard routes
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

    // profile routes
    Route::get('/profile',[ProfileController::class,'index'])->name('profile')->middleware('permission:view profile');
    Route::post('/profile',[ProfileController::class,'update'])->name('edit-profile')->middleware('permission:edit profile');

    // settings routes
    Route::get('/settings',[SettingsController::class,'index'])->name('settings')->middleware('permission:view settings');
    Route::post('/settings',[SettingsController::class,'update'])->name('edit-settings')->middleware('permission:edit settings');


    // enquiries Module
    Route::prefix('/enquiries')->middleware('permission:view enquiries')->group(function () {
        Route::get('/',[NotificationController::class,'index'])->name('enquiries');
        Route::post('/deleteSelected',[NotificationController::class,'deleteSelected'])->name('enquiry.deleteSelected')->middleware('permission:delete enquiry');
        Route::get('/delete/{id}',[NotificationController::class,'destroy'])->name('enquiry-delete')->middleware('permission:delete enquiry');
        Route::get('/show/{id}',[NotificationController::class,'show'])->name('enquiry-show')->middleware('permission:view enquiries');
        Route::get('/mark/{enquiry}',[NotificationController::class,'mark'])->name('enquiry-mark')->middleware('permission:mark enquiry');
    });


    // users, role permission Module
    Route::prefix('/users')->middleware('permission:view users')->group(function () {
        Route::get('/',[UserController::class,'index'])->name('users');
        Route::post('/deleteSelected',[UserController::class,'deleteSelected'])->name('user.deleteSelected')->middleware('permission:delete user');
        Route::post('/',[UserController::class,'store'])->name('user-save')->middleware('permission:add user');
        Route::get('/delete/{id}',[UserController::class,'destroy'])->name('user-delete')->middleware('permission:delete user');
        Route::get('/edit/{id?}', [UserController::class, 'show'])->name('user-edit')->middleware('permission:edit user');
    });

    Route::prefix('/doctors')->middleware('permission:view doctors')->group(function () {
        Route::get('/',[DoctorController::class,'index'])->name('doctors');
        Route::post('/deleteSelected',[DoctorController::class,'deleteSelected'])->name('doctor.deleteSelected')->middleware('permission:delete doctor');
        Route::post('/',[DoctorController::class,'store'])->name('doctor-save')->middleware('permission:add doctor');
        Route::get('/delete/{id}',[DoctorController::class,'destroy'])->name('doctor-delete')->middleware('permission:delete doctor');
        Route::get('/edit/{id?}', [DoctorController::class, 'show'])->name('doctor-edit')->middleware('permission:edit doctor');
    });

    Route::prefix('/patients')->middleware('permission:view patients')->group(function () {
        Route::get('/',[PatientController::class,'index'])->name('patients');
        Route::post('/deleteSelected',[PatientController::class,'deleteSelected'])->name('patient.deleteSelected')->middleware('permission:delete patient');
        Route::post('/',[PatientController::class,'store'])->name('patient-save')->middleware('permission:add patient');
        Route::get('/delete/{id}',[PatientController::class,'destroy'])->name('patient-delete')->middleware('permission:delete patient');
        Route::get('/edit/{id?}', [PatientController::class, 'show'])->name('patient-edit')->middleware('permission:edit patient');
    });

    // permissions
    Route::prefix('/permissions')->middleware('permission:view permissions')->group(function () {
        Route::get('/',[PermissionController::class,'index'])->name('permissions');
        Route::post('/deleteSelected',[PermissionController::class,'deleteSelected'])->name('permission.deleteSelected')->middleware('permission:delete permission');
        Route::post('/',[PermissionController::class,'store'])->name('permission-save')->middleware('permission:add permission');
        Route::get('/delete/{id}',[PermissionController::class,'destroy'])->name('permission-delete')->middleware('permission:delete permission');
        Route::get('/edit/{id?}', [PermissionController::class, 'show'])->name('permission-edit')->middleware('permission:edit permission');
    });


    // role
    Route::prefix('/roles')->middleware('permission:view roles')->group(function () {
        Route::get('/',[RoleController::class,'index'])->name('roles');
        Route::post('/deleteSelected',[RoleController::class,'deleteSelected'])->name('role.deleteSelected')->middleware('permission:delete role');
        Route::post('/',[RoleController::class,'store'])->name('role-save')->middleware('permission:add role');
        Route::get('/delete/{id}',[RoleController::class,'destroy'])->name('role-delete')->middleware('permission:delete role');
        Route::get('/edit/{id?}', [RoleController::class, 'show'])->name('role-edit')->middleware('permission:edit role');
        Route::post('/permission',[RoleController::class,'permissionUpdate'])->name('update-role-permission')->middleware('permission:assign role-permissions');
        Route::get('/permission/{id}',[RoleController::class,'permissionEdit'])->name('edit-role-permission')->middleware('permission:assign role-permissions');
    });


    // Hospital Module
    Route::prefix('/hospital')->middleware('permission:view hospitals')->group(function () {
        Route::get('/',[HospitalController::class,'index'])->name('hospitals');
        Route::post('/deleteSelected',[HospitalController::class,'deleteSelected'])->name('hospital.deleteSelected')->middleware('permission:delete hospital');
        Route::get('/delete/{id}',[HospitalController::class,'destroy'])->name('hospital-delete')->middleware('permission:delete hospital');
        Route::get('/create',[HospitalController::class,'create'])->name('add-hospital-form')->middleware('permission:add hospital');
        Route::post('/store',[HospitalController::class,'store'])->name('add-hospital')->middleware('permission:add hospital');
        Route::get('/edit/{id}',[HospitalController::class,'edit'])->name('edit-hospital-form')->middleware('permission:edit hospital');
        Route::post('/update',[HospitalController::class,'update'])->name('update-hospital')->middleware('permission:edit hospital');
        Route::get('/show/{id}',[HospitalController::class,'show'])->name('view-hospital');

        // hospital working hours
        Route::get('/time-edit/{id}',[HospitalController::class,'timeEdit'])->name('edit-hospital-time-form')->middleware('permission:edit hospital');
        Route::post('/time-update',[HospitalController::class,'timeUpdate'])->name('update-hospital-time')->middleware('permission:edit hospital');

        // ajax for dynamic district and subdivision
        Route::get('/getDistrict/{id}',[HospitalController::class,'getDistrict'])->name('get-district');
        Route::get('/getSubdivision/{id}',[HospitalController::class,'getSubdivision'])->name('get-subdivision');
        
    });

    

    // PM JAY Resources Module
    Route::prefix('/pm-jay-resource')->middleware('permission:view pm-jay-resources')->group(function () {
        Route::get('/',[PmJayController::class,'index'])->name('pm-jay-resources');
        Route::post('/deleteSelected',[PmJayController::class,'deleteSelected'])->name('pm-jay-resource.deleteSelected')->middleware('permission:delete pm-jay-resource');
        Route::get('/delete/{id}',[PmJayController::class,'destroy'])->name('pm-jay-resource-delete')->middleware('permission:delete pm-jay-resource');
        Route::get('/create',[PmJayController::class,'create'])->name('add-pm-jay-resource-form')->middleware('permission:add pm-jay-resource');
        Route::post('/store',[PmJayController::class,'store'])->name('add-pm-jay-resource')->middleware('permission:add pm-jay-resource');
        Route::get('/edit/{id}',[PmJayController::class,'edit'])->name('edit-pm-jay-resource-form')->middleware('permission:edit pm-jay-resource');
        Route::post('/update',[PmJayController::class,'update'])->name('update-pm-jay-resource')->middleware('permission:edit pm-jay-resource');
        Route::get('/show/{id}',[PmJayController::class,'show'])->name('view-pm-jay-resource');
    });


    // Sliders Module
    Route::prefix('/slider')->middleware('permission:view sliders')->group(function () {
        Route::get('/',[SliderController::class,'index'])->name('sliders');
        Route::post('/deleteSelected',[SliderController::class,'deleteSelected'])->name('slider.deleteSelected')->middleware('permission:delete slider');
        Route::get('/delete/{id}',[SliderController::class,'destroy'])->name('slider-delete')->middleware('permission:delete slider');
        Route::get('/create',[SliderController::class,'create'])->name('add-slider-form')->middleware('permission:add slider');
        Route::post('/store',[SliderController::class,'store'])->name('add-slider')->middleware('permission:add slider');
        Route::get('/edit/{id}',[SliderController::class,'edit'])->name('edit-slider-form')->middleware('permission:edit slider');
        Route::post('/update',[SliderController::class,'update'])->name('update-slider')->middleware('permission:edit slider');
        Route::get('/show/{id}',[SliderController::class,'show'])->name('view-slider');
    });

    //speciality module
    Route::prefix('/specialities')->middleware('permission:view specialities')->group(function () {
        Route::get('/',[SpecialityController::class,'index'])->name('specialities');
        Route::post('/deleteSelected',[SpecialityController::class,'deleteSelected'])->name('speciality.deleteSelected')->middleware('permission:delete speciality');
        Route::post('/',[SpecialityController::class,'store'])->name('speciality-save')->middleware('permission:add speciality');
        Route::get('/delete/{id}',[SpecialityController::class,'destroy'])->name('speciality-delete')->middleware('permission:delete speciality');
        Route::get('/edit/{id?}', [SpecialityController::class, 'show'])->name('speciality-edit')->middleware('permission:edit speciality');
    });    


    // front side setting routes
    Route::get('/front-setting',[FrontSettingController::class,'index'])->name('front-setting')->middleware('permission:view front-setting');
    Route::post('/front-setting',[FrontSettingController::class,'update'])->name('edit-front-setting')->middleware('permission:edit front-setting');
       
});


Route::get('/clear-all', function () {
    // Clear the application cache
    Artisan::call('cache:clear');
    
    // Clear and reload route cache
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    
    // Dump the autoloader
    Artisan::call('clear-compiled');
    Artisan::call('optimize');
    
    dd('Cache, routes, autoload, and optimization cleared successfully.');
});

