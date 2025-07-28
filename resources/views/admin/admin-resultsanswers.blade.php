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
                                                <label>Nama Quiz *)</label>
                                                <select name="course_id" id="course_id" class="form-control form-control" required>
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
                                                    <th class="text-center">Nama Quiz</th>
                                                    <th class="text-center">Honda ID</th>
                                                    <th class="text-center">Nama</th>
                                                    <th class="text-center">Kategori</th>
                                                    <th class="text-center">Main Dealer</th>
                                                    <th class="text-center">Score</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                        </table>

                                        <script type="text/javascript" src="{{ asset('files\bower_components\jquery\js\jquery.min.js') }}"></script>
                                        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
                                        <script>
                                            let dataTable;
                                            function loadTable(courseId = '') {
                                                if (dataTable) {
                                                    dataTable.destroy();
                                                }
                                                dataTable = $('#myTable').DataTable({
                                                    processing: true,
                                                    serverSide: true,
                                                    ajax: {
                                                        url: '{{ url("/dataresults/json") }}',
                                                        data: {
                                                            course_id: courseId,
                                                        }
                                                    },
                                                    columns: [
                                                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                                                        { data: 'namacourse', name: 'namacourse' },
                                                        { data: 'honda_id', name: 'honda_id' },
                                                        { data: 'nama', name: 'nama' },
                                                        { data: 'category', name: 'category' },
                                                        { data: 'maindealer', name: 'maindealer', className: 'text-center' },
                                                        { data: 'score', name: 'score', className: 'text-center' },
                                                        { data: 'status', name: 'status', className: 'text-center' },
                                                        { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' },
                                                    ],
                                                    searching: true,
                                                    lengthChange: true
                                                });
                                            }
                                        
                                            function loadDropdowns() {
                                                $.get('{{ url("/api/course") }}', function(data) {
                                                    let options = '<option value="">-- Pilih Quiz --</option>';
                                                    data.forEach(item => {
                                                        options += `<option value="${item.id}">${item.namacourse}</option>`;
                                                    });
                                                    $('#course_id').html(options);
                                                });
                                            }
                                        
                                            $(document).ready(function() {
                                                loadDropdowns();
                                                loadTable();
                                        
                                                $('#filterBtn').on('click', function () {
                                                    const corId = $('#course_id').val();
                                                    loadTable(corId);
                                                });
                                        
                                                $('#resetBtn').on('click', function () {
                                                    $('#course_id').val('');
                                                    loadTable();
                                                });
                                        
                                                $('#downloadBtn').on('click', function (e) {
                                                    e.preventDefault();
                                                    const corId = $('#course_id').val();
                                                    
                                                    if (!corId) {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Gagal Download',
                                                            text: 'Silakan pilih Nama Quiz terlebih dahulu!',
                                                        });
                                                        return false;
                                                    }
                                                    
                                                    let url = '{{ url("/results/exams/downloadAnswers") }}' + `?course_id=${corId}`;
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