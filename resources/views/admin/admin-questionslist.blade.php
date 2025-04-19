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
                                        <h5><i class="feather icon-edit"></i> Detail Ujian</h5>
                                    </div>
                                    <hr class="m-0">
                                    <div class="card-block">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Nama Ujian</th>
                                                    <td>{{ $course->namacourse }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Category</th>
                                                    <td>{{ $course->category->namacategory }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Jumlah Soal</th>
                                                    <td>{{ $course->questions_count ?? 0 }} Soal</td>
                                                </tr>
                                                <tr>
                                                    <th>Durasi</th>
                                                    <td>{{ $course->duration_minutes }} Menit</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5><i class="ion-help-circled"></i> Soal Ujian</h5>
                                        <a href="{{ url('/admin/exams/' . $course->id . '/question-create') }}" class="btn btn-primary btn-sm">
                                            <i class="ion-plus-round"></i> Tambah
                                        </a>
                                    </div>
                                    <hr class="m-0">
                                 <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="display table table-bordered" id="myTable" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 5px;">No</th>
                                                    <th class="text-center">Soal & Jawaban</th>
                                                    <th class="text-center" style="width: 20px;">Action</th>
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
                                          ajax: '{{ url("/dataquestion-answer/json/" . $course->id) }}',
                                          searching: true, 
                                          lengthChange: true, 
                                          columns: [
                                          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                                          { data: 'questions_answer', name: 'questions_answer' },
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
