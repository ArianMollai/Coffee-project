<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;


/* ************* USER ***************** */
Route::middleware('jwt')->group(function (){
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.get');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');
    Route::post('/users/logout', [AuthController::class, 'Logout']);
    Route::post('/users/create/user', [UserController::class, 'CreateNewUser']);
});

/* *************AUTH ******************* */
Route::middleware('guest.jwt')->group(function (){
    Route::post('/users/register', [AuthController::class, 'Register'])->name('users.register');
    Route::post('/users/login', [AuthController::class, 'login'])->name('users.login');
    Route::post('/users/admin/login', [AuthController::class, 'adminLogin'])->name('users.admin.login');
});

require __DIR__ . "/admin.php";