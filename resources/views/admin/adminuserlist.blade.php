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
                                        <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#addUserModal"><i class="icofont icofont-plus"></i> Tambah</button>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="display table table-striped table-bordered" id="myTable"
                                                cellspacing="0" width="100%">
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
                                                        ajax: '{{ url('get-user/data') }}',
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
                                                                data: 'nama',
                                                                name: 'nama'
                                                            },
                                                            {
                                                                data: 'username',
                                                                name: 'username'
                                                            },
                                                            {
                                                                data: 'email',
                                                                name: 'email'
                                                            },
                                                            {
                                                                data: 'maindealer',
                                                                name: 'maindealer',
                                                                className: 'text-center'
                                                            },
                                                            {
                                                                data: 'role',
                                                                name: 'role',
                                                                className: 'text-center'
                                                            },
                                                            {
                                                                data: 'status',
                                                                name: 'status',
                                                                className: 'text-center'
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
                                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                            <script>
                                                function handleStatusClick(userId, element) {
                                                    Swal.fire({
                                                        title: 'Force Logout?',
                                                        text: "Apakah Anda yakin ingin memaksa logout user ini?",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#01a9ac',
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
                                        <select name="role" id="role" class="form-control" required
                                            onchange="toggleForm()">
                                            <option value="Admin">Admin</option>
                                            <option value="AdminMD">Admin MD</option>
                                            <option value="Juri">Juri</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="maindealerField" style="display:none">
                                        <label>Main Dealer</label>
                                        <select class="form-control" name="maindealer_id">
                                            <option value="">Pilih Main Dealer</option>
                                            @foreach ($mainDealers as $md)
                                                <option value="{{ $md->id }}">{{ $md->kodemd }} -
                                                    {{ $md->nama_md }}</option>
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

                <!-- Modal Detail User -->
                <div class="modal fade" id="detailUserModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Nama</th>
                                                <td id="detail_nama"></td>
                                            </tr>
                                            <tr>
                                                <th>Username</th>
                                                <td id="detail_username"></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td id="detail_email"></td>
                                            </tr>
                                            <tr>
                                                <th>Role</th>
                                                <td id="detail_role"></td>
                                            </tr>
                                            <tr>
                                                <th>Main Dealer</th>
                                                <td id="detail_maindealer"></td>
                                            </tr>
                                            <tr>
                                                <th>Kode MD</th>
                                                <td id="detail_kodemd"></td>
                                            </tr>
                                            <tr>
                                                <th>Jabatan</th>
                                                <td id="detail_jabatan"></td>
                                            </tr>
                                            <tr>
                                                <th>Divisi</th>
                                                <td id="detail_division"></td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td id="detail_status"></td>
                                            </tr>
                                            <tr>
                                                <th>Dibuat Pada</th>
                                                <td id="detail_created"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit User -->
                <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form id="editUserForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="user_id" id="edit_user_id">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" name="nama" id="edit_nama" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" id="edit_email" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name="username" id="edit_username" class="form-control"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <input type="password" id="password" name="password" class="form-control"
                                                placeholder="Kosongkan jika tidak ingin mengubah">
                                            <span class="input-group-addon" onclick="togglePassword()"
                                                style="cursor: pointer;">
                                                <i class="ion-eye-disabled" id="eye-icon"></i>
                                            </span>
                                        </div>
                                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="role" id="edit_role" class="form-control"
                                            onchange="toggleEditFields()">
                                            <option value="Admin">Admin</option>
                                            <option value="AdminMD">Admin MD</option>
                                            <option value="Juri">Juri</option>
                                            <option value="Peserta">Peserta</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="edit_maindealer_field" style="display:none;">
                                        <label>Main Dealer</label>
                                        <select class="form-control select2-maindealeredit" name="maindealer_id"
                                            id="edit_maindealer_id">
                                            <option value="">Pilih Main Dealer</option>
                                            @foreach ($mainDealers as $md)
                                                <option value="{{ $md->id }}">{{ $md->kodemd }} -
                                                    {{ $md->nama_md }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" id="edit_jabatan_field" style="display:none;">
                                        <label>Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" id="edit_jabatan">
                                    </div>
                                    <div class="form-group" id="edit_division_field" style="display:none;">
                                        <label>Divisi</label>
                                        <input type="text" class="form-control" name="division" id="edit_division">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                <script>
                    function toggleForm() {
                        var role = $('#role').val();
                        $('#maindealerField, #jabatanField, #divisionField').hide();

                        if (role === 'AdminMD') {
                            $('#maindealerField').show();
                        } else if (role === 'Juri') {
                            $('#jabatanField, #divisionField').show();
                        }
                    }

                    $(document).ready(function() {
                        $('.select2-maindealer').select2({
                            placeholder: "Pilih Main Dealer",
                            dropdownParent: $('#addUserModal')
                        });

                        $('#addUserModal').on('show.bs.modal', function() {
                            toggleForm();
                            $('.select2-maindealer').val(null).trigger('change');
                        });
                    });
                </script>
                <script>
                    $(document).ready(function() {
                        $('#editUserForm').on('submit', function(e) {
                            e.preventDefault();

                            var form = $(this);
                            var url = form.attr('action');
                            var formData = form.serialize();

                            $.ajax({
                                type: "POST",
                                url: url,
                                data: formData,
                                success: function(response) {
                                    if (response.success) {
                                        $('#editUserModal').modal('hide');
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: response.message,
                                            icon: 'success',
                                            confirmButtonColor: '#01a9ac',
                                            confirmButtonText: 'OK'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $('#myTable').DataTable().ajax.reload();
                                            }
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    var errorMessage = xhr.responseJSON.message ||
                                        'Terjadi kesalahan saat memperbarui data';
                                    Swal.fire({
                                        title: 'Error!',
                                        text: errorMessage,
                                        icon: 'error',
                                        confirmButtonColor: '#01a9ac'
                                    });
                                }
                            });
                        });
                    });

                    function togglePassword() {
                        const passwordInput = document.getElementById('password');
                        const eyeIcon = document.getElementById('eye-icon');

                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            eyeIcon.classList.remove('ion-eye-disabled');
                            eyeIcon.classList.add('ion-eye');
                        } else {
                            passwordInput.type = 'password';
                            eyeIcon.classList.remove('ion-eye');
                            eyeIcon.classList.add('ion-eye-disabled');
                        }
                    }

                    function editUser(userId) {
                        $.ajax({
                            url: '/user/' + userId,
                            method: 'GET',
                            success: function(data) {
                                $('#edit_user_id').val(data.id);
                                $('#edit_nama').val(data.nama);
                                $('#edit_email').val(data.email);
                                $('#edit_username').val(data.username);
                                $('#edit_role').val(data.role);
                                $('#password').val('');
                                if (data.role === 'AdminMD' || data.role === 'Peserta') {
                                    $('#edit_maindealer_id').val(data.maindealer_id).trigger('change');
                                }
                                if (data.role === 'Juri') {
                                    $('#edit_jabatan').val(data.jabatan);
                                    $('#edit_division').val(data.division);
                                }

                                toggleEditFields();

                                $('#editUserForm').attr('action', '/user/' + userId);
                                $('#editUserModal').modal('show');
                            }
                        });
                    }

                    function toggleEditFields() {
                        const role = $('#edit_role').val();
                        $('#edit_maindealer_field, #edit_jabatan_field, #edit_division_field').hide();
                        if (role === 'AdminMD' || role === 'Peserta') {
                            $('#edit_maindealer_field').show();
                        } else if (role === 'Juri') {
                            $('#edit_jabatan_field, #edit_division_field').show();
                        }
                    }
                    // Fungsi untuk menampilkan detail user
                    function showUserDetail(userId) {
                        $.ajax({
                            url: '/user/detail/' + userId,
                            method: 'GET',
                            success: function(data) {
                                // Isi data ke modal
                                $('#detail_nama').text(data.nama);
                                $('#detail_username').text(data.username);
                                $('#detail_email').text(data.email);
                                $('#detail_role').text(data.role);
                                $('#detail_maindealer').text(data.maindealer);
                                $('#detail_kodemd').text(data.kodemd);
                                $('#detail_jabatan').text(data.jabatan);
                                $('#detail_division').text(data.division);
                                $('#detail_status').text(data.status);
                                $('#detail_created').text(data.created_at);

                                // Tampilkan modal
                                $('#detailUserModal').modal('show');
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Gagal memuat data user',
                                    icon: 'error',
                                    confirmButtonColor: '#01a9ac'
                                });
                            }
                        });
                    }
                    $(document).ready(function() {
                        $('.select2-maindealeredit').select2({
                            placeholder: "Pilih Main Dealer",
                            dropdownParent: $('#editUserModal')
                        });

                        $('#editUserModal').on('shown.bs.modal', function() {
                            $('.select2-maindealeredit').select2({
                                placeholder: "Pilih Main Dealer",
                                dropdownParent: $('#editUserModal')
                            });
                        });
                    });
                </script>
                <style>
                    .icon-black {
                        color: #444 !important;
                        font-size: 16px;
                    }

                    #eye-icon {
                        font-size: 16px;
                        color: #444;
                    }

                    input::-ms-reveal {
                        display: none;
                    }
                </style>
                <script>
                    function togglePassword() {
                        const passwordInput = document.getElementById('password');
                        const eyeIcon = document.getElementById('eye-icon');

                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            eyeIcon.classList.remove('ion-eye-disabled');
                            eyeIcon.classList.add('ion-eye');
                        } else {
                            passwordInput.type = 'password';
                            eyeIcon.classList.remove('ion-eye');
                            eyeIcon.classList.add('ion-eye-disabled');
                        }
                    }
                </script>
            </div>
        </div>
    </div>
    </div>
@endsection
