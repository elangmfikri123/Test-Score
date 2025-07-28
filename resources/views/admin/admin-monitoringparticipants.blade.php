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
                                    </div>
                                </div>
                            </div>

                                {{-- TABEL PESERTA --}}
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5><i class="fa fa-user-plus"></i> Monitoring Participants</h5>
                                        <a href="{{ route('participants.add', $course->id) }}"
                                            class="btn btn-primary btn-sm">
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
                                                        <th class="text-center">Honda ID</th>
                                                        <th class="text-center">Nama</th>
                                                        <th class="text-center">Kategori</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Durasi</th>
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
                                    $(document).ready(function () {
                                        const table = $('#myTable').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            ajax: '{{ url("/monitoring/data/json/" . $course->id) }}',
                                            columns: [
                                                { data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center', orderable: false, searchable: false },
                                                { data: 'honda_id', name: 'honda_id' },
                                                { data: 'nama', name: 'nama' },
                                                { data: 'namacategory', name: 'namacategory' },
                                                { data: 'status_pengerjaan', name: 'status_pengerjaan', className: 'text-center' },
                                                {
                                                    data: 'duration_minutes',
                                                    name: 'duration_minutes',
                                                    className: 'text-center',
                                                    render: function (data, type, row) {
                                                        const id = 'countdown-' + row.id;
                                                        if (row.status_pengerjaan.includes('On Progress')) {
                                                            setTimeout(() => startCountdown(id, data), 100);
                                                            return `<span id="${id}" data-seconds="${data}">Loading...</span>`;
                                                        }
                                                        const hours = Math.floor(data / 3600);
                                                        const minutes = Math.floor((data % 3600) / 60);
                                                        const seconds = data % 60;
                                                        return `<span>${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}</span>`;
                                                    }
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

                                        setInterval(() => {
                                            table.ajax.reload(null, false); 
                                        }, 10000);
    
                                        function startCountdown(elementId, secondsRemaining) {
                                            const el = document.getElementById(elementId);
                                            if (!el) return;
    
                                            const interval = setInterval(() => {
                                                if (secondsRemaining <= 0) {
                                                    clearInterval(interval);
                                                    el.innerText = '00:00:00';
                                                    el.classList.add('text-danger');
                                                    return;
                                                }
    
                                                const hours = Math.floor(secondsRemaining / 3600);
                                                const minutes = Math.floor((secondsRemaining % 3600) / 60);
                                                const seconds = secondsRemaining % 60;
    
                                                el.innerText = String(hours).padStart(2, '0') + ':' +
                                                               String(minutes).padStart(2, '0') + ':' +
                                                               String(seconds).padStart(2, '0');
    
                                                secondsRemaining--;
                                            }, 1000);
                                        }
    
                                        // DELETE peserta
                                        $('#myTable').on('click', '.btn-delete', function () {
                                            const id = $(this).data('id');
                                            Swal.fire({
                                                title: 'Yakin ingin menghapus peserta ini?',
                                                text: "Data peserta ini akan dihapus dari ujian.",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonText: 'Ya, hapus!',
                                                cancelButtonText: 'Batal'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $.ajax({
                                                        url: '{{ url("/monitoring/delete") }}/' + id,
                                                        type: 'DELETE',
                                                        data: {
                                                            _token: '{{ csrf_token() }}'
                                                        },
                                                        success: function (res) {
                                                            if (res.status === 'success') {
                                                                Swal.fire({
                                                                    icon: 'success',
                                                                    title: 'Berhasil Dihapus!',
                                                                    text: res.message || 'Data berhasil dihapus.',
                                                                    timer: 1500,
                                                                    showConfirmButton: false
                                                                });
                                                                table.ajax.reload(null, false);
                                                            } else {
                                                                Swal.fire('Gagal', 'Gagal menghapus data', 'error');
                                                            }
                                                        },
                                                        error: function () {
                                                            Swal.fire('Error', 'Terjadi kesalahan server', 'error');
                                                        }
                                                    });
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
@endsection
