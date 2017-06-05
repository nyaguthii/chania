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
Route::get('/users',[
		'uses'=>'UsersController@index',
		'middleware'=>'roles',
		'roles'=>'Admin'
	])->name('users.index');
Route::get('/users/{user}/edit','UsersController@edit')->name('users.edit');
Route::post('/users/{user}/update','UsersController@update')->name('users.update');
Route::post('/users/{user}/delete','UsersController@delete')->name('users.destroy');

/*Route::get('/register','RegistrationController@create');
Route::post('/register','RegistrationController@store');*/

Route::get('/customers/{is_member}/index','CustomersController@index')->name('customers.index');
Route::get('/customers/create','CustomersController@create')->name('customers.create');
Route::get('/customers/create2','CustomersController@create2')->name('customers.create2');

Route::post('/customers','CustomersController@store')->name('customers.store');
Route::post('/customers2','CustomersController@store2')->name('customers2.store');
Route::get('/customers/{customer}','CustomersController@show')->name('customers.show');
Route::get('/customers/{customer}/edit','CustomersController@edit')->name('customers.edit');
Route::post('/customers/{customer}/update','CustomersController@update')->name('customers.update');
Route::post('/customers/{is_member}/find','CustomersController@find')->name('customers.find');
Route::get('/customers/{customer}/statementDate','CustomersController@statementDate')->name('customers.statementdate');
Route::post('/customers/{customer}/statement','CustomersController@statement')->name('customers.statement');


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
Route::post('/policies/{policy}/update','CustomerPoliciesController@update')->name('customer.policies.update');

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

Route::get('/vehicles/overpayments','VehiclesController@overpayments')->name('vehicles.overpayments');
Route::get('/vehicles/underpayments','VehiclesController@underpayments')->name('vehicles.underpayments');
Route::get('/vehicles','VehiclesController@index')->name('vehicles.index');
Route::get('/vehicles/{vehicle}/statementDate','VehiclesController@statementDate')->name('vehicles.statementdate');
Route::post('/vehicles/{vehicle}/statement','VehiclesController@statement')->name('vehicles.statement');
Route::post('/vehicles/find','VehiclesController@find')->name('vehicles.find');






Route::get('/paymentSchedules/{paymentSchedule}/payments/create','PaymentsController@create')->name('payments.create');
Route::post('/paymentSchedules/{paymentSchedule}/payments','PaymentsController@store')->name('payments.store');
Route::post('/paymentSchedules/{paymentSchedule}/update','PaymentsController@update')->name('payments.update');

Route::get('/customers/{customer}/payments','PaymentsController@index')->name('payments.index');
Route::get('/customers/{customer}/payments/{payment}','PaymentsController@edit')->name('payments.edit');
Route::get('/payments/daily','PaymentsController@showDailyForm')->name('payments.daily.form');
Route::post('/payments/daily','PaymentsController@getDaily')->name('payments.daily');
Route::get('/payments/range','PaymentsController@showRangeForm')->name('payments.range.form');
Route::post('/payments/range','PaymentsController@getRange')->name('payments.range');

Route::get('/customers/{customer}/vehicles/create','CustomerVehiclesController@create')->name('customers.vehicles.create');
Route::get('/customers/{customer}/vehicles/{vehicle}','CustomerVehiclesController@show')->name('customers.vehicles.show');
Route::get('/customers/{customer}/vehicles','CustomerVehiclesController@index')->name('customers.vehicles.index');
Route::post('/customers/{customer}/vehicles','CustomerVehiclesController@store')->name('customers.vehicles.store');

Route::get('/vehicles/{vehicle}','CustomerVehiclesController@edit')->name('customers.vehicles.edit');
Route::post('/vehicles/{vehicle}/update','CustomerVehiclesController@update')->name('customers.vehicles.update');

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

Route::get('/banktranstactions/create','BankTransactionsController@create')->name('banktransactions.create');
Route::get('/banktranstactions/index','BankTransactionsController@index')->name('banktransactions.index');
Route::post('/banktranstactions','BankTransactionsController@store')->name('banktransactions.store');
Route::get('/banktranstactions/{bankTransaction}/edit','BankTransactionsController@edit')->name('banktransactions.edit');
Route::post('/banktranstactions/{bankTransaction}/update','BankTransactionsController@update')->name('banktransactions.update');



Route::get('/policies/{policy}/suspensions/create','PolicySuspensionsController@create')->name('suspensions.create');
Route::post('/policies/{policy}/suspensions','PolicySuspensionsController@store')->name('suspensions.store');
Route::get('/suspensions/{suspension}/edit','PolicySuspensionsController@edit')->name('suspensions.edit');
Route::get('/suspensions/index','PolicySuspensionsController@index')->name('suspensions.index');
Route::post('/suspensions/{suspension}/update','PolicySuspensionsController@update')->name('suspensions.update');
Route::post('/suspensions/{suspension}/sustain','PolicySuspensionsController@sustain')->name('suspensions.sustain');
Route::get('/policies/{policy}/suspension','PolicySuspensionsController@show')->name('suspensions.show');

Route::get('/policies/{policy}/cancellations/create','PolicyCancellationsController@create')->name('cancellations.create');
Route::post('/policies/{policy}/cancellations','PolicyCancellationsController@store')->name('cancellations.store');
Route::post('/policies/{policy}/activate','PolicyCancellationsController@activate')->name('cancellations.activate');
Route::get('/cancellations/index','PolicyCancellationsController@index')->name('cancellations.index');

Route::get('/policies/{policy}/claims/create','PolicyClaimsController@create')->name('claims.create');
Route::post('/policies/{policy}/claims','PolicyClaimsController@store')->name('claims.store');
Route::get('/claims/index','PolicyClaimsController@index')->name('claims.index');
Route::get('/claims/{claim}/edit','PolicyClaimsController@edit')->name('claims.edit');
Route::post('/claims/{claim}/update','PolicyClaimsController@update')->name('claims.update');

Route::get('/carriers/create','CarriersController@create')->name('carriers.create');
Route::get('/carriers/index','CarriersController@index')->name('carriers.index');
Route::post('/carriers','CarriersController@store')->name('carriers.store');
Route::post('/carriers/{carrier}','CarriersController@delete')->name('carriers.destroy');

Route::get('/vehicles/{vehicle}/payments/create','VehiclePaymentsController@create')->name('vehicles.payments.create');
Route::post('/vehicles/{vehicle}/payments','VehiclePaymentsController@store')->name('vehicles.payments.store');
Route::get('/dailyPayments/{dailyPayment}/edit','VehiclePaymentsController@edit')->name('vehicles.payments.edit');
Route::post('/dailyPayments/{dailyPayment}/update','VehiclePaymentsController@update')->name('vehicles.payments.update');

/*Route::get('/vehicleAccounts/{vehicleAccount}/vehicleTransactions/create','VehicleTransactionsController@create')->name('vehicleAccounts.transactions.create');
Route::post('/vehicleAccounts/{vehicleAccount}/vehicleTransactions','VehicleTransactionsController@store')->name('vehicleAccounts.transactions.store');
Route::get('/vehicleTransactions/{vehicleTransactions}/edit','VehicleTransactionsController@edit')->name('vehicleAccounts.transactions.edit');
Route::post('/vehicleTransactions/{vehicleTransactions}/update','VehicleTransactionsController@update')->name('vehicleAccounts.transactions.update');*/



Route::get('/vehicles/{vehicle}/vehicleCredits/create','VehicleCreditsController@create')->name('vehicles.credits.create');
Route::get('/vehicles/{vehicle}/vehicleCredits','VehicleCreditsController@index')->name('vehicles.credits.index');
Route::post('/vehicles/{vehicle}/vehicleCredits','VehicleCreditsController@store')->name('vehicles.credits.store');
Route::get('/vehicleCredits/{vehicleCredit}/edit','VehicleCreditsController@edit')->name('vehicles.credits.edit');
Route::post('/vehicleCredits/{vehicleCredit}/update','VehicleCreditsController@update')->name('vehicles.credits.update');






