<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('user/login', 'LoginController@login');
Route::get('loginFb','LoginController@loginFb');// Đăng nhập facebook extension

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('user-info', 'LoginController@getUserInfo'); // Lấy thông tin User
    Route::get('member-info', 'LoginController@getMemberInfo'); // Lấy thông tin tài khoản trên FB
    Route::get('list-scan', 'LoginController@getListScan'); // Show danh sách thông tin tài khoản đã lấy của khách hàng.
});

// Route::middleware(['role'])->namespace('Admin')->group(function() {
//     Route::get('getListScan', 'ListScanController@getListScan');
//     Route::post('switchCall', 'ListScanController@switchCall');
//     Route::post('changeData', 'ListScanController@changeData');
// });
