@extends('layout.templatecourse')
@section('title', 'Finished')
@section('content')
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-header m-t-50"></div>
                        <div class="page-body">
                            <div class="d-flex justify-content-center">
                                <div class="col-md-7">

                                    {{-- Banner Selesai --}}
                                    <div class="card borderless-card shadow-sm mb-2">
                                        <div class="card-block bg-primary text-white rounded px-3 py-3 text-center">
                                            <div class="d-flex justify-content-center align-items-center mb-1">
                                                <i class="feather icon-check-circle mr-2" style="font-size: 20px;"></i>
                                                <h6 class="mb-0">Ujian Telah Selesai</h6>
                                            </div>
                                            <small>Selamat! Anda telah menyelesaikan ujian ini dengan baik.</small>
                                        </div>
                                    </div>

                                    {{-- Detail Hasil Ujian --}}
                                    <div class="card shadow-sm mt-0">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">
                                                <i class="feather icon-clipboard text-primary"></i> Ringkasan Ujian
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-sm-5 text-muted">ID Honda</div>
                                                <div class="col-sm-7 font-weight-bold">
                                                    {{ $pesertaCourse->peserta->honda_id ?? '-' }}</div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-5 text-muted">Nama</div>
                                                <div class="col-sm-7 font-weight-bold">
                                                    {{ $pesertaCourse->peserta->nama ?? '-' }}</div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-5 text-muted">Main Dealer</div>
                                                <div class="col-sm-7 font-weight-bold">
                                                    {{ $pesertaCourse->peserta->maindealer->nama_md ?? '-' }}</div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-5 text-muted">Kategori</div>
                                                <div class="col-sm-7 font-weight-bold">
                                                    {{ $pesertaCourse->course->category->namacategory ?? '-' }}</div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-5 text-muted">Exam</div>
                                                <div class="col-sm-7 font-weight-bold">
                                                    {{ $pesertaCourse->course->namacourse ?? '-' }}</div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-5 text-muted">Waktu Mulai</div>
                                                <div class="col-sm-7 font-weight-bold">{{ $pesertaCourse->start_exam }}
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-5 text-muted">Waktu Selesai</div>
                                                <div class="col-sm-7 font-weight-bold">{{ $pesertaCourse->end_exam }}</div>
                                            </div>
                                        </div>

                                        <div class="card-footer text-center">
                                            <a href="{{ route('participants.quizlist') }}"
                                                class="btn btn-warning btn-sm mt-2">
                                                <i class="feather icon-arrow-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div> <!-- d-flex -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    // Cegah tombol back
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
</script>