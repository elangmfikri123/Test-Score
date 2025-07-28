@extends('layout.template')
@section('title', 'Index Peserta')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="card borderless-card">
                        <div class="card-block inverse-breadcrumb">
                            <div class="breadcrumb-header">
                                <h5>Selamat Datang Peserta, {{ $peserta->nama }}</h5>
                            </div>
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="#!">
                                            <i class="icofont icofont-home"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Profil Peserta --}}
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">MY PROFILE</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        {{-- Gambar Profil --}}
                                        <div class="col-md-4 text-center mb-3 mb-md-0">
                                            @if ($peserta->filesPeserta && $peserta->filesPeserta->foto_profil)
                                                <img src="{{ asset('storage/' . $peserta->filesPeserta->foto_profil) }}"
                                                    class="img-thumbnail rounded" alt="Foto Profil"
                                                    style="width: 200px; height: 200px; object-fit: cover;">
                                            @else
                                                <img src="https://via.placeholder.com/180x180?text=No+Image"
                                                    class="img-thumbnail rounded" alt="Default Foto">
                                            @endif
                                        </div>

                                        {{-- Informasi Detail --}}
                                        <div class="col-md-8">
                                            <div class="mb-3 d-flex">
                                                <i class="feather icon-user text-primary me-3"
                                                    style="font-size: 20px; width: 30px;"></i>
                                                <div>
                                                    <div class="text-muted small mb-1">Full Name</div>
                                                    <div class="fw-bold">{{ $peserta->nama }}</div>
                                                </div>
                                            </div>

                                            <div class="mb-3 d-flex">
                                                <i class="feather icon-mail text-warning me-3"
                                                    style="font-size: 20px; width: 30px;"></i>
                                                <div>
                                                    <div class="text-muted small mb-1">Email Address</div>
                                                    <div class="fw-bold">{{ $peserta->email }}</div>
                                                </div>
                                            </div>

                                            <div class="mb-3 d-flex">
                                                <i class="feather icon-layers text-success me-3"
                                                    style="font-size: 20px; width: 30px;"></i>
                                                <div>
                                                    <div class="text-muted small mb-1">Kategori</div>
                                                    <div class="fw-bold">{{ $peserta->category->namacategory ?? '-' }}</div>
                                                </div>
                                            </div>

                                            <div class="mb-3 d-flex">
                                                <i class="feather icon-briefcase text-info me-3"
                                                    style="font-size: 20px; width: 30px;"></i>
                                                <div>
                                                    <div class="text-muted small mb-1">Main Dealer</div>
                                                    <div class="fw-bold">{{ $peserta->maindealer->kodemd ?? '-' }} -
                                                        {{ $peserta->maindealer->nama_md ?? '-' }}</div>
                                                </div>
                                            </div>

                                            <div class="mb-0 d-flex">
                                                <i class="feather icon-clock text-muted me-3"
                                                    style="font-size: 20px; width: 30px;"></i>
                                                <div>
                                                    <div class="text-muted small mb-1">Registered At</div>
                                                    <div class="fw-bold">
                                                        {{ \Carbon\Carbon::parse($peserta->created_at)->format('d/m/Y H:i:s') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Riwayat Login --}}
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">MY LOGINS</h5>
                                </div>
                                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                    @forelse($loginSessions as $session)
                                        <div class="mb-3">
                                            <p class="mb-1 text-break">{{ Str::limit($session->user_agent, 60) }}</p>
                                            <small>{{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->format('d/m/Y H:i:s') }}</small>
                                            @if($session->id === session()->getId())
                                                <span class="text-success">- Current Device</span>
                                            @endif
                                            <small class="d-block text-muted">IP: {{ $session->ip_address }}</small>
                                        </div>
                                    @empty
                                        <p class="text-muted">Belum ada riwayat login.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
@endsection
