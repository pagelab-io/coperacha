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

//region pages routes

/*
|--------------------------------------------------------------------------
| SITE
|--------------------------------------------------------------------------
*/
Route::group([
    'as' => 'pages.',
    'prefix' => ''
], function ($router) {
    $router->get('/', [ 'as' => 'index', 'uses' => 'HomeController@getHomePage']);
    $router->get('/about', [ 'as' => 'about', 'uses' => 'HomeController@getAboutPage']);
    $router->get('/contact', [ 'as' => 'contact', 'uses' => 'HomeController@getContactPage']);
    $router->get('/faqs', [ 'as' => 'faqs', 'uses' => 'HomeController@getFaqsPage']);
    $router->get('/test', [ 'as' => 'test', 'middleware' => 'auth', 'uses' => 'HomeController@getTestPage']);
});

Route::group([
    'as'        => 'user.',
    'namespace' => 'User',
    'prefix' => '/user'
], function($router){
    // register
    $router->get('/create', ['as'=>'create', 'uses' => 'UserController@create']);
    $router->get('/profile', ['as'=>'profile', 'uses' => 'UserController@getProfilePage']);
    $router->get('/password', ['as'=>'password', 'uses' => 'UserController@getPasswordPage']);
    $router->get('/contacts', ['as'=>'contacts', 'uses' => 'UserController@getContactsPage']);
});

Route::group([
    'as'        => 'moneybox.',
    'prefix' => '/moneybox'
], function($router){
    // register
    $router->get('/dashboard', ['as' => 'dashboard', 'uses' => 'HomeController@getDashboardPage']);
    $router->get('/detail/{url}', ['as' => 'detail', 'uses' => 'HomeController@getDetailPage']);
    $router->get('/create',  ['middleware' => 'auth', 'as' => 'create', 'uses' => 'HomeController@getCreateMoneyboxPage']);
    $router->get('/step-2',  ['as' => 'step-2', 'uses' => 'HomeController@getCreateMoneyboxPage2']);
    $router->get('/request', ['as' => 'request', 'uses' => 'HomeController@getRequestPage']);
    $router->get('/join',    ['as' => 'join', 'uses' => 'HomeController@getJoinPage']);
    $router->get('/summary', ['as' => 'summary', 'uses' => 'HomeController@getSummaryPage']);

    $router->group([
        'namespace' => 'Moneybox',
        'middleware' => 'auth'
    ], function($router){
        $router->post('/createSession', ['uses' => 'MoneyboxController@step1']);
        $router->post('/deleteSession', ['uses' => 'MoneyboxController@step2']);
    });
});

Route::post('/sendmail', [ 'as' => 'sendmail', 'uses' => 'HomeController@postMailContact']);
Route::get('/sendmail', [ 'as' => 'sendmail', 'uses' => 'HomeController@getMailContact']);

//endregion

//region API routes

/*
|--------------------------------------------------------------------------
| REGISTER
|--------------------------------------------------------------------------
*/
$router->group([
    'as' => 'register',
    'namespace' => 'Register',
    'prefix' => 'api/v1/register',
    'middleware' => 'rest',
], function($router){
    // register
    $router->post('/', ['uses' => 'RegisterController@register']);
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
$router->group([
    'as' => 'auth',
    'namespace' => 'Auth',
    'prefix' => 'api/v1/auth'
], function($router){
    $router->post('/login', [
        'middleware' => 'rest',
        'uses' => 'AuthController@login'
    ]);
    $router->get('/logout', [
        'middleware' => 'auth',
        'uses' => 'AuthController@logout'
    ]);
    $router->put('/passwordRecovery', [
        'middleware' => 'rest',
        'uses' => 'PasswordController@passwordRecovery'
    ]);
});

/*
|--------------------------------------------------------------------------
| MONEYBOX ROUTES
|--------------------------------------------------------------------------
*/
$router->group([
    'as' => 'moneybox',
    'namespace' => 'Moneybox',
    'prefix' => 'api/v1/moneybox',
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

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
$router->group([
    'as' => 'user',
    'namespace' => 'User',
    'prefix' => 'api/v1/user'
], function($router){
    // register
    $router->get('/profile', ['middleware' => ['auth', 'rest'], 'uses' => 'UserController@getProfile']);
    $router->put('/profile', ['middleware' => ['auth', 'rest'], 'uses' => 'UserController@updateProfile']);
    $router->put('/changePassword', ['middleware' => ['auth', 'rest'], 'uses' => 'UserController@changePassword']);
});

/*
|--------------------------------------------------------------------------
| PARTICIPANT ROUTES
|--------------------------------------------------------------------------
*/
$router->group([
    'as' => 'participant',
    'namespace' => 'Participant',
    'prefix' => 'api/v1/participant'
], function($router){
    $router->post('/', [
        'middleware' => 'guest',
        'uses' => 'ParticipantController@createParticipant'
    ]);
});

//endregion

//region Dashboard routes

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
