<?php

use BandManager\App\Http\Controllers\LoginController;
use BandManager\App\Http\Middleware\FacebookCSRF;
use BandManager\App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// AUTH ===========================================================================================
// ================================================================================================

Route::get('/login', fn () => view('page.login'))->name('login');
Route::get('/login/fb-success', [LoginController::class, 'handleFacebookLogin'])
    ->middleware([FacebookCSRF::class, VerifyCsrfToken::class]);

Route::match(['GET', 'POST'], '/logout', function () {
    Auth::logout();
    return redirect('/');
});

// ================================================================================================
// ================================================================================================

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => view('page.home'));
    Route::get('/other', fn () => view('page.other'));

    Route::get('/me', fn () => view('page.me'));
});
