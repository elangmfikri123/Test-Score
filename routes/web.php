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
use App\Http\Controllers\ExportController;
use App\Http\Controllers\AdminMDController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainDealerController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\FormPenilaianController;
use App\Http\Controllers\PesertaCourseController;
use App\Http\Controllers\EnrolledJuriPesertaController;
use App\Models\FormPenilaian;

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

//ADMINISTRATOR
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard']);
    Route::get('/listuser', [AdminController::class, 'userlist'])->name('admin.userlist');
    Route::get('/user/{id}', [AdminController::class, 'show']);
    Route::put('/user/{id}', [AdminController::class, 'update'])->name('user.update');
    Route::get('/get-user/data', [AdminController::class, 'getusertable']);
    Route::post('/force-logout/{id}', [AuthController::class, 'forceLogout']);
    Route::post('/user/store', [AdminController::class, 'store'])->name('user.store');

    Route::post('/peserta/{id}/update-status', [AdminController::class, 'updateStatus'])->name('peserta.updateStatus');
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

    //ADD QUESTION
    Route::get('/admin/exams/{id}/questions', [CourseController::class, 'showquestionslist']);
    Route::get('/dataquestion-answer/json/{id}', [CourseController::class, 'dataquestionAnswerJson']);
    Route::get('/admin/exams/{id}/question-create', [CourseController::class, 'createquestion']);
    Route::post('/admin/exams/{id}/question-store', [CourseController::class, 'storequestion']);
    Route::post('/upload-image', [CourseController::class, 'uploadImage'])->name('image.upload');


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

    //ScoreCard

    Route::get('/admin/scorecardlist', [FormPenilaianController::class, 'show']);
    Route::get('/scorecardlist/json', [FormPenilaianController::class, 'listScoreCardJson']);
    Route::get('/admin/scorecard/create', [FormPenilaianController::class, 'createdScoring'])->name('scorecard.store');
    Route::post('/scorecard/store', [FormPenilaianController::class, 'store']);
    Route::get('/admin/scorecard/{id}/edit', [EnrolledJuriPesertaController::class, 'edit'])->name('scorecard.edit');

    // Enrolled Juri
    Route::get('/admin/scorecard/{id}/jurilist', [EnrolledJuriPesertaController::class, 'listJuriScoring'])->name('scorecard.jurilist');
    Route::get('/jurienrolled/json/{id}', [EnrolledJuriPesertaController::class, 'getEnrolledJuriTable']);

    Route::get('/admin/enrolle/{id}/juridata', [EnrolledJuriPesertaController::class, 'addJuri'])->name('juri.add');
    Route::get('/jurienrolle/data/json/{id}', [EnrolledJuriPesertaController::class, 'getNonEnrolledJuriJson'])->name('juri.json');
    Route::post('/jurienrolle/store/{id}', [EnrolledJuriPesertaController::class, 'storeJuri'])->name('juri.store');

    
    // Enrolled Peserta
    Route::get('/admin/scorecard/{form_id}/{juri_id}/addpeserta', [EnrolledJuriPesertaController::class, 'addPesertaToJuri']);
    Route::get('/json/pesertalist/{form_id}/{juri_id}', [EnrolledJuriPesertaController::class, 'getNonEnrolledPeserta'])->name('peserta.json');
    Route::post('/admin/store/{form_id}/{juri_id}/peserta', [EnrolledJuriPesertaController::class, 'storePesertaToJuri'])->name('peserta.store');
    Route::delete('/admin/delete/{juri_id}/{form_id}', [EnrolledJuriPesertaController::class, 'deleteJuri'])->name('listjuri.delete');

    Route::get('/juripeserta/detail/{form_id}/{juri_id}', [EnrolledJuriPesertaController::class, 'getDetailPeserta'])->name('juripeserta.detail');

});

// ADMIN MAIN DEALERS
Route::get('/admin-maindealers/index', [AdminMDController::class, 'index'])->middleware(['auth', 'role:AdminMD']);
Route::get('/admin-maindealers/lampiran', [AdminMDController::class, 'lampiranFile'])->middleware(['auth', 'role:AdminMD']);

