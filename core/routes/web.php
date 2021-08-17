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

Route::get('/', function () {
    // Index
    return view('av_core::welcome');

    // Maintenance (Bảo trì)
    // return view('av_core::maintenance');
})->name('home');

Route::get('chinhsach', function() {
    return view('av_core::chinhsach');
});

Route::get('redirect/{social}', 'LoginController@redirect');
Route::get('callback/{social}', 'LoginController@callback');
Route::get('verifyPhone','LoginController@verifyPhone');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('test1','LoginController@test1');
// Route::post('test','LoginController@test')->name('test');
Route::post('test','LoginController@test')->name('test');

Route::middleware(['role'])->namespace('Admin')->prefix('admincp')->name('admin.')->group(function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('list-scan', 'ListScanController@index')->name('listScan');
    Route::get('management-member', 'ManagementMemberController@index')->name('management_member');
    Route::get('how-to-use', 'HowToUseController@index')->name('howtouse');
    // affilate
    Route::get('management-affilate','ManagementAffilateController@index')->name('management_affilate');
    Route::get('getAffilate','ManagementAffilateController@getAffilate');

    Route::get('getListScan', 'ListScanController@getListScan');
    Route::post('switchCall', 'ListScanController@switchCall');
    Route::post('changeData', 'ListScanController@changeData');

    Route::get('active', 'ActiveMemberController@index')->name('active');
    Route::get('list-active', 'ActiveMemberController@getListActive');
    Route::post('switchActive', 'ActiveMemberController@switchActive');
    Route::post('changeExpired', 'ActiveMemberController@changeExpired');

    // transaction
    Route::get('payment','PaymentController@index')->name('payment');
    Route::post('order','PaymentController@order')->name('order');
    Route::get('transaction','PaymentController@listTransaction')->name('transaction');
    Route::post('delete-transaction','PaymentController@deleteTransaction')->name('delete-transaction');

    // list-user
    Route::get('getUser','HomeController@getUser')->name('getUser');
    Route::post('switchCallUser', 'HomeController@switchCallUser');
});

// super admin
Route::middleware(['isAdmin'])->namespace('Superadmin')->prefix('admincp')->name('superadmin.')->group(function() {
    Route::get('list-transaction','TransactionController@index')->name('list-transaction');
    Route::get('get-list-transaction','TransactionController@getList');
    Route::post('acceptTransaction','TransactionController@acceptTransaction');
});

