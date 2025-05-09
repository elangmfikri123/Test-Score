@extends('layout.templatecourse')
@section('title', 'Finished')
@section('content')
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- Main-body start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-header m-t-50"></div>
                        <div class="page-body">
                            <!-- Container dengan justify-content-center untuk pusat horizontal -->
                            <div class="d-flex justify-content-center">
                                <div class="col-md-7">
                                    
                                    <div class="row justify-content-center">
                                        <div class="col-md">
                                            <div class="card borderless-card">
                                                <div class="card-block success-breadcrumb text-center py-4">
                                                    <h5>Selamat Anda Telah Menyelesaikan Ujian !</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Card Detail Peserta -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="ion-checkmark-round"></i> Ujian Selesai</h5>    
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-block">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th>ID Honda</th>
                                                        <td>: {{ $pesertaCourse->peserta->honda_id ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <td>: {{ $pesertaCourse->peserta->nama ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Main Dealer</th>
                                                        <td>: {{ $pesertaCourse->peserta->maindealer->nama_md ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Kategori</th>
                                                        <td>: {{ $pesertaCourse->course->category->namacategory ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Exam</th>
                                                        <td>: {{ $pesertaCourse->course->namacourse ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Start Exam</th>
                                                        <td>: {{ $pesertaCourse->start_exam }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>End Exam</th>
                                                        <td>: {{ $pesertaCourse->end_exam }}</td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr class="m-0">
                                        <!-- Card Footer untuk Mulai Ujian -->
                                        <div class="card-footer text-center">
                                            <a href="{{ route('participants.quizlist') }}" class="btn btn-warning mt-3">Kembali</a>
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