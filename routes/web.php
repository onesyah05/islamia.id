<?php

use Illuminate\Support\Facades\Route;

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
    return view('front.pages.home');
})->name('home');

Route::get('/detail', function () {
    return view('front.pages.detail');
})->name('detail');

Route::get('/ask', function () {
    return view('front.pages.question');
})->name('ask');

Route::get('/class', function () {
    return view('front.pages.maintanance');
})->name('class');

Route::get('/collaction', function () {
    return view('front.pages.collaction');
})->name('collaction');
