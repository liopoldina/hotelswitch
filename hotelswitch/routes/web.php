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
Auth::routes(['verify' => true]);

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

//account
Route::get('/my_reservations', 'Account\MyReservationsController@index')->name('my_reservations');
Route::get('/settings', 'Account\SettingsController@index')->name('settings');
Route::put('/settings', 'Account\SettingsController@update')->name('settings.update');

//autocomplete
Route::get('/autocomplete', 'Autocomplete\ExpediaController@index')->name('autocomplete.index');

//template
Route::get('/template', 'TemplateController@index')->name('template.index');



