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
    // register
    $router->get('/test', [
        'middleware' => 'guest',
        'uses' => 'RegisterController@emailTest'
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
    $router->put('/passwordRecovery', [
        'middleware' => 'guest',
        'uses' => 'PasswordController@passwordRecovery'
    ]);
});
//endregion

//region Moneyboxes
$router->group([
    'as' => 'moneybox',
    'namespace' => 'Moneybox',
    'prefix' => 'moneybox'
], function($router){
    $router->post('/', [
        'middleware' => 'guest',
        'uses' => 'MoneyboxController@createMoneybox'
    ]);
    $router->put('/', [
        'middleware' => 'guest',
        'uses' => 'MoneyboxController@updateMoneybox'
    ]);
    $router->get('/', [
        'middleware' => 'guest',
        'uses' => 'MoneyboxController@getAll'
    ]);
    $router->post('/categories', [
        'middleware' => 'guest',
        'uses' => 'CategoryController@createCategory'
    ]);
    $router->get('/categories', [
        'middleware' => 'guest',
        'uses' => 'CategoryController@getAll'
    ]);
    $router->post('/settings', [
        'middleware' => 'guest',
        'uses' => 'SettingController@createSetting'
    ]);
    $router->get('/settings', [
        'middleware' => 'guest',
        'uses' => 'SettingController@getAll'
    ]);
    $router->post('/option', [
        'middleware' => 'guest',
        'uses' => 'SettingController@createOptions'
    ]);
    $router->post('/payment', [
        'middleware' => 'guest',
        'uses' => 'PaymentController@createPayment'
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
    $router->put('/changePassword', [
        'middleware' => 'guest',
        'uses' => 'UserController@changePassword'
    ]);
});
//endregion

//region Participants

$router->group([
    'as' => 'participant',
    'namespace' => 'Participant',
    'prefix' => 'participant'
], function($router){
    $router->post('/', [
        'middleware' => 'guest',
        'uses' => 'ParticipantController@createParticipant'
    ]);
});

//endregion