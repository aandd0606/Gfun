<?php
//use \Illuminate\Support\Facades\Route
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
Route::resource('project', 'ProjectController');
//註冊收據資源路由
Route::resource('receipt', 'ReceiptController');
//註冊project中有receipt表單修改的路由
Route::get('project/{id}/edit/{receipt_id}','ProjectController@show');
//註冊收據細項資源路由
//Route::resource('product', 'ProductController');
//Route::get('product/{receipt_id}/receipt','ProductController@create');
Route::get('product/receipt/{receipt_id}','ProductController@create')->name('product.create');
Route::post('product','ProductController@store')->name('product.store');
Route::delete('product/{id}','ProductController@destroy')->name('product.destroy');
Route::put('product/{id}','ProductController@update')->name('product.update');
Route::get('product/receipt/{receipt_id}/edit/{id}','ProductController@create')->name('product.receipt');
Route::get('product/orderword/{receipt_id}','ProductController@orderWord')->name('product.orderword');
Route::get('product/receiptword/{receipt_id}','ProductController@receiptWord')->name('product.receiptWord');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
