@extends('layout.template')
@section('title', 'Manage Category - Admin')
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
                                        <h5>Manage Category</h5>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addUserModal"><i class="icofont icofont-plus"></i>Tambah</button>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="display table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 50px;">No</th>
                                                        <th class="text-center">Category</th>
                                                        <th class="text-center">Keterangan</th>
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
                                              ajax: '{{ url("/get-category/data") }}',
                                              searching: true,
                                              lengthChange: true, 
                                              columns: [
                                              { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                                              { data: 'namacategory', name: 'namacategory' },
                                              { data: 'keterangan', name: 'keterangan' },
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

            <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Tambah Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form untuk menambah user -->
                            <form action="{{ url('/category/store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="namacategory">Nama Category</label>
                                    <input type="text" class="form-control" id="namacategory" name="namacategory" required>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                                </div>
                                <div class="modal-footer"><button type="submit" class="btn btn-primary">Submit</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Category -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="formEditCategory" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label>Nama Category</label>
                        <input type="text" class="form-control" id="edit_namacategory" name="namacategory" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" id="edit_keterangan" name="keterangan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>



                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function editCategory(id) {
    $.get('/category/edit/' + id, function(data) {
        $('#edit_id').val(data.id);
        $('#edit_namacategory').val(data.namacategory);
        $('#edit_keterangan').val(data.keterangan);
        $('#editCategoryModal').modal('show');
        $('#formEditCategory').attr('action', '/category/update/' + id);
    });
}

$('#formEditCategory').on('submit', function(e) {
    e.preventDefault();

    var id = $('#edit_id').val();
    var form = $(this);
    var formData = form.serialize();

    $.ajax({
        url: '/category/update/' + id,
        type: 'POST',
        data: formData,
        success: function(response) {
            $('#editCategoryModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Kategori berhasil diupdate',
                timer: 1500,
                showConfirmButton: false
            });
            $('#myTable').DataTable().ajax.reload();
        },
        error: function() {
            Swal.fire('Error', 'Gagal update data', 'error');
        }
    });
});

function deleteCategory(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data akan hilang permanen",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/category/delete/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#myTable').DataTable().ajax.reload();
                },
                error: function() {
                    Swal.fire('Error', 'Gagal menghapus data', 'error');
                }
            });
        }
    });
}
</script>

@endsection