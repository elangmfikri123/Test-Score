@extends('layout.template')
@section('title', 'User List')
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
                                        <h5>User List</h5>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addUserModal"><i class="icofont icofont-plus"></i> Tambah</button>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="display table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 20px;">No</th>
                                                        <th class="text-center">Nama</th>
                                                        <th class="text-center">Username</th>
                                                        <th class="text-center">Email</th>
                                                        <th class="text-center" style="width: 20px;">Grub MD</th>
                                                        <th class="text-center">Role</th>
                                                        <th class="text-center">Status</th>
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
                                              ajax: '{{ url("get-user/data") }}',
                                              searching: true, 
                                              lengthChange: true, 
                                              columns: [
                                                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center'  },
                                                { data: 'nama', name: 'nama' },
                                                { data: 'username', name: 'username' },
                                                { data: 'email', name: 'email' },
                                                { data: 'maindealer', name: 'maindealer', className: 'text-center'},
                                                { data: 'role', name: 'role', className: 'text-center' },
                                                { data: 'status', name: 'status', className: 'text-center'},
                                                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' },
                                             ],
                                              });
                                            });
                                          </script>
                                          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                          <script>
                                            function handleStatusClick(userId, element) {
                                                Swal.fire({
                                                    title: 'Force Logout?',
                                                    text: "Apakah Anda yakin ingin memaksa logout user ini?",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    confirmButtonText: 'Ya, Logout',
                                                    cancelButtonText: 'Cancel'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        $.ajax({
                                                            url: '/force-logout/' + userId,
                                                            type: 'POST',
                                                            data: {
                                                                _token: '{{ csrf_token() }}'
                                                            },
                                                            success: function(response) {
                                                                if (response.success) {
                                                                    $(element).removeClass('bg-success').addClass('bg-secondary');
                                                                    $(element).text('Offline');
                                                                    
                                                                    Swal.fire(
                                                                        'Berhasil!',
                                                                        response.message,
                                                                        'success'
                                                                    );
                                                                }
                                                            },
                                                            error: function(xhr) {
                                                                Swal.fire(
                                                                    'Error!',
                                                                    xhr.responseJSON.message || 'Terjadi kesalahan',
                                                                    'error'
                                                                );
                                                            }
                                                        });
                                                    }
                                                });
                                            }
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <!-- Deferred rendering for speed table end -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Add User -->
                <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="createUserForm" action="{{ route('user.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="role" id="role" class="form-control" required onchange="toggleForm()">
                                            <option value="Admin">Admin</option>
                                            <option value="AdminMD">Admin MD</option>
                                            <option value="Juri">Juri</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="maindealerField" style="display:none">
                                        <label>Main Dealer</label>
                                        <select class="form-control select2-maindealer" name="maindealer">
                                            <option value="">Pilih Main Dealer</option>
                                            @foreach($mainDealers as $md)
                                                <option value="{{ $md->id }}">{{ $md->kodemd }} - {{ $md->nama_md }}</option>
                                             @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" id="jabatanField" style="display:none">
                                        <label>Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan">
                                    </div>
                                    <div class="form-group" id="divisionField" style="display:none">
                                        <label for="division">Divisi</label>
                                        <input type="text" class="form-control" name="division">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                <script>
function toggleForm() {
    var role = $('#role').val();
    
    // Sembunyikan semua field tambahan
    $('#maindealerField, #jabatanField, #divisionField').hide();
    
    // Tampilkan field sesuai role
    if (role === 'AdminMD') {
        $('#maindealerField').show();
    } else if (role === 'Juri') {
        $('#jabatanField, #divisionField').show();
    }
}

$(document).ready(function() {
    // Inisialisasi select2
    $('.select2-maindealer').select2({
        placeholder: "Pilih Main Dealer",
        dropdownParent: $('#addUserModal') // Penting untuk select2 di modal
    });

    // Inisialisasi saat modal dibuka
    $('#addUserModal').on('show.bs.modal', function () {
        toggleForm();
        $('.select2-maindealer').val(null).trigger('change'); // Reset select2
    });
});
                    </script>
                </div>
            </div>
        </div>
    </div>
    
@endsection