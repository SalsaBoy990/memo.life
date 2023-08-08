<?php

use App\Http\Controllers\Public\ArticleController;
use Illuminate\Support\Facades\Auth;
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


/**
 * This is the frontpage route
 */
Route::get('/', function () {
    return view('pages.public.frontpage');
})->name('frontpage');


Auth::routes([
    'logout' => false
]);

/**
 * This is the SPA-route
 */
Route::group(
    ['middleware' => ['auth', '2fa', 'role:super-administrator|administrator'] ],
    function () {
        Route::get('/admin', function () {
            return view('pages.admin.admin');
        })->name('admin');
    });


/**
 * Public routes go here
 */
Route::get('/article/{article}', [ArticleController::class, 'show'])->name('article.public.show');


/**
 * This is for testing
 */
Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
})->name('sentry');


// 2FA endpoints
Route::get('2fa', [App\Http\Controllers\UserCodeController::class, 'index'])->name('2fa.index');
Route::post('2fa', [App\Http\Controllers\UserCodeController::class, 'store'])->name('2fa.post');
Route::get('2fa/reset', [App\Http\Controllers\UserCodeController::class, 'resend'])
    ->name('2fa.resend');
// 2FA endpoints END
