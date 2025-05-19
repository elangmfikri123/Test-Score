@extends('layout.template')
@section('title', 'Submission KLHR')
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
                                    <h5>Submission KLHR</h5>
                                    @php
                                    use Illuminate\Support\Facades\Auth;
                                    use Carbon\Carbon;
                                
                                    $user = Auth::user();
                                    $now = Carbon::now();
                                    $deadline = Carbon::create(2025, 5, 19, 23, 59, 0);
                                @endphp
                                
                                @if($user->role === 'AdminMD' && $now->lessThanOrEqualTo($deadline))
                                <a href="{{ url('/submissionklhr/create') }}" class="btn btn-primary btn-sm">
                                    <i class="ion-plus-round"></i> Tambah
                                </a>
                            @elseif($user->role === 'AdminMD')
                                <button class="btn btn-primary btn-sm" onclick="alertDeadline()">
                                    <i class="ion-plus-round"></i> Tambah
                                </button>
                            @elseif($user->role === 'Admin')
                                <a href="{{ url('/submissionklhr/create') }}" class="btn btn-primary btn-sm">
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
                                                    <th class="text-center">Main Dealer</th>
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
                                          ajax: '{{ url("/datasubmission/json") }}',
                                          searching: true, 
                                          lengthChange: true,
                                          columns: [
                                            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                                            { data: 'maindealer', name: 'maindealer', orderable: true, searchable: true },
                                            { data: 'createdtime', name: 'createdtime', className: 'text-center' },
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
</div>
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