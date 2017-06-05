<?php

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/salas', 'RoomsController@index');
Route::get('/salas/cadastrar', 'RoomsController@create');
Route::post('/salas/cadastrar', 'RoomsController@store');
Route::get('/salas/editar/{id?}', 'RoomsController@edit');
Route::post('/salas/editar/{id?}', 'RoomsController@update');
Route::delete('/salas/remover/{id?}', 'RoomsController@destroy')->name('rooms.destroy');
Route::get('/home/{date?}', 'ReservesController@index')->name('home');
