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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'WorldController@index');

Route::get('/castle', 'CastleController@index');

Route::get('/castle/build/{id}', 'CastleController@build');

Route::get('/castle/update/{id}', 'CastleController@update');