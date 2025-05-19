@extends('layout.template')
@section('title', 'Peserta List')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            
                            <div class="card mb-3">
                                <div class="card-block">
                                    <form id="filterForm">
                                        <div class="row align-items-end">
                                            <div class="col-md-4">
                                                <label>Kategori</label>
                                                <select name="category_id" id="category_id" class="form-control form-control">
                                                    <option value="">-- Semua --</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Main Dealer</label>
                                                <select name="maindealer_id" id="maindealer_id" class="form-control form-control">
                                                    <option value="">-- Semua --</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 d-flex align-items-end" style="gap: 8px">
                                                <button type="button" id="filterBtn" class="btn btn-secondary btn-sm px-3 mb-1">
                                                    <i class="ion-funnel"></i> Filter
                                                </button>
                                                <button type="button" id="resetBtn" class="btn btn-warning btn-sm px-3 mb-1">
                                                    <i class="ion-refresh"></i> Reset
                                                </button>
                                                <button id="downloadBtn" class="btn btn-primary btn-sm px-3 mb-1">
                                                    <i class="ion-archive"></i> Download
                                                </button>
                                            </div>
                                        </div>                          
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Ajax data source (Arrays) table start -->
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Data Peserta</h5>
                                    @php
                                    use Illuminate\Support\Facades\Auth;
                                    use Carbon\Carbon;
                                
                                    $user = Auth::user();
                                    $now = Carbon::now();
                                    $deadline = Carbon::create(2025, 5, 19, 23, 59, 0);
                                @endphp
                                
                                @if($user->role === 'AdminMD' && $now->lessThanOrEqualTo($deadline))
                                <a href="{{ url('/registrasi/create') }}" class="btn btn-primary btn-sm">
                                    <i class="ion-plus-round"></i> Tambah
                                </a>
                            @elseif($user->role === 'AdminMD')
                                <button class="btn btn-primary btn-sm" onclick="alertDeadline()">
                                    <i class="ion-plus-round"></i> Tambah
                                </button>
                            @elseif($user->role === 'Admin')
                                <a href="{{ url('/registrasi/create') }}" class="btn btn-primary btn-sm">
                                    <i class="ion-plus-round"></i> Tambah
                                </a>
                            @endif                      
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 50px;">No</th>
                                                    <th class="text-center">Honda ID</th>
                                                    <th class="text-center">Nama</th>
                                                    <th class="text-center">Ketegori</th>
                                                    <th class="text-center">Main Dealer</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Created Time</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                        </table>

                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
                                        <script>
                                            let dataTable;
                                        
                                            function loadTable(categoryId = '', maindealerId = '') {
                                                if (dataTable) {
                                                    dataTable.destroy();
                                                }
                                        
                                                dataTable = $('#myTable').DataTable({
                                                    processing: true,
                                                    serverSide: true,
                                                    ajax: {
                                                        url: '{{ url("/get-peserta/data") }}',
                                                        data: {
                                                            category_id: categoryId,
                                                            maindealer_id: maindealerId
                                                        }
                                                    },
                                                    columns: [
                                                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                                                        { data: 'honda_id', name: 'honda_id' },
                                                        { data: 'nama', name: 'nama' },
                                                        { data: 'category', name: 'category' },
                                                        { data: 'maindealer', name: 'maindealer', className: 'text-center' },
                                                        { data: 'status', name: 'status', className: 'text-center' },
                                                        { data: 'createdtime', name: 'createdtime', className: 'text-center' },
                                                        { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' },
                                                    ],
                                                    searching: true,
                                                    lengthChange: true
                                                });
                                            }
                                        
                                            function loadDropdowns() {
                                                $.get('{{ url("/api/category") }}', function(data) {
                                                    let options = '<option value="">-- Semua --</option>';
                                                    data.forEach(item => {
                                                        options += `<option value="${item.id}">${item.namacategory}</option>`;
                                                    });
                                                    $('#category_id').html(options);
                                                });
                                        
                                                $.get('{{ url("/api/maindealer") }}', function(data) {
                                                    let options = '<option value="">-- Semua --</option>';
                                                    data.forEach(item => {
                                                        options += `<option value="${item.id}">${item.kodemd}-${item.nama_md}</option>`;
                                                    });
                                                    $('#maindealer_id').html(options);
                                                });
                                            }
                                        
                                            $(document).ready(function() {
                                                loadDropdowns();
                                                loadTable();
                                        
                                                $('#filterBtn').on('click', function () {
                                                    const catId = $('#category_id').val();
                                                    const mdId = $('#maindealer_id').val();
                                                    loadTable(catId, mdId);
                                                });
                                        
                                                $('#resetBtn').on('click', function () {
                                                    $('#category_id, #maindealer_id').val('');
                                                    loadTable();
                                                });
                                        
                                                $('#downloadBtn').on('click', function (e) {
                                                    e.preventDefault();
                                                    const catId = $('#category_id').val();
                                                    const mdId = $('#maindealer_id').val();
                                                    let url = '{{ url("/get-peserta/download") }}' + `?category_id=${catId}&maindealer_id=${mdId}`;
                                                    window.location.href = url;
                                                });
                                            });
                                        </script>                                        
                                    </div>
                                </div>
                            </div>  
                            <!-- Deferred rendering for speed table end -->
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success') && session('honda_id'))
<script>
    const hondaId = '{{ session('honda_id') }}';
    const actionType = '{{ session('action_type') }}';

    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        html: actionType === 'create' 
            ? `Data dengan Honda ID <strong>${hondaId}</strong> berhasil <strong>disimpan</strong>.` 
            : `Data dengan Honda ID <strong>${hondaId}</strong> berhasil <strong>diperbarui</strong>.`,
        confirmButtonText: 'OK'
    });
</script>
@endif
<script>
    function alertDeadline() {
        Swal.fire({
            icon: 'warning',
            title: 'Pendaftaran Ditutup',
            text: 'Maaf, pendaftaran sudah ditutup pada 19 Mei 2025 pukul 23:59.',
            confirmButtonText: 'OK'
        });
    }
    function alertEditDeadline() {
        Swal.fire({
            icon: 'warning',
            title: 'Edit Ditutup',
            text: 'Maaf, fitur edit sudah ditutup pada 19 Mei 2025 pukul 23:59.',
            confirmButtonText: 'OK'
        });
    }
</script>
@endsection