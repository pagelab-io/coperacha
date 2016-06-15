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

$router->group([
    'as'         => 'auth.',
    'namespace'  => 'Auth',
    'prefix'     => 'auth'
], function($router){

    $router->post('login', [
        'as' => 'login',
        'middleware' => 'guest',
        'uses'       => 'AuthController@login'
    ]);

});
