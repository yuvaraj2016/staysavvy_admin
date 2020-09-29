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
    //$request->session()->put('token', $value);
    //return Http::get('http://restschool.hridham.com/api/getAllAlbums')->json();
})->name('home');
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::post('/login', 'UserController@login');

Route::get('/logout', 'UserController@logout')->name('logout')->middleware('checktoken');

Route::resource('albums', 'AlbumController');
Route::resource('albums.photo', 'PhotoController');
Route::resource('testimonials', 'TestimonialsController');

Route::resource('bookings', 'ProductCategoryController')->except('index')->middleware('checktoken');

Route::get('booking_list/{page?}','ProductCategoryController@index')->name('booking.index')->middleware('checktoken');

Route::get('getprodSubcat/{id}','ProductCategoryController@getsubcategories')->name('getsubcategories')->middleware('checktoken');

Route::get('getallprodSubcat','ProductSubCategoryController@getallsubcategories')->name('getallprodSubcat')->middleware('checktoken');

Route::resource('product_sub_categories', 'ProductSubCategoryController')->except('index')->middleware('checktoken');

Route::get('product_sub_cat_list/{page?}','ProductSubCategoryController@index')->name('product_sub_cat.index')->middleware('checktoken');


Route::resource('supplier_categories', 'SupplierCategoryController')->except('index')->middleware('checktoken');

Route::get('supplier_cat_list/{page?}','SupplierCategoryController@index')->name('supplier_cat.index')->middleware('checktoken');


Route::resource('vendor_categories', 'VendorCategoryController')->except('index')->middleware('checktoken');

Route::get('vendor_cat_list/{page?}','VendorCategoryController@index')->name('vendor_cat.index')->middleware('checktoken');

Route::resource('status', 'StatusController')->except('index')->middleware('checktoken');

Route::get('status_list/{page?}','StatusController@index')->name('status.index')->middleware('checktoken');


Route::resource('ordertype', 'OrdertypeController')->except('index')->middleware('checktoken');

Route::get('ordertype_list/{page?}','OrdertypeController@index')->name('ordertype.index')->middleware('checktoken');



Route::resource('payment', 'PaymentController')->except('index')->middleware('checktoken');

Route::get('payment_list/{page?}','PaymentController@index')->name('payment.index')->middleware('checktoken');


Route::resource('items', 'ItemController')->except('index')->middleware('checktoken');

Route::get('item_list/{page?}','ItemController@index')->name('item.index')->middleware('checktoken');

Route::get('getitemvariants/{id}','ItemController@getitemvariants')->name('getitemvariants')->middleware('checktoken');

Route::get('getallitemvariants','ItemVariantController@getallitemvariants')->name('getallitemvariants')->middleware('checktoken');



Route::resource('item_variants', 'ItemVariantController')->except('index')->middleware('checktoken');

Route::get('item_variant_list/{page?}','ItemVariantController@index')->name('item_variant.index')->middleware('checktoken');



Route::resource('item_variants_group', 'ItemVariantgroupController')->except('index')->middleware('checktoken');

Route::get('item_variant_group_list/{page?}','ItemVariantgroupController@index')->name('item_variant_group.index')->middleware('checktoken');






Route::resource('stock_masters', 'StockMasterController')->except('index')->middleware('checktoken');

Route::get('stock_master_list/{page?}','StockMasterController@index')->name('stock_master.index')->middleware('checktoken');

Route::resource('suppliers', 'SupplierController')->except('index')->middleware('checktoken');

Route::get('supplier_list/{page?}','SupplierController@index')->name('supplier.index')->middleware('checktoken');


Route::resource('vendors', 'VendorController')->except('index')->middleware('checktoken');

Route::get('vendor_list/{page?}','VendorController@index')->name('vendor.index')->middleware('checktoken');

Route::get('getvendorStore/{id}','VendorController@getvendorstores')->name('getvendorstores')->middleware('checktoken');

Route::get('getallVendorStore','VendorstoresController@getallvendorstores')->name('getallvendorstores')->middleware('checktoken');


Route::resource('vendorstores', 'VendorstoresController')->except('index')->middleware('checktoken');

Route::get('vendorstores_list/{page?}','VendorstoresController@index')->name('vendorstores.index')->middleware('checktoken');



Route::resource('profile', 'ProfileController')->except('index')->middleware('checktoken');

Route::get('show_profile/{page?}','ProfileController@index')->name('profile.index')->middleware('checktoken');



Route::put('update_password', 'ProfileController@updatepassword')->name('update_password')->middleware('checktoken');

Route::get('change_password','ProfileController@passwordedit')->name('change_password.index')->middleware('checktoken');


Route::resource('users', 'UserController')->except('index')->middleware('checktoken');

Route::get('user_list/{page?}','UserController@index')->name('user.index')->middleware('checktoken');



Route::resource('roles', 'RoleController')->except('index')->middleware('checktoken');

Route::get('role_list/{page?}','RoleController@index')->name('role.index')->middleware('checktoken');




Route::resource('permissions', 'PermissionController')->except('index')->middleware('checktoken');

Route::get('permission_list/{page?}','PermissionController@index')->name('permission.index')->middleware('checktoken');



Route::resource('settings', 'SettingsController')->except('index')->middleware('checktoken');


Route::resource('stock_tracker', 'StockTrackerController')->except('index')->middleware('checktoken');

Route::get('stock_tracker_list/{page?}','StockTrackerController@index')->name('stock_tracker.index')->middleware('checktoken');




Route::post('assets/storeimage/{module}/{id}', 'AssetsController@store')->name('assets.storeimage')->middleware('checktoken');

Route::resource('assets', 'AssetsController')->except('store')->middleware('checktoken');



Route::get('{slug?}/{id}/edit/assets','AssetsController@editimage')->name('assets.edit')->middleware('checktoken');

// Route::get('product_categories/{page?}', function (Request$page=0) {
//     echo $page;
// });

// Route::post('/login', function () {
// $respose=Http::post('http://restschool.hridham.com/api/login',[
//     "username"=>"admin",
//     "password"=>"12345678"
// ]);

// //Session::put('token',$respose->json()['token']);
// session()->put('token', $respose->json()['token']);
//   return dd(session()->get('token'));
// });
Route::get('getuser', function () {
    return 1;
});

