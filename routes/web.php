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
Route::group(['middleware' => 'auth'], function () {
    Route::get('/salas', 'RoomsController@index');
    Route::get('/salas/cadastrar', 'RoomsController@create');
    Route::post('/salas/cadastrar', 'RoomsController@store');
    Route::get('/salas/editar/{id?}', 'RoomsController@edit');
    Route::post('/salas/editar/{id?}', 'RoomsController@update');
    Route::delete('/salas/remover/{id?}', 'RoomsController@destroy')->name('rooms.destroy');
    Route::delete('/reservas/remover/{id?}', 'ReservesController@destroy')->name('reserves.destroy');
    Route::post('/reservas/reservar', 'ReservesController@store')->name('reserves.store');
    Route::get('/home/{date?}', 'ReservesController@index')->name('home');
    Route::get('/usuarios/editar', 'UsersController@edit')->name('users.edit');
    Route::post('/usuarios/editar', 'UsersController@update')->name('users.update');
    Route::delete('/usuarios/remover/{id?}', 'UsersController@destroy')->name('users.destroy');
});