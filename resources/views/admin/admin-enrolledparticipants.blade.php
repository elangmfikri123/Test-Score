@extends('layout.template')
@section('title', 'Enroll Participants')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="{{ route('participants.store', $course->id) }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5><i class="fa fa-user-plus"></i> Enrolled Participants</h5>
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fa fa-save"></i> Simpan
                                        </button>
                                    </div>
                                    <hr class="m-0">
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="display table table-striped table-bordered" id="myTable" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 50px;">No</th>
                                                        <th class="text-center">Honda ID</th>
                                                        <th class="text-center">Nama</th>
                                                        <th class="text-center">Kategory</th>
                                                        <th class="text-center">Main Dealer</th>
                                                        <th class="text-center" style="width: 70px;">
                                                            <input type="checkbox" id="selectAll">
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
                                <script>
                                    $(document).ready(function () {
                                        let table = $('#myTable').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            ajax: '{{ url("/pesertaenrolle/data/json/" . $course->id) }}',
                                            columns: [
                                                { data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center', orderable: false, searchable: false },
                                                { data: 'honda_id', name: 'honda_id', class:'text-center' },
                                                { data: 'nama', name: 'nama', class:'text-center' },
                                                { data: 'namacategory', name: 'category.namacategory', class:'text-center' },
                                                { data: 'kodemd', name: 'maindealer.kodemd' , class:'text-center' },
                                                {
                                                    data: 'id',
                                                    name: 'action',
                                                    orderable: false,
                                                    searchable: false,
                                                    className: 'text-center',
                                                    render: function (data) {
                                                        return '<input type="checkbox" class="rowCheckbox" name="peserta_ids[]" value="' + data + '">';
                                                    }
                                                }
                                            ]
                                        });
                                        $('#selectAll').on('change', function () {
                                            $('.rowCheckbox').prop('checked', this.checked);
                                        });
                                        $(document).on('change', '.rowCheckbox', function () {
                                            $('#selectAll').prop('checked', $('.rowCheckbox:checked').length === $('.rowCheckbox').length);
                                        });
                                    });
                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
