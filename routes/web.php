<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\QuestionController;
use App\Http\Controllers\User\CollectionController;
use App\Http\Controllers\User\BookmarkController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashcobardController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\Ustadz\UstadzController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\NotificationController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

// Login Routes
Route::get('/login', function () {
    return view('front.pages.login');
})->name('login');

Route::get('/class', function () {
    return view('front.pages.maintanance');
})->name('class');

Route::get('/collaction', function () {
    return view('front.pages.collaction');
})->name('collaction');

// GUEST ROUTES (tanpa auth)
Route::resource('guest', GuestController::class);

// Question Routes - Public access for viewing
Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');


Route::middleware(['auth'])->group(function () {
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifications.index');
    // Jika ingin fitur tandai semua sudah dibaca:
    Route::post('/notifikasi/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::get('/notifikasi/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
});

// Public Search Route
Route::get('/search', [HomeController::class, 'search'])->name('search.questions');

// User Routes - Protected for authenticated users
Route::middleware(['auth', 'role:user,admin,ustadz'])->group(function () {
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::get('/bookmarks/{id}', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{id}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');

    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::get('/account/detail', [AccountController::class, 'detail'])->name('account.detail');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password');
    Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');

    // Notification Routes
    Route::get('/notifications', [AccountController::class, 'notifications'])->name('notifications');
    Route::put('/notifications/{id}/read', [AccountController::class, 'markNotificationAsRead'])->name('notifications.read');
    Route::put('/notifications/read-all', [AccountController::class, 'markAllNotificationsAsRead'])->name('notifications.read-all');
});

// // Admin Routes - User Management (Admin Only)
// Route::prefix('admin')->middleware(['auth', 'role:admin,ustadz'])->name('dashboard.')->group(function () {
//     Route::resource('users', UserController::class);
//     Route::resource('questions', QuestionController::class);
//     // Add any other admin-only resource routes here later
// });

// Admin/Ustadz Dashboard Routes
Route::prefix('dashboard/')->middleware(['auth', 'role:admin,ustadz'])->name('dashboard.')->group(function () {
    Route::get('/', [DashcobardController::class, 'index'])->name('index');
    Route::resource('users', UserController::class);
    Route::resource('questions', AdminQuestionController::class);
    // Route::get('/questions', [DashcobardController::class, 'questions'])->name('questions');
    Route::get('/settings', [DashcobardController::class, 'settings'])->name('settings');
    Route::get('/ustadz', [DashcobardController::class, 'ustadz'])->name('ustadz');
});

// Ustadz Routes
Route::prefix('dashboard/ustadz')->middleware(['auth', 'role:ustadz'])->group(function () {
    Route::resource('/', UstadzController::class)->names('ustadz');
});

// LOGOUT
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

// Google Auth Routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
