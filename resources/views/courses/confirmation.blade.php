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
                            <div class="row justify-content-center">
                                <div class="col-md">
                                    <div class="card borderless-card">
                                        <div class="card-block success-breadcrumb text-center py-4">
                                            <h5>Selamat Mengerjakan Ujian !</h5>
                                        </div>
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
                                            {!! $pesertaCourse->course->description ?? '-' !!}
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
                                                        <th>Durasi</th>
                                                        <td>: {{ $pesertaCourse->course->duration_minutes ?? '-' }} Menit</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr class="m-0">
                                        <!-- Card Footer untuk Mulai Ujian -->
                                        <div class="card-footer text-center">
                                            <button class="btn btn-primary mt-3" id="btnMulaiUjian">Mulai Mengerjakan</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('btnMulaiUjian').addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin Untuk Memulai Ujian?',
                text: "Waktu akan mulai dihitung setelah kamu klik 'Ya'",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Mulai',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/exam/start/{{ $pesertaCourse->id }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                window.location.href = "{{ route('exam.start', ['id' => $pesertaCourse->id]) }}";
                            }
                        }
                    });
                }
            });
        });
    </script> 
@endsection
