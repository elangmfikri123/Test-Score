@extends('layout.template')
@section('title', 'Quiz List')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5>List Quiz</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="display table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 20px;">No</th>
                                                        <th class="text-center">Nama Quiz</th>
                                                        <th class="text-center">Kategori</th>
                                                        <th class="text-center">Start Date</th>
                                                        <th class="text-center">End Date</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                            <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
                                            <script>
                                            $(document).ready(function() {
                                                $('#myTable').DataTable({
                                                    processing: true,
                                                    serverSide: true,
                                                    ajax: '{{ url("/quizlist/Json") }}',
                                                    searching: true, 
                                                    lengthChange: true,
                                                    columns: [
                                                        { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center' },
                                                        { data: 'nama', name: 'nama', className: 'text-center' },
                                                        { data: 'categori', name: 'categori', className: 'text-center' },
                                                        { data: 'start_date', name: 'start_date', className: 'text-center' },
                                                        { data: 'end_date', name: 'end_date', className: 'text-center' },
                                                        { 
                                                            data: 'status_pengerjaan', 
                                                            name: 'status_pengerjaan', 
                                                            className: 'text-center',
                                                            render: function(data, type, row) {
                                                                if (data === 'selesai') {
                                                                    return '<span class="badge badge-success">Selesai</span>';
                                                                } else if (data === 'sedang_dikerjakan') {
                                                                    return '<span class="badge badge-info">Sedang Dikerjakan</span>';
                                                                } else {
                                                                    return '<span class="badge badge-secondary">Belum Mulai</span>';
                                                                }
                                                            }
                                                        },
                                                        { 
                                                            data: 'action', 
                                                            name: 'action', 
                                                            orderable: false, 
                                                            searchable: false, 
                                                            className: 'text-center',
                                                            render: function(data, type, row) {
                                                                return data; // Render HTML langsung dari controller
                                                            }
                                                        },
                                                    ],
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
@endsection