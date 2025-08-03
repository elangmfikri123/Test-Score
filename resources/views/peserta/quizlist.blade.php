@extends('layout.template')
@section('title', 'Quiz List')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-header mb-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <h5 class="mb-1">Daftar Ujian Peserta</h5>
                                            <small class="text-muted">Lihat daftar ujian yang tersedia dan mulai kerjakan</small>
                                        </div>
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                                                <li class="breadcrumb-item">
                                                    <a href="{{ url('/peserta/index') }}"><i class="feather icon-home"></i></a>
                                                </li>
                                                <li class="breadcrumb-item">Tes Online</li>
                                                <li class="breadcrumb-item active" aria-current="page">Daftar Ujian</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5>List Quiz</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="row mb-3 justify-content-between">
                                            <div class="col-md-1">
                                                <select id="entries" class="form-control">
                                                    <option value="5">5</option>
                                                    <option value="10" selected>10</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 text-right">
                                                <input type="text" id="searchInput" class="form-control"
                                                    placeholder="Cari quiz...">
                                            </div>
                                        </div>

                                        <div id="quizContainer"></div>

                                        <div class="mt-4 text-center" id="paginationContainer"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let currentPage = 1;
            let entriesPerPage = 10;
            let searchTerm = "";

            function fetchData() {
                $.ajax({
                    url: '{{ url('/quizlist/Json') }}',
                    data: {
                        length: entriesPerPage,
                        start: (currentPage - 1) * entriesPerPage,
                        search: {
                            value: searchTerm
                        }
                    },
                    success: function(response) {
                        renderCards(response.data);
                        renderPagination(response.recordsTotal);
                        setupExamButtonHandlers();
                    }
                });
            }

            function renderCards(data) {
                const container = $('#quizContainer');
                container.empty();

                if (data.length === 0) {
                    container.append('<p class="text-center text-muted">Tidak ada quiz ditemukan.</p>');
                    return;
                }

                data.forEach(item => {
                    let statusLabel = '';
                    if (item.status_pengerjaan === 'selesai') {
                        statusLabel = '<label class="label label-success">Selesai</label>';
                    } else if (item.status_pengerjaan === 'sedang_dikerjakan') {
                        statusLabel = '<label class="label label-info">On Progress</label>';
                    } else {
                        statusLabel = '<label class="label label-warning">Belum Mulai</label>';
                    }

                    const card = `
                    <div class="card mb-3">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="quiz-info">
                                <h5 class="mb-1">${item.nama}</h5>
                                <p class="mb-1"><strong>Kategori:</strong> ${item.categori}</p>
                                <p class="mb-1"><strong>Waktu:</strong> ${item.start_date} - ${item.end_date}</p>
                                ${statusLabel}
                            </div>
                            <div class="quiz-action text-right">
                                ${item.action}
                            </div>
                        </div>
                    </div>
                `;
                    container.append(card);
                });
            }

            function renderPagination(total) {
                const totalPages = Math.ceil(total / entriesPerPage);
                const pagination = $('#paginationContainer');
                pagination.empty();

                for (let i = 1; i <= totalPages; i++) {
                    pagination.append(`
                    <button class="btn btn-sm ${i === currentPage ? 'btn-primary' : 'btn-light'} mx-1" data-page="${i}">
                        ${i}
                    </button>
                `);
                }
            }

            function setupExamButtonHandlers() {
                $('.start-exam-btn').on('click', function(e) {
                    e.preventDefault();
                    
                    const startDate = new Date($(this).data('start'));
                    const endDate = new Date($(this).data('end'));
                    const now = new Date();
                    const url = $(this).attr('href');

                    if (now < startDate) {
                        Swal.fire({
                            title: 'Ujian Belum Dapat Dimulai',
                            text: 'Waktu ujian belum tiba. Silahkan tunggu sampai waktu yang ditentukan.',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    } else if (now > endDate) {
                        Swal.fire({
                            title: 'Ujian Sudah Berakhir',
                            text: 'Waktu ujian telah habis. Anda tidak dapat memulai ujian ini.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        window.location.href = url;
                    }
                });
            }

            // Events
            $('#searchInput').on('input', function() {
                searchTerm = $(this).val();
                currentPage = 1;
                fetchData();
            });

            $('#entries').on('change', function() {
                entriesPerPage = parseInt($(this).val());
                currentPage = 1;
                fetchData();
            });

            $('#paginationContainer').on('click', 'button', function() {
                currentPage = parseInt($(this).data('page'));
                fetchData();
            });

            fetchData();
        });
    </script>
@endsection