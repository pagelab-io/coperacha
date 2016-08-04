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
        'middleware' => 'rest',
        'uses' => 'RegisterController@register'
    ]);
    // register
    $router->get('/', [
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
        'middleware' => 'rest',
        'uses' => 'AuthController@login'
    ]);
    $router->get('/logout', [
        'middleware' => ['auth', 'rest'],
        'uses' => 'AuthController@logout'
    ]);
    $router->put('/passwordRecovery', [
        'middleware' => 'rest',
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
        'middleware' => ['auth', 'rest'],
        'uses' => 'MoneyboxController@createMoneybox'
    ]);
    $router->put('/', [
        'middleware' => ['auth', 'rest'],
        'uses' => 'MoneyboxController@updateMoneybox'
    ]);
    $router->get('/', [
        'middleware' => ['auth', 'rest'],
        'uses' => 'MoneyboxController@getAll'
    ]);
    $router->post('/categories', [
        'middleware' => ['auth', 'rest'],
        'uses' => 'CategoryController@createCategory'
    ]);
    $router->get('/categories', [
        'middleware' => ['auth', 'rest'],
        'uses' => 'CategoryController@getAll'
    ]);
    $router->post('/settings', [
        'middleware' => ['auth', 'rest'],
        'uses' => 'SettingController@createSetting'
    ]);
    $router->get('/settings', [
        'middleware' => ['auth', 'rest'],
        'uses' => 'SettingController@getAll'
    ]);
    $router->post('/option', [
        'middleware' => ['auth', 'rest'],
        'uses' => 'SettingController@createOptions'
    ]);
    $router->post('/payment', [
        'middleware' => 'rest',
        'uses' => 'PaymentController@createPayment'
    ]);
    $router->get('/paypal/return', [
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
        'middleware' => ['auth', 'rest'],
        'uses' => 'UserController@getProfile'
    ]);
    $router->put('/profile', [
        'middleware' => ['auth', 'rest'],
        'uses' => 'UserController@updateProfile'
    ]);
    $router->put('/changePassword', [
        'middleware' => ['auth', 'rest'],
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
