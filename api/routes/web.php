<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


//Route People
Route::get('people',  	  	 ['uses' => 'PeopleController@showAllPeople']);

Route::get('people/{id}', 	 ['uses' => 'PeopleController@showOnePeople']);

Route::post('people', 	  	 ['uses' => 'PeopleController@create']);

Route::delete('people/{id}', ['uses' => 'PeopleController@delete']);

Route::put('people/{id}', 	 ['uses' => 'PeopleController@update']);

//Route Address
Route::get('address',  	   	  ['uses' => 'AddressController@showAllAddress']);

Route::get('address/{id}', 	  ['uses' => 'AddressController@showOneAddress ']);

Route::post('address', 	   	  ['uses' => 'AddressController@create']);

Route::delete('address/{id}', ['uses' => 'AddressController@delete']);

Route::put('address/{id}', 	  ['uses' => 'AddressController@update']);

//Route People x Address
Route::get('people_addresses', 		 ['uses' => 'PeopleController@showAllWithAddress']);

Route::get('people_addresses/{id}',  ['uses' => 'PeopleController@showOnePeopleWithAddress']);