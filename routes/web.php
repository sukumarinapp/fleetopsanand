<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/parameter', 'ParameterController@index')->name('parameter');
Route::post('/paramupdate','ParameterController@update')->name('paramupdate');
Route::resource('/rhplatform', 'RHPlatformController');

Route::resource('/manager', 'ManagerController');
Route::post('/checkemail','ManagerController@checkEmail')->name('checkemail');
Route::resource('/client', 'ClientController');
Route::resource('/vehicle', 'VehicleController');
Route::get('/assignvehicle/{id}', 'VehicleController@assign')->name('assignvehicle');
Route::post('/assigndriver','VehicleController@assigndriver')->name('assigndriver');
Route::get('/removevehicle/{id}', 'VehicleController@remove')->name('removevehicle');
Route::post('/removedriver','VehicleController@removedriver')->name('removedriver');
Route::resource('/fdriver', 'FdriverController');
Route::post('/checkDNO','FdriverController@checkDNO')->name('checkDNO');
Route::post('/checkVNO','VehicleController@checkVNO')->name('checkVNO');
Route::get('/sms', 'SMSController@index')->name('sms');
Route::post('/smsupdate','SMSController@update')->name('smsupdate');
Route::get('/change_password','ManagerController@change_password')->name('change_password');
Route::post('/update_password','ManagerController@update_password')->name('update_password');

Route::get('/driver', 'DriverController@index')->name('driver');
Route::get('/drivervno', 'DriverController@drivervno')->name('drivervno');
Route::post('/drivervnovalid', 'DriverController@drivervnovalid')->name('drivervnovalid');
Route::get('/driverrhsales', 'DriverController@driverrhsales')->name('driverrhsales');
Route::get('/driverrental', 'DriverController@driverrental')->name('driverrental');
Route::get('/drivervnoerror', 'DriverController@drivervnoerror')->name('drivervnoerror');
Route::post('/driverpay','DriverController@driverpay')->name('driverpay');
Route::post('/driverpaysave','DriverController@driverpaysave')->name('driverpaysave');
Route::get('/driverpaysuccess', 'DriverController@driverpaysuccess')->name('driverpaysuccess');
Route::post('/billbox', 'DriverController@billbox')->name('billbox');

Route::get('/driverpayerror', 'DriverController@driverpayerror')->name('driverpayerror');
Route::get('/driverhelp/{VNO}/{DCN}', 'DriverController@driverhelp')->name('driverhelp');
Route::get('/driverhelp1/{VNO}/{DCN}', 'DriverController@driverhelp1')->name('driverhelp1');
Route::get('/driverhelp2/{VNO}/{DCN}', 'DriverController@driverhelp2')->name('driverhelp2');
Route::get('/driverhelp3/{VNO}/{DCN}', 'DriverController@driverhelp3')->name('driverhelp3');
Route::get('/driverhelpprev1/{VNO}/{DCN}', 'DriverController@driverhelpprev1')->name('driverhelpprev1');
Route::get('/driverhelpprev2/{VNO}/{DCN}', 'DriverController@driverhelpprev2')->name('driverhelpprev2');
Route::get('/driverhelpprev3/{VNO}/{DCN}', 'DriverController@driverhelpprev3')->name('driverhelpprev3');

Route::get('/workflow', 'WorkflowController@index')->name('workflow');
Route::post('/workflow1', 'WorkflowController@workflow1')->name('workflow1');
Route::get('/auditing', 'WorkflowController@index')->name('auditing');
Route::post('/auditing1', 'WorkflowController@auditing1')->name('auditing1');

Route::get('/locations', 'HomeController@locations')->name('locations');



