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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::view('/', 'welcome');

Auth::routes();

Route::redirect('/home', '/')->name('home');

Route::get('/blog', 'BlogController@index');
Route::get('/blog/{id}', 'BlogController@show');

Route::get('/admin', 'AdminController@halamanawal')->middleware('auth', 'admin');
Route::get('/admin/export', 'AdminController@export')->middleware('auth', 'admin');
Route::get('/admin/create', 'AdminController@create')->middleware('auth', 'admin');
Route::post('/admin/create-post', 'AdminController@store')->middleware('auth', 'admin');

Route::get('/admin/edit/{id}', 'AdminController@edit')->middleware('auth', 'admin');
Route::post('/admin/edit/{id}', 'AdminController@update')->middleware('auth', 'admin');

Route::post('/admin/delete/{id}', 'AdminController@delete')->middleware('auth', 'admin');