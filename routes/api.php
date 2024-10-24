<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\TodoController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('projects', [ProjectsController::class, 'index']);


// full api method
Route::apiResource('projects', ProjectsController::class);

Route::apiResource('test', ProjectsController::class);





// Posts Crud
Route::get('posts', [PostController::class, 'index']);

Route::get('post/{id}', [PostController::class, 'show']);

Route::post('posts/create', [PostController::class, 'store']);

Route::post('posts/update/{id}', [PostController::class, 'update']);

Route::post('posts/delete/{id}', [PostController::class, 'destory']);


Route::get('users', [TodoController::class, 'index']);

Route::controller(AuthController::class)->middleware('jwt.verify')->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::controller(TodoController::class)->middleware('jwt.verify')->group(function () {
    Route::get('todos', 'index');
    Route::post('todo', 'store');
    Route::get('todo/{id}', 'show');
    Route::put('todo/{id}', 'update');
    Route::delete('todo/{id}', 'destroy');
});
