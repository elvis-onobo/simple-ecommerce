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
// wallet
Route::get('/wallet', 'WalletController@index')->name('wallet');
Route::get('/enter-funds', 'WalletController@enter_fund')->name('enter-funds');
Route::post('/fund-wallet', 'WalletController@fund_wallet')->name('fund-wallet');
Route::get('/fund-wallet', 'WalletController@fund_wallet')->name('fund-wallet');
Route::get('/gift', 'WalletController@gift')->name('gift');
Route::post('/gift', 'WalletController@gift_fund')->name('gift-fund');
Route::get('/verify/{reference}', 'WalletController@verify')->name('verify');
Route::get('/history', 'WalletController@history')->name('history');
// product
Route::get('/buy/{id}/{slug}', 'ProductController@buy')->name('buy');
Route::get('/buy-from-wallet/{id}', 'ProductController@buy_from_wallet')->name('buy-from-wallet');
Route::get('/card-buy/verify/{reference}', 'PurchaseController@verify')->name('verify-purchase');
