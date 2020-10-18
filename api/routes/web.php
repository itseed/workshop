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

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->post('/webhook', function () use ($router) {
        return 'success';
    });

    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('getAll', 'UserController@getAll');
        $router->get('getID/{id}', 'UserController@getID');
        $router->post('insertData', 'UserController@addData');
        $router->put('updateData/{id}', 'UserController@updateData');
        $router->delete('deleteData/{id}', 'UserController@deleteData');
    });
});
