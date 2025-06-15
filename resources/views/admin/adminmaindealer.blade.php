@extends('layout.template')
@section('title', 'Manage Main Dealer - Admin')
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
                                        <h5>Manage Main Dealer</h5>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#addUserModal">
                                            <i class="icofont icofont-plus"></i> Tambah
                                        </button>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="display table table-striped table-bordered" id="myTable"
                                                cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 50px;">No</th>
                                                        <th class="text-center">Kode Main Dealer</th>
                                                        <th class="text-center">Nama Main Dealer</th>
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

                <!-- Modal Add User -->
                <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUserModalLabel">Tambah Main Dealer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="addMainDealerForm">
                                    @csrf
                                    <div class="form-group">
                                        <label for="kodemd">Kode Main Dealer</label>
                                        <input type="text" class="form-control" id="kodemd" name="kodemd" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_md">Nama Main Dealer</label>
                                        <input type="text" class="form-control" id="nama_md" name="nama_md" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Main Dealer -->
                <div class="modal fade" id="editMainDealerModal" tabindex="-1" role="dialog"
                    aria-labelledby="editMainDealerModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form id="editMainDealerForm">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Main Dealer</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="edit_id" name="id">
                                    <div class="form-group">
                                        <label for="edit_kodemd">Kode Main Dealer</label>
                                        <input type="text" class="form-control" id="edit_kodemd" name="kodemd" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_nama_md">Nama Main Dealer</label>
                                        <input type="text" class="form-control" id="edit_nama_md" name="nama_md"
                                            required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('/get-maindealer/data') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'kodemd',
                        name: 'kodemd'
                    },
                    {
                        data: 'nama_md',
                        name: 'nama_md'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });
            $('#addMainDealerForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ url('/maindealer/store') }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addUserModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Main Dealer berhasil ditambahkan!',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            $('#addMainDealerForm')[0].reset();
                            table.ajax.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menambahkan data.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            let table = $('#myTable').DataTable();

            $(document).on('click', '.edit-button', function() {
                let id = $(this).data('id');
                $.get('/maindealer/edit/' + id, function(data) {
                    $('#edit_id').val(data.id);
                    $('#edit_kodemd').val(data.kodemd);
                    $('#edit_nama_md').val(data.nama_md);
                    $('#editMainDealerModal').modal('show');
                });
            });

            $('#editMainDealerForm').on('submit', function(e) {
                e.preventDefault();
                let id = $('#edit_id').val();
                let formData = $(this).serialize();

                $.ajax({
                    url: '/maindealer/update/' + id,
                    method: 'POST',
                    data: formData,
                    success: function(res) {
                        $('#editMainDealerModal').modal('hide');
                        Swal.fire('Berhasil!', res.success, 'success');
                        table.ajax.reload();
                    },
                    error: function(err) {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat update.', 'error');
                    }
                });
            });


            // Konfirmasi hapus data
            $(document).on('click', '.delete-button', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                var actionUrl = form.attr('action');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data ini akan dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: actionUrl,
                            type: 'DELETE',
                            data: {
                                '_token': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire('Berhasil Dihapus!', response.success,
                                    'success').then(
                                    () => {
                                        form.closest('tr').remove();
                                    });
                            },
                            error: function() {
                                Swal.fire('Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
