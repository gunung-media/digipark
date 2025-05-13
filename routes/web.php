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


Route::prefix('/mobile')
    ->name('mobile.')
    ->namespace('Mobile')
    ->middleware('inertia:app-mobile')->group(function () {
        Route::namespace('Authentication')
            ->middleware('guest:seeker')
            ->group(function () {
                Route::get('/', 'OnboardingController')->name('landing');
                Route::get('login', 'LoginController@index')->name('login');
                Route::post('login', 'LoginController@login')->name('login.proceed');

                Route::get('signup', 'SignupController@index')->name('signup');
                Route::post('signup/store', 'SignupController@store')->name('signup.store');
            });

        Route::middleware('auth:seeker')
            ->group(function () {
                Route::get('logout', 'Authentication\LoginController@logout')->name('logout');
                Route::prefix('/home')
                    ->namespace('Home')
                    ->group(function () {
                        Route::get('/', 'HomeController')->name('home');
                        Route::get('news/{slug}', 'NewsController@detail')->name('news.detail');
                        Route::get('notification', 'NotificationController@index')->name('notification');
                        Route::get('notification_count', 'NotificationController@count')->name('notification.count');
                    });

                Route::prefix('job')
                    ->namespace('Job')
                    ->name('job.')
                    ->group(function () {
                        Route::get('', 'JobController@index')->name('index');
                        Route::get('search', 'JobController@search')->name('search');
                        Route::get('edit/{id}', 'JobDetailController@index')->name('detail');
                    });

                Route::prefix('/service')
                    ->namespace('Service')
                    ->name('service.')
                    ->group(function () {
                        Route::get('', 'ServiceController')->name('index');
                        Route::get('claim-jht', 'ClaimJhtController@index')->name('claim-jht');
                        Route::post('claim-jht/store', 'ClaimJhtController@store')->name('claim-jht.store');
                    });


                Route::prefix('/profile')
                    ->namespace('Profile')
                    ->name('profile.')
                    ->group(function () {
                        Route::get('', 'ProfileController')->name('index');
                        Route::get('edit', 'EditProfileController@index')->name('edit');
                        Route::post('edit/proceed', 'EditProfileController@proceed')->name('edit.proceed');

                        Route::get('change_pass', 'ChangePasswordController@index')->name('change-password.index');
                        Route::post('change_pass/proceed', 'ChangePasswordController@proceed')->name('change-password.proceed');
                    });
            });
    });

// Portal Routes
Route::get('website', 'PortalController')->name('portal');
Route::name('portal.')->prefix('website')->group(function () {
    Route::get('menu/{slug}', 'SubMenuController')->name('sub-menu');
    Route::get('ketenagakerjaan', 'InfoEmploymentController')->name('info-employment');
    Route::get('guide', 'GuideController')->name('guide');
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
            Route::get('{slug}', 'DetailController')->name('detail');
        });

    // Dummies Routes
    Route::name('dummies.')
        ->group(function () {
            Route::get('magang', fn() => view('portal.dummies.magang'))->name('magang');
            Route::get('info', fn() => view('portal.dummies.info'))->name('info');
            Route::prefix('pdf')->group(function () {
                Route::get('claim-jht', fn() => view('pdf.claim-jht', ['record' => App\Models\Seeker\ClaimJht::first()]));
                Route::get('job', fn() => view('pdf.job', ['record' => App\Models\Company\Job::first()]));
                Route::get('company-laid-off', fn() => view('pdf.company-laid-off', ['record' => App\Models\Company\CompanyLaidOff::first()]));
                Route::get('company-legalization', fn() => view('pdf.company-legalization', ['record' => App\Models\Company\CompanyLegalization::first()]));
                Route::get('labor-demand', fn() => view('pdf.labor-demand', ['record' => App\Models\Company\LaborDemand::first()]));
                Route::get('placement', fn() => view('pdf.placement', ['record' => App\Models\Company\Placement::first()]));
            });
        });
});
