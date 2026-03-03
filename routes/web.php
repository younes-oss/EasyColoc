<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColocationController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/dashboardAdmin', function () {
    return view('dashboardAdmin');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');



Route::middleware('auth')->group(function () {

    Route::get('/colocations/create', [ColocationController::class, 'create'])
        ->name('colocations.create');

    Route::post('/colocations', [ColocationController::class, 'store'])
        ->name('colocations.store');

    Route::get('/colocations/join', [ColocationController::class, 'joinForm'])
        ->name('colocations.join.form');

    Route::post('/colocations/join', [ColocationController::class, 'join'])
        ->name('colocations.join');

});