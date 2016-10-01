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
header('Access-Control-Allow-Headers: Authorization, Content-Type');

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
    /* Home Routes... */
    $router->get('/', [ 'as' => 'index', 'uses' => 'HomeController@getHomePage']);
    $router->get('/about', [ 'as' => 'about', 'uses' => 'HomeController@getAboutPage']);
    $router->get('/contact', [ 'as' => 'contact', 'uses' => 'HomeController@getContactPage']);
    $router->get('/faqs', [ 'as' => 'faqs', 'uses' => 'HomeController@getFaqsPage']);
    $router->get('/pricing', [ 'as' => 'pricing', 'uses' => 'HomeController@getPricingPage']);
    /* Password Reset Routes... */
    $router->get('password/recovery', 'Auth\PasswordController@getEmail');
    $router->get('password/reset/{token?}', 'Auth\PasswordController@getReset');
    $router->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $router->post('password/reset', 'Auth\PasswordController@reset');
});

Route::group([
    'as'        => 'user.',
    'namespace' => 'User',
    'prefix' => '/user'
], function($router){
    // register
    $router->get('/create', ['as'=>'create', 'uses' => 'UserController@create']);
    $router->get('/profile/{userid?}', [
        'middleware' => 'auth',
        'as'=>'profile',
        'uses' => 'UserController@getProfilePage']);
});

Route::group([
    'as'        => 'moneybox.',
    'prefix' => '/moneybox'
], function($router){
    // register
    $router->get('/dashboard', ['middleware' => 'auth', 'as' => 'dashboard', 'uses' => 'HomeController@getDashboardPage']);
    $router->get('/detail/{url}', ['as' => 'detail', 'uses' => 'HomeController@getDetailPage']);
    $router->get('/create/{url?}',  ['middleware' => 'auth', 'as' => 'create', 'uses' => 'HomeController@getCreateMoneyboxPage']);
    //$router->get('/step-2',  ['middleware' => 'auth', 'as' => 'step-2', 'uses' => 'HomeController@getCreateMoneyboxPage2']);
    $router->get('/request/{moneyboxurl}', ['as' => 'request', 'uses' => 'HomeController@getRequestPage']);
    $router->get('/join/{moneyboxurl}',    ['as' => 'join', 'uses' => 'HomeController@getJoinPage']);//->where('moneyboxurl','[moneyboxurl]+');
    $router->get('/summary/{url}', ['as' => 'summary', 'uses' => 'HomeController@getSummaryPage']);

    $router->group([
        'namespace' => 'Moneybox',
        'middleware' => 'auth'
    ], function($router){
        $router->post('/createSession', ['uses' => 'MoneyboxController@step1']);
        $router->post('/deleteSession', ['uses' => 'MoneyboxController@step2']);
    });
});


// ROUTES FOR MAIL
Route::post('/sendmail', [ 'as' => 'sendmail', 'uses' => 'HomeController@postMailContact']);
Route::post('/sendinvitation', [ 'as' => 'sendinvitation', 'uses' => 'HomeController@postMailInvitation']);
Route::post('/sendrequest', [ 'as' => 'sendmailrequest', 'uses' => 'HomeController@postMailRequest']);
Route::post('/sendthanks', [ 'as' => 'sendmailthanks', 'uses' => 'HomeController@postMailThanks']);
Route::post('/sendremove', [ 'as' => 'sendremove', 'uses' => 'HomeController@postRemoveMoneybox']);


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
    'middleware' => 'rest',
], function($router){
    $router->post('/',  ['middleware' => 'auth', 'uses' => 'MoneyboxController@createMoneybox']);
    $router->post('/upload', ['middleware' => 'auth', 'uses' => 'MoneyboxController@upload']);
    $router->put('/',   ['middleware' => 'auth', 'uses' => 'MoneyboxController@updateMoneybox']);
    $router->get('/',   ['middleware' => 'auth', 'uses' => 'MoneyboxController@getAll']);
    $router->post('/categories',    ['middleware' => 'auth', 'uses' => 'CategoryController@createCategory']);
    $router->get('/categories',     ['middleware' => 'auth', 'uses' => 'CategoryController@getAll']);
    $router->post('/settings',      ['middleware' => 'auth', 'uses' => 'SettingController@createSetting']);
    $router->get('/settings',       ['middleware' => 'auth', 'uses' => 'SettingController@getAll']);
    $router->post('/option',        ['middleware' => 'auth', 'uses' => 'SettingController@createOptions']);
    $router->post('/payment',       ['uses' => 'PaymentController@createPayment']);
    $router->post('/getParticipants', ['uses' => 'MoneyboxController@getParticipants']);
});

Route::get('/moneybox/image/{filename}', 'Moneybox\MoneyboxController@getMoneyboxImage');

/*
|--------------------------------------------------------------------------
| PAYMENT ROUTES
|--------------------------------------------------------------------------
*/
$router->group([
    'as' => 'payment',
    'namespace' => 'Moneybox',
    'prefix' => 'payment',
], function($router){
    $router->get('/paypal/return',  ['uses' => 'PaymentController@paypalResponse']);
    $router->post('/conekta/return',  ['uses' => 'PaymentController@conektaResponse']);
    $router->get('/downloadPayment/{method}/{image}/{barcode}/{clabe}',  ['uses' => 'PaymentController@paymentDownload']);
});

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
$router->group([
    'as' => 'user',
    'namespace' => 'User',
    'prefix' => 'api/v1/user',
    'middleware' => ['auth', 'rest']
], function($router){
    // register
    $router->get('/profile/{userid?}', ['uses' => 'UserController@getProfile']);
    $router->put('/profile', ['uses' => 'UserController@updateProfile']);
    $router->put('/changePassword', ['uses' => 'UserController@changePassword']);
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
        'middleware' => ['rest'],
        'uses' => 'ParticipantController@createParticipant'
    ]);
    $router->post('/createTmpParticipant', [
        'middleware' => ['rest'],
        'uses' => 'ParticipantController@createTmpParticipant'
    ]);
    $router->post('/deleteTmpParticipant', [
        'middleware' => ['rest'],
        'uses' => 'ParticipantController@deleteTmpParticipant'
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
    'middleware' => ['dashboard'],
    'as' => 'dashboard.'
], function ($router) {
    $router->get('/','DashboardController@index');
    $router->get('/home','DashboardController@index');

    // dashboard users
    $router->group([
        'prefix' => 'users',
        'as' => 'users.'
    ], function($router){
        $router->get('/{username}','DashboardController@getUserByUsername');
        $router->get('/{name?}/{gender?}',['as' => 'index','uses' => 'DashboardController@getUsers']);
    });

    // dashboard moneyboxes
    $router->group([
        'prefix' => 'moneyboxes',
        'as' => 'moneyboxes.'
    ], function ($router){
        $router->get('/{url}','DashboardController@getMoneyboxesByUrl');
        $router->get('/{name?}/{status?}',['as' => 'index','uses' => 'DashboardController@getMoneyboxes']);
    });
});
//endregion
