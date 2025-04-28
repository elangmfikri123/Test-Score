@extends('layout.template')
@section('title', 'User List')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="card borderless-card">
                    <div class="card-block info-breadcrumb">
                        <div class="breadcrumb-header">
                            <h5>Selamat Datang Admin Main Dealer</h5>
                        </div>
                        <div class="page-header-breadcrumb">
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        @foreach($categories as $index => $cat)
                        <div class="col-xl-3 col-md-6">
                            <!-- Menentukan warna berdasarkan index -->
                            <div class="card 
                                @if($index % 4 == 0) bg-c-yellow
                                @elseif($index % 4 == 1) bg-c-green
                                @elseif($index % 4 == 2) bg-c-pink
                                @else bg-c-lite-green
                                @endif
                                update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-7">
                                            <h4 class="text-white">{{ $cat->total }}</h4>
                                            <h6 class="text-white m-b-0">{{ $cat->category->namacategory ?? 'Kategori Tidak Diketahui' }}</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <canvas id="update-chart-{{ $loop->iteration }}" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p class="text-white m-b-0">
                                        <i class="feather icon-clock text-white f-14 m-r-10"></i>Update : {{ $cat->latest_created_at }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                                      
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection