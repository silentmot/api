<?php

Route::get('/', 'HomeController@welcome');
Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
