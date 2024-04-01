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

Route::name('portal.')->group(function () {
    Route::get('login', 'LoginController@index')->name('login');
    Route::post('login/{mode?}', 'LoginController@login')->name('login.post');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::get('register', 'RegisterController@index')->name('register.index');
    Route::post('register', 'RegisterController@store')->name('register');
    Route::post('consultation', 'PostConsultationController')->name('consultation');
    Route::get('konsultasi', 'IndexConsultationController')->name('consultation');

    Route::name('berita.')->prefix('website/berita')->group(function () {
        Route::get('/', 'Berita\IndexController')->name('index');
        Route::get('{slug}', 'Berita\DetailController')->name('detail');
        Route::post('comment', 'Berita\CommentController')->name('comment');
    });

    Route::name('jobs.')->prefix('jobs')->namespace('Pekerjaan')->group(function () {
        Route::get('/', 'IndexController')->name('index');
        Route::get('{jobId}', 'DetailController')->name('detail');
    });
    Route::post('jobs/apply', 'Seeker\ApplyJobController')->name('jobs.apply');

    Route::middleware('auth:company')->group(function () {
        Route::name('layanan.')->prefix('layanan')->namespace('Layanan')->group(function () {
            Route::name('pembuatanPekerjaan.')->prefix('pembuatan-pekerjaan')->group(function () {
                Route::get('form', 'PembuatanPekerjaan@index')->name('index');
                Route::post('form', 'PembuatanPekerjaan@store')->name('store');
            });
            Route::name('permintaanTenagaKerja.')->prefix('permintaan-tenaga-kerja')->group(function () {
                Route::get('form', 'PermintaanTenagaKerja@index')->name('index');
                Route::post('form', 'PermintaanTenagaKerja@store')->name('store');
            });
            Route::name('pelaporanPenempatan.')->prefix('pelaporan-penempatan')->group(function () {
                Route::get('form', 'PelaporanPenempatan@index')->name('index');
                Route::post('form', 'PelaporanPenempatan@store')->name('store');
            });
        });
    });
});

Route::get('menu/{slug}', 'SubMenuController')->name('subMenu');
