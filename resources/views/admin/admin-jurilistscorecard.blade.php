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

                            {{-- DETAIL UJIAN --}}
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                                <div class="mr-3">
                                                    <i class="feather icon-edit text-primary" style="font-size: 32px;"></i>
                                                </div>
                                                <div>
                                                    <div class="text-muted small">Nama Scorecard</div>
                                                    <div class="font-weight-bold">{{ $data->namaform ?? '-' }}</div>
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
                                                    <div class="font-weight-bold">{{ $data->category->namacategory ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TABEL PESERTA --}}
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5><i class="fa fa-user-plus"></i> Monitoring Juri</h5>
                                    <a href="{{ route('juri.add', $data->id) }}" class="btn btn-primary btn-sm">
                                        <i class="ion-plus-round"></i> Tambah
                                    </a>
                                </div>
                                <hr class="m-0">
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="myTable" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 50px;">No</th>
                                                    <th class="text-center">Nama Juri</th>
                                                    <th class="text-center">Divisi</th>
                                                    <th class="text-center">Total Peserta</th>
                                                    <th class="text-center">Action</th>
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

<!-- Modal Detail Peserta -->
<div class="modal fade" id="modalDetailPeserta" tabindex="-1" role="dialog" aria-labelledby="modalDetailPesertaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 85%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailPesertaLabel">Detail Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto; max-height: 80vh;">
                <table class="table table-bordered table-striped w-100" id="tableDetailPeserta">
                    <thead class="thead-light">
                        <tr>
                            <th style="min-width: 50px;">No</th>
                            <th style="min-width: 100px;">Honda ID</th>
                            <th style="min-width: 150px;">Nama Peserta</th>
                            <th style="min-width: 120px;">Category</th>
                            <th style="min-width: 150px;">Main Dealer</th>
                            <th style="min-width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Diisi lewat AJAX -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Inisialisasi DataTable
    const table = $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url('/jurienrolled/json/' . $data->id) }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'namajuri', name: 'namajuri' },
            { data: 'division', name: 'division' },
            { data: 'countpeserta', name: 'countpeserta', className: 'text-center' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ]
    });

    // Fungsi untuk menampilkan SweetAlert dengan z-index tinggi
    function showSwal(options) {
        // Simpan modal yang sedang aktif
        const activeModal = $('.modal.show').length ? $('.modal.show') : null;
        
        // Tampilkan SweetAlert
        return Swal.fire({
            ...options,
            customClass: {
                container: 'swal2-top-overlay'
            },
            didOpen: () => {
                if (activeModal) {
                    const modalZIndex = parseInt(activeModal.css('z-index'));
                    $('.swal2-container').css('z-index', modalZIndex + 9999);
                } else {
                    $('.swal2-container').css('z-index', 999999);
                }
            },
            willClose: () => {
                if (activeModal) {
                    activeModal.focus();
                }
            }
        });
    }

    // DELETE peserta
    $('#myTable').on('click', '.btn-delete', function() {
        const juriId = $(this).data('id');
        const formId = $(this).data('formid');

        showSwal({
            title: 'Apakah Anda yakin?',
            text: "Data juri dan peserta yang terkait akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/delete/' + juriId + '/' + formId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            showSwal({
                                title: 'Berhasil!',
                                text: res.message,
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            table.ajax.reload(null, false);
                        } else {
                            showSwal({
                                title: 'Gagal!',
                                text: res.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan saat menghapus data.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        showSwal({
                            title: 'Gagal!',
                            text: message,
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });

    // DETAIL PESERTA
    $('#myTable').on('click', '.btn-detail', function() {
        const juriId = $(this).data('id');
        const formId = $(this).data('formid');

        $.ajax({
            url: '/juripeserta/detail/' + formId + '/' + juriId,
            type: 'GET',
            success: function(res) {
                if (res.status === 'success') {
                    let rows = '';
                    res.data.forEach((item) => {
                        rows += `<tr>
                            <td>${item.no}</td>
                            <td>${item.honda_id}</td>
                            <td>${item.nama}</td>
                            <td>${item.namacategory}</td>
                            <td>${item.nama_md}</td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm btn-remove-peserta"
                                        data-pesertaid="${item.peserta_id}"
                                        data-formid="${formId}"
                                        data-juriid="${juriId}">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>`;
                    });
                    $('#tableDetailPeserta tbody').html(rows);
                    $('#modalDetailPeserta').modal('show');
                } else {
                    showSwal({
                        title: 'Error',
                        text: 'Gagal mengambil data peserta.',
                        icon: 'error'
                    });
                }
            },
            error: function() {
                showSwal({
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memuat data.',
                    icon: 'error'
                });
            }
        });
    });

    // HAPUS PESERTA DARI JURI
    $('#modalDetailPeserta').on('click', '.btn-remove-peserta', function() {
        const pesertaId = $(this).data('pesertaid');
        const formId = $(this).data('formid');
        const juriId = $(this).data('juriid');
        
        console.log('Data to delete:', {
            formId: formId,
            juriId: juriId,
            pesertaId: pesertaId
        });

        showSwal({
            title: 'Hapus Peserta?',
            text: "Peserta akan dikembalikan ke daftar peserta yang belum dinilai!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("juripeserta/delete") }}/' + formId + '/' + juriId + '/' + pesertaId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(res) {
                        console.log('Delete response:', res);
                        if (res.status === 'success') {
                            showSwal({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.pesan,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                // Refresh tabel peserta dan juri
                                $('.btn-detail[data-id="'+juriId+'"]').click();
                                table.ajax.reload(null, false);
                            });
                        } else {
                            showSwal({
                                title: 'Gagal!',
                                text: res.pesan || 'Terjadi kesalahan',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Delete error:', xhr.responseJSON || error);
                        let pesan = 'Terjadi kesalahan saat menghapus peserta';
                        if (xhr.responseJSON && xhr.responseJSON.pesan) {
                            pesan = xhr.responseJSON.pesan;
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            pesan = xhr.responseJSON.message;
                        }
                        showSwal({
                            title: 'Gagal!',
                            text: pesan,
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});
</script>
@endsection