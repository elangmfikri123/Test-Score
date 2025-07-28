@extends('layout.templatecourse')
@section('title', 'Online-Confirmation')
@section('content')
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-header m-t-50"></div>
                        <div class="page-body">

                            {{-- Banner Atas --}}

                            <div class="card borderless-card shadow-sm mb-2">
                                <div class="card-block bg-primary text-white rounded px-3 py-3 text-center">
                                    <div class="d-flex justify-content-center align-items-center mb-1">
                                        <i class="feather icon-edit mr-2" style="font-size: 20px;"></i>
                                        <h6 class="mb-1">Selamat Mengerjakan Ujian</h6>
                                    </div>
                                    <small>Pastikan Anda membaca deskripsi ujian sebelum memulai.</small>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                {{-- Kolom Deskripsi --}}
                                <div class="col-md-4">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light d-flex align-items-center">
                                            <i class="feather icon-info mr-2 text-primary"></i>
                                            <strong>Deskripsi Quiz</strong>
                                        </div>
                                        <div class="card-body">
                                            {!! $pesertaCourse->course->description ?? '-' !!}
                                        </div>
                                    </div>
                                </div>

                                {{-- Kolom Detail Peserta --}}
                                <div class="col-md-8">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light d-flex align-items-center">
                                            <i class="feather icon-user-check mr-2 text-primary"></i>
                                            <strong>Detail Peserta</strong>
                                        </div>
                                        <div class="card-body pt-3">

                                            @php
                                                $detailList = [
                                                    'ID Honda' => $pesertaCourse->peserta->honda_id ?? '-',
                                                    'Nama' => $pesertaCourse->peserta->nama ?? '-',
                                                    'Main Dealer' =>
                                                        $pesertaCourse->peserta->maindealer->nama_md ?? '-',
                                                    'Kategori' => $pesertaCourse->course->category->namacategory ?? '-',
                                                    'Exam' => $pesertaCourse->course->namacourse ?? '-',
                                                    'Durasi' =>
                                                        ($pesertaCourse->course->duration_minutes ?? '-') . ' Menit',
                                                ];
                                            @endphp

                                            @foreach ($detailList as $label => $value)
                                                <div class="row mb-2">
                                                    <div class="col-sm-5 text-muted">{{ $label }}</div>
                                                    <div class="col-sm-7 font-weight-bold">{{ $value }}</div>
                                                </div>
                                            @endforeach

                                        </div>
                                        <div class="card-footer text-center">
                                            <button class="btn btn-primary mt-2" id="btnMulaiUjian">
                                                <i class="feather icon-play-circle"></i> Mulai Mengerjakan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('btnMulaiUjian').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin Untuk Memulai Ujian?',
                text: "Waktu akan mulai dihitung setelah kamu klik 'Ya'",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Mulai',
                cancelButtonText: 'Batal'
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
                                window.location.href =
                                    "{{ route('exam.start', ['id' => $pesertaCourse->id]) }}";
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
