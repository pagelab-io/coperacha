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

//region page routes
Route::get('/', [ 'as' => 'index', 'uses' => 'HomeController@getHomePage']);
Route::get('/about', [ 'as' => 'about', 'uses' => 'HomeController@getAboutPage']);
Route::get('/contact', [ 'as' => 'contact', 'uses' => 'HomeController@getContactPage']);
Route::get('/faqs', [ 'as' => 'faqs', 'uses' => 'HomeController@getFaqsPage']);

//endregion

Route::get('/sendmail', function () {
    return view('emails.test');
});

//region Register
$router->group([
    'as' => 'register',
    'namespace' => 'Register',
    'prefix' => 'register',
    'middleware' => 'rest',
], function($router){
    // register
    $router->post('/', [
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
    'prefix' => 'moneybox',
    'middleware' => ['auth', 'rest'],
], function($router){
    $router->post('/',  [ 'uses' => 'MoneyboxController@createMoneybox']);
    $router->put('/',   [ 'uses' => 'MoneyboxController@updateMoneybox']);
    $router->get('/',   [ 'uses' => 'MoneyboxController@getAll']);
    $router->post('/categories',    ['uses' => 'CategoryController@createCategory']);
    $router->get('/categories',     ['uses' => 'CategoryController@getAll']);
    $router->post('/settings',      ['uses' => 'SettingController@createSetting']);
    $router->get('/settings',       ['uses' => 'SettingController@getAll']);
    $router->post('/option',        ['uses' => 'SettingController@createOptions']);
    $router->post('/payment',       ['uses' => 'PaymentController@createPayment']);
    $router->get('/paypal/return',  ['uses' => 'PaymentController@paypalResponse']);
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
