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
                                                    <span class="messages text-danger" style="font-size: 0.7rem;"></span>
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
                                                    <small class="text-muted d-block mt-1">Maksimal ukuran file: 15 MB</small>
                                                    <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">File Submission Tanda Tangan(.pdf)
                                                    *</label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control"
                                                        name="file_ttdkanwil" accept=".pdf">
                                                    <small class="text-muted d-block mt-1">Maksimal ukuran file: 15 MB</small>
                                                    <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">File Submission Evidence Pelaksaan(.pdf) *</label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control" name="file_dokumpelaksanaan" accept=".pdf">
                                                    <small class="text-muted d-block mt-1">Maksimal ukuran file: 15 MB</small>
                                                    <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-success"><i class="ion-checkmark"></i> Submit</button>
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
            const urlFields = ['link_klhr1', 'link_klhr2', 'link_klhr3'];

            function getMessageEl(input) {
                return input.closest('.col-sm-9')?.querySelector('.messages') || null;
            }

            function isValidUrl(value) {
                try {
                    const url = new URL(value);
                    return ['http:', 'https:'].includes(url.protocol);
                } catch (e) {
                    return false;
                }
            }

            function showError(input, message) {
                input.classList.add('is-invalid');
                const messageEl = getMessageEl(input);
                if (messageEl) messageEl.textContent = message;
            }

            function clearError(input) {
                input.classList.remove('is-invalid');
                const messageEl = getMessageEl(input);
                if (messageEl) messageEl.textContent = '';
            }

            function validateInput(input) {
                const value = (input.value || '').trim();
                const isRequired = input.classList.contains('requiredform');
                const isUrlField = urlFields.includes(input.name);

                if (isRequired && !value) {
                    showError(input, 'Perlu diisi / Tidak boleh kosong.');
                    return false;
                }

                if (value && isUrlField && !isValidUrl(value)) {
                    showError(input, 'Format link tidak valid. Gunakan http:// atau https://');
                    return false;
                }

                clearError(input);
                return true;
            }

            function setupFileSizeValidator(selector, maxSizeMB, label) {
                $(selector).on('change', function() {
                    const file = this.files[0];
                    if (file && file.size / (1024 * 1024) > maxSizeMB) {
                        this.value = '';
                        this.classList.add('is-invalid');
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ukuran File Melebihi Batas',
                            text: `${label} maksimal ${maxSizeMB} MB.`,
                            confirmButtonText: 'OK'
                        });
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });
            }

            setupFileSizeValidator('input[name="file_submission"]', 15, 'File Submission');
            setupFileSizeValidator('input[name="file_ttdkanwil"]', 15, 'File Submission Tanda Tangan');
            setupFileSizeValidator('input[name="file_dokumpelaksanaan"]', 15, 'File Submission Evidence');

            form.querySelectorAll('input, select, textarea').forEach(input => {
                input.addEventListener('input', () => validateInput(input));
                input.addEventListener('change', () => validateInput(input));
            });

            form.addEventListener('submit', function(e) {
                let isValid = true;
                let firstInvalid = null;

                form.querySelectorAll('input, select, textarea').forEach(input => {
                    if (!validateInput(input)) {
                        isValid = false;
                        if (!firstInvalid) firstInvalid = input;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    firstInvalid?.focus();
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
