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

//homepage
Route::get('/', 'HomepageController@index')->name('homepage.index');

//search
Route::get('/search', 'SearchController@index')->name('search.index');
Route::get('/results', 'SearchController@show')->name('search.show');

//hotel
Route::get('/hotel', 'HotelController@index')->name('hotel.index'); 

//reservations
Route::get('/book', 'ReservationsController@create')->name('reservations.create');
Route::post('/book', 'ReservationsController@store')->name('reservations.store');
Route::get('/confirmation', 'ReservationsController@confirmation')->name('reservations.confirmation');


//autocomplete
Route::get('/autocomplete', 'Autocomplete\ExpediaController@index')->name('autocomplete.index');

//template
Route::get('/template', 'TemplateController@index')->name('template.index');



