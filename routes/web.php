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

// Portal Routes
Route::get('website', 'PortalController')->name('portal');
Route::name('portal.')->prefix('website')->group(function () {
    Route::get('menu/{slug}', 'SubMenuController')->name('sub-menu');
    // Auth Routes
    Route::namespace('Auth')
        ->group(function () {
            Route::get('register', 'RegisterController@index')->name('register');
            Route::post('register', 'RegisterController@store')->name('register.post');
            Route::get('login', 'LoginController@index')->name('login');
            Route::post('login/{mode?}', 'LoginController@login')->name('login.post');
            Route::get('logout', 'LoginController@logout')->name('logout');
        });

    // Consultation Routes
    Route::name('consultation')
        ->prefix('konsultasi')
        ->namespace('Consultation')
        ->group(function () {
            Route::get('', 'IndexConsultationController');
            Route::post('', 'PostConsultationController');
        });

    // News Routes
    Route::name('news.')
        ->prefix('berita')
        ->namespace('News')
        ->group(function () {
            Route::get('/', 'IndexController')->name('index');
            Route::get('{slug}', 'DetailController')->name('detail');
            Route::post('comment', 'CommentController')->name('comment');
        });

    // Jobs Routes
    Route::name('jobs.')
        ->prefix('pekerjaan')
        ->namespace('Jobs')
        ->group(function () {
            Route::get('/', 'IndexController')->name('index');
            Route::get('{jobId}', 'DetailController')->name('detail');
            Route::post('apply', 'ApplyJobController')->name('apply');
        });

    // News Routes
    Route::name('train-and-internship.')
        ->prefix('latihan-dan-magang')
        ->namespace('TrainAndInternship')
        ->group(function () {
            Route::get('/', 'IndexController')->name('index');
            // Route::get('{slug}', 'DetailController')->name('detail');
        });

    // Dummies Routes
    Route::name('dummies.')
        ->group(function () {
            Route::get('magang', fn () => view('portal.dummies.magang'))->name('magang');
            Route::get('info', fn () => view('portal.dummies.info'))->name('info');
        });
});
