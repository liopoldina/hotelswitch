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

//auth
Auth::routes();

//account
Route::get('/dashboard', 'Account\DashboardController@index')->name('dashboard');
Route::get('/reservations', 'Account\ReservationsController@index')->name('reservations');
Route::get('/settings', 'Account\SettingsController@index')->name('settings');

//pages
Route::get('/', 'HomepageController@index')->name('homepage');
Route::get('/search', 'SearchController@index')->name('search');
Route::get('/hotel', 'HotelController@index')->name('hotel');
Route::get('/book', 'BookController@index')->name('book');

//ajax
Route::get('/results', 'Ajax\ResultsController@index')->name('results');
Route::get('/autocomplete', 'Ajax\AutocompleteController@index')->name('autocomplete');

//template
Route::get('/template', 'TemplateController@index')->name('template');



