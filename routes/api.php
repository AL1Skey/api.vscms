<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(["prefix"=>"public"], function(){
    Route::get('/brands', [BrandController::class, 'index']);
    Route::get('/headers', [HeaderController::class, 'index']);
    Route::get('/footers', [FooterController::class, 'index']);
    Route::get('/services', [ServicesController::class, 'index']);
    Route::get('/projects', [ProjectController::class, 'index']);
});


Route::get('/me', [AuthController::class, 'verify']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/brands', [BrandController::class, 'index']);
    Route::post('/brands', [BrandController::class, 'store']);
    Route::get('/brands/{id}', [BrandController::class, 'show']);
    Route::put('/brands/{id}', [BrandController::class, 'update']);
    Route::delete('/brands/{id}', [BrandController::class, 'destroy']);
    
    Route::get('/headers', [HeaderController::class, 'index']);
    Route::post('/headers', [HeaderController::class, 'store']);
    Route::get('/headers/{id}', [HeaderController::class, 'show']);
    Route::put('/headers/{id}', [HeaderController::class, 'update']);
    Route::delete('/headers/{id}', [HeaderController::class, 'destroy']);
    
    Route::get('/footers', [FooterController::class, 'index']);
    Route::post('/footers', [FooterController::class, 'store']);
    Route::get('/footers/{id}', [FooterController::class, 'show']);
    Route::put('/footers/{id}', [FooterController::class, 'update']);
    Route::delete('/footers/{id}', [FooterController::class, 'destroy']);
    
    Route::get('/users', [UsersController::class, 'index']);
    Route::post('/users', [UsersController::class, 'store']);
    Route::get('/users/{id}', [UsersController::class, 'show']);
    Route::put('/users/{id}', [UsersController::class, 'update']);
    Route::delete('/users/{id}', [UsersController::class, 'destroy']);

    Route::get('/services', [ServicesController::class, 'index']);
    Route::post('/services', [ServicesController::class, 'store']);
    Route::get('/services/{id}', [ServicesController::class, 'show']);
    Route::put('/services/{id}', [ServicesController::class, 'update']);
    Route::delete('/services/{id}', [ServicesController::class, 'destroy']);

    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

});