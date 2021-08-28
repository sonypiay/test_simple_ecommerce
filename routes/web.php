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

Route::get('/logout', 'LoginController@doLogout')->name('dologout');

Route::group(['as' => 'frontend.'], function() {
  Route::group(['as' => 'login.'], function() {
    Route::get('/', 'LoginController@index')->name('index');
    Route::post('/dologin', 'LoginController@doLogin')->name('dologin');
  });

  Route::group(['prefix' => 'register', 'as' => 'register.'], function() {
    Route::get('/', 'RegisterController@index')->name('index');
    Route::post('/create', 'RegisterController@doRegister')->name('create');
  });

  Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['check_user_login', 'is_role_user']], function() {
    Route::get('/', function() { return redirect()->route('frontend.user.home'); });
    Route::get('/home', 'Frontend\HomeController@index')->name('home');

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function() {
      Route::get('/', 'Frontend\ProfileController@index')->name('index');
      Route::post('/update', 'Frontend\ProfileController@update')->name('update');
    });

    Route::group(['prefix' => 'change_password', 'as' => 'change_password.'], function() {
      Route::get('/', 'Frontend\ChangePasswordController@index')->name('index');
      Route::post('/update', 'Frontend\ChangePasswordController@update')->name('update');
    });
  });
});

Route::group(['prefix' => 'backoffice', 'as' => 'backoffice.', 'middleware' => ['check_user_login', 'is_role_admin']], function() {
  Route::get('/', function() { return redirect()->route('backoffice.dashboard'); });
  Route::get('/dashboard', 'BackOffice\DashboardController@index')->name('dashboard');

  Route::group(['prefix' => 'product', 'as' => 'product.'], function() {
    Route::get('/', 'BackOffice\ProductController@index')->name('index');
    Route::get('/create', 'BackOffice\ProductController@createOrEdit')->name('create_page');
    Route::get('/edit/{id}', 'BackOffice\ProductController@createOrEdit')->name('edit_page');
    Route::get('/delete/{id?}', 'BackOffice\ProductController@destroy')->name('delete');

    Route::post('/store', 'BackOffice\ProductController@storeOrUpdate')->name('store');
    Route::post('/update/{id}', 'BackOffice\ProductController@storeOrUpdate')->name('update');
  });

  Route::group(['prefix' => 'users', 'as' => 'users.'], function() {
    Route::get('/', 'BackOffice\UserController@index')->name('index');
    Route::get('/create', 'BackOffice\UserController@createOrEdit')->name('create_page');
    Route::get('/edit/{id}', 'BackOffice\UserController@createOrEdit')->name('edit_page');
    Route::get('/detail/{id}', 'BackOffice\UserController@detail')->name('view');
    Route::get('/delete/{id?}', 'BackOffice\UserController@destroy')->name('delete');

    Route::post('/store', 'BackOffice\UserController@storeOrUpdate')->name('store');
    Route::post('/update/{id}', 'BackOffice\UserController@storeOrUpdate')->name('update');
    Route::put('/set_status/{id?}', 'BackOffice\UserController@setStatus')->name('set_status');
  });

  Route::group(['prefix' => 'profile', 'as' => 'profile.'], function() {
    Route::get('/', 'BackOffice\ProfileController@index')->name('index');
    Route::post('/update', 'BackOffice\ProfileController@update')->name('update');
  });

  Route::group(['prefix' => 'change_password', 'as' => 'change_password.'], function() {
    Route::get('/', 'BackOffice\ChangePasswordController@index')->name('index');
    Route::post('/update', 'BackOffice\ChangePasswordController@update')->name('update');
  });
});
