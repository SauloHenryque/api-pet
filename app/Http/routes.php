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


Route::post('/api/autenticacao', [
    'middleware' => ['cors', 'output.api'],
    'uses' => 'AuthJwtController@autenticacao'
]);


Route::group([
    'prefix'     => 'api',
    'middleware' => ['cors', 'jwt.auth', 'output.api'],
], function () {

    Route::get('/autenticacao/detalhes', 'AuthJwtController@detalhes');

    Route::get('/racas', 'RacasApiController@index');
    Route::get('/racas/{id}', 'RacasApiController@index');
    Route::post('/racas', 'RacasApiController@store');
    Route::put('/racas/{id}', 'RacasApiController@store');
    Route::delete('/racas/{id}', 'RacasApiController@destroy');

    Route::get('/proprietarios', 'ProprietariosApiController@index');
    Route::get('/proprietarios/{id}', 'ProprietariosApiController@index');
    Route::post('/proprietarios', 'ProprietariosApiController@store');
    Route::put('/proprietarios/{id}', 'ProprietariosApiController@store');
    Route::delete('/proprietarios/{id}', 'ProprietariosApiController@destroy');

    Route::get('/pets', 'PetsApiController@index');
    Route::get('/pets/{id}', 'PetsApiController@index');
    Route::post('/pets', 'PetsApiController@store');
    Route::put('/pets/{id}', 'PetsApiController@store');
    Route::delete('/pets/{id}', 'PetsApiController@destroy');

});

