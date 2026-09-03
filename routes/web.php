<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Frontend Product Routes
|--------------------------------------------------------------------------
*/

/*
| Product Listing
*/
Route::get(
    '/products',
    [ProductController::class, 'index']
)->name('products.index');

/*
| Product Create
*/
Route::get(
    '/products/create',
    [ProductController::class, 'create']
)->name('products.create');

/*
| Product Store
*/
Route::post(
    '/products/store',
    [ProductController::class, 'store']
)->name('products.store');

/*
| Product Edit
*/
Route::get(
    '/products/{id}/edit',
    [ProductController::class, 'edit']
)->name('products.edit');

/*
| Product Detail
*/
Route::get(
    '/products/{id}',
    [ProductController::class, 'show']
)->name('products.show');

/*
| Product Update
*/
Route::put(
    '/products/{id}',
    [ProductController::class, 'update']
)->name('products.update');

/*
| Product Delete
*/
Route::delete(
    '/products/{id}',
    [ProductController::class, 'destroy']
)->name('products.destroy');

/*
| Toggle Status
*/
Route::post(
    '/products/{id}/toggle-status',
    [ProductController::class, 'toggleStatus']
)->name('products.toggle-status');

/*
| CSV Export
*/
Route::get(
    '/products/export/csv',
    [ProductController::class, 'exportCsv']
)->name('products.export.csv');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        | Dashboard
        */
        Route::get(
            '/',
            [AdminController::class, 'dashboard']
        )->name('dashboard');

        /*
        | Products
        */
        Route::get(
            '/products',
            [AdminController::class, 'productsIndex']
        )->name('products.index');

        /*
        | Create
        */
        Route::get(
            '/products/create',
            [AdminController::class, 'productsCreate']
        )->name('products.create');

        /*
        | Store
        */
        Route::post(
            '/products/store',
            [AdminController::class, 'productsStore']
        )->name('products.store');

        /*
        | Edit
        */
        Route::get(
            '/products/{id}/edit',
            [AdminController::class, 'productsEdit']
        )->name('products.edit');

        /*
        | Update
        */
        Route::put(
            '/products/{id}',
            [AdminController::class, 'productsUpdate']
        )->name('products.update');

        /*
        | Delete
        */
        Route::delete(
            '/products/{id}',
            [AdminController::class, 'productsDestroy']
        )->name('products.destroy');

        /*
        | Toggle Status
        */
        Route::post(
            '/products/{id}/toggle-status',
            [AdminController::class, 'productsToggleStatus']
        )->name('products.toggle-status');

        /*
        | CSV Export
        */
        Route::get(
            '/products/export/csv',
            [AdminController::class, 'productsExportCsv']
        )->name('products.export.csv');

        /*
        | Site Settings
        */
        Route::get(
            '/settings',
            [AdminController::class, 'settings']
        )->name('settings');

        /*
        | Update Site Settings
        */
        Route::post(
            '/settings/update',
            [AdminController::class, 'settingsUpdate']
        )->name('settings.update');
    });
