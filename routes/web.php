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

Route::get('/','BookController@index')->name('index');
Route::get('crear','BookController@create')->name('create');
Route::post('/store','BookController@store')->name('store');
Route::get('/detalles/{isbn}','BookController@show')->name('show');

Route::delete('/eliminar/{isbn}','BookController@destroy')->name('destroy');
