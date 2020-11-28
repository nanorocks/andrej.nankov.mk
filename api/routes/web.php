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

    Route::get('/cv', [
        'as' => 'cv',
        'uses' => 'ClientSide\PageController@getCv'
    ]);

});

Route::get('/config', [
    'as' => 'config',
    'uses' => 'ClientSide\ConfigController@getConfig'
]);

Route::get('/projects', [
    'as' => 'projects',
    'uses' => 'ClientSide\ProjectController@getProjects'
]);

Route::get('/posts', [
    'as' => 'posts',
    'uses' => 'ClientSide\PostController@getPosts'
]);
