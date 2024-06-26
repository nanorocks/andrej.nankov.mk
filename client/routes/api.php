<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/profile', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/purge-action-oauth', function (Request $request) {

    $cmd = Artisan::call('app:purge-action-command');

    return $request->json(['status' => $cmd]);
});
