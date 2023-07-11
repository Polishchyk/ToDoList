<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

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

Route::post('/login', [AuthenticationController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    Route::post('/projects/store', [ProjectController::class, 'store']);
    Route::put('/projects/{id}/update', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}/delete', [ProjectController::class, 'destroy']);
    Route::get('/clients/{id}/projects', [ProjectController::class, 'getProjectsByClient']);

    Route::get('/clients', [ClientController::class, 'index']);
    Route::get('/clients/{id}', [ClientController::class, 'show']);
    Route::post('/clients/store', [ClientController::class, 'store']);
    Route::put('/clients/{id}/update', [ClientController::class, 'update']);
    Route::delete('/clients/{id}/delete', [ClientController::class, 'destroy']);

    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/projects/{id}/tasks', [TaskController::class, 'getTasksByProject']);
    Route::get('/profile/tasks', [TaskController::class, 'getMyTasks']);

    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile/update', [UserController::class, 'update']);
});
