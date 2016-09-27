<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::any('/', 'IndexController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::any('/enter','IndexController@enter');
Route::any('/registration','IndexController@registration');
Route::any('/main','IndexController@main');
Route::any('/exit','IndexController@exitZ');
Route::any('/userInfo','IndexController@userInfo');
Route::any('/change','IndexController@change');
Route::any('/people','IndexController@people');
Route::any('/plus','IndexController@plus');
Route::any('/minus','IndexController@minus');
Route::any('/peoplePop','IndexController@peoplePop');