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
                                        <h5>Manage Participants Course</h5>
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
                                                        ajax: '{{ url("/datacourseparticipants/json") }}',
                                                        searching: true, 
                                                        lengthChange: true,
                                                        columns: [{
                                                                data: 'id',
                                                                name: 'id'
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
                                                                data: 'participant',
                                                                name: 'participant', class: 'text-center'
                                                            },
                                                            {
                                                                data: 'start_date',
                                                                name: 'start_date'
                                                            },
                                                            {
                                                                data: 'end_date',
                                                                name: 'end_date'
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
    </div>
@endsection
