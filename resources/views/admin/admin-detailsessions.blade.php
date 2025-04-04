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
                                        <h5><i class="feather icon-edit"></i> Detail Sessions</h5>
                                    </div>
                                    <hr class="m-0">
                                    <div class="card-block">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Nama Ujian</th>
                                                    <td>Test KLHN 2025 - FLP</td>
                                                </tr>
                                                <tr>
                                                    <th>Category</th>
                                                    <td>Frontline People</td>
                                                </tr>
                                                <tr>
                                                    <th>Sesi</th>
                                                    <td>50 Soal</td>
                                                </tr>
                                                <tr>
                                                    <th>Mulai</th>
                                                    <td>90 menit</td>
                                                </tr>
                                                <tr>
                                                    <th>Selesai</th>
                                                    <td>90 menit</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5><i class="fa fa-user-plus"></i> Enrolled Participants</h5>
                                        <a href="{{ url('/admin/exams/create') }}" class="btn btn-primary btn-sm">
                                            <i class="ion-plus-round"></i> Tambah
                                        </a>
                                    </div>
                                    <hr class="m-0">
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 50px;">No</th>
                                                    <th class="text-center">Honda ID</th>
                                                    <th class="text-center">Nama</th>
                                                    <th class="text-center">Category</th>
                                                    <th class="text-center col-2">Action</th>
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
                                          ajax: '{{ url("/get-peserta/data") }}',
                                          searching: true, // Menampilkan fitur pencarian
                                          lengthChange: true, // Menampilkan fitur pengaturan jumlah data per halaman
                                          columns: [
                                          { data: 'id', name: 'id' },
                                          { data: 'nama', name: 'nama' },
                                          { data: 'honda_id', name: 'honda_id' },
                                          { data: 'category', name: 'category' },
                                          { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' },
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
