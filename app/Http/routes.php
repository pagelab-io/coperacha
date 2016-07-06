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
    return view('index');
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
$router->group([
    'as' => 'moneybox',
    'namespace' => 'Moneybox',
    'prefix' => 'moneybox'
], function($router){
    $router->post('/create', [
        'middleware' => 'guest',
        'uses' => 'MoneyboxController@createMoneybox'
    ]);
    $router->get('/list', [
        'middleware' => 'guest',
        'uses' => 'MoneyboxController@getAll'
    ]);
    $router->post('/categories/create', [
        'middleware' => 'guest',
        'uses' => 'CategoryController@createCategory'
    ]);
    $router->post('/categories/list', [
        'middleware' => 'guest',
        'uses' => 'CategoryController@getAll'
    ]);
    $router->post('/settings/create', [
        'middleware' => 'guest',
        'uses' => 'SettingController@createSetting'
    ]);
    $router->post('/settings/list', [
        'middleware' => 'guest',
        'uses' => 'SettingController@getAll'
    ]);
    $router->post('/options/create', [
        'middleware' => 'guest',
        'uses' => 'SettingController@createOptions'
    ]);
});
//endregion

//region User
$router->group([
    'as' => 'user',
    'namespace' => 'User',
    'prefix' => 'user'
], function($router){
    // register
    $router->get('/profile', [
        'middleware' => 'guest',
        'uses' => 'UserController@getProfile'
    ]);
    $router->put('/profile', [
        'middleware' => 'guest',
        'uses' => 'UserController@updateProfile'
    ]);
});
//endregion
