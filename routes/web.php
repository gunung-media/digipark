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

Route::get('/', 'LandingController')->name('landing');
Route::get('website', 'PortalController')->name('portal');
Route::get('form', fn () => view('portal.form'))->name('form');
Route::get('berita', fn () => view('portal.berita'))->name('berita');
Route::get('text', fn () => view('portal.text'))->name('text');
