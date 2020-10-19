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
    $router->post('/webhook', function () use ($router) {
        return 'success';
    });

    $router->post('user/register', 'UserController@register');
    $router->post('user/login', ['uses' => 'UserController@login']);

    $router->get('customers/getID/{id}', 'CustomerController@getID');
    $router->post('customers/insertData', 'CustomerController@addData');

    $router->group(['prefix' => 'test', 'middleware' => 'jwt.auth'], function ($router) {
        $router->get('/', function () use ($router) {
            return $router->app->version();
        });
    });

    $router->group(['prefix' => 'customers', 'middleware' => 'jwt.auth'], function () use ($router) {
        $router->get('getAll', 'CustomerController@getAll');
        // $router->put('updateData/{id}', 'CustomerController@updateData');
        // $router->delete('deleteData/{id}', 'CustomerController@deleteData');
    });
});
