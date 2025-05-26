@extends('layout.template')
@section('title', 'Detail Peserta')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <!--profile cover start-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cover-profile">
                                    <div class="profile-bg-img position-relative">
                                        <img class="profile-bg-img img-fluid w-100" 
                                             src="{{ asset('files\assets\images\user-profile\bg-img1.jpg') }}" 
                                             alt="bg-img">
                                        <div class="card-block user-info">
                                            <div class="col-md-12">
                                                <div class="media-left">
                                                    <div class="profile-image">
                                                        <img class="user-img img-radius" 
                                                             src="{{ asset('storage/' . $peserta->filesPeserta->foto_profil) }}" 
                                                             alt="user-img"
                                                             style="width: 150px; height: 150px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--profile cover end-->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- tab header start -->
                                <div class="tab-header card">
                                    <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#bpeserta"
                                                role="tab">Data Peserta</a>
                                            <div class="slide"></div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#batasan" role="tab">Data Atasan</a>
                                            <div class="slide"></div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#bdealer" role="tab">Data Dealer</a>
                                            <div class="slide"></div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#bfiles" role="tab">Files</a>
                                            <div class="slide"></div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content">
                                    <!-- tab panel personal start -->                           
                                    <div class="tab-pane active" id="bpeserta" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5 class="card-header-text m-0">Identitas Peserta</h5>

                                                @auth
                                                    @if (auth()->user()->role === 'Admin')
                                                        <div class="dropdown dropdown-warning ms-auto">
                                                            <button class="btn btn-sm btn-info dropdown-toggle waves-effect waves-light" type="button" id="dropdown-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Update Status
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-5">
                                                                <a class="dropdown-item waves-effect update-status" data-value="Verified" href="#">Verified</a>
                                                                <a class="dropdown-item waves-effect update-status" data-value="Lolos" href="#">Lolos</a>
                                                                <a class="dropdown-item waves-effect update-status" data-value="Tidak Lolos" href="#">Tidak Lolos</a>
                                                                <a class="dropdown-item waves-effect update-status" data-value="Updated" href="#">Updated</a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endauth
                                            </div>
                                            <div class="card-block">
                                                <div class="view-info">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="general-info">
                                                                <div class="row">
                                                                    <div class="col-xl-6">
                                                                        <div class="table-responsive">
                                                                            <table class="table m-0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <th scope="row">Nama Lengkap</th>
                                                                                        <td>{{ $peserta->nama }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">No. Handphone/WhatsApp</th>
                                                                                        <td>{{ $peserta->no_hp }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">No. Handphone (AstraPay)</th>
                                                                                        <td>{{ $peserta->no_hp_astrapay }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Email</th>
                                                                                        <td>{{ $peserta->email }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Tempat Lahir</th>
                                                                                        <td>{{ $peserta->tempat_lahir }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Tanggal Lahir</th>
                                                                                        <td>{{ \Carbon\Carbon::parse($peserta->tanggal_lahir)->format('d-F-Y') }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Pendidikan Terakhir</th>
                                                                                        <td>{{ $peserta->pendidikan_terakhir }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Jenis Kelamin</th>
                                                                                        <td>{{ $peserta->jenis_kelamin }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Agama</th>
                                                                                        <td>{{ $peserta->agama }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Pantangan Makanan</th>
                                                                                        <td>{{ $peserta->pantangan_makanan ?? '-' }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Riwayat Penyakit</th>
                                                                                        <td>{{ $peserta->riwayat_penyakit ?? '-' }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Sosial Media Instagram</th>
                                                                                        <td><a href="{{ $peserta->link_instagram }}">{{ $peserta->link_instagram }}</a></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Sosial Media Facebook</th>
                                                                                        <td><a href="{{ $peserta->link_facebook }}">{{ $peserta->link_facebook }}</a></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Sosial Media Tiktok</th>
                                                                                        <td><a href="{{ $peserta->link_tiktok }}">{{ $peserta->link_tiktok }}</a></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end of table col-lg-6 -->
                                                                    <div class="col-xl-6">
                                                                        <div class="table-responsive">
                                                                            <table class="table">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <th scope="row">Honda ID</th>
                                                                                        <td>{{ $peserta->honda_id }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Main Dealer</th>
                                                                                        <td>{{ $peserta->MainDealer->kodemd }}-{{ $peserta->MainDealer->nama_md }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Kategori</th>
                                                                                        <td>{{ $peserta->Category->namacategory }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Jabatan</th>
                                                                                        <td>{{ $peserta->jabatan }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Tanggal Mendapat Honda ID</th>
                                                                                        <td>{{ \Carbon\Carbon::parse($peserta->tanggal_hondaid)->format('d-F-Y') }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Tanggal Mulai Bekerja di Dealer Saat Ini</th>
                                                                                        <td>{{ \Carbon\Carbon::parse($peserta->tanggal_awalbekerja)->format('d-F-Y') }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Lama Bekerja di Dealer Saat Ini</th>
                                                                                        <td>{{ $peserta->lamabekerja_dealer }} Bulan</td>
                                                                                    </tr>
                                                                                </tbody>
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
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Riwayat Kepesertaan KLHN Sebelumnya</h5>
                                            </div>
                                            <div class="card-block table-border-style">
                                                <div class="table-responsive">
                                                    <table class="table table-styling">
                                                        <thead>
                                                            <tr class="table-primary">
                                                                <th class="text-center" style="width: 100px;">No</th>
                                                                <th class="text-center">Tahun</th>
                                                                <th class="text-center">Kategory</th>
                                                                <th class="text-center">Status Kepesertaan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($riwayat_klhn as $index => $riwayat)
                                                                <tr>
                                                                    <th class="text-center" style="width: 100px;">{{ $index + 1 }}</th>
                                                                    <td class="text-center">{{ $riwayat['tahun_keikutsertaan'] }}</td>
                                                                    <td class="text-center">{{ $riwayat['vcategory'] }}</td>
                                                                    <td class="text-center">{{ $riwayat['status_kepesertaan'] }}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="4" class="text-center">Tidak ada riwayat kepesertaan.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="batasan" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-header-text">Data Atasan Peserta</h5>
                                            </div>
                                            <div class="card-block">
                                                <div class="view-info">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-xl-6">
                                                                        <div class="table-responsive">
                                                                            <table class="table m-0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <th scope="row">Nama Atasan</th>
                                                                                        <td>{{ $peserta->identitasAtasan->nama_lengkap_atasan }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Jabatan</th>
                                                                                        <td>{{ $peserta->identitasAtasan->jabatan }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">No Handphone</th>
                                                                                        <td>{{ $peserta->identitasAtasan->no_hp }}</td>
                                                                                    </tr>
                                                                                </tbody>
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

                                    <div class="tab-pane" id="bdealer" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-header-text">Data Dealer</h5>
                                            </div>
                                            <div class="card-block">
                                                <div class="view-info">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="general-info">
                                                                <div class="row">
                                                                    <div class="col-xl-6">
                                                                        <div class="table-responsive">
                                                                            <table class="table m-0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <th scope="row">Kode Dealer (AHM)</th>
                                                                                        <td>{{ $peserta->identitasDealer->kode_dealer }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Nama Resmi Dealer/AHASS</th>
                                                                                        <td>{{ $peserta->identitasDealer->nama_dealer }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">No. Telp Dealer</th>
                                                                                        <td>{{ $peserta->identitasDealer->no_telp_dealer }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Kota/Kabupatean Dealer</th>
                                                                                        <td>{{ $peserta->identitasDealer->kota }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Provinsi Dealer</th>
                                                                                        <td>{{ $peserta->identitasDealer->provinsi }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Tahun Dealer Meraih Juara di KLHN Sebelumnya</th>
                                                                                        <td>{{ $peserta->identitasDealer->tahun_menang_klhn }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Kategori Juara</th>
                                                                                        <td>{{ $peserta->identitasDealer->keikutsertaan_klhn_sebelumnya }}</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="table-responsive">
                                                                            <table class="table">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <th scope="row">Link Google Business Profil Dealer</th>
                                                                                        <td><a href="{{ $peserta->identitasDealer->link_google_business }}">{{ $peserta->identitasDealer->link_google_business }}</a></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Sosial Media Instagram</th>
                                                                                        <td><a href="{{ $peserta->identitasDealer->link_instagram }}">{{ $peserta->identitasDealer->link_instagram }}</a></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Sosial Media Facebook</th>
                                                                                        <td><a href="{{ $peserta->identitasDealer->link_facebook }}">{{ $peserta->identitasDealer->link_facebook }}</a></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Sosial Media Tiktok</th>
                                                                                        <td><a href="{{ $peserta->identitasDealer->link_tiktok }}">{{ $peserta->identitasDealer->link_tiktok }}</a></td>
                                                                                    </tr>
                                                                                </tbody>
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

                                    <div class="tab-pane" id="bfiles" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-header-text">Files</h5>
                                            </div>
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-xl-6">
                                                                    <div class="table-responsive">
                                                                        <table class="table m-0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th scope="row">Judul Project</th>
                                                                                    <td>{{ $peserta->filesPeserta->judul_project ?? '-' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Tahun Pembuatan</th>
                                                                                    <td>{{ $peserta->filesPeserta->tahun_pembuatan_project ?? '-' }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">File Project</th>
                                                                                    <td>
                                                                                        @if (!empty($peserta->filesPeserta->file_project))
                                                                                            <div class="d-flex align-items-center gap-2">
                                        
                                                                                                <button onclick="togglePdfViewer('{{ asset('storage/' . $peserta->filesPeserta->file_project) }}')" 
                                                                                                        class="btn btn-sm btn-info">
                                                                                                    <i class="ion-ios-eye"></i> Lihat File
                                                                                                </button>
                                                                                                
                                                                                                <div class="mx-1"></div>
                                                                                                
                                                                                                <a href="{{ asset('storage/' . $peserta->filesPeserta->file_project) }}" 
                                                                                                   download
                                                                                                   class="btn btn-sm btn-success">
                                                                                                   <i class="ion-archive"></i> Download
                                                                                                </a>
                                                                                            </div>
                                                                                            
                                                                                            <small class="text-muted ms-2">
                                                                                                {{ basename($peserta->filesPeserta->file_project) }}
                                                                                            </small>
                                                                                            <div id="pdfViewerContainer" class="mt-3" style="display: none;">
                                                                                                <iframe id="pdfViewer" src="" width="100%" height="500px" style="border: 1px solid #ddd;"></iframe>
                                                                                            </div>
                                                                                        @else
                                                                                            <span class="text-muted">Tidak ada file</span>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">File Lampiran</th>
                                                                                    <td>
                                                                                        @if (!empty($peserta->filesPeserta->file_lampiranklhn))
                                                                                        <div class="d-flex align-items-center gap-2">
                                                                                            <a href="{{ asset('storage/' . $peserta->filesPeserta->file_lampiranklhn) }}" 
                                                                                               download
                                                                                               class="btn btn-sm btn-success">
                                                                                               <i class="ion-archive"></i> Download
                                                                                            </a>
                                                                                        </div>
                                                                                        <small class="text-muted ms-2">
                                                                                            {{ basename($peserta->filesPeserta->file_lampiranklhn) }}
                                                                                        </small>
                                                                                    @else
                                                                                        <span class="text-muted">Tidak ada file</span>
                                                                                    @endif
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-6">
                                                                    <div class="table-responsive">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th scope="row">Foto KTP</th>
                                                                                    <td>
                                                                                        @if(!empty($peserta->filesPeserta->ktp))
                                                                                            <div class="d-flex flex-column align-items-start gap-3">
                                                                                                <div class="border p-2 rounded bg-light" style="max-width: 300px;">
                                                                                                    <img src="{{ asset('storage/' . $peserta->filesPeserta->ktp) }}" 
                                                                                                         alt="Foto KTP"
                                                                                                         class="img-fluid rounded"
                                                                                                         style="max-height: 200px; width: auto;">
                                                                                                </div>
                                                                                                <div class="mx-1"></div>
                                                                                                <a href="{{ asset('storage/' . $peserta->filesPeserta->ktp) }}" 
                                                                                                   download
                                                                                                   class="btn btn-sm btn-success">
                                                                                                   <i class="ion-archive"></i> Download KTP
                                                                                                </a>
                                                                                            </div>
                                                                                        @else
                                                                                            <span class="text-muted">Belum ada foto KTP</span>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
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
                        </div>
                    </div>
                    <!-- Page-body end -->
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function togglePdfViewer(pdfUrl) {
            const container = document.getElementById('pdfViewerContainer');
            const iframe = document.getElementById('pdfViewer');
            
            // Cek ekstensi file
            if(pdfUrl.toLowerCase().endsWith('.pdf')) {
                if(container.style.display === 'none') {
                    iframe.src = pdfUrl;
                    container.style.display = 'block';
                } else {
                    container.style.display = 'none';
                }
            } else {
                // Jika bukan PDF, buka di tab baru
                window.open(pdfUrl, '_blank');
            }
        }
    </script>
        <script type="text/javascript" src="{{ asset('files\bower_components\jquery\js\jquery.min.js') }}"></script>
<script>
$(document).on('click', '.update-status', function (e) {
    e.preventDefault();
    let status = $(this).data('value');
    let pesertaId = '{{ $peserta->id }}';
    Swal.fire({
        title: 'Update Status Peserta',
        html: `Apakah Anda yakin ingin mengubah status menjadi <strong>${status}</strong> untuk Honda ID <strong>{{ $peserta->honda_id }}</strong>?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Update!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/peserta/${pesertaId}/update-status`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status_lolos: status
                },
                success: function (response) {
                    Swal.fire(
                        'Berhasil!',
                        response.message,
                        'success'
                    ).then(() => {
                        window.location.href = '{{ route('list.peserta') }}';
                    });
                },
                error: function () {
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat mengupdate status.',
                        'error'
                    );
                }
            });
        }
    });
});
</script>
@endsection
