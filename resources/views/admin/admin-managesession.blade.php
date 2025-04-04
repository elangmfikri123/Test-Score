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
                                        <h5>Session List</h5>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#addUserModal">
                                            <i class="icofont icofont-plus"></i> Tambah
                                        </button>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="display table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 50px;">No</th>
                                                        <th class="text-center">Course</th>
                                                        <th class="text-center">Session</th>
                                                        <th class="text-center">Participants</th>
                                                        <th class="text-center">Start Date</th>
                                                        <th class="text-center">End Date</th>
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
                                              { data: 'sesi', name: 'sesi' },
                                              { data: 'participant', name: 'participant' },
                                              { data: 'start_date', name: 'start_date' },
                                              { data: 'end_date', name: 'end_date' },
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
                <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Tambah Session</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="addMainDealerForm">
                                @csrf
                                <div class="form-group">
                                    <label for="kodemd">Sesi</label>
                                    <input type="text" class="form-control" id="kodemd" name="kodemd" required>
                                </div>
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select class="form-control" id="category" name="category">
                                        <option value="">Select Course</option>
                                        <option value="admin">Admin</option>
                                        <option value="peserta">Peserta</option>
                                        <option value="juri">Juri</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama_md">Start Date</label>
                                    <input type="datetime-local" class="form-control" id="nama_md" name="nama_md" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_md">End Date</label>
                                    <input type="datetime-local" class="form-control" id="nama_md" name="nama_md" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
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