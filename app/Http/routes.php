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
        'uses' => 'AuthController@login'
    ]);
    $router->get('/logout', [
        'middleware' => 'auth',
        'uses' => 'AuthController@logout'
    ]);
    $router->put('/passwordRecovery', [
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
        'middleware' => 'auth',
        'uses' => 'CategoryController@createCategory'
    ]);
    $router->get('/categories', [
        'middleware' => 'auth',
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
    $router->get('/paypal/return', [
        'middleware' => 'guest',
        'uses' => 'PaymentController@paypalResponse'
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

//region Dashboard

Route::group([
    'prefix' => 'dashboard',
    'namespace' => 'Dashboard'
], function ($router) {
    // Authentication Routes...
    $router->get('login', 'Auth\AuthController@showLoginForm');
    $router->post('login', 'Auth\AuthController@login');
    $router->get('logout', 'Auth\AuthController@logout');

    /* Registration Routes...*/
    $this->get('register', 'Auth\AuthController@showRegistrationForm');
    $this->post('register', 'Auth\AuthController@register');

    /* Password Reset Routes... */
    $router->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    $router->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $router->post('password/reset', 'Auth\PasswordController@reset');
});

Route::group([
    'prefix' => 'dashboard',
    'namespace' => 'Dashboard',
    'middleware' => ['dashboard']
], function ($router) {
    $router->get('/','DashboardController@index');
    $router->get('/home','DashboardController@index');
});
//endregion
