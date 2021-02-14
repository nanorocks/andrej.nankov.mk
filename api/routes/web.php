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

# Auth
Route::group(['namespace' => 'AdminSide'], function () {
    # Admin side Auth
    Route::post('auth/login', 'AuthController@login');
    Route::post('auth/refresh', 'AuthController@refresh');
});

# Admin side
Route::group(['prefix' => 'admin', 'namespace' => 'AdminSide', 'middleware' => ['jwt']], function () {
    # Profile
    Route::get('/profile', 'ProfileController@show');
    Route::post('/profile', 'ProfileController@update');
    # Projects
    Route::get('/projects', 'ProjectController@index');
    Route::post('/projects', 'ProjectController@store');
    Route::put('/projects/{id}', 'ProjectController@update'); // Later make it POST request for images
    Route::get('/projects/{id}', 'ProjectController@show');
    Route::delete('/projects/{id}', 'ProjectController@destroy');
    # Posts
    Route::get('/posts', 'PostController@index');
    Route::post('/posts', 'PostController@store');
    Route::put('/posts/{id}', 'PostController@update'); // Later make it POST request for images
    Route::get('/posts/{id}', 'PostController@show');
    Route::delete('/posts/{id}', 'PostController@destroy');
    #Configs
    Route::get('/configs', 'ConfigController@index');
    Route::post('/configs', 'ConfigController@store');
    Route::put('/configs/{id}', 'ConfigController@update');
    Route::get('/configs/{id}', 'ConfigController@show');
    Route::delete('/configs/{id}', 'ConfigController@destroy');
});

# Client side
Route::group(['namespace' => 'ClientSide', 'middleware' => ['hmac', 'api-key']], function () {
    # Profile
    Route::get('/profile', 'ProfileController@index');
    # Config
    Route::get('/configs', 'ConfigController@index');
    # Projects
    Route::get('/projects', 'ProjectController@index');
    Route::get('/projects/{id}', 'ProjectController@show');
    # Posts
    Route::get('/posts', 'PostController@index');
    Route::get('/posts/{id}', 'PostController@show');
    Route::get('/posts/uuid/{id}', 'PostController@showByUuid');
});
