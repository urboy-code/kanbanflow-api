<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/v1/register', [AuthController::class, 'register']);
Route::post('/v1/login', [AuthController::class, 'login']);

// NOTE FOR THIS ROUTE
// GET /api/v1/projects
// POST /api/v1/projects
// GET /api/v1/projects/{project}
// PUT /api/v1/projects/{project}
// DELETE /api/v1/projects/{project}
Route::apiResource('/v1/projects', ProjectController::class)->middleware('auth:sanctum');

// NOTE FOR THIS ROUTE
// GET /api/v1/projects/{project}/tasks
// POST /api/v1/projects/{project}/tasks
// GET /api/v1/projects/{project}/tasks/{task}
// PUT /api/v1/projects/{project}/tasks/{task}
// DELETE /api/v1/projects/{project}/tasks/{task}
Route::apiResource('/v1/projects.tasks', TaskController::class)->scoped()->middleware('auth:sanctum');
