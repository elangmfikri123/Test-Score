@extends('layout.template')
@section('title', 'User List')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">

                    <div class="page-body" style="margin-top: -20px;">

                        <div class="card mb-3">
                            <div class="card-block">
                                <form id="filterForm">
                                    <div class="row align-items-end justify-content-between">   
                                        <!-- Tombol kiri -->
                                        <div class="col-md-9">

                                        </div>
                                        <div class="col-md-3 text-end">
                                            <button type="button" id="draftBtn" class="btn btn-warning btn-sm px-3 mb-1">
                                                <i class="icofont icofont-copy-black"></i> Draft
                                            </button>
                                            <button id="submitBtn" class="btn btn-success btn-sm px-3 mb-1">
                                                <i class="ion-checkmark"></i> Submit
                                            </button>
                                        </div>
                                    </div>                          
                                </form>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-3">
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
                                                            <td class="text-center" style="width: 85px;">                                    
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
                                <div class="card mb-6">
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-styling">
                                                <thead>
                                                    <tr class="table-primary">
                                                        <th class="text-center" style="width: 50px;">Catatan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        <tr>
                                                            <td class="text-center" style="width: 50px;">
                                                                <textarea rows="6" cols="6" class="form-control" placeholder=""
                                                                         style="resize: none; min-height: auto; max-height: auto; overflow: auto;"></textarea>
                                                            </td>
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
                                    <div class="card-body p-3">
                                        <h6 class="mb-3">Information</h6>
                                        <div>
                                            <p class="mb-2"><strong>Participant</strong><br>Elang Muhammad Fikhri</p>
                                            <p class="mb-2"><strong>Main Dealer</strong><br>INDAKO TRADING COY</p>
                                            <p class="mb-0"><strong>Kategori</strong><br>Team Leader</p>
                                        </div>
                                    </div>
                                </div>
                            
                                {{-- Card Final Score --}}
                                <div class="card mb-2">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px; background-color: #cdcdcd; border-radius: 5px; margin-right: 1rem;">
                                            <i class="icofont icofont-award" style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">46.29%</h5>
                                            <span>Total Score</span>
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
