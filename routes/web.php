<?php

use App\Models\AdminMD;
use App\Models\Category;
use App\Models\MainDealer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Utilities\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JuriController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AdminMDController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainDealerController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\FormPenilaianController;
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

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/check-session', [AuthController::class, 'checkSession'])->name('check.session');
Route::get('/registrasi', [RegistrasiController::class, 'registrasi']);

//ADMINISTRATOR
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard']);
    Route::get('/listuser', [AdminController::class, 'userlist'])->name('admin.userlist');
    Route::get('/get-user/data', [AdminController::class, 'getusertable']);
    Route::post('/force-logout/{id}', [AuthController::class, 'forceLogout']);
    Route::post('/user/store', [AdminController::class, 'store'])->name('user.store');

    Route::get('/listpeserta/admin', [AdminController::class, 'pesertalist']);
    Route::get('/get-peserta/data/admin', [AdminController::class, 'getpesertatable']);

    Route::get('/listjuri', [AdminController::class, 'jurilist']);
    Route::get('/datajuri/json', [AdminController::class, 'juriJson']);

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

    Route::get('/admin/scorecardlist', [FormPenilaianController::class, 'show']);
    Route::get('/scorecardlist/json', [FormPenilaianController::class, 'listScoreCardJson']);

});

// ADMIN MAIN DEALERS
Route::middleware(['auth', 'role:AdminMD'])->group(function () {
    Route::get('/admin-maindealers/index', [AdminMDController::class, 'index']);

    Route::get('/listpeserta', [AdminController::class, 'pesertalist'])->name('list.peserta');
    Route::get('/get-peserta/data', [AdminController::class, 'getpesertatable']);

    Route::get('/registrasi/create', [AdminMDController::class, 'registrasiPeserta']);
    Route::post('/store/registrasi', [AdminMDController::class, 'storeRegister'])->name('registrasi.store');

    Route::get('/submission/klhr', [AdminMDController::class, 'showSubmission'])->name('submission.klhr');
    Route::get('/datasubmission/json', [AdminMDController::class, 'submissionJson']);

    Route::get('/submissionklhr/create', [AdminMDController::class, 'registerSubmission']);
    Route::post('/submission/store', [AdminMDController::class, 'createSubmission'])->name('submission.store');

});


//JURI
Route::middleware(['auth', 'role:Juri'])->group(function () {
    Route::get('/juri/index', [JuriController::class, 'index']);
    Route::get('/peserta/list', [JuriController::class, 'pesertalist']);

});

//PESERTA
Route::middleware(['auth', 'role:Peserta'])->group(function () {
    Route::get('/peserta/index', [PesertaController::class, 'index']);
    Route::get('/participants/quizlist', [PesertaController::class, 'showlistquiz']);
    Route::get('/quizlist/Json', [PesertaController::class, 'listJson']);

    Route::get('/exam/confirmation/{id}', [PesertaCourseController::class, 'showConfirmation']);
    Route::get('/exam/{id}/{questionNumber}', [PesertaCourseController::class, 'showquiz'])->name('exam.start');
    Route::get('/exam/ajax/question/{id}/{questionNumber}', [PesertaCourseController::class, 'getQuestionAjax']);
    Route::get('/exam/ajax/answered-status/{pesertaId}/{courseId}', [PesertaCourseController::class, 'getAnsweredStatus']);
    Route::post('/exam/ajax/answer', [PesertaCourseController::class, 'submitAnswerAjax']);


});

