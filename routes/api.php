<?php

use App\Http\Controllers\V1\ArticleController;
use App\Http\Controllers\V1\UploadController;
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V2\HomeController;
use App\Http\Controllers\V2\LoginController;
use App\Http\Controllers\V2\RegisterController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'v1'], function ($router){
    $router->get('users', [UserController::class, 'index']);
    $router->resource('articles', ArticleController::class);

    $router->get('upload', [UploadController::class, 'index']);
    $router->post('upload', [UploadController::class, 'store']);
});


Route::group(['prefix' => 'v2'], function ($router) {
    $router->get('register', [RegisterController::class, 'index']);
    $router->post('register', [RegisterController::class, 'register']);

    $router->get('login', [LoginController::class, 'login']);
    $router->post('login', [LoginController::class, 'login']);

    $router->get('email', [HomeController::class, 'email']);
    $router->post('buy', [HomeController::class, 'buy']);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
