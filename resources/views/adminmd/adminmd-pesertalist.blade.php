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
                            <!-- Ajax data source (Arrays) table start -->
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Data Peserta</h5>
                                    <a href="{{ url('/registrasi/create') }}" class="btn btn-primary btn-sm">
                                        <i class="ion-plus-round"></i> Tambah
                                    </a>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 50px;">No</th>
                                                    <th class="text-center">Honda ID</th>
                                                    <th class="text-center">Nama</th>
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
                                        $(document).ready(function() {
                                        $('#myTable').DataTable({
                                          processing: true,
                                          serverSide: true,
                                          ajax: '{{ url("/get-peserta/data") }}',
                                          searching: true, 
                                          lengthChange: true,
                                          columns: [
                                          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                                          { data: 'honda_id', name: 'honda_id' },
                                          { data: 'nama', name: 'nama' },
                                          { data: 'maindealer', name: 'maindealer', orderable: true, searchable: true },
                                          { data: 'status', name: 'status', className: 'text-center' },
                                          { data: 'createdtime', name: 'createdtime', className: 'text-center' },
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