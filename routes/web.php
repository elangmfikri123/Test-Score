<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainDealerController;
use App\Http\Controllers\RegistrasiController;
use App\Models\MainDealer;

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

Route::get('/', [AuthController::class, 'login']);
Route::get('/registrasi', [RegistrasiController::class, 'registrasi']);
Route::get('/register', [RegistrasiController::class, 'registrasi2']);

Route::get('/admin', [AdminController::class, 'dashboard']);

Route::get('/listuser', [AdminController::class, 'userlist']);
Route::get('/get-user/data', [AdminController::class, 'getusertable']);

Route::get('/listpeserta', [AdminController::class, 'pesertalist']);
Route::get('/get-peserta/data', [AdminController::class, 'getpesertatable']);

Route::get('/listjuri', [AdminController::class, 'jurilist']);

Route::get('/categorylist', [CategoryController::class, 'categorylist']);
Route::get('/get-category/data', [CategoryController::class, 'getcategory']);
Route::post('/category/store', [CategoryController::class, 'storecategory'])->name('category.store');

Route::get('/maindealerlist', [MainDealerController::class, 'maindealerlist']);
Route::get('/get-maindealer/data', [MainDealerController::class, 'getmaindealer']);
Route::post('/maindealer/store', [MainDealerController::class, 'storemaindealer'])->name('maindealer.store');
Route::delete('/maindealer/delete/{id}', [MainDealerController::class, 'deleteMainDealer'])->name('maindealer.delete');