@extends('layout.template')
@section('title', 'User List')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">

                    <div class="page-body">
                        <div class="row">

                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-styling">
                                                <thead>
                                                    <tr class="table-primary">
                                                        <th class="text-center" style="width: 50px;">#</th>
                                                        <th class="text-center" style="width: 50px;">Parameter</th>
                                                        <th class="text-center">Weight (%)</th>
                                                        <th class="text-center">Score</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        <tr>
                                                            <th class="text-center" style="width: 50px;">1</th>
                                                            <td style="white-space: normal; width: 570px;">
                                                                <strong>Pemilihan Kata & Kalimat</strong>
                                                                <br>Selama berbicara peserta menggunakan bahasa dan pemilihan kata yang tepat dan mudah dimengerti.
                                                            </td>
                                                            <td class="text-center" style="width: 50px;">3.00%</td>
                                                            <td class="text-center">                                    
                                                                <select class="form-control form-select-sm">
                                                                    @for ($i = 1; $i <= 6; $i++)
                                                                        <option>{{ $i }}</option>
                                                                    @endfor
                                                            </select></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center" style="width: 50px;">2</th>
                                                            <td style="white-space: normal; width: 570px;">
                                                                <strong>Gestur</strong>
                                                                <br>Selama berbicara peserta menggunakan bahasa dan pemilihan kata yang tepat dan mudah dimengerti.
                                                            </td>
                                                            <td class="text-center" style="width: 50px;">3.00%</td>
                                                            <td class="text-center">                                    
                                                                <select class="form-control form-select-sm">
                                                                    @for ($i = 1; $i <= 6; $i++)
                                                                        <option>{{ $i }}</option>
                                                                    @endfor
                                                            </select></td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                {{-- Card Informasi --}}
                                <div class="card mb-2">
                                    <div class="card-body text-center">
                                        <img src="{{ asset('files/assets/images/Logo-100.png') }}" 
                                             alt="Theme-Logo" 
                                             style="max-height: 100px; width: auto;">
                                    </div>
                                </div>

                                {{-- Card Informasi --}}
                                <div class="card mb-2">
                                    <div class="card-header">
                                        <h5>Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Participant</strong><br> A ERWIN AGUSTIAWAN</p>
                                        <p><strong>Main Dealer</strong><br> BANK CENTRAL ASIA</p>
                                        <p><strong>Kategori</strong><br>Agent Inbound Large</p>
                                    </div>
                                </div>
                            
                                {{-- Card Final Score --}}
                                <div class="card mb-2">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="bi bi-trophy-fill" style="font-size: 2rem; color: #0d6efd;"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">46.29%</h5>
                                            <small>Total Score</small>
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
