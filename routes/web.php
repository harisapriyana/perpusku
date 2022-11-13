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
//  menggunakan stripe
Route::post('/cart/stripe', [App\Http\Controllers\CartController::class, 'checkout'])->middleware('auth');
// menggunakan midtrans
Route::post('/cart/midtrans', [App\Http\Controllers\CartController::class, 'order'])->middleware('auth');

Route::post('payments/midtrans-notification', [App\Http\Controllers\CartController::class, 'receive']);

Route::get('/cart/checkout', [App\Http\Controllers\CartController::class, 'create'])->middleware('auth');

Route::post('/cart/{book:slug}', [App\Http\Controllers\CartController::class, 'store'])->middleware('auth');

Route::put('/cart/{id}/edit', [App\Http\Controllers\CartController::class, 'update'])->middleware('auth');

Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'destroy'])->middleware('auth');

Route::get('/cart/create', [App\Http\Controllers\CartController::class, 'create'])->middleware('auth');

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
