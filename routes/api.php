<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
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
    Route::get('/tasks/{id}', [TaskController::class, 'show']);
    Route::post('/tasks/store', [TaskController::class, 'store']);
    Route::get('/projects/{id}/tasks', [TaskController::class, 'getTasksByProject']);
    Route::get('/profile/tasks', [TaskController::class, 'getMyTasks']);
    Route::put('/tasks/{id}/update', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}/delete', [TaskController::class, 'destroy']);

    Route::get('/task-statuses', [TaskStatusController::class, 'index']);
    Route::post('/task-statuses/store', [TaskStatusController::class, 'store']);
    Route::put('/task-statuses/{id}/update', [TaskStatusController::class, 'update']);
    Route::delete('/task-statuses/{id}/delete', [TaskStatusController::class, 'destroy']);

    Route::post('/comments', [CommentController::class, 'store']);
    Route::get('task/{id}/comments', [CommentController::class, 'showByTaskId']);
    Route::get('comments', [CommentController::class, 'index']);
    Route::get('comments/{id}', [CommentController::class, 'show']);
    Route::delete('/comments/{id}/delete', [CommentController::class, 'destroy']);
    Route::put('/comments/{id}/update', [CommentController::class, 'update']);

    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile/update', [UserController::class, 'update']);
});
