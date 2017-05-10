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
Route::get('/customers/{customer}','CustomersController@show')->name('customers.show');
Route::get('/customers/{customer}/edit','CustomersController@edit')->name('customers.edit');
Route::post('/customers/{customer}/update','CustomersController@update')->name('customers.update');
Route::post('/customers/{is_member}/find','CustomersController@find')->name('customers.find');

Route::get('/customers/{customer}/creditpayments/create','CreditPaymentsController@create')->name('creditpayments.create');
Route::post('/customers/{customer}/creditpayments','CreditPaymentsController@store')->name('creditpayments.store');
Route::get('/creditpayments/{creditPayment}/edit','CreditPaymentsController@edit')->name('creditpayments.edit');
Route::post('/creditpayments/{creditPayment}/update','CreditPaymentsController@update')->name('creditpayments.update');



Route::get('/policies','PoliciesController@index')->name('policies.index');
Route::post('/policies/find','PoliciesController@find')->name('policies.find');
Route::get('/policies/{status}','PoliciesController@status')->name('policies.status');
Route::get('/policies/expired','PoliciesController@expired')->name('policies.expired');


Route::get('/customers/{customer}/policies/create','CustomerPoliciesController@create')->name('customer.policies.create');
Route::get('/customers/{customer}/policies','CustomerPoliciesController@index')->name('customer.policies.index');
Route::get('/customers/{customer}/policies/{policy}/generate','CustomerPoliciesController@generate')->name('customer.policies.generate');
Route::get('/customers/{customer}/policies/{policy}','CustomerPoliciesController@show')->name('customer.policies.show');
Route::post('/customers/{customer}/policies','CustomerPoliciesController@store')->name('customer.policies.store');
Route::get('/customers/{customer}/policies/{policy}/edit','CustomerPoliciesController@edit')->name('customer.policies.edit');
Route::post('/customers/{customer}/policies/{policy}/cancel','CustomerPoliciesController@cancel')->name('customer.policies.cancel');
Route::post('/customers/{customer}/policies/{policy}/suspend','CustomerPoliciesController@suspend')->name('customer.policies.suspend');
Route::post('/customers/{customer}/policies/{policy}/activate','CustomerPoliciesController@activate')->name('customer.policies.activate');
Route::post('/customers/{customer}/policies/{policy}/sustain','CustomerPoliciesController@sustain')->name('customer.policies.sustain');

Route::get('/customers/{customer}/credits/create','CreditsController@create')->name('credits.create');
Route::get('/customers/{customer}/credits','CreditsController@index')->name('credits.index');
Route::post('/customers/{customer}/credits','CreditsController@store')->name('credits.store');
Route::get('/credits/{credit}/edit','CreditsController@edit')->name('credits.edit');
Route::post('/credits/{credit}/update','CreditsController@update')->name('credits.update');

Route::post('/policies/{policy}/endorsements','EndorsementsController@store')->name('endorsements.store');
Route::get('/policies/{policy}/endorsements/create','EndorsementsController@create')->name('endorsements.create');
Route::get('/endorsements/{endorsement}/edit','EndorsementsController@edit')->name('endorsements.edit');
Route::post('/endorsements/{endorsement}','EndorsementsController@update')->name('endorsements.update');




Route::post('/policies/{policy}/paymentSchedules','PaymentSchedulesController@store')->name('paymentSchedules.store');
Route::get('/paymentSchedules/due','PaymentSchedulesController@dueForm')->name('paymentSchedules.due.form');
Route::post('/paymentSchedules/due','PaymentSchedulesController@due')->name('paymentSchedules.due');
Route::post('/paymentSchedules/{customer}/due','PaymentSchedulesController@Customerdue')->name('paymentSchedules.customer.due');


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

Route::get('/payments/totalperday','PaymentsController@totalPerDay')->name('payments.totalperday');


Route::get('/commissions','CommissionsController@index')->name('commissions.index');
//Route::get('/commissions/{commission}','CommissionsController@show')->name('commissions.show');

//Route::get('/commissions/{commission}/create','CommissionPaymentsController@create')->name('commission.payments.create');
//Route::post('/commissions/{commission}/payments','CommissionPaymentsController@store')->name('commission.payments.store');
//Route::get('/commissions/{commission}/payments/{commissionPayment}','CommissionPaymentsController@edit')->name('commissions.payments.edit');
//Route::post('/commissions/{commission}/payments/{commissionPayment}/update','CommissionPaymentsController@update')->name('commissions.payments.update');

Route::get('/receipts/{receipt}','ReceiptsController@show')->name('receipts.show');
Route::get('/creditreceipts/{receipt}','CreditReceiptsController@show')->name('creditReceipts.show');

Route::post('/policies/{policy}/refunds','RefundsController@store')->name('refunds.store');
Route::get('/policies/{policy}/refunds/create','RefundsController@create')->name('refunds.create');
Route::get('/refunds','RefundsController@index')->name('refunds.index');
Route::get('/refunds/{refund}/edit','RefundsController@edit')->name('refunds.edit');
Route::post('/refunds/{refund}/update','RefundsController@update')->name('refunds.update');