Route::middleware(['auth', 'role:Admin,AdminMD'])->group(function () {
    Route::get('/listpeserta', [AdminController::class, 'pesertalist'])->name('list.peserta');
    Route::get('/get-peserta/data', [AdminController::class, 'getpesertatable']);
    Route::get('/api/category', [AdminController::class, 'apiCategory']);
    Route::get('/api/maindealer', [AdminController::class, 'apiMaindealer']);
    Route::get('/get-peserta/download', [ExportController::class, 'downloadPeserta'])->name('peserta.download');

    Route::get('/registrasi/create', [AdminMDController::class, 'registrasiPeserta']);
    Route::post('/store/registrasi', [AdminMDController::class, 'storeRegister'])->name('registrasi.store');
    Route::post('/check-hondaid-email', [AdminMDController::class, 'checkHondaIdEmail'])->name('check.hondaid.email');
    Route::get('/datapeserta/detail/{id}', [AdminMDController::class, 'detailPeserta']);
    Route::get('/registrasidata/edit/{id}', [AdminMDController::class, 'editPeserta']);
    Route::put('/updatepeserta/data/{id}', [AdminMDController::class, 'updatePeserta']);

    Route::get('/submission/klhr', [AdminMDController::class, 'showSubmission'])->name('submission.klhr');
    Route::get('/datasubmission/json', [AdminMDController::class, 'submissionJson']);
    Route::get('/submissionklhr/create', [AdminMDController::class, 'registerSubmission']);
    Route::post('/submission/store', [AdminMDController::class, 'createSubmission'])->name('submission.store');
    Route::get('/submissionklhr/detail/{id}', [AdminMDController::class, 'submissionDetail']);
    Route::get('/submissionklhr/edit/{id}', [AdminMDController::class, 'submissionEdit'])->name('submission.edit');
    Route::put('/submissionklhr/update/{id}', [AdminMDController::class, 'submissionUpdate'])->name('submission.update');

});


//JURI
Route::middleware(['auth', 'role:Juri'])->group(function () {
    Route::get('/juri/index', [JuriController::class, 'index']);
    Route::get('/peserta/list', [JuriController::class, 'pesertalist']);
    Route::get('/peserta/list/data', [JuriController::class, 'getPesertaListData'])->name('juri.peserta.data');

    Route::get('/scorecard/scoring/{id}', [JuriController::class, 'showScoring']);
    Route::get('/api/formpenilaian/{id}/parameters', [JuriController::class, 'getParameters']);

    Route::post('/scorecard/submit', [JuriController::class, 'submitScoring'])->name('scorecard.submit');

});

//PESERTA
Route::middleware(['auth', 'role:Peserta'])->group(function () {
    Route::get('/peserta/index', [PesertaController::class, 'index']);
    Route::get('/participants/quizlist', [PesertaController::class, 'showlistquiz'])->name('participants.quizlist');
    Route::get('/quizlist/Json', [PesertaController::class, 'listJson']);

    Route::get('/exam/confirmation/{id}', [PesertaCourseController::class, 'showConfirmation']);
    Route::post('/exam/start/{id}', [PesertaCourseController::class, 'startExam'])->name('exam.ajaxstart');
    Route::get('/exam/{id}', [PesertaCourseController::class, 'showQuiz'])->name('exam.start');
    Route::get('/exam/{id}/{numberQuestion}', [PesertaCourseController::class, 'loadQuestion']);
    Route::get('/exam/{pesertaCourseId}/answered', [PesertaCourseController::class, 'getAnsweredQuestions']);
    Route::post('/exam/answer', [PesertaCourseController::class, 'storeAnswer']);
    Route::post('/exam/finish/{id}', [PesertaCourseController::class, 'finishExam'])->name('exam.finish');
    Route::get('/finished/exam/{id}', [PesertaCourseController::class, 'finished'])->name('exam.finished');

});

