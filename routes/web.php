<?php

use BandManager\App\Http\Controllers\LoginController;
use BandManager\App\Http\Middleware\FacebookCSRF;
use BandManager\App\Http\Middleware\VerifyCsrfToken;
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

Route::get('/login', fn () => view('page.login'))->name('login');
Route::get('/login/fb-success', [LoginController::class, 'handleFacebookLogin'])
    ->middleware([FacebookCSRF::class, VerifyCsrfToken::class]);

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => view('page.home'));
    Route::get('/other', fn () => view('page.other'));

    Route::get('/me', fn () => view('page.me'));
});
