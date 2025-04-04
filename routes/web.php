<?php

use App\Models\Category;
use App\Models\MainDealer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JuriController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainDealerController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\PesertaCourseController;

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

Route::get('/admin/exams', [AdminController::class, 'managecourselist']);
Route::get('/admin/exams/create', [AdminController::class, 'addnewcourse']);
Route::get('/admin/exams/detail', [AdminController::class, 'detailcourse']);
Route::get('/admin/exams/question-create', [AdminController::class, 'createquestion']);
Route::get('/admin/exams_sessions', [AdminController::class, 'sessionslist']);
Route::get('/admin/exams_sessions/detail', [AdminController::class, 'sessiondetail']);

//JURI
Route::get('/peserta/list', [JuriController::class, 'pesertalist']);
Route::get('/get-user/data', [AdminController::class, 'getusertable']);


//PESERTA
Route::get('/online-quiz/results', [PesertaCourseController::class, 'showquiz']);
Route::get('/exam-confirmation/quiz', [PesertaCourseController::class, 'showconfirmation']);

Route::get('/participants/quizlist', [PesertaController::class, 'showlistquiz']);