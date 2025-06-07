@extends('layout.template')
@section('title', 'Results Course')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">

                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- Result Header Card -->
                                <div class="card shadow-sm">
                                    <div class="card-header bg-primary text-white d-flex justify-content-center align-items-center gap-3 py-3">
                                        <h4 class="mb-0 fw-bold">{{ $pesertaCourse->course->namacourse ?? '-' }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <!-- Participant Info -->
                                        <div class="row text-center mb-4 border-bottom pb-3">
                                            <div class="col-md-4 mb-2 mb-md-0">
                                                <div class="text-muted small">Honda ID</div>
                                                <div class="fw-bold fs-6">{{ $pesertaCourse->peserta->honda_id }}</div>
                                            </div>
                                            <div class="col-md-4 mb-2 mb-md-0">
                                                <div class="text-muted small">Nama Peserta</div>
                                                <div class="fw-bold fs-6">{{ $pesertaCourse->peserta->nama }}</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="text-muted small">Main Dealer</div>
                                                <div class="fw-bold fs-6">
                                                    {{ $pesertaCourse->peserta->maindealer->nama_md ?? '-' }}</div>
                                            </div>
                                        </div>

                                        <!-- Test Results -->
                                        <div class="row row-cols-2 row-cols-md-4 g-3 text-center mt-3">
                                            <div class="col">
                                                <div class="border rounded-1 p-3 bg-light h-100">
                                                    <div class="text-muted small">Benar</div>
                                                    <div class="fw-bold fs-5">{{ $jumlahBenar }} Soal</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="border rounded-1 p-3 bg-light h-100">
                                                    <div class="text-muted small">Salah</div>
                                                    <div class="fw-bold fs-5">{{ $jumlahSalah }} Soal</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="border rounded-3 p-3 bg-light h-100">
                                                    <div class="text-muted small">Skip</div>
                                                    <div class="fw-bold fs-5">{{ $jumlahSkip }} Soal</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="border rounded-3 p-3 bg-light h-100">
                                                    <div class="text-muted small">Score</div>
                                                    <div class="fw-bold fs-5">{{ number_format($score, 2) }}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="border rounded-3 p-3 bg-light h-100">
                                                    <div class="text-muted small">Durasi</div>
                                                    <div class="fw-bold fs-6">
                                                        @if($durasi)
                                                            {{ str_pad($durasi->h, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($durasi->i, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($durasi->s, 2, '0', STR_PAD_LEFT) }}
                                                        @else
                                                            -
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="border rounded-3 p-3 bg-light h-100">
                                                    <div class="text-muted small">Waktu Ujian</div>
                                                    <div class="fw-bold fs-6">
                                                        {{ $waktuUjian ? $waktuUjian->format('d/m/Y H:i') : '-' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center mt-3">
                                            <a href="{{ route('course.detailsAnswers', $pesertaCourse->id) }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i> Preview
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    function getColor($status)
                                    {
                                        return match ($status) {
                                            'Benar' => 'green',
                                            'Salah' => 'red',
                                            'Skip' => 'orange',
                                            default => 'black',
                                        };
                                    }
                                    function getIcon($status)
                                    {
                                        return match ($status) {
                                            'Benar' => 'ion-checkmark-round',
                                            'Salah' => 'ion-close-round',
                                            'Skip' => 'ion-help-circled',
                                            default => '',
                                        };
                                    }
                                @endphp

                                <div class="card">
                                    <div class="card-block">
                                        <div style="display: flex; flex-wrap: wrap; margin: 0 -5px;">
                                            @foreach ($resultDetails as $data)
                                                @php
                                                    $status = $data['status'];
                                                    $color = getColor($status);
                                                    $icon = getIcon($status);
                                                @endphp
                                                <div class="border rounded-3 p-3 bg-light"
                                                    style="
                                                        border: 1px solid #d6d6d6;
                                                        width: calc(20% - 10px);
                                                        height: 50px;
                                                        box-sizing: border-box;
                                                        display: flex;
                                                        align-items: center;
                                                        justify-content: space-between;
                                                        padding: 0 10px;
                                                        color: {{ $color }};
                                                        font-weight: bold;
                                                        font-size: 14px;
                                                        margin: 0 5px 10px 5px;
                                                    ">
                                                    <span>{{ $data['nomor'] }}) {{ $status }}</span>
                                                    <i class="{{ $icon }}"></i>
                                                </div>
                                            @endforeach
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
