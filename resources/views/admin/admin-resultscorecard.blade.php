@extends('layout.template')
@section('title', 'Result Course')
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
                                            <div class="col-md-3">
                                                <label>Nama Scorecard</label>
                                                <select name="namaform" id="namaform_id" class="form-control form-control" required>
                                                </select>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-end" style="gap: 5px">
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
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 50px;">No</th>
                                                    <th class="text-center">Nama Scorecard</th>
                                                    <th class="text-center">Nama Juri</th>
                                                    <th class="text-center">Honda ID</th>
                                                    <th class="text-center">Nama Peserta</th>
                                                    <th class="text-center">Kategori Peserta</th>
                                                    <th class="text-center">Main Dealer</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                        </table>

                                        <script type="text/javascript" src="{{ asset('files\bower_components\jquery\js\jquery.min.js') }}"></script>
                                        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
                                        <script>
                                            let dataTable;
                                            function loadTable(namaformId = '') {
                                                if (dataTable) {
                                                    dataTable.destroy();
                                                }
                                                dataTable = $('#myTable').DataTable({
                                                    processing: true,
                                                    serverSide: true,
                                                    ajax: {
                                                        url: '{{ url("/admin/resultscorecard/data") }}',
                                                        data: {
                                                            namaform_id: namaformId,
                                                        }
                                                    },
                                                    columns: [
                                                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                                                        { data: 'namaform', name: 'namaform' },
                                                        { data: 'namajuri', name: 'namajuri' },
                                                        { data: 'honda_id', name: 'honda_id' },
                                                        { data: 'nama', name: 'nama' },
                                                        { data: 'category', name: 'category' },
                                                        { data: 'maindealer', name: 'maindealer', className: 'text-center' },
                                                        { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' },
                                                    ],
                                                    searching: true,
                                                    lengthChange: true
                                                });
                                            }
                                        
                                            function loadDropdowns() {
                                                $.get('{{ url("/api/scorecard") }}', function(data) {
                                                    let options = '<option value="">-- Pilih Scorecard --</option>';
                                                    data.forEach(item => {
                                                        options += `<option value="${item.id}">${item.namaform}</option>`;
                                                    });
                                                    $('#namaform_id').html(options);
                                                });
                                            }
                                        
                                            $(document).ready(function() {
                                                loadDropdowns();
                                                loadTable();
                                        
                                                $('#filterBtn').on('click', function () {
                                                    const formID = $('#namaform_id').val();
                                                    loadTable(formID);
                                                });
                                        
                                                $('#resetBtn').on('click', function () {
                                                    $('#namaform_id').val('');
                                                    loadTable();
                                                });
                                        
                                                $('#downloadBtn').on('click', function (e) {
                                                    e.preventDefault();
                                                    const formID = $('#namaform_id').val();
                                                    
                                                    if (!formID) {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Oops...',
                                                            text: 'Silakan pilih quiz terlebih dahulu!',
                                                            confirmButtonColor: '#3085d6',
                                                        });
                                                        return false;
                                                    }
                                                    
                                                    let url = '{{ url("/results/exams/downloadAnswers") }}' + `?namaform_id=${formID}`;
                                                    window.location.href = url;
                                                });
                                            });
                                        </script>                                        
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
</div>
@endsection