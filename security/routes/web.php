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
/**
 * @var \Illuminate\Routing\Route $router
 */

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group([
    'prefix' => 'security/auth'
], function ($router) {

    $router->post('login', 'AuthController@login');
    $router->post('register', 'AuthController@register');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
    $router->post('me', 'AuthController@me');

});

$router->group([
    'prefix' => 'security',
    'middleware' => 'auth:api'
], function ($router) {
    $router->get('/', function () use ($router) {
        return "security service home";
    });

    $router->get('/example', 'ExampleController@index');
});
