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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//pages
Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('/search', 'SearchController@index')->name('search');
Route::get('/hotel', 'HotelController@index')->name('hotel');

//xhr
Route::get('/xhr', 'XhrController@index')->name('xhr');
Route::get('/autocomplete', 'AutocompleteController@index')->name('autocomplete');



//template
Route::get('/template', 'TemplateController@index')->name('template');



