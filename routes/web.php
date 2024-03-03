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

Route::name('portal.berita.')->prefix('website/berita')->group(function () {
    Route::get('/', 'Berita\IndexController')->name('index');
    Route::get('{slug}', 'Berita\DetailController')->name('detail');
});

Route::get('text', fn () => view('portal.text'))->name('text');
