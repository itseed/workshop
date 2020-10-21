<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    // return app()->environment();
    return $router->app->version();
});

$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});

$router->get('test/{uid}/{messages}', 'LineBotController@pushMessage');

// $router->get('/test', function() {
//     // $lineBot = new LineBot(env('LINE_TOKEN'), env('LINE_CHANNAL'));
//     // return \Illuminate\Support\Str::random(32);
//     // return env('LINE_TOKEN');
// });

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    // $router->post('/webhook', function () use ($router) {
    //     return 'success';
    // });

    $router->post('webhook', 'LineBotController@bot');

    // Matches "/api/register
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');

    $router->get('profile', 'UserController@profile');
    $router->get('users/{id}', 'UserController@singleUser');
    $router->get('users', 'UserController@allUsers');

    //Verify Customer
    $router->get('verify/{uid}', 'VerifyController@getID');
    $router->post('registerLine', 'VerifyController@addData');

    $router->group(['prefix' => 'customers', 'middleware' => 'auth'], function () use ($router) {
        // $router->get('/', 'CustomerController@getAll');
        // $router->get('/{id}', 'CustomerController@getID');
        // $router->put('updateData/{id}', 'CustomerController@updateData');
        // $router->delete('deleteData/{id}', 'CustomerController@deleteData');
    });

    // $router->get('customers/{id}', 'CustomerController@getID');
    // $router->get('customers', 'CustomerController@getAll');

 });

// $router->group(['prefix' => 'api/v1'], function () use ($router) {
//     $router->post('/webhook', function () use ($router) {
//         return 'success';
//     });

//     $router->post('register', 'UserController@register');
//     $router->post('login', ['uses' => 'UserController@login']);

//     $router->group(['prefix' => 'me'], function ($router) {
//         $router->get('/', 'UserController@me');
//     });

//     $router->get('customers/getID/{id}', 'CustomerController@getID');
//     $router->post('customers/insertData', 'CustomerController@addData');

//     $router->group(['prefix' => 'test', 'middleware' => 'jwt.auth'], function ($router) {
//         $router->get('/', function () use ($router) {
//             return $router->app->version();
//         });
//     });

//     $router->group(['prefix' => 'customers', 'middleware' => 'jwt.auth'], function () use ($router) {
//         $router->get('getAll', 'CustomerController@getAll');
//         // $router->put('updateData/{id}', 'CustomerController@updateData');
//         // $router->delete('deleteData/{id}', 'CustomerController@deleteData');
//     });
// });
