<?php

use Illuminate\Support\Facades\Redis;
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
    //event(new UserSignedUp(Request::query('name')));
    return view('welcome');
});



Route::get('/room', 'RoomController@index');
Route::get('/room/{room}', 'RoomController@GameRoom');

//API
Route::get('/api/room/{room}/seats', 'SeatController@retrieve');

Route::post('/api/room', 'RoomController@create');
Route::post('/api/room/sitdown', 'RoomController@SitDown');




Route::auth();

Route::get('/home', 'HomeController@index');
