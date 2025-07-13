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
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                                <div class="mr-3">
                                                    <i class="feather icon-file-text text-info" style="font-size: 32px;"></i>
                                                </div>
                                                <div>
                                                    <div class="text-muted small">Nama Ujian</div>
                                                    <div class="font-weight-bold">{{ $course->namacourse }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                                <div class="mr-3">
                                                    <i class="feather icon-layers text-success" style="font-size: 32px;"></i>
                                                </div>
                                                <div>
                                                    <div class="text-muted small">Kategori</div>
                                                    <div class="font-weight-bold">{{ $course->category->namacategory }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                                <div class="mr-3">
                                                    <i class="feather icon-list text-warning" style="font-size: 32px;"></i>
                                                </div>
                                                <div>
                                                    <div class="text-muted small">Jumlah Soal</div>
                                                    <div class="font-weight-bold">{{ $course->questions_count ?? 0 }} Soal</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                                <div class="mr-3">
                                                    <i class="feather icon-clock text-danger" style="font-size: 32px;"></i>
                                                </div>
                                                <div>
                                                    <div class="text-muted small">Durasi</div>
                                                    <div class="font-weight-bold">{{ $course->duration_minutes }} Menit</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5><i class="ion-help-circled"></i> Soal Ujian</h5>
                                    <div>
                                        <select id="categoryFilter" class="form-control form-control-sm d-inline-block" style="width: 200px;">
                                            <option value="">Semua Kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->vnamacategory }}</option>
                                            @endforeach
                                        </select>
                                        <a href="{{ url('/admin/exams/' . $course->id . '/question-create') }}"
                                            class="btn btn-primary btn-sm ml-2">
                                            <i class="ion-plus-round"></i> Tambah
                                        </a>
                                        <a href="{{ url('/admin/exams/' . $course->id . '/question-upload') }}"
                                            class="btn btn-warning btn-sm ml-2">
                                            <i class="feather icon-upload"></i> Upload
                                        </a>
                                    </div>
                                </div>
                                <hr class="m-0">
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="display table table-bordered" id="myTable" cellspacing="0"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 5px;">No</th>
                                                    <th class="text-center">Soal & Jawaban</th>
                                                    <th class="text-center" style="width: 20px;">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url('/dataquestion-answer/json/' . $course->id) }}',
                data: function(d) {
                    d.category_id = $('#categoryFilter').val();
                }
            },
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
                    data: 'questions_answer',
                    name: 'questions_answer'
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

        // Filter berdasarkan kategori
        $('#categoryFilter').change(function() {
            table.ajax.reload();
        });
    });

    function deleteQuestion(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus soal ini?',
            text: "Soal dan semua jawaban akan dihapus.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/exams/question-delete/' + id,
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
                            Swal.fire('Gagal', 'Data gagal dihapus', 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                    }
                });
            }
        });
    }
</script>

<style>
    .badge-info {
        background-color: #17a2b8;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 12px;
        display: inline-block;
        margin-top: 5px;
    }
    .badge {
        font-weight: 500;
    }
</style>
@endsection