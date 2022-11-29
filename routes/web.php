<?php

use App\Http\Controllers\Auth\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Settings\Permissions;
use App\Http\Controllers\Home\Products;


Route::redirect('/', '/login');
Route::redirect('/home', '/login');


Route::get('/login', [Login::class, 'index'])->name('login');;
Route::post('/login', [Login::class, 'login'])->name('login.form');

Route::middleware('auth')->group(function(){
    Route::prefix('dashboard')->group(function(){
        Route::get('/', [Dashboard::class, 'index'])->name('dashboard');
    });

    Route::prefix('home')->group(function(){
        Route::prefix('products')->group(function(){
            Route::get('/', [Products::class, 'index'])->name('products');
            Route::post('/store', [Products::class, 'store'])->name('products.store');
            Route::get('/table', [Products::class, 'table'])->name('products.table');
            Route::post('/delete', [Products::class, 'delete'])->name('products.delete');
            Route::post('/inventory/add', [Products::class, 'inventoryAdd'])->name('products.inventory.add');
        });
    });

    Route::prefix('settings')->group(function(){
        Route::prefix('permissions')->group(function(){
            Route::get('/', [Permissions::class, 'index'])->name('permissions');
        });
    });
});
