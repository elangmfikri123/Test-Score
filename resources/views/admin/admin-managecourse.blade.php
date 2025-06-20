@extends('layout.template')
@section('title', 'Manage Course')
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
                                        <h5>Course List</h5>
                                        <a href="{{ url('/admin/exams/create') }}" class="btn btn-primary btn-sm">
                                            <i class="ion-plus-round"></i> Tambah
                                        </a>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="display table table-striped table-bordered" id="myTable"
                                                cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 50px;">No</th>
                                                        <th class="text-center">Course</th>
                                                        <th class="text-center">Category</th>
                                                        <th class="text-center">Total Questions</th>
                                                        <th class="text-center">Durations (Menit)</th>
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
                                                        ajax: '{{ url('/datacourse/json') }}',
                                                        searching: true,
                                                        lengthChange: true,
                                                        columns: [{
                                                                data: 'DT_RowIndex',
                                                                name: 'DT_RowIndex',
                                                                orderable: false,
                                                                searchable: false,
                                                                className: 'text-center'
                                                            },
                                                            {
                                                                data: 'namacourse',
                                                                name: 'namacourse'
                                                            },
                                                            {
                                                                data: 'categoryname',
                                                                name: 'categoryname'
                                                            },
                                                            {
                                                                data: 'totalquestion',
                                                                name: 'totalquestion',
                                                                className: 'text-center'
                                                            },
                                                            {
                                                                data: 'duration_minutes',
                                                                name: 'duration_minutes',
                                                                className: 'text-center'
                                                            },
                                                            {
                                                                data: 'action',
                                                                name: 'action',
                                                                orderable: false,
                                                                searchable: false,
                                                                className: 'text-center'
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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function deleteCourse(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus course ini?',
                text: "Seluruh soal dan jawaban juga akan dihapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/exams/' + id + '/delete',
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil Dihapus!',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                $('#myTable').DataTable().ajax.reload();
                            } else {
                                Swal.fire('Gagal', 'Gagal menghapus data', 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'Terjadi kesalahan server', 'error');
                        }
                    });
                }
            });
        }
    </script>
@endsection
