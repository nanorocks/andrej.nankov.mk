<?php

use Illuminate\Support\Facades\Route;

/** @var \Laravel\Lumen\Routing\Router $router */


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

Route::get('/', function () use ($router) {
    return $router->app->version();
});

Route::get('/swagger', function () use ($router) {
    return redirect('/api/documentation');
});

Route::post('/login', [
    'as' => 'login',
    'uses' => 'AdminSide\AuthController@login'
]);


Route::group(['middleware' => ['jwt']], function () {



});


Route::delete('/projects/{id}', [
    'as' => 'projects.destroy',
    'uses' => 'AdminSide\ProjectController@destroy'
]);

Route::delete('/post/{id}', [
    'as' => 'post.destroy',
    'uses' => 'AdminSide\ProjectController@destroy'
]);

Route::delete('/config/{id}', [
    'as' => 'config.destroy',
    'uses' => 'AdminSide\ConfigController@destroy'
]);



Route::get('/cv', [
    'as' => 'cv',
    'uses' => 'ClientSide\PageController@index'
]);

Route::get('/config', [
    'as' => 'config',
    'uses' => 'ClientSide\ConfigController@index'
]);

Route::get('/projects', [
    'as' => 'projects',
    'uses' => 'ClientSide\ProjectController@index'
]);

Route::get('/projects/{id}', [
    'as' => 'projects',
    'uses' => 'ClientSide\ProjectController@show'
]);

Route::get('/posts', [
    'as' => 'posts',
    'uses' => 'ClientSide\PostController@index'
]);

Route::get('/posts/{id}', [
    'as' => 'posts',
    'uses' => 'ClientSide\PostController@show'
]);
