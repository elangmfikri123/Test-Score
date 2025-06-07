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
                                                    <td>{{ $course->category->namacategory ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Durasi</th>
                                                    <td>{{ $course->duration_minutes }} Menit</td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                                                { data: 'id', name: 'id' },
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
                                            table.ajax.reload(null, false); // Tetap di halaman saat ini
                                        }, 10000);
    
                                        // Countdown logic
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
                                            if (confirm('Yakin ingin menghapus peserta ini?')) {
                                                $.ajax({
                                                    url: '{{ url("/monitoring/delete") }}/' + id,
                                                    type: 'DELETE',
                                                    data: {
                                                        _token: '{{ csrf_token() }}'
                                                    },
                                                    success: function (res) {
                                                        if (res.status === 'success') {
                                                            table.ajax.reload(null, false);
                                                        }
                                                    },
                                                    error: function () {
                                                        alert('Terjadi kesalahan saat menghapus data.');
                                                    }
                                                });
                                            }
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
