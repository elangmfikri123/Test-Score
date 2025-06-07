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
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5><i class="feather icon-edit"></i> Detail Scorecard</h5>
                                    </div>
                                    <hr class="m-0">
                                    <div class="card-block">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th style="width: 300px;">Nama Scorecard</th>
                                                    <td>{{ $data->namaform ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 300px;">Category</th>
                                                    <td>{{ $data->category->namacategory ?? '-' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                                            <table class="display table table-striped table-bordered" id="myTable"
                                                width="100%">
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

                                {{-- SCRIPT DATATABLE --}}
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
                                <script>
                                    $(document).ready(function() {
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

                                        // DELETE peserta
                                        $('#myTable').on('click', '.btn-delete', function() {
                                            const juriId = $(this).data('id');
                                            const formId = $(this).data('formid');

                                            Swal.fire({
                                                title: 'Apakah Anda yakin?',
                                                text: "Data juri dan peserta yang terkait akan dihapus!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonText: 'Ya, hapus!',
                                                cancelButtonText: 'Batal'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $.ajax({
                                                        url: '/admin/delete/' + juriId + '/' + formId,
                                                        type: 'POST', // <-- Ganti dari DELETE ke POST
                                                        data: {
                                                            _token: '{{ csrf_token() }}',
                                                            _method: 'DELETE' // <-- Laravel akan memahami ini sebagai DELETE
                                                        },
                                                        success: function(res) {
                                                            if (res.status === 'success') {
                                                                Swal.fire('Berhasil!', res.message, 'success');
                                                                table.ajax.reload(null, false);
                                                            } else {
                                                                Swal.fire('Gagal!', res.message, 'error');
                                                            }
                                                        },
                                                        error: function(xhr) {
                                                            let message = 'Terjadi kesalahan saat menghapus data.';
                                                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                                                message = xhr.responseJSON.message;
                                                            }
                                                            Swal.fire('Gagal!', message, 'error');
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
                res.data.forEach(item => {
                    rows += `<tr>
                                <td>${item.no}</td>
                                <td>${item.honda_id}</td>
                                <td>${item.nama}</td>
                                <td>${item.namacategory}</td>
                                <td>${item.nama_md}</td>
                                <td class="text-center">
                                    <button class="btn btn-danger btn-sm btn-remove-peserta"
                                            data-id="${item.id}"
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
                Swal.fire('Error', 'Gagal mengambil data peserta.', 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Terjadi kesalahan saat memuat data.', 'error');
        }
    });
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

    <!-- Modal Detail Peserta -->
<div class="modal fade" id="modalDetailPeserta" tabindex="-1" role="dialog" aria-labelledby="modalDetailPesertaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:80% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailPesertaLabel">Detail Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
<table class="table table-bordered table-striped" id="tableDetailPeserta">
    <thead>
        <tr>
            <th>No</th>
            <th>Honda ID</th>
            <th>Nama Peserta</th>
            <th>Category</th>
            <th>Main Dealer</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <!-- Diisi lewat AJAX -->
    </tbody>
</table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection
