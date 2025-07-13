@extends('layout.template')
@section('title', 'Manage Course')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- Success Notification (added at the top) -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4">
                        <div class="d-flex align-items-center">
                            <i class="feather icon-check-circle mr-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <strong>Sukses!</strong> {{ session('success') }}
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <!-- Your existing content below (unchanged) -->
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

                                    <!-- Section Upload dan Download Template -->
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="card border-secondary mb-4">
                                                <div class="card-header bg-primary text-white py-2">
                                                    <h6 class="mb-0"><i class="feather icon-upload"></i> Upload Soal Massal</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="border p-3 rounded bg-light">
                                                                <h6 class="font-weight-bold"><i class="feather icon-download"></i> Download Template</h6>
                                                                <p class="small text-muted">Download template Excel untuk mengisi soal dalam format yang benar</p>
                                                                <a href="{{ url('/admin/exams/'.$course->id.'/download-template') }}" class="btn btn-primary btn-sm">
                                                                    <i class="feather icon-download"></i> Download Template Excel
                                                                </a>
                                                                <div class="mt-3">
                                                                    <div class="d-flex align-items-center text-primary small">
                                                                        <i class="feather icon-info mr-2"></i>
                                                                        <span>Template sudah termasuk dropdown kategori</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="border p-3 rounded bg-light">
                                                                <h6 class="font-weight-bold"><i class="feather icon-upload"></i> Upload Soal</h6>
                                                                <form id="uploadForm" action="{{ url('/admin/exams/'.$course->id.'/import-questions') }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="form-group row mb-0">
                                                                        <div class="col-sm-12">
                                                                            <p class="small text-muted">File Excel (xlsx, xls, csv).</p>
                                                                            <div class="input-group">
                                                                                <input type="file" class="form-control form-control-sm" id="excelFile" name="file" accept=".xlsx,.xls,.csv" required>
                                                                                <div class="input-group-append">
                                                                                    <button type="submit" class="btn btn-success btn-sm">
                                                                                        <i class="feather icon-upload"></i> Upload
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                            <small class="form-text text-muted">Maksimal ukuran file: 5MB</small>
                                                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="alert alert-warning mt-3 mb-0 py-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class="feather icon-info mr-2"></i>
                                                            <div>
                                                                <ul class="mb-0 pl-3 small">
                                                                    <strong class="d-block">Petunjuk Pengisian:</strong>
                                                                    <li>Kolom <strong>Kategori</strong> harus dipilih dari dropdown</li>
                                                                    <li>Gunakan <strong>1</strong> untuk jawaban benar dan <strong>0</strong> untuk jawaban salah</li>
                                                                    <li>Setiap soal harus memiliki <strong>minimal 2 pilihan jawaban</strong></li>
                                                                    <li>Hanya boleh ada <strong>satu jawaban benar</strong> per soal</li>
                                                                    <li>Kolom C dan D bisa dikosongkan jika tidak digunakan</li>
                                                                </ul>
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
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {

        $('#categoryFilter').change(function() {
            table.ajax.reload();
        });

        $('#excelFile').change(function(e) {
            var fileName = e.target.files[0].name;
            $(this).next('.custom-file-label').text(fileName);
        });

        $('#uploadForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            
            Swal.fire({
                title: 'Mengupload soal...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Soal berhasil diupload',
                        timer: 5000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan saat mengupload',
                    });
                }
            });
        });
    });
</script>
@endsection