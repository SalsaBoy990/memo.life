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
Route::get('/admin', function () {
    return view('pages.admin.admin');
})->name('admin');


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
