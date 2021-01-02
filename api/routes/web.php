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

Route::post('/login', [
    'as' => 'login',
    'uses' => 'AdminSide\AuthController@login'
]);

Route::post('/refresh', [
    'as' => 'refresh',
    'uses' => 'AdminSide\AuthController@refresh'
]);


// Admin
Route::group(['middleware' => ['jwt']], function () {

    Route::get('/cv', [
        'as' => 'cv.index',
        'uses' => 'ClientSide\PageController@index'
    ]);

    Route::get('/config', [
        'as' => 'config.index',
        'uses' => 'ClientSide\ConfigController@index'
    ]);

    Route::get('/projects', [
        'as' => 'projects.index',
        'uses' => 'ClientSide\ProjectController@index'
    ]);

    Route::get('/projects/{id}', [
        'as' => 'projects.show',
        'uses' => 'ClientSide\ProjectController@show'
    ]);

    Route::get('/posts', [
        'as' => 'posts.index',
        'uses' => 'ClientSide\PostController@index'
    ]);

    Route::get('/posts/{id}', [
        'as' => 'posts.show',
        'uses' => 'ClientSide\PostController@show'
    ]);



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



});

// Client
Route::group(['middleware' => ['hmac', 'api-key']], function () {

    Route::get('/cv', [
        'as' => 'cv.index',
        'uses' => 'ClientSide\PageController@index'
    ]);

    Route::get('/config', [
        'as' => 'config.index',
        'uses' => 'ClientSide\ConfigController@index'
    ]);

    Route::get('/projects', [
        'as' => 'projects.index',
        'uses' => 'ClientSide\ProjectController@index'
    ]);

    Route::get('/projects/{id}', [
        'as' => 'projects.show',
        'uses' => 'ClientSide\ProjectController@show'
    ]);

    Route::get('/posts', [
        'as' => 'posts.index',
        'uses' => 'ClientSide\PostController@index'
    ]);

    Route::get('/posts/{id}', [
        'as' => 'posts.show',
        'uses' => 'ClientSide\PostController@show'
    ]);

    Route::get('/posts/uuid/{id}', [
        'as' => 'posts.showByUuid',
        'uses' => 'ClientSide\PostController@showByUuid'
    ]);

});



