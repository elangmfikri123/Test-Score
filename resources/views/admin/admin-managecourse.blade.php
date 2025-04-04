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
                                <!-- Ajax data source (Arrays) table start -->
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5>Course List</h5>
                                        <a href="{{ url('/admin/exams/create') }}" class="btn btn-primary btn-sm">
                                            <i class="ion-plus-round"></i> Tambah
                                        </a>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="display table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 50px;">No</th>
                                                        <th class="text-center">Course</th>
                                                        <th class="text-center">Exam</th>
                                                        <th class="text-center">Category</th>
                                                        <th class="text-center">Questions</th>
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
                                              ajax: '{{ url("get-user/data") }}',
                                              searching: true, // Menampilkan fitur pencarian
                                              lengthChange: true, // Menampilkan fitur pengaturan jumlah data per halaman
                                              columns: [
                                              { data: 'id', name: 'id' },
                                              { data: 'nama', name: 'nama' },
                                              { data: 'username', name: 'username' },
                                              { data: 'email', name: 'email' },
                                              { data: 'role', name: 'role' },
                                              { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' },
                                             ],
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
@endsection