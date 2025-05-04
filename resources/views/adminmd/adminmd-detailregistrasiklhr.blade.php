@extends('layout.template')
@section('title', 'Registrasi KLHR')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><strong>Detail Submission KLHR</strong></h5>
                                    </div>
                                    <hr class="m-0">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-xl-6">
                                                        <div class="table-responsive">
                                                            <table class="table m-0">
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">Main Dealer</th>
                                                                        <td>{{ $submissiondetail->maindealer->kodemd }}-{{ $submissiondetail->maindealer->nama_md }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Link Publikasi KLHR 1</th>
                                                                        <td>
                                                                            @if ($submissiondetail->link_klhr1)
                                                                                <a href="{{ $submissiondetail->link_klhr1 }}"
                                                                                    target="_blank">{{ $submissiondetail->link_klhr1 }}</a>
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Link Publikasi KLHR 2</th>
                                                                        <td>
                                                                            @if ($submissiondetail->link_klhr2)
                                                                                <a href="{{ $submissiondetail->link_klhr2 }}"
                                                                                    target="_blank">{{ $submissiondetail->link_klhr2 }}</a>
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Link Publikasi KLHR 3</th>
                                                                        <td>
                                                                            @if ($submissiondetail->link_klhr3)
                                                                                <a href="{{ $submissiondetail->link_klhr3 }}"
                                                                                    target="_blank">{{ $submissiondetail->link_klhr3 }}</a>
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">File Submission</th>
                                                                        <td>
                                                                            @if (!empty($submissiondetail->file_submission))
                                                                                <div
                                                                                    class="d-flex align-items-center gap-2">
                                                                                    <div class="mx-1"></div>
                                                                                    <a href="{{ asset('storage/' . $submissiondetail->file_submission) }}"
                                                                                        download
                                                                                        class="btn btn-sm btn-success">
                                                                                        <i class="ion-archive"></i> Download
                                                                                    </a>
                                                                                </div>

                                                                                <small class="text-muted ms-2">
                                                                                    {{ basename($submissiondetail->file_submission) }}
                                                                                </small>
                                                                            @else
                                                                                <span class="text-muted">Tidak ada file
                                                                                    submission</span>
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
                                                                        <th scope="row">File Tanda Tangan Kanwil</th>
                                                                        <td>
                                                                            @if (!empty($submissiondetail->file_ttdkanwil))
                                                                                <div
                                                                                    class="d-flex align-items-center gap-2">
                                                                                    <button
                                                                                        onclick="showPdfViewer('{{ asset('storage/' . $submissiondetail->file_ttdkanwil) }}', 'ttdkanwil')"
                                                                                        class="btn btn-sm btn-primary">
                                                                                        <i class="ion-ios-eye"></i> Lihat
                                                                                    </button>
                                                                                    <div class="mx-1"></div>
                                                                                    <a href="{{ asset('storage/' . $submissiondetail->file_ttdkanwil) }}"
                                                                                        download
                                                                                        class="btn btn-sm btn-success">
                                                                                        <i class="ion-archive"></i> Download
                                                                                    </a>
                                                                                </div>
                                                                                <small class="text-muted ms-2">
                                                                                    {{ basename($submissiondetail->file_ttdkanwil) }}
                                                                                </small>
                                                                            @else
                                                                                <span class="text-muted">Tidak ada file
                                                                                    tanda tangan</span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">File Evidence Pelaksanaan</th>
                                                                        <td>
                                                                            @if (!empty($submissiondetail->file_dokumpelaksanaan))
                                                                                <div
                                                                                    class="d-flex align-items-center gap-2">
                                                                                    <button
                                                                                        onclick="showPdfViewer('{{ asset('storage/' . $submissiondetail->file_dokumpelaksanaan) }}', 'evidence')"
                                                                                        class="btn btn-sm btn-primary">
                                                                                        <i class="ion-ios-eye"></i> Lihat
                                                                                    </button>
                                                                                    <div class="mx-1"></div>
                                                                                    <a href="{{ asset('storage/' . $submissiondetail->file_dokumpelaksanaan) }}"
                                                                                        download
                                                                                        class="btn btn-sm btn-success">
                                                                                        <i class="ion-archive"></i> Download
                                                                                    </a>
                                                                                </div>
                                                                                <small class="text-muted ms-2">
                                                                                    {{ basename($submissiondetail->file_dokumpelaksanaan) }}
                                                                                </small>
                                                                            @else
                                                                                <span class="text-muted">Tidak ada file
                                                                                    evidence</span>
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
                    <!-- Single PDF Viewer Container yang akan digunakan untuk semua file -->
                    <div id="pdfViewerModal" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pdfViewerTitle">Preview Dokumen</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <iframe id="pdfViewerFrame" src="" width="100%" height="470px"
                                        style="border: none;"></iframe>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showPdfViewer(fileUrl, fileType) {
            let title = '';
            switch (fileType) {
                case 'ttdkanwil':
                    title = 'File Tanda Tangan Kanwil';
                    break;
                case 'evidence':
                    title = 'File Evidence Pelaksanaan';
                    break;
                default:
                    title = 'Preview Dokumen';
            }

            document.getElementById('pdfViewerTitle').textContent = title;
            if (fileUrl.toLowerCase().endsWith('.pdf')) {
                document.getElementById('pdfViewerFrame').src = fileUrl;
                $('#pdfViewerModal').modal('show');
            } else {
                window.open(fileUrl, '_blank');
            }
        }
    </script>
@endsection
