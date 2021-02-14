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

Route::get('/', 'HomeController@showWelcome');

Route::get('aiksteles/{city_id?}', 'SearchController@getSearch');
Route::get('aikstele/{title}', 'CourtController@getCourt');
Route::get('apie', 'AboutController@showIndex');
Route::get('kontaktai', 'ContactController@showIndex');
Route::post('aiksteles', 'SearchController@postSearch');

Route::group(['middleware' => 'auth'], function() {
	Route::resource('admin/aiksteles', 'AdminCourtsController');
	Route::resource('admin/miestai', 'AdminCitiesController');
	Route::resource('admin/aiksteliu_tipai', 'AdminTypesController');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');