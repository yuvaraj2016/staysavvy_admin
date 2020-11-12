<?php

use App\Http\Controllers\UserController;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
//use Session;
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
   
})->name('home');
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::post('/login', 'UserController@login')->name('userlogin');

Route::get('/logout', 'UserController@logout')->name('logout')->middleware('checktoken');

// Route::resource('albums', 'AlbumController');
// Route::resource('albums.photo', 'PhotoController');
// Route::resource('testimonials', 'TestimonialsController');

Route::resource('bookings', 'BookingController')->except('index')->middleware('checktoken');;

Route::get('booking_list/{page?}','BookingController@index')->name('booking.index')->middleware('checktoken');;


Route::resource('status', 'StatusController')->except('index')->middleware('checktoken');

Route::get('status_list/{page?}','StatusController@index')->name('status.index')->middleware('checktoken');

Route::resource('property', 'PropertyController')->except('index')->middleware('checktoken');

Route::get('property_list/{page?}','PropertyController@index')->name('property.index')->middleware('checktoken');



Route::resource('host', 'HosttypeController')->except('index')->middleware('checktoken');

Route::get('host_list/{page?}','HosttypeController@index')->name('host.index')->middleware('checktoken');



Route::resource('properties', 'PropertiesController')->except('index')->middleware('checktoken');

Route::get('properties_list/{page?}','PropertiesController@index')->name('properties.index')->middleware('checktoken');




Route::resource('tax', 'TaxController')->except('index')->middleware('checktoken');

Route::get('tax_list/{page?}','TaxController@index')->name('tax.index')->middleware('checktoken');



Route::resource('roomtype', 'BookingroomController')->except('index')->middleware('checktoken');

Route::get('booking_room_list/{page?}','BookingroomController@index')->name('roomtype.index')->middleware('checktoken');


Route::resource('booksts', 'BookingstatusController')->except('index')->middleware('checktoken');

Route::get('booking_status_list/{page?}','BookingstatusController@index')->name('booksts.index')->middleware('checktoken');



Route::resource('amenity', 'AmenitiesController')->except('index')->middleware('checktoken');

Route::get('amenity_list/{page?}','AmenitiesController@index')->name('amenity.index')->middleware('checktoken');


Route::resource('payment', 'PaymentController')->except('index')->middleware('checktoken');

Route::get('payment_list/{page?}','PaymentController@index')->name('payment.index')->middleware('checktoken');

Route::resource('profile', 'ProfileController')->except('index')->middleware('checktoken');

Route::get('show_profile/{page?}','ProfileController@index')->name('profile.index')->middleware('checktoken');

// Route::put('update_password', 'ProfileController@updatepassword')->name('update_password')->middleware('checktoken');

// Route::get('change_password','ProfileController@passwordedit')->name('change_password.index')->middleware('checktoken');


Route::resource('users', 'UserController')->except('index')->middleware('checktoken');

Route::get('user_list/{page?}','UserController@index')->name('user.index')->middleware('checktoken');



Route::resource('roles', 'RoleController')->except('index')->middleware('checktoken');

Route::get('role_list/{page?}','RoleController@index')->name('role.index')->middleware('checktoken');


Route::resource('permissions', 'PermissionController')->except('index')->middleware('checktoken');

Route::get('permission_list/{page?}','PermissionController@index')->name('permission.index')->middleware('checktoken');



Route::resource('settings', 'SettingsController')->except('index')->middleware('checktoken');



Route::post('assets/storeimage/{module}/{id}', 'AssetsController@store')->name('assets.storeimage')->middleware('checktoken');

Route::resource('assets', 'AssetsController')->except('store')->middleware('checktoken');



Route::get('{slug?}/{id}/edit/assets','AssetsController@editimage')->name('assets.edit')->middleware('checktoken');



Route::resource('commission', 'CommissionController')->except('index')->middleware('checktoken');

Route::get('commission_list/{page?}','CommissionController@index')->name('commission.index')->middleware('checktoken');


Route::resource('rooms', 'RoomController')->except('index')->middleware('checktoken');

Route::get('rooms_list/{page?}','RoomController@index')->name('rooms.index')->middleware('checktoken');


Route::resource('profile', 'ProfileController')->except('index')->middleware('checktoken');

Route::get('show_profile/{page?}','ProfileController@index')->name('profile.index')->middleware('checktoken');



Route::put('update_password', 'ProfileController@updatepassword')->name('update_password')->middleware('checktoken');

Route::get('change_password','ProfileController@passwordedit')->name('change_password.index')->middleware('checktoken');


Route::get('getuser', function () {
    return 1;
});

