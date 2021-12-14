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
Route::get('/test', 'HomeController@test')->name('test');
Route::get('/replay', 'HomeController@replay')->name('replay');
Route::get('/track/{VNO}/{starttime}/{endtime}','HomeController@track')->name('track');
Route::get('/parameter', 'ParameterController@index')->name('parameter');
Route::post('/paramupdate','ParameterController@update')->name('paramupdate');
Route::resource('/rhplatform', 'RHPlatformController');

Route::resource('/manager', 'ManagerController');
Route::post('/checkemail','ManagerController@checkEmail')->name('checkemail');
Route::post('/duplicateUserContact','ManagerController@duplicateUserContact')->name('duplicateUserContact');
Route::resource('/client', 'ClientController');
Route::resource('/vehicle', 'VehicleController');
Route::get('/assignvehicle/{id}', 'VehicleController@assign')->name('assignvehicle');
Route::post('/assigndriver','VehicleController@assigndriver')->name('assigndriver');
Route::get('/removevehicle/{id}', 'VehicleController@remove')->name('removevehicle');
Route::post('/removedriver','VehicleController@removedriver')->name('removedriver');
Route::resource('/fdriver', 'FdriverController');
Route::post('/checkDNO','FdriverController@checkDNO')->name('checkDNO');
Route::post('/checkDCN','FdriverController@checkDCN')->name('checkDCN');
Route::post('/checkVNO','VehicleController@checkVNO')->name('checkVNO');
Route::post('/tracker_device_sn','VehicleController@tracker_device_sn')->name('tracker_device_sn');
Route::post('/tracker_id','VehicleController@tracker_id')->name('tracker_id');
Route::post('/tracker_sim_no','VehicleController@tracker_sim_no')->name('tracker_sim_no');
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
Route::get('/prompt', 'DriverController@prompt')->name('prompt');
Route::get('/billbox', 'DriverController@billbox')->name('billbox');

Route::get('/balance/{DCR}', 'DriverController@balance')->name('balance');
Route::get('/driverpayerror', 'DriverController@driverpayerror')->name('driverpayerror');
Route::get('/driverhelp/{VNO}/{DCN}', 'DriverController@driverhelp')->name('driverhelp');
Route::get('/resendsms/{VID}', 'VehicleController@resendsms')->name('resendsms');
Route::get('/driverhelp1/{VNO}/{DCN}', 'DriverController@driverhelp1')->name('driverhelp1');
Route::get('/driverhelp2/{VNO}/{DCN}', 'DriverController@driverhelp2')->name('driverhelp2');
Route::get('/driverhelp3/{VNO}/{DCN}', 'DriverController@driverhelp3')->name('driverhelp3');
Route::get('/driverhelpprev1/{VNO}/{DCN}', 'DriverController@driverhelpprev1')->name('driverhelpprev1');
Route::get('/driverhelpprev2/{VNO}/{DCN}', 'DriverController@driverhelpprev2')->name('driverhelpprev2');
Route::get('/driverhelpprev3/{VNO}/{DCN}', 'DriverController@driverhelpprev3')->name('driverhelpprev3');

Route::get('/workflow', 'WorkflowController@index')->name('workflow');
Route::get('/vehiclelog/{from}/{to}', 'WorkflowController@vehiclelog')->name('vehiclelog');
Route::get('/rhreport/{from}/{to}', 'WorkflowController@rhreport')->name('rhreport');
Route::get('/sales/{from}/{to}', 'WorkflowController@sales')->name('sales');
Route::get('/collection/{from}/{to}', 'WorkflowController@collection')->name('collection');
Route::get('/notificationslog/{from}/{to}', 'WorkflowController@notificationslog')->name('notificationslog');
Route::get('/telematicslog/{from}/{to}', 'WorkflowController@telematicslog')->name('telematicslog');
Route::get('/alertlog/{from}/{to}', 'HomeController@alertlog')->name('alertlog');
Route::get('/acknowledge/{id}', 'HomeController@acknowledge')->name('acknowledge');
Route::get('/workflowlog/{from}/{to}', 'WorkflowController@workflowlog')->name('workflowlog');
Route::get('/override/{VNO}', 'WorkflowController@override')->name('override');
Route::get('/overrides/{VNO}', 'WorkflowController@overrides')->name('overrides');
Route::post('/saveoverride', 'WorkflowController@saveoverride')->name('saveoverride');
Route::get('/auditsrch', 'WorkflowController@auditsrch')->name('auditsrch');
Route::get('/auditing/{VNO}/{DCR}', 'WorkflowController@auditing')->name('auditing');
Route::post('/rhresettesting/{DCR}', 'WorkflowController@rhresettesting')->name('rhresettesting');
Route::post('/resendsms/{id}', 'WorkflowController@resendsms')->name('resendsms');
Route::post('/auditingsave', 'WorkflowController@auditingsave')->name('auditingsave');

Route::get('/locations', 'HomeController@locations')->name('locations');
Route::get('/vehicle_location/{VNO}', 'HomeController@vehicle_location')->name('vehicle_location');
Route::get('/initial_location/{VNO}', 'HomeController@initial_location')->name('initial_location');
Route::get('/alerts', 'HomeController@alerts')->name('alerts');

Route::get('/fuelsrch', 'FuelController@fuelsrch')->name('fuelsrch');
Route::get('/fueler/{VNO}', 'FuelController@fueler')->name('fueler');
Route::get('/fuel_consumed/{DCR}', 'WorkflowController@fuel_consumed')->name('fuel_consumed');

Route::get('/help', 'WorkflowController@help')->name('help');

Route::get('/test', 'HomeController@test')->name('test');




