<?php

use App\Http\Middleware\CekLogin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardBookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [PagesController::class, 'index']);

Route::get('/about', [PagesController::class, 'about']);

Route::resource('/book', BookController::class);

Route::post('/cart/checkout', [App\Http\Controllers\CartController::class, 'checkout']);

Route::post('/cart/{book:slug}', [App\Http\Controllers\CartController::class, 'store']);

Route::get('/cart/create', [App\Http\Controllers\CartController::class, 'create']);

Route::get('/category', [CategoryController::class,'index']);

Route::get('/category/{category:slug}', [CategoryController::class,'show']);

Route::get('/category/{category:slug}/cari', [CategoryController::class,'cari']);

Route::get('/author', [AuthorController::class, 'index']);

Route::get('/author/{author:alias}', [AuthorController::class, 'show']);

Route::get('/author/{author:alias}/cari', [AuthorController::class, 'cari']);

Route::get('/login', [LoginController::class, 'index'])->name('login');

Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/register', [LoginController::class, 'register']);

Route::post('/register', [LoginController::class, 'store']);

Route::post('/logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['auth']], function(){
    Route::group(['middleware' => ['ceklogin:1']], function(){
        Route::resource('/dashboard', App\Http\Controllers\DashboardBookController::class);
    });
    Route::group(['middleware' => ['ceklogin:0']], function(){
        Route::get('/cart', [BookController::class, 'index']);
    });
});
