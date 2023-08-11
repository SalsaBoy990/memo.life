<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\UserController;
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
    ['middleware' => ['auth', '2fa', 'role:super-administrator|administrator']],
    function () {
        Route::get('/admin/app', function () {
            return view('pages.admin.admin');
        })->name('admin');
    });


Route::group(
    ['prefix' => 'admin'],
    function () {
        Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
    });


Route::group(
    ['middleware' => ['auth', 'verified', '2fa', 'role:super-administrator|administrator|editor'], 'prefix' => 'admin'],
    function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('user/account/{user}', [UserController::class, 'account'])->name('user.account');
        Route::put('user/update/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('user/destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::delete('user/account/delete/{user}',
            [UserController::class, 'deleteAccount'])->name('user.account.delete');

    }
);


Route::group(
    ['middleware' => ['auth', 'verified', '2fa', 'role:super-administrator'], 'prefix' => 'admin'],
    function () {
        Route::get('user/manage', [UserController::class, 'index'])->name('user.manage');
        /* Roles and Permissions */
        Route::get('role-permission/manage', [RolePermissionController::class, 'index'])
            ->name('role-permission.manage');
        /* Roles and Permissions END */
    }
);


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
Route::get('2fa', [\App\Http\Controllers\Auth\UserCodeController::class, 'index'])->name('2fa.index');
Route::post('2fa', [\App\Http\Controllers\Auth\UserCodeController::class, 'store'])->name('2fa.post');
Route::get('2fa/reset', [\App\Http\Controllers\Auth\UserCodeController::class, 'resend'])
    ->name('2fa.resend');
// 2FA endpoints END
