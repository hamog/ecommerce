<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserPermissionController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\ProductController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')
    ->middleware(['auth', 'permission:view admin dashboard'])
    ->name('admin.')
    ->group(static function () {
        Route::get('/', [HomeController::class, 'index'])->name('home.index');
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::post('/user/{user}/roles', UserRoleController::class)->name(
            'users.roles.assign',
        );
        Route::post(
            '/users/{user}/permissions',
            UserPermissionController::class,
        )->name('users.permissions.assign');
        Route::post(
            '/roles/{role}/permissions',
            RolePermissionController::class,
        )->name('roles.permissions.assign');

        Route::resource('categories', CategoryController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('products', ProductController::class);

        Route::post('/images/{path?}', [ImageController::class, 'store'])->name(
            'images.store',
        );
        Route::get('/images', [ImageController::class, 'show'])->name(
            'images.show',
        );
        Route::delete('/images', [ImageController::class, 'destroy'])->name(
            'images.destroy',
        );

    });
