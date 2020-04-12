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


$router->group([
    'prefix' => 'organization',
    'name' => 'organization.',
    'middleware' => 'auth:api'
], function ($router) {

    $router->get('/test', 'ExampleController@test');

    $router->group([],function ($router) {
        $router->get('users', ['as' => 'user.get', 'uses' => 'UserController@index']);
        $router->post('users', ['as' => 'user.post', 'uses' => 'UserController@store']);
        $router->get('users/{user}', ['as' => 'user.get.id', 'uses' => 'UserController@show']);
        $router->put('users/{user}', ['as' => 'user.get.update', 'uses' => 'UserController@update']);
        $router->delete('users/{user}', ['as' => 'user.delete', 'uses' => 'UserController@destroy']);
        $router->delete('users/{user}/purge', ['as' => 'user.purge', 'uses' => 'UserController@purge']);
    });

    $router->group([],function ($router) {
        $router->get('groups', ['as' => 'group.get', 'uses' => 'GroupController@index']);
        $router->post('groups', ['as' => 'group.post', 'uses' => 'GroupController@store']);
        $router->get('groups/{group}', ['as' => 'group.get.id', 'uses' => 'GroupController@show']);
        $router->put('groups/{group}', ['as' => 'group.get.update', 'uses' => 'GroupController@update']);
        $router->delete('groups/{group}', ['as' => 'group.delete', 'uses' => 'GroupController@destroy']);
         $router->delete('groups/{group}/purge', ['as' => 'group.purge', 'uses' => 'GroupController@purge']);
    });

    $router->group([],function ($router) {

        $router->get('organizations', ['as' => 'organization.get', 'uses' => 'OrganizationController@index']);
        $router->post('organizations', ['as' => 'organization.post', 'uses' => 'OrganizationController@store']);
        $router->get('organizations/{organization}', ['as' => 'organization.get.id', 'uses' => 'OrganizationController@show']);
        $router->put('organizations/{organization}', ['as' => 'organization.get.update', 'uses' => 'OrganizationController@update']);
        $router->delete('organizations/{organization}', ['as' => 'organization.delete', 'uses' => 'OrganizationController@destroy']);
        $router->delete('organizations/{organization}/purge', ['as' => 'organization.purge', 'uses' => 'OrganizationController@purge']);
    });
});

