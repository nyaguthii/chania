<?php

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



/*
Route::get('/','SessionsController@create');
Route::get('/login','SessionsController@create')->name('login');
Route::post('/login','SessionsController@store');
Route::get('/logout','SessionsController@destroy');
Route::get('/dashboard','SessionsController@index');
*/
Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

/*Route::get('/register','RegistrationController@create');
Route::post('/register','RegistrationController@store');*/

Route::get('/customers/{is_member}/index','CustomersController@index')->name('customers.index');
Route::get('/customers/create','CustomersController@create');
Route::post('/customers','CustomersController@store');
Route::get('/customers/{customer}','CustomersController@show');
Route::get('/customers/{customer}/edit','CustomersController@edit')->name('customers.edit');
Route::post('/customers/{customer}/update','CustomersController@update')->name('customers.update');

Route::get('/customers/{customer}/policies/create','PoliciesController@create')->name('policies.create');
Route::get('/customers/{customer}/policies','PoliciesController@index')->name('policies.index');
Route::get('/customers/{customer}/policies/{policy}/generate','PoliciesController@generate')->name('policies.generate');
Route::get('/customers/{customer}/policies/{policy}','PoliciesController@show')->name('policies.show');
Route::post('/customers/{customer}/policies','PoliciesController@store')->name('policies.store');
Route::get('/customers/{customer}/policies/{policy}/edit','PoliciesController@edit')->name('policies.edit');
Route::post('/customers/{customer}/policies/{policy}/cancel','PoliciesController@cancel')->name('policies.cancel');


Route::post('/policies/{policy}/endorsements','EndorsementsController@store')->name('endorsements.store');
Route::get('/policies/{policy}/endorsements/create','EndorsementsController@create')->name('endorsements.create');
Route::get('/endorsements/{endorsement}/edit','EndorsementsController@edit')->name('endorsements.edit');
Route::post('/endorsements/{endorsement}','EndorsementsController@update')->name('endorsements.update');




Route::post('/policies/{policy}/paymentSchedules','PaymentSchedulesController@store')->name('paymentSchedules.store');
Route::get('/paymentSchedules/due','PaymentSchedulesController@dueForm')->name('paymentSchedules.due.form');
Route::post('/paymentSchedules/due','PaymentSchedulesController@due')->name('paymentSchedules.due');


Route::get('/customers/{customer}/vehicles','VehiclesController@index')->name('vehicles.index');
Route::get('/customers/{customer}/vehicles/create','VehiclesController@create')->name('vehicles.create');
Route::post('/customers/{customer}/vehicles','VehiclesController@store')->name('vehicles.store');
Route::get('/customers/{customer}/vehicles/{vehicle}','VehiclesController@show')->name('vehicles.show');

Route::get('/paymentSchedules/{paymentSchedule}/payments/create','PaymentsController@create')->name('payments.create');
Route::post('/paymentSchedules/{paymentSchedule}/payments','PaymentsController@store')->name('payments.store');


Route::get('/customers/{customer}/payments','PaymentsController@index')->name('payments.index');
Route::get('/customers/{customer}/payments/{payment}','PaymentsController@edit')->name('payments.edit');
Route::post('/customers/{customer}/payments/{payment}/update','PaymentsController@update')->name('payments.update');
Route::get('/payments/daily','PaymentsController@showDailyForm')->name('payments.daily.form');
Route::post('/payments/daily','PaymentsController@getDaily')->name('payments.daily');
Route::get('/payments/range','PaymentsController@showRangeForm')->name('payments.range.form');
Route::post('/payments/range','PaymentsController@getRange')->name('payments.range');




Route::get('/commissions','CommissionsController@index')->name('commissions.index');
Route::get('/commissions/{commission}/create','CommissionPaymentsController@create')->name('commission.payments.create');
Route::post('/commissions/{commission}/payments','CommissionPaymentsController@store')->name('commission.payments.store');

Route::get('/receipts/{receipt}','ReceiptsController@show')->name('receipts.show');

Route::post('/policies/{policy}/refunds','RefundsController@store')->name('refunds.store');
Route::get('/policies/{policy}/refunds/create','RefundsController@create')->name('refunds.create');
Route::get('/refunds','RefundsController@index')->name('refunds.index');
Route::get('/refunds/{refund}/edit','RefundsController@edit')->name('refunds.edit');
Route::post('/refunds/{refund}/update','RefundsController@update')->name('refunds.update');









