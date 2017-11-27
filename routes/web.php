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
    return view('welcome');
});
//註冊顧客單位資源路由
Route::resource('customer', 'CustomerController');
//註冊協作廠商資源路由
Route::resource('company', 'CompanyController');
//註冊案件資源路由
Route::resource('case', 'CaseController');