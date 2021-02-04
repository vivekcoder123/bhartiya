<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ServiceController;
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

		Route::resource('/users', UserController::class);

		/********************End User********************/


		/******************Start Bank*******************/

		Route::resource('/banks', BankController::class);

		/********************End Bank********************/


		/******************Start Service*******************/

        Route::post('/save_service_form_fields',[ServiceController::class,'save_service_form_fields']);
		Route::resource('/services', ServiceController::class);

		/********************End Service********************/


		/******************Start Staff*******************/

		Route::resource('/staffs', StaffController::class);

		/********************End Staff********************/


		/******************Start Designation*******************/

		Route::resource('/designations', DesignationController::class);

		/********************End Designation********************/




	});
});
