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

header('Access-Control-Allow-Origin: *');
header( 'Access-Control-Allow-Headers: Authorization, Content-Type');

Route::get('/', function () {
    return view('welcome');
});

//region Register
$router->group([
    'as' => 'register',
    'namespace' => 'Register',
    'prefix' => 'register'
], function($router){
    // register
    $router->post('/', [
        'middleware' => 'guest',
        'uses' => 'RegisterController@register'
    ]);
});
//endregion

//region Login
$router->group([
    'as' => 'auth',
    'namespace' => 'Auth',
    'prefix' => 'auth'
], function($router){
    $router->post('/login', [
        'middleware' => 'guest',
        'uses' => 'AuthController@login'
    ]);
});
//endregion

//region Moneyboxes
$router->group([ // 401
    'as' => 'moneybox',
    'namespace' => 'Moneybox',
    'prefix' => 'moneybox'
], function($router){
    $router->post('/categories/create', [
        'middleware' => 'guest',
        'uses' => 'MoneyboxController@addCategory'
    ]);
    $router->post('/categories/list', [
        'middleware' => 'guest',
        'uses' => 'MoneyboxController@getAll'
    ]);
});
//endregion
