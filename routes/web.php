<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\SlideController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [GenreController::class, 'index']);
Route::get('/', [SlideController::class, 'index']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('login.provider');
Route::get('/login/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('login.callback');
Route::get('/forgot-password', [AuthController::class, 'showPasswordResetForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetEmail'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'updatePassword'])->name('password.update');
Route::post('/payment-vnpay', [VnPayController::class, 'create'])->name('payment.vnpay');
Route::get('/return-vnpay', [VnPayController::class, 'handle'])->name('vnpay.return');

