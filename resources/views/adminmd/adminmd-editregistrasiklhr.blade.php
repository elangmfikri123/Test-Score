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
                                    <div class="card-header text-center">
                                        <h3><strong>Edit Submission KLHR</strong></h3>
                                    </div>
                                    <hr class="m-0">
                                    <div class="card-block">
                                        <form id="step4Form" action="{{ route('submission.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')                                        
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Main Dealer *</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control requiredform select2-init" name="maindealer_id">
                                                        <option value="" disabled {{ old('maindealer_id', $submission->maindealer_id ?? '') == '' ? 'selected' : '' }}>Pilih Main Dealer</option>
                                                        @foreach($mainDealers as $row)
                                                            <option value="{{ $row->id }}"
                                                                {{ old('maindealer_id', $submission->maindealer_id ?? '') == $row->id ? 'selected' : '' }}>
                                                                {{ $row->kodemd }} - {{ $row->nama_md }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>  
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Link Publikasi KLHR 1 *</label>
                                                <div class="col-sm-9">
                                                    <input type="url" class="form-control" placeholder="https://" name="link_klhr1" 
                                                        value="{{ old('link_klhr1', $submission->link_klhr1 ?? '') }}">
                                                    <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Link Publikasi KLHR 2</label>
                                                <div class="col-sm-9">
                                                    <input type="url" class="form-control" placeholder="https://" name="link_klhr2" 
                                                        value="{{ old('link_klhr2', $submission->link_klhr2 ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Link Publikasi KLHR 3</label>
                                                <div class="col-sm-9">
                                                    <input type="url" class="form-control" placeholder="https://" name="link_klhr3" 
                                                        value="{{ old('link_klhr3', $submission->link_klhr3 ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">File Submission (.xlsx) *</label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control"
                                                        name="file_submission" accept=".xlsx,.xls">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">File Submission Tanda Tangan(.pdf)
                                                    *</label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control"
                                                        name="file_ttdkanwil" accept=".pdf">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">File Submission Evidence Pelaksaan(.pdf) *</label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control" name="file_dokumpelaksanaan" accept=".pdf">
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-success"><i class="ion-checkmark"></i>
                                                    Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2-init').select2({
                minimumResultsForSearch: 1
            });

            const form = document.getElementById('step4Form');
            form.addEventListener('submit', function(e) {
                let isValid = true;
                let firstInvalid = null;

                form.querySelectorAll('.requiredform').forEach(input => {
                    const value = input.value.trim();
                    const messageEl = input.parentElement.querySelector('.messages');

                    if (!value) {
                        input.classList.add('is-invalid');
                        if (messageEl) messageEl.textContent = 'Perlu diisi / Tidak boleh kosong.';
                        isValid = false;
                        if (!firstInvalid) firstInvalid = input;
                    } else {
                        input.classList.remove('is-invalid');
                        if (messageEl) messageEl.textContent = '';
                    }
                });

                function setupFileSizeValidator(selector, maxSizeMB, message) {
                    $(selector).on('change', function() {
                        const file = this.files[0];
                        if (file && file.size / (1024 * 1024) > maxSizeMB) {
                            alert(message);
                            this.value = '';
                            $(this).addClass(
                            'is-invalid');
                        } else {
                            $(this).removeClass(
                            'is-invalid'); 
                        }
                    });
                }

                setupFileSizeValidator('input[name="file_submission"]', 15,
                    'Ukuran file submission melebihi batas 15 MB.');
                setupFileSizeValidator('input[name="file_ttdkanwil"]', 15,
                    'Ukuran file tanda tangan melebihi batas 15 MB.');
                setupFileSizeValidator('input[name="file_dokumpelaksanaan"]', 15,
                    'Ukuran file dokumen pelaksanaan melebihi batas 15 MB.');

                if (!isValid) {
                    e.preventDefault();
                    if (firstInvalid) firstInvalid.focus();
                }
            });
        });
    </script>

    <style>
        .step-form {
            transition: all 0.3s ease;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .progress {
            height: 10px;
            border-radius: 5px;
        }
    </style>
@endsection
