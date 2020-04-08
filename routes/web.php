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
Route::get('/fund', 'WalletController@fund')->name('fund');
// product
Route::get('/buy/{id}/{slug}', 'ProductController@buy')->name('buy');