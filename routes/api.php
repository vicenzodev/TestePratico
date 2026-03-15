<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

Route::post('/login', [UserController::class, 'login']);
Route::post('/transactions', [TransactionController::class, 'store']);
Route::get('/transactions', [TransactionController::class, 'index']);