<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// company routes
Route::get('company/all', 'CompanyController@all');
Route::post('company/buy', 'CompanyController@buy');
Route::get('company/single/{id}', 'CompanyController@single');
Route::resource('companies', 'CompanyController');

// station routes
Route::get('station/all', 'StationController@all');
Route::resource('stations', 'StationController');


