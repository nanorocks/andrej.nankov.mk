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

# Admin side Auth
Route::post('auth/login', 'AdminSide\AuthController@login');
Route::post('auth/refresh', 'AdminSide\AuthController@refresh');

# Admin side
Route::group(['middleware' => ['jwt']], function () {
    # Profile
    Route::get('/admin/profile', 'AdminSide\ProfileController@show');
    // Update profile

    # Projects
    Route::get('/admin/projects', 'AdminSide\ProjectController@index');
    Route::post('/admin/projects', 'AdminSide\ProjectController@store');
    //TODO: Route::put('/admin/projects/{id}', 'AdminSide\ProjectController@update'); // Later make it POST request for images
    Route::get('/admin/projects/{id}', 'AdminSide\ProjectController@show');
    Route::delete('/admin/projects/{id}', 'AdminSide\ProjectController@destroy');
    # Posts
    Route::get('/admin/posts', 'AdminSide\PostController@index');
    Route::post('/admin/posts', 'AdminSide\PostController@store');
    Route::put('/admin/posts/{id}', 'AdminSide\PostController@update'); // Later make it POST request for images
    Route::get('/admin/posts/{id}', 'AdminSide\PostController@show');
    Route::delete('/admin/posts/{id}', 'AdminSide\PostController@destroy');
    #Configs
    Route::get('/admin/configs', 'AdminSide\ConfigController@index');
    Route::post('/admin/configs', 'AdminSide\ConfigController@store');
    Route::put('/admin/configs/{id}', 'AdminSide\ConfigController@update');
    Route::get('/admin/configs/{id}', 'AdminSide\ConfigController@show');
    Route::delete('/admin/configs/{id}', 'AdminSide\ConfigController@destroy');
});

# Client side
Route::group(['middleware' => ['hmac', 'api-key']], function () {
    # Profile
    Route::get('/profile', 'ClientSide\ProfileController@index');
    # Config
    Route::get('/configs', 'ClientSide\ConfigController@index');
    # Projects
    Route::get('/projects', 'ClientSide\ProjectController@index');
    Route::get('/projects/{id}', 'ClientSide\ProjectController@show');
    # Posts
    Route::get('/posts', 'ClientSide\PostController@index');
    Route::get('/posts/{id}', 'ClientSide\PostController@show');
    Route::get('/posts/uuid/{id}', 'ClientSide\PostController@showByUuid');
});
