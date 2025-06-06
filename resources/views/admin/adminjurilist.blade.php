@extends('layout.template')
@section('title', 'Juri List - Admin')
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
                                    <h5>Data Juri</h5>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addUserModal"><i class="icofont icofont-plus"></i> Tambah</button>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 50px;">No</th>
                                                    <th class="text-center">Nama</th>
                                                    <th class="text-center">Jabatan</th>
                                                    <th class="text-center">Division</th>
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
                                          ajax: '{{ url("/datajuri/json") }}',
                                          searching: true, 
                                          lengthChange: true,
                                          columns: [
                                          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center'  },
                                          { data: 'nama', name: 'nama' },
                                          { data: 'jabatan', name: 'jabatan' },
                                          { data: 'division', name: 'division', orderable: true, searchable: true },
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

            <!-- Modal Add User -->
        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form untuk menambah user -->
                        <form action="{{ url('/user/store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role">
                                    <option value="admin">Admin</option>
                                    <option value="peserta">Peserta</option>
                                    <option value="juri">Juri</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="modal-footer"><button type="submit" class="btn btn-primary">Submit</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
</div>
@endsection