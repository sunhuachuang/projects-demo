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

Route::get('code', function() {
    dump(App::Make('code.service'));
});

Route::controllers([
   'password' => 'Auth\PasswordController',
]);

// Authentication routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');

//home
Route::get('/', 'TicketController@index');

//order
Route::get('orders', 'OrderController@index');
Route::get('orders/new/{ticket}', 'OrderController@new');
Route::get('orders/pay/{order}', 'OrderController@pay');
Route::get('orders/pay/{order}/ok', 'OrderController@payOk');
Route::delete('orders/delete/{order}', 'OrderController@delete');

//user
Route::get('user', 'UserController@index')->middleware('auth');

//admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'role:admin']], function()
{
    Route::get('/', 'HomeController@index');

    //admin ticket
    Route::resource('tickets', 'TicketController');

    //admin order
    Route::get('orders', 'OrderController@index');
    Route::post('orders/ok/{order}', 'OrderController@ok');
});