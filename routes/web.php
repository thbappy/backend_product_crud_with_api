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
Route::get('product/create', 'HomeController@create')->name('product.create');
Route::post('product/store', 'HomeController@store')->name('product.store');
Route::get('product/edit/{id}', 'HomeController@edit')->name('product.edit');
Route::post('product/update/{id}', 'HomeController@update')->name('product.update');
Route::delete('product/delete/{id}', 'HomeController@destroy')->name('product.delete');
