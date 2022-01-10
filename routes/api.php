<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;


Route::get('/ping' , function(){
    return ['pong'=>true];
});
 Route::get('unauthenticated', function(){
     return['error'=> 'Usuário nao logado!'];
 })->name('login');

Route::post('/user', [AuthController::class, 'create']);
Route::middleware('auth:api')->get('/auth/logout', [AuthController::class, 'logout']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/auth/me', [AuthController::class, 'me']);


Route::middleware('auth:api')->post('todo',[ApiController::class, 'createTodo']);
Route::get('/todos' , [ApiController::class, 'getAllTodos']);
Route::get('/todo/{id}', [ApiController::class, 'getTodo']);
Route::middleware('auth:api')->put('/todo/{id}', [ApiController::class, 'updateTodo']);
Route::middleware('auth:api')->delete('/todo/{id}', [ApiController::class, 'deleteTodo']);