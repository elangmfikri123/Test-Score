@extends('layout.templatecourse')
@section('title', 'Online-Quiz')
@section('content')
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- Main-body start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-header m-t-50"></div>
                        <div class="page-body">
                            <div class="row">
                                <!-- Bagian Kiri: Pertanyaan & Jawaban -->
                                <div class="col-md-9">
                                    <div class="card">
                                        <!-- Header dengan garis bawah -->
                                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                            <h5>Soal Nomor. 1</h5>
                                            <label id="timer" class="label label-inverse-warning fw-bold px-4 py-2 text-dark" style="font-size: 1rem;">00:10:00</label>
                                        </div>                                                                               
                                        <hr class="m-0">
                                        <div class="card-block">
                                            <p>Apa ibu kota Indonesia ?</p>
                                            <form>
                                                @php
                                                    $options = [
                                                        'A' => 'Jakarta',
                                                        'B' => 'Surabaya',
                                                        'C' => 'Bandung',
                                                        'D' => 'Medan',
                                                        'E' => 'Solo',
                                                    ];
                                                @endphp
                                
                                                @foreach ($options as $key => $value)
                                                    <div class="form-check d-flex align-items-center mb-2">
                                                        <button type="button" class="btn btn-outline-primary me-2"
                                                            style="width: 40px; height: 40px; font-size: 16px; padding: 0;">
                                                            {{ $key }}
                                                        </button>
                                                        <input class="form-check-input d-none" type="radio" name="answer"
                                                            id="option{{ $key }}" value="{{ $key }}">
                                                        <label class="form-check-label" for="option{{ $key }}"
                                                            style="cursor: pointer;">
                                                            {{ $value }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </form>
                                        </div>
                                        <hr class="m-0">
                                        <!-- Footer dengan tombol navigasi -->
                                        <div class="card-footer d-flex justify-content-between">
                                            <button class="btn btn-secondary"><i class="ion-chevron-left"></i>Sebelumnya</button>
                                            <button class="btn btn-primary">Selanjutnya <i class="ion-chevron-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                                

                                <!-- Bagian Kanan: Nomor Soal -->
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Jumlah Soal</h5>
                                            <div class="d-flex justify-content-between">
                                                <p><strong>Total Soal:</strong> 100</p>
                                                <p><strong>Sudah Dijawab:</strong> 3</p>
                                            </div>
                                            
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-block">
                                            <!-- Container untuk daftar soal dengan scroll -->
                                            <div class="container" style="max-height: 300px; overflow-y: auto;">
                                                <div class="row row-cols-5 gx-1 gy-1">
                                                    @for ($i = 1; $i <= 100; $i++)
                                                        <div class="col p-0 m-1">
                                                            <button 
                                                                class="btn {{ $i <= 3 ? 'btn-success' : 'btn-light' }} d-flex align-items-center justify-content-center"
                                                                style="width: 40px; height: 40px; font-size: 14px; padding: 0; margin: 2px;">
                                                                {{ $i }}
                                                            </button>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="m-0">
                                        <!-- Card Footer untuk Akhiri Ujian -->
                                        <div class="card-footer text-center">
                                            <button class="btn btn-primary mt-3">Akhiri Ujian <i class="ion-archive"></i></button>
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
