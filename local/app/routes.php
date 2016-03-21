<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::get('/', 'UsersController@profile');

Route::any('admin/login', 'UsersController@login');

Route::get('admin/logout', 'UsersController@logout');

Route::get('admin/profile', 'UsersController@profile');

Route::get('test', 'TestController@test');
Route::get('temptest', 'TestController@test_template');


Route::any('admin/laravel-ajax', 'AjaxController@index');

Route::resource('users', 'UsersController');
