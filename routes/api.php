<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('books/','BookController@index')->name('index');
// Route::get('crear','BookController@create')->name('create');
Route::post('/books/create/{isbn}','BookController@store')->name('store');
Route::get('books/{isbn}','BookController@show')->name('show');

Route::delete('books/delete/{isbn}','BookController@destroy')->name('destroy');
