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
Route::group(['middleware' => 'back'],function(){
	

Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users','UsersController@index')->name('users.index');
Route::get('/tyreshome','TyresController@dashboard')->name('tyres.dashboard');
//Route::get('/insurancehome','InsuranceController@dashboard')->name('insurance.dashboard');
Route::get('/cashiershome','CashiersController@dashboard')->name('cashiers.dashboard');

Route::get('/users/{user}/edit','UsersController@edit')->name('users.edit');
Route::get('/users/{user}/changepassword','UsersController@changepassword')->name('users.changepassword');
Route::post('/users/{user}/updatepassword','UsersController@updatepassword')->name('users.updatepassword');
Route::get('/users/create','UsersController@create')->name('users.create');
Route::post('/users','UsersController@store')->name('users.store');
Route::post('/users/{user}/update','UsersController@update')->name('users.update');
Route::post('/users/{user}/delete','UsersController@delete')->name('users.destroy');

Route::get('/roles','RolesController@index')->name('roles.index');
Route::get('/roles/create','RolesController@create')->name('roles.create');
Route::post('/roles','RolesController@store')->name('roles.store');
Route::get('/roles/{role}/edit','RolesController@edit')->name('roles.edit');
Route::post('/roles/{role}/update','RolesController@update')->name('roles.update');
Route::post('/roles/{role}/delete','RolesController@delete')->name('roles.delete');
//Route::get('/register','RegistrationController@create');
//Route::post('/register','RegistrationController@store');

Route::get('/customers/{is_member}/index','CustomersController@index')->name('customers.index');
Route::get('/customers/create','CustomersController@create')->name('customers.create');
Route::get('/customers/create2','CustomersController@create2')->name('customers.create2');
Route::get('/customers','CustomersController@index2')->name('customers.index2');
Route::get('/customers/membersajax','CustomersController@membersAjax');
Route::get('/customers/nonmembersajax','CustomersController@nonmembersajax');


Route::post('/customers','CustomersController@store')->name('customers.store');
Route::post('/customers2','CustomersController@store2')->name('customers2.store');
Route::get('/customers/{customer}/show','CustomersController@show')->name('customers.show');
Route::get('/customers/{customer}/edit','CustomersController@edit')->name('customers.edit');
Route::post('/customers/{customer}/update','CustomersController@update')->name('customers.update');
Route::post('/customers/{is_member}/find','CustomersController@find')->name('customers.find');
Route::get('/customers/{customer}/statementDate','CustomersController@statementDate')->name('customers.statementdate');
Route::post('/customers/{customer}/statement','CustomersController@statement')->name('customers.statement');

Route::get('/customers/{customer}/tyreStatementDate','CustomersController@tyreStatementDate')->name('customers.tyres.statementdate');
Route::post('/customers/{customer}/tyreStatement','CustomersController@tyreStatement')->name('customers.tyres.statement');
Route::get('/customers/overpayments','CustomersController@overPayments')->name('customers.overpayments');
Route::get('/customers/underpayments','CustomersController@underPayments')->name('customers.underpayments');

Route::get('/customers/{customer}/creditpayments/create','CreditPaymentsController@create')->name('creditpayments.create');
Route::post('/customers/{customer}/creditpayments','CreditPaymentsController@store')->name('creditpayments.store');
Route::get('/creditpayments/{creditPayment}/edit','CreditPaymentsController@edit')->name('creditpayments.edit');
Route::post('/creditpayments/{creditPayment}/update','CreditPaymentsController@update')->name('creditpayments.update');



//Route::get('/policies','PoliciesController@index')->name('policies.index');
//Route::post('/policies/find','PoliciesController@find')->name('policies.find');
//Route::get('/policies/{status}','PoliciesController@status')->name('policies.status');
//Route::get('/policies/expired','PoliciesController@expired')->name('policies.expired');

Route::get('/policies/active/ajax','PoliciesController@ajaxActive');
Route::get('/policies/activepolicies/ajax','PoliciesController@active')->name('policies.active.ajax');
Route::get('/policies/cancelled/ajax','PoliciesController@ajaxCancelled');
Route::get('/policies/cancelledpolicies/ajax','PoliciesController@cancelled')->name('policies.cancelled.ajax');
Route::get('/policies/suspended/ajax','PoliciesController@ajaxSuspended');
Route::get('/policies/suspendedpolicies/ajax','PoliciesController@suspended')->name('policies.suspended.ajax');
Route::get('/policies/expired/ajax','PoliciesController@ajaxExpired');
Route::get('/policies/expiredpolicies/ajax','PoliciesController@expired')->name('policies.expired.ajax');

Route::get('/customers/{customer}/policies/create','CustomerPoliciesController@create')->name('customer.policies.create');
Route::get('/customers/{customer}/policies','CustomerPoliciesController@index')->name('customer.policies.index');
Route::get('/customers/{customer}/policies/{policy}/generate','CustomerPoliciesController@generate')->name('customer.policies.generate');
Route::get('/customers/{customer}/policies/{policy}/show','CustomerPoliciesController@show')->name('customer.policies.show');
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
Route::get('/paymentSchedules/duetomorrow','PaymentSchedulesController@dueTomorrow')->name('due.tomorrow');

Route::get('/vehicles/overpayments','VehiclesController@overpayments')->name('vehicles.overpayments');
Route::get('/vehicles/underpayments','VehiclesController@underpayments')->name('vehicles.underpayments');

Route::get('/vehicles','VehiclesController@index')->name('vehicles.index');
Route::get('/vehicles/{vehicle}/statementDate','VehiclesController@statementDate')->name('vehicles.statementdate');
Route::get('/vehicles/ajax','VehiclesController@ajax')->name('vehicles.ajax');
Route::post('/vehicles/{vehicle}/statement','VehiclesController@statement')->name('vehicles.statement');
Route::post('/vehicles/find','VehiclesController@find')->name('vehicles.find');



Route::get('/paymentSchedules/{paymentSchedule}/payments/create','PrePaymentsController@create')->name('prepayments.create');
Route::post('/paymentSchedules/{paymentSchedule}/payments','PrePaymentsController@store')->name('prepayments.store');
Route::post('/paymentSchedules/{paymentSchedule}/update','PrePaymentsController@update')->name('prepayments.update');

Route::get('/paymentSchedules/{paymentSchedule}/edit','PaymentSchedulesController@edit')->name('paymentSchedules.edit');
Route::post('/paymentSchedules/{paymentSchedule}/update2','PaymentSchedulesController@update2')->name('paymentSchedules.update2');

Route::get('/customers/{customer}/payments','PrePaymentsController@index')->name('prepayments.index');
Route::get('/customers/{customer}/payments/{payment}/edit','PrePaymentsController@edit')->name('prepayments.edit');
Route::get('/payments/daily','PrePaymentsController@showDailyForm')->name('prepayments.daily.form');
Route::post('/payments/daily','PrePaymentsController@getDaily')->name('prepayments.daily');
Route::get('/payments/range','prePaymentsController@showRangeForm')->name('prepayments.range.form');
Route::post('/payments/range','PrePaymentsController@getRange')->name('prepayments.range');



Route::get('/customers/{customer}/vehicles/create','CustomerVehiclesController@create')->name('customers.vehicles.create');
Route::get('/customers/{customer}/vehicles/{vehicle}/show','CustomerVehiclesController@show')->name('customers.vehicles.show');
Route::get('/customers/{customer}/vehicles','CustomerVehiclesController@index')->name('customers.vehicles.index');
Route::post('/customers/{customer}/vehicles','CustomerVehiclesController@store')->name('customers.vehicles.store');

Route::get('/vehicles/{vehicle}/edit','CustomerVehiclesController@edit')->name('customers.vehicles.edit');
Route::post('/vehicles/{vehicle}/update','CustomerVehiclesController@update')->name('customers.vehicles.update');

Route::get('/payments/totalperday','PrePaymentsController@totalPerDay')->name('prepayments.totalperday');
Route::get('/payments/dailytotaldayajax','PrePaymentsController@totalPerDayAjax');
Route::get('/payments/dailytotalday','PrePaymentsController@getTotalPerDayAjax')->name('prepayments.totalperdayajax');
Route::get('/payments/dailytotaldayajax2','PrePaymentsController@totalPerDayAjax2');
Route::get('/payments/dailytotalday2','PrePaymentsController@getTotalPerDayAjax2')->name('prepayments.totalperdayajax2');
Route::get('/payments/dailytotaldayajax3','PrePaymentsController@totalPerDayAjax3');
Route::get('/payments/dailytotalday3','PrePaymentsController@getTotalPerDayAjax3')->name('prepayments.totalperdayajax3');
Route::get('/payments/dailytotaldayajax4','PrePaymentsController@totalPerDayAjax4');
Route::get('/payments/dailytotalday4','PrePaymentsController@getTotalPerDayAjax4')->name('prepayments.totalperdayajax4');

Route::get('/commissions','CommissionsController@index')->name('commissions.index');
Route::get('/commissions/monthlyajax','CommissionsController@monthlyajax');
Route::get('/commissions/monthly','CommissionsController@monthly')->name('commissions.monthly');
Route::get('/commissions/yearlyajax','CommissionsController@yearlyajax');
Route::get('/commissions/yearly','CommissionsController@yearly')->name('commissions.yearly');
//Route::get('/commissions/{commission}','CommissionsController@show')->name('commissions.show');

//Route::get('/commissions/{commission}/create','CommissionPaymentsController@create')->name('commission.payments.create');
//Route::post('/commissions/{commission}/payments','CommissionPaymentsController@store')->name('commission.payments.store');
//Route::get('/commissions/{commission}/payments/{commissionPayment}','CommissionPaymentsController@edit')->name('commissions.payments.edit');
//Route::post('/commissions/{commission}/payments/{commissionPayment}/update','CommissionPaymentsController@update')->name('commissions.payments.update');

Route::get('/receipts/{payment}/show','ReceiptsController@show')->name('receipts.show');
Route::post('/receipts/{receipt}/print','ReceiptsController@print')->name('receipts.print');
Route::get('/creditreceipts/{receipt}','CreditReceiptsController@show')->name('creditReceipts.show');

Route::post('/policies/{policy}/refunds','RefundsController@store')->name('refunds.store');
Route::get('/policies/{policy}/refunds/create','RefundsController@create')->name('refunds.create');
Route::get('/refunds','RefundsController@index')->name('refunds.index');
Route::get('/refunds/{refund}/edit','RefundsController@edit')->name('refunds.edit');
Route::post('/refunds/{refund}/update','RefundsController@update')->name('refunds.update');
Route::get('/refunds/ajax','RefundsController@ajax');
Route::get('/refundsAjax','RefundsController@indexAjax')->name('refunds.indexajax');

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
Route::get('/suspensions/ajax','PolicySuspensionsController@ajax');
Route::get('/suspensionsAjax','PolicySuspensionsController@indexAjax')->name('suspensions.indexajax');

Route::get('/policies/{policy}/cancellations/create','PolicyCancellationsController@create')->name('cancellations.create');
Route::post('/policies/{policy}/cancellations','PolicyCancellationsController@store')->name('cancellations.store');
Route::post('/policies/{policy}/activate','PolicyCancellationsController@activate')->name('cancellations.activate');
Route::get('/cancellations/index','PolicyCancellationsController@index')->name('cancellations.index');
Route::get('/cancellations/ajax','PolicyCancellationsController@ajax');
Route::get('/cancellationsAjax','PolicyCancellationsController@indexAjax')->name('cancellations.indexajax');

Route::get('/policies/{policy}/claims/create','PolicyClaimsController@create')->name('claims.create');
Route::post('/policies/{policy}/claims','PolicyClaimsController@store')->name('claims.store');
Route::get('/claims/index','PolicyClaimsController@index')->name('claims.index');
Route::get('/claims/{claim}/edit','PolicyClaimsController@edit')->name('claims.edit');
Route::post('/claims/{claim}/update','PolicyClaimsController@update')->name('claims.update');
Route::get('/claims/ajax','PolicyClaimsController@ajax');
Route::get('claims/indexAjax','PolicyClaimsController@indexAjax')->name('claims.ajax.index');

Route::get('/carriers/create','CarriersController@create')->name('carriers.create');
Route::get('/carriers/index','CarriersController@index')->name('carriers.index');
Route::post('/carriers','CarriersController@store')->name('carriers.store');
Route::post('/carriers/{carrier}','CarriersController@delete')->name('carriers.destroy');

//Route::get('/vehicles/{vehicle}/payments/create','VehiclePaymentsController@create')->name('vehicles.payments.create');
//Route::post('/vehicles/{vehicle}/payments','VehiclePaymentsController@store')->name('vehicles.payments.store');
//Route::get('/dailyPayments/{dailyPayment}/edit','VehiclePaymentsController@edit')->name('vehicles.payments.edit');
//Route::post('/dailyPayments/{dailyPayment}/update','VehiclePaymentsController@update')->name('vehicles.payments.update');

/*Route::get('/vehicleAccounts/{vehicleAccount}/vehicleTransactions/create','VehicleTransactionsController@create')->name('vehicleAccounts.transactions.create');
Route::post('/vehicleAccounts/{vehicleAccount}/vehicleTransactions','VehicleTransactionsController@store')->name('vehicleAccounts.transactions.store');
Route::get('/vehicleTransactions/{vehicleTransactions}/edit','VehicleTransactionsController@edit')->name('vehicleAccounts.transactions.edit');
Route::post('/vehicleTransactions/{vehicleTransactions}/update','VehicleTransactionsController@update')->name('vehicleAccounts.transactions.update');*/



Route::get('/vehicles/{vehicle}/vehicleCredits/create','VehicleCreditsController@create')->name('vehicles.credits.create');
Route::get('/vehicles/{vehicle}/vehicleCredits','VehicleCreditsController@index')->name('vehicles.credits.index');
Route::post('/vehicles/{vehicle}/vehicleCredits','VehicleCreditsController@store')->name('vehicles.credits.store');
Route::get('/vehicleCredits/{vehicleCredit}/edit','VehicleCreditsController@edit')->name('vehicles.credits.edit');
Route::post('/vehicleCredits/{vehicleCredit}/update','VehicleCreditsController@update')->name('vehicles.credits.update');

Route::get('/claims/{claim}/excesses/create','ExcessesController@create')->name('excesses.create');
Route::post('/claims/{claim}/excesses','ExcessesController@store')->name('excesses.store');
Route::get('/excesses/{excess}/edit','ExcessesController@edit')->name('excesses.edit');
Route::post('/excesses/{excess}/update','ExcessesController@update')->name('excesses.update');

Route::get('/products','ProductsController@index')->name('products.index');
Route::post('/products','ProductsController@store')->name('products.store');
Route::get('/products/create','ProductsController@create')->name('products.create');
Route::get('/products/{product}/edit','ProductsController@edit')->name('products.edit');
Route::post('/products/{product}/update','ProductsController@update')->name('products.update');
Route::get('/products/{product}/delete','ProductsController@delete')->name('products.delete');
Route::post('/products/{product}/destroy','ProductsController@destroy')->name('products.destroy');
Route::get('/productsajax','ProductsController@ajax');

Route::get('/inouts','MaterialTransactionsController@index')->name('inout.index');
Route::get('/inoutajax','MaterialTransactionsController@ajax');
Route::get('/products/{product}/inout/create','MaterialTransactionsController@create')->name('inout.create');
Route::post('/products/{product}/inouts','MaterialTransactionsController@store')->name('inout.store');
Route::get('/inouts/{materialTransaction}/edit','MaterialTransactionsController@edit')->name('inout.edit');
Route::post('/inouts/{materialTransaction}/update','MaterialTransactionsController@update')->name('inout.update');
Route::post('/inouts/{materialTransaction}/delete','MaterialTransactionsController@delete')->name('inout.delete');

Route::get('/orders','OrdersController@index')->name('orders.index');
Route::get('/orders/create','OrdersController@create')->name('orders.create');
Route::post('/orders','OrdersController@store')->name('orders.store');
Route::get('/orders/ajax','OrdersController@ajax');
Route::get('/orders/{order}/show','OrdersController@show')->name('orders.show');
Route::get('/orders/{order}/edit','OrdersController@edit')->name('orders.edit');
Route::post('/orders/{order}/update','OrdersController@update')->name('orders.update');
Route::get('/orders/{order}/delete','OrdersController@delete')->name('orders.delete');
Route::post('/orders/{order}/destroy','OrdersController@destroy')->name('orders.destroy');
Route::get('/orders/dailysales','OrdersController@dailySales')->name('daily.sales.tyres');
Route::get('/orders/dailysalesajax','OrdersController@dailySalesAjax');
Route::get('/orders/dailypayments','OrdersController@dailyPayments')->name('daily.payments.tyres');
Route::get('/orders/dailypaymentsajax','OrdersController@dailyPaymentsAjax');


//cashier routes
Route::get('/cashiers','CashiersController@index')->name('cashiers.index');
Route::get('/cashiers/members','CashiersController@members')->name('cashiers.members');
Route::get('/cashiers/nonmembers','CashiersController@nonMembers')->name('cashiers.nonmembers');

Route::get('vehicless/{vehicle}/payments/create','PaymentsController@create')->name('payments.create');
Route::post('/vehicless/{vehicle}/payments','PaymentsController@store')->name('payments.store');
Route::get('/payments/ajax','PaymentsController@ajax')->name('payments.ajax');
Route::get('/payments','PaymentsController@index')->name('payments.index');
Route::get('/payments/{payment}/edit','PaymentsController@edit')->name('payments.edit');
Route::post('/payments/{payment}/destroy','PaymentsController@destroy')->name('payments.destroy');
Route::post('/payments/{payment}/update','PaymentsController@update')->name('payments.update');
Route::get('/payments/{payment}/delete','PaymentsController@delete')->name('payments.delete');
Route::get('/excess/ajax','PaymentsController@excessAjax');
Route::get('/excess/index','PaymentsController@excess')->name('excess.ajax.index');


Route::get('/paymenttypes','PaymentTypesController@index')->name('paymenttypes.index');
Route::get('/paymenttypes/create','PaymentTypesController@create')->name('paymenttypes.create');
Route::post('/paymenttypes','PaymentTypesController@store')->name('paymenttypes.store');
Route::get('/paymenttypes/{paymentType}/edit','PaymentTypesController@edit')->name('paymenttypes.edit');
Route::post('/paymenttypes/{paymentType}/update','PaymentTypesController@update')->name('paymenttypes.update');
Route::post('/paymenttypes/{paymentType}/destroy','PaymentTypesController@destroy')->name('paymenttypes.destroy');

Route::get('/customers/{customer}/payments/create','CustomerPaymentsController@create')->name('payments.customers.create');
Route::post('/customers/{customer}/payments','CustomerPaymentsController@store')->name('payments.customers.store');

//this route handles the members sub modules
Route::get('/members/getmembersajax','MembersController@getMembersAjax');
Route::get('/members/getnonmembersajax','MembersController@getNonMembersAjax');
Route::get('/getmembers','MembersController@getMembers')->name('members.index');
Route::get('/getnonmembers','MembersController@getNonMembers')->name('nonmembers.index');

Route::get('/insurance/getmembersajax','InsuranceController@getMembersAjax');
Route::get('/insurance/getnonmembersajax','InsuranceController@getNonMembersAjax');
Route::get('/insurance/getmembers','InsuranceController@getMembers')->name('insurancemembers.index');
Route::get('/insurance/getnonmembers','InsuranceController@getNonMembers')->name('insurancenonmembers.index');
Route::get('/insurance/getvehiclesajax','InsuranceController@vehiclesajax');
Route::get('/insurance/getvehicles','InsuranceController@vehicles')->name('insurance.vehicles');

Route::get('/tyres/differenceajax','TyresController@differenceAjax');
Route::get('/tyres/difference','TyresController@difference')->name('tyres.difference');

Route::get('/customers/tyres','CustomerTyresController@index')->name('customers.tyres.index');
Route::get('/customers/{customer}/tyres/show','CustomerTyresController@show')->name('customers.tyres.show');
Route::get('/customers/tyres/ajax','CustomerTyresController@ajax');

Route::get('/customers/{customer}/tyres/credits/create','TyreCreditsController@create')->name('tyres.credits.create');
Route::post('/customers/{customer}/tyres/credits/store','TyreCreditsController@store')->name('tyres.credits.store');
Route::get('/customers/{customer}/tyres/credits','TyreCreditsController@index')->name('tyres.credits.index');
Route::get('/tyres/credits/{credit}/edit','TyreCreditsController@edit')->name('tyres.credits.edit');
Route::post('/tyres/credits/{credit}/update','TyreCreditsController@update')->name('tyres.credits.update');
Route::get('/tyres/credits/{credit}/delete','TyreCreditsController@delete')->name('tyres.credits.delete');
Route::post('/tyres/credits/{credit}/destroy','TyreCreditsController@destroy')->name('tyres.credits.destroy');

Route::get('/customers/{customer}/tyres/payments','TyrePaymentsController@index')->name('tyres.payments.index');
Route::get('/customers/{customer}/tyres/statementdates','TyrePaymentsController@statementDates')->name('tyres.statement.dates');

Route::get('/sacco/payments','SaccoPaymentsController@index')->name('sacco.payments.index');
Route::get('/sacco/paymentsAjax','SaccoPaymentsController@paymentsAjax');
Route::get('/sacco/customers','SaccoPaymentsController@customers')->name('sacco.customers');
Route::get('/sacco/customersAjax','SaccoPaymentsController@customersAjax');
Route::get('/sacco/customers/{customer}/show','SaccoPaymentsController@show');

Route::get('/customers/{customer}/sacco/statementDate','SaccoPaymentsController@statementDate')->name('customers.sacco.statementdate');
Route::post('/customers/{customer}/sacco/statement','SaccoPaymentsController@statement')->name('customers.sacco.statement');

Route::get('generate-pdf/{customer}', 'PdfController@insurance')->name('generate-pdf');
Route::get('/places','PlacesController@index')->name('places.index');
Route::post('/places','PlacesController@store')->name('places.store');
Route::get('/places/create','PlacesController@create')->name('places.create');
Route::get('/places/{place}/edit','PlacesController@edit')->name('places.edit');
Route::post('/places/{place}/update','PlacesController@update')->name('places.update');
Route::post('/places/{place}/delete','PlacesController@delete')->name('places.delete');

});