@extends('layout.templatecourse')
@section('title', 'Online-Confirmation')
@section('content')
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- Main-body start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-header m-t-50"></div>
                        <div class="page-body">
                            <div class="card borderless-card">
                                <div class="card-block success-breadcrumb">
                                    <div class="breadcrumb-header">
                                        <h5>Selamat Datang Elang Muhammad Fikhri !</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Bagian Kiri: Pertanyaan & Jawaban -->
                                <div class="col-md-4">
                                    <div class="card">
                                        <!-- Header dengan garis bawah -->
                                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                            <h5><i class="ion-navicon-round"></i> Deskripsi Quiz</h5>
                                        </div>                                                                                
                                        <hr class="m-0">
                                        <div class="card-block">
                                            <p>Apa ibu kota Indonesia?</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Bagian Kanan: Detail Peserta -->
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="ion-checkmark-round"></i> Detail Peserta</h5>    
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-block">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th>ID Honda </th>
                                                        <td>: 812888121212</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <td>: Elang Muhammad Fikhri</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Main Dealer</th>
                                                        <td>: AHM-Astra Honda Motor</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Category</th>
                                                        <td>: Frontline People</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Exam</th>
                                                        <td>: Frontline People-KLHN 2025</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Durasi</th>
                                                        <td>: 90 menit</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr class="m-0">
                                        <!-- Card Footer untuk Mulai Ujian -->
                                        <div class="card-footer text-center">
                                            <button class="btn btn-primary mt-3">Mulai Mengerjakan</button>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
