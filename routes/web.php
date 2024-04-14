<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\VnPayController;
use App\Http\Controllers\CancelSubscriptionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MovieAdminController;
use App\Http\Controllers\CtMovieAdminController;

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

Route::get('/', function () {
    return view('index');
});

// Authentication routes
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

// Profile routes
Route::get('/profile', [AuthController::class, 'showProfile'])->name('user.profile');
Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('user.profile.update');
Route::get('/change-password', [AuthController::class, 'showPasswordChangeForm'])->name('password.change');
Route::post('/password/update', [AuthController::class, 'resetPassword'])->name('password.reset.update');

Route::post('/payment-vnpay', [VnPayController::class, 'create'])->name('payment.vnpay');
Route::get('/return-vnpay', [VnPayController::class, 'handle'])->name('vnpay.return');

Route::post('/cancel-subscription', [CancelSubscriptionController::class, 'cancel'])->name('cancel.subscription');

Route::get('/admin', [AdminController::class, 'showIndexAdmin']);

Route::get('/admin/movies', [MovieAdminController::class, 'index'])->name('admin.movies.index');
Route::get('/admin/movies/create', [MovieAdminController::class, 'create'])->name('movies.create');
Route::post('/admin/movies', [MovieAdminController::class, 'store'])->name('admin.movies.store');
Route::post('admin/movies/{id}/delete', [MovieAdminController::class, 'delete'])->name('admin.movies.delete');
Route::post('admin/movies/{id}/restore', [MovieAdminController::class, 'restore'])->name('admin.movies.restore');

Route::get('/admin/ct_movies', [CtMovieAdminController::class, 'index'])->name('admin.ct_movies.index');
Route::get('/admin/ct_movies/create', [CtMovieAdminController::class, 'create'])->name('admin.ct_movies.create');
Route::post('/admin/ct_movies', [CtMovieAdminController::class, 'store'])->name('admin.ct_movies.store');
Route::post('/admin/ct_movies/{id}/delete', [CtMovieAdminController::class, 'delete'])->name('admin.ct_movies.delete');
Route::post('/admin/ct_movies/{id}/restore', [CtMovieAdminController::class, 'restore'])->name('admin.ct_movies.restore');
Route::post('/admin/ct_movies/{id}/block', [CtMovieAdminController::class, 'block'])->name('admin.ct_movies.block');
Route::post('/admin/ct_movies/{id}/unblock', [CtMovieAdminController::class, 'unblock'])->name('admin.ct_movies.unblock');