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
                                    </div>
                                </div>

                                <!-- Questions Table -->
                                <table class="table" id="questionTable">
                                    <tbody>
                                        @foreach ($questions as $index => $q)
                                            <tr>
                                                <td>
                                                    <div class="card shadow-sm mb-1 border">
                                                        <div
                                                            class="card-header bg-light d-flex justify-content-between align-items-center">
                                                            <strong>Soal No {{ $index + 1 }}</strong>
                                                            @if ($q['is_skipped'])
                                                                <span class="text-warning"><i class="ion-help-circled"></i>
                                                                    Terlewati</span>
                                                            @endif
                                                        </div>
                                                        <div class="card-body">
                                                            <p class="mb-3">{!! $q['question'] !!}</p>
                                                            <!-- tampilkan pertanyaan sebagai HTML -->
                                                            <table class="table table-bordered mb-0">
                                                                <tbody>
                                                                    @foreach ($q['options'] as $optionKey => $optionText)
                                                                        @php
                                                                            $isCorrect =
                                                                                $optionKey === $q['correct_answer'];
                                                                            $isUserAnswer =
                                                                                $optionKey === $q['user_answer'];
                                                                            $rowClass = '';

                                                                            if ($isCorrect) {
                                                                                $rowClass = 'table-success';
                                                                            }
                                                                            if ($isUserAnswer && !$isCorrect) {
                                                                                $rowClass = 'table-danger';
                                                                            }
                                                                        @endphp
                                                                        <tr class="{{ $rowClass }}">
                                                                            <td style="width: 5%">
                                                                                <strong>{{ $optionKey }}.</strong></td>
                                                                            <td
                                                                                class="d-flex justify-content-between align-items-center">
                                                                                <span>{!! $optionText !!}</span>
                                                                                @if ($isUserAnswer && !$isCorrect)
                                                                                    <span class="text-danger fw-bold"><i
                                                                                            class="ion-close-round"></i>
                                                                                        Salah</span>
                                                                                @elseif ($isCorrect && $isUserAnswer)
                                                                                    <span class="text-success fw-bold"><i
                                                                                            class="ion-checkmark-round"></i>
                                                                                        Benar</span>
                                                                                @elseif ($isCorrect)
                                                                                    <span class="text-success"><i
                                                                                            class="ion-alert-circled"></i>
                                                                                        Koreksi</span>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
