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

use App\Buildings;

use App\Units;

Route::get('/', 'WorldController@index');

Route::auth();

Route::get('/home', 'WorldController@index');

Route::get('/castle', 'CastleController@index');

Route::group(['middleware' => 'web'], function () {
    Route::get('/edit-profile', 'Auth\EditprofileController@editprofile');
    Route::post('/edit-profile', 'Auth\EditprofileController@saveprofile');
});


Route::get('/castle/build/{id}', function ($type) {
    $building = new Buildings;
    $building->type = $type;
    $building->build();

    return redirect('/castle');
});

Route::get('/castle/update/{id}', function ($type) {
    $building = new Buildings;
    $building->type = $type;
    $building->building_update();

    return redirect('/castle');
});

Route::get('/castle/units/add/{type}/{number}', function ($type, $number) {
    $units = new Units;
    $units->type = $type;
    $units->number = $number;
    $units->add();

    return redirect('/castle');
});

Route::get('/attack/{id}', function ($id) {
    $battle = new \App\Battles();
    $battle->enemy = $id;
    $battle->attack();

    return redirect('/');
});