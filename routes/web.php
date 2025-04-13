<?php

use App\Models\Category;
use App\Models\MainDealer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JuriController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
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

Route::get('/admin/exams', [CourseController::class, 'managecourselist']);
Route::get('/datacourse/json', [CourseController::class, 'showcourselist']);
Route::get('/admin/exams/create', [CourseController::class, 'addnewcourse']);
Route::post('/admin/course/store', [CourseController::class, 'store']);

Route::get('/admin/exams/{id}/questions', [CourseController::class, 'showquestionslist']);
Route::get('/dataquestion-answer/json/{id}', [CourseController::class, 'dataquestionAnswerJson']);
Route::get('/admin/exams/{id}/question-create', [CourseController::class, 'createquestion']);
Route::post('/admin/exams/{id}/question-store', [CourseController::class, 'storequestion']);

Route::get('/admin/manage-participants', [CourseController::class, 'showCourseParticipants']);
Route::get('/datacourseparticipants/json', [CourseController::class, 'JsonParticipantsCourse']);

// Monitoring peserta
Route::get('/admin/manage-participants/{id}', [CourseController::class, 'listParticipanstCourse'])->name('participants.monitoring');
Route::get('/admin/enrolle/{id}/participantsdata', [CourseController::class, 'addParticipants'])->name('participants.add');

// Menambahkan peserta
Route::get('/monitoring/data/json/{id}', [CourseController::class, 'getEnrolledParticipantsJson']);
Route::delete('/monitoring/delete/{id}', [CourseController::class, 'deletePeserta'])->name('peserta.delete');

Route::get('/pesertaenrolle/data/json/{id}', [CourseController::class, 'getNonEnrolledParticipantsJson']);
Route::post('/enrolle/store/{id}', [CourseController::class, 'storeParticipants'])->name('participants.store');

//JURI
Route::get('/peserta/list', [JuriController::class, 'pesertalist']);
Route::get('/get-user/data', [AdminController::class, 'getusertable']);


//PESERTA
Route::get('/online-quiz/results', [PesertaCourseController::class, 'showquiz']);
Route::get('/exam-confirmation/quiz', [PesertaCourseController::class, 'showconfirmation']);

Route::get('/participants/quizlist', [PesertaController::class, 'showlistquiz']);