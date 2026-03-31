@extends('layout.template')
@section('title', 'Deadline Registrasi')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Pengaturan Deadline Registrasi</h5>
                                    </div>
                                    <div class="card-block">
                                        @php
                                            $now = now();
                                            $pesertaDeadlineDate = \Carbon\Carbon::parse($pesertaDeadline);
                                            $klhrDeadlineDate = \Carbon\Carbon::parse($klhrDeadline);
                                        @endphp

                                        <div class="row m-b-20">
                                            <div class="col-md-6 m-b-10">
                                                <div class="status-box">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="m-b-0">Status Pendaftaran Peserta</h6>
                                                        <span class="badge {{ $now->lessThanOrEqualTo($pesertaDeadlineDate) ? 'badge-success' : 'badge-danger' }}">
                                                            {{ $now->lessThanOrEqualTo($pesertaDeadlineDate) ? 'AKTIF' : 'DITUTUP' }}
                                                        </span>
                                                    </div>
                                                    <small class="text-danger d-block m-t-5">
                                                        Deadline: {{ $pesertaDeadlineDate->format('d M Y H:i') }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-md-6 m-b-10">
                                                <div class="status-box">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="m-b-0">Status Pendaftaran KLHR</h6>
                                                        <span class="badge {{ $now->lessThanOrEqualTo($klhrDeadlineDate) ? 'badge-success' : 'badge-danger' }}">
                                                            {{ $now->lessThanOrEqualTo($klhrDeadlineDate) ? 'AKTIF' : 'DITUTUP' }}
                                                        </span>
                                                    </div>
                                                    <small class="text-danger d-block m-t-5">
                                                        Deadline: {{ $klhrDeadlineDate->format('d M Y H:i') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <form action="{{ route('admin.deadline-settings.update') }}" method="POST">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Deadline Registrasi Peserta</label>
                                                <div class="col-sm-9">
                                                    <input type="datetime-local" class="form-control @error('peserta_registration_deadline') is-invalid @enderror"
                                                        name="peserta_registration_deadline"
                                                        value="{{ old('peserta_registration_deadline', \Carbon\Carbon::parse($pesertaDeadline)->format('Y-m-d\TH:i')) }}">
                                                    @error('peserta_registration_deadline')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Deadline Registrasi KLHR</label>
                                                <div class="col-sm-9">
                                                    <input type="datetime-local" class="form-control @error('klhr_registration_deadline') is-invalid @enderror"
                                                        name="klhr_registration_deadline"
                                                        value="{{ old('klhr_registration_deadline', \Carbon\Carbon::parse($klhrDeadline)->format('Y-m-d\TH:i')) }}">
                                                    @error('klhr_registration_deadline')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .status-box {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 14px 16px;
            background: #f8fafc;
        }
    </style>
    @if (session('success'))
        <script>
            window.addEventListener('load', function () {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Disimpan',
                        html: `
                            <div style="font-size:14px;">
                                <div>{{ session('success') }}</div>
                                <div style="margin-top:6px;color:#6c757d;">
                                    Update terakhir: <strong>{{ session('updated_at') }}</strong>
                                </div>
                            </div>
                        `,
                        confirmButtonText: 'OK',
                        allowOutsideClick: true
                    });
                } else {
                    alert("{{ session('success') }} (Update terakhir: {{ session('updated_at') }})");
                }
            });
        </script>
    @endif
@endsection
