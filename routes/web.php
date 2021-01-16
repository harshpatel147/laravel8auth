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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

// Route::view('/products/sample', 'products.sample');
// Route::view('/products/sample', 'products.sample')->name('products.sample');
use App\Http\Controllers\ProductController;  
// Route::resource('products', ProductController::class);
// Route::middleware(['auth:sanctum', 'verified'])->get('/products/', 'App\Http\Controllers\ProductController@index')->name('products.index')->middleware('can:isAdmin'); 
// Route::middleware(['auth:sanctum', 'verified'])->get('/products/create', 'App\Http\Controllers\ProductController@create')->name('products.create'); 
// Route::middleware(['auth:sanctum', 'verified'])->post('/products/store', 'App\Http\Controllers\ProductController@store')->name('products.store'); 
// Route::middleware(['auth:sanctum', 'verified'])->get('/products/edit/{product}', 'App\Http\Controllers\ProductController@edit')->name('products.edit'); 
// Route::middleware(['auth:sanctum', 'verified'])->get('/products/show/{product}', 'App\Http\Controllers\ProductController@show')->name('products.show'); 

// Route::get('/products/sample', 'App\Http\Controllers\ProductController@sample')->name('products.sample'); 
Route::prefix('admin')->middleware(['auth:sanctum', 'verified'])->group(function () {  
// can:isAdmin  <- authentication middleware
//rolePermissioncheck  <- authentication middleware
    //it Matches The "/admin/products" URL "/admin/products/create"
    
    Route::resource('products', ProductController::class);
	Route::get('/products/', 'App\Http\Controllers\ProductController@index')->name('admin.products.index'); //index all the data view...

	Route::get('/products/create', 'App\Http\Controllers\ProductController@create')->name('admin.products.create'); //Create form view...

	Route::post('/products/store', 'App\Http\Controllers\ProductController@store')->name('admin.products.store'); //insert into DB...

	Route::get('/products/edit/{product}', 'App\Http\Controllers\ProductController@edit')->name('admin.products.edit'); //Edit form view...

	Route::put('/products/update/{product}', 'App\Http\Controllers\ProductController@update')->name('admin.products.update'); //Save the Updated Data into DB from Edit Form View...

	Route::get('/products/show/{product}', 'App\Http\Controllers\ProductController@show')->name('admin.products.show'); //it shows more details of specific products using thier unique Id...
});

//https://medium.com/swlh/laravel-authorization-and-roles-permission-management-6d8f2043ea20


use App\Http\Controllers\RoleController;  
//rolePermissioncheck <- authentication middleware
Route::prefix('admin')->middleware(['auth:sanctum', 'verified'])->group(function () {  
	
	Route::resource('roles', RoleController::class);

	Route::prefix('roles')->middleware(['auth:sanctum', 'verified'])->group(function () {  

		Route::get('/', 'App\Http\Controllers\RoleController@index')->name('admin.roles.index'); //index all the data view...

		Route::get('/create', 'App\Http\Controllers\RoleController@create')->name('admin.roles.create'); //Create form view...

		Route::post('/store', 'App\Http\Controllers\RoleController@store')->name('admin.roles.store'); //insert into DB...

		Route::get('/edit/{role}', 'App\Http\Controllers\RoleController@edit')->name('admin.roles.edit'); //Edit form view...

		Route::put('/update/{role}', 'App\Http\Controllers\RoleController@update')->name('admin.roles.update'); //Save the Updated Data into DB from Edit Form View...

	});

});

use App\Http\Controllers\PermissionController;  
//rolePermissioncheck <- authentication middleware
Route::prefix('admin')->middleware(['auth:sanctum', 'verified'])->group(function () {  

	Route::resource('permissions', PermissionController::class);
	
	Route::prefix('permissions')->middleware(['auth:sanctum', 'verified'])->group(function () {  

		Route::get('/', 'App\Http\Controllers\PermissionController@index')->name('admin.permissions.index'); //index all the data view...

		Route::get('/create', 'App\Http\Controllers\PermissionController@create')->name('admin.permissions.create'); //Create form view...

		Route::post('/store', 'App\Http\Controllers\PermissionController@store')->name('admin.permissions.store'); //insert into DB...

		Route::get('/edit/{permission}', 'App\Http\Controllers\PermissionController@edit')->name('admin.permissions.edit'); //Edit form view...

		Route::put('/update/{permission}', 'App\Http\Controllers\PermissionController@update')->name('admin.permissions.update'); //Save the Updated Data into DB from Edit Form View...

	});
});

use App\Http\Controllers\PermissionRoleController;  
//rolePermissioncheck <- authentication middleware
Route::prefix('admin')->middleware(['auth:sanctum', 'verified'])->group(function () {  

	Route::resource('rolepermissions', PermissionRoleController::class);
	
	Route::prefix('rolepermissions')->middleware(['auth:sanctum', 'verified'])->group(function () {  

		Route::get('/', 'App\Http\Controllers\PermissionRoleController@index')->name('admin.rolepermissions.index'); //index all the data view...

		Route::get('/create', 'App\Http\Controllers\PermissionRoleController@create')->name('admin.rolepermissions.create'); //Create form view...

		Route::post('/store', 'App\Http\Controllers\PermissionRoleController@store')->name('admin.rolepermissions.store'); //insert into DB...

		Route::get('/edit/{rolepermission}', 'App\Http\Controllers\PermissionRoleController@edit')->name('admin.rolepermissions.edit'); //Edit form view...

		Route::post('/update/', 'App\Http\Controllers\PermissionRoleController@update')->name('admin.rolepermissions.update'); //Save the Updated Data into DB from Edit Form View...

	});
});