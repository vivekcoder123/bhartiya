<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\BankController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    If(Auth::check())
        {
            return redirect('/login');
        }else{
            return redirect('/login');
        }
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

	Route::prefix('admin')->group(function () {

		/******************Start dashboard*******************/

		Route::resource('/dashboard', DashboardController::class);

		/******************End dashboard*******************/


		/******************Start User*******************/

		Route::put('users/update/{id}',[UserController::class,'updateUser']);
        Route::post('/users/change-status',[UserController::class,'changeStatus']);
		Route::post('/users/getDeleteSelectedImages', [UserController::class,'getDeleteSelectedImages']);
		Route::resource('/users', UserController::class);

		/********************End User********************/


		/******************Start Enquery*******************/

        Route::get('/enquiries/get_dynamic_data',[EnquiryController::class,'get_dynamic_data']);
		Route::resource('/enquiries', EnquiryController::class);

		/********************End Enquery********************/


		/******************Start Bank*******************/
		Route::post('/banks/change-status',[BankController::class,'changeStatus']);
		Route::resource('/banks', BankController::class);
		Route::get('/get-banks', [BankController::class,'getBanks'])->name('get-banks');


		/********************End Bank********************/


		/******************Start Service*******************/

        Route::post('/save_service_form_fields',[ServiceController::class,'save_service_form_fields']);
        Route::put('services/update/{id}',[ServiceController::class,'updateService']);
        //Route::delete('services/{id}',[ServiceController::class,'deleteService']);
        Route::post('/services/change-status',[ServiceController::class,'changeStatus']);
		Route::resource('/services', ServiceController::class);

		/********************End Service********************/


		/******************Start Staff*******************/


		Route::post('/staffs/getDeleteSelectedImages', [StaffController::class,'getDeleteSelectedImages']);
		Route::post('/save_staff_incentive',[StaffController::class,'save_staff_incentive']);
		Route::post('/save_staff_target',[StaffController::class,'save_staff_target']);
		Route::put('staffs/update/{id}',[StaffController::class,'updateStaff']);
		//Route::post('/staffs/{id}', [StaffController::class,'destroy']);
		Route::resource('/staffs', StaffController::class);

		/********************End Staff********************/


		/******************Start Designation*******************/

		Route::post('/designations/change-status',[DesignationController::class,'changeStatus']);
		Route::resource('/designations', DesignationController::class);
		Route::get('/get-designations', [DesignationController::class,'getdesignations'])->name('get-designations');

		/********************End Designation********************/


		/******************Start Location*******************/

		Route::post('/locations/change-status',[LocationController::class,'changeStatus']);
		Route::resource('/locations', LocationController::class);
		Route::get('/get-locations', [LocationController::class,'getlocations'])->name('get-locations');

		/********************End Location********************/




	});
});
