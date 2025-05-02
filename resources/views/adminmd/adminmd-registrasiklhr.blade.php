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
                                        <h3><strong>Submission KLHR</strong></h3>
                                    </div>
                                    <hr class="m-0">
                                    <div class="card-block">
                                        <form id="step4Form" action="{{ route('submission.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Main Dealer *</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control requiredform select2-init"
                                                        name="maindealer_id">
                                                        <option value="" disabled selected>Pilih Main Dealer</option>
                                                        @foreach ($mainDealers as $row)
                                                            <option value="{{ $row->id }}">{{ $row->kodemd }} -
                                                                {{ $row->nama_md }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Link Publikasi KLHR 1 *</label>
                                                <div class="col-sm-9">
                                                    <input type="url" class="form-control requiredform"
                                                        name="link_klhr1" placeholder="Link publikasi KLHR">
                                                    <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Link Publikasi KLHR 2</label>
                                                <div class="col-sm-9">
                                                    <input type="url" class="form-control" name="link_klhr2"
                                                        placeholder="Link publikasi KLHR">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Link Publikasi KLHR 3</label>
                                                <div class="col-sm-9">
                                                    <input type="url" class="form-control" name="link_klhr3"
                                                        placeholder="Link publikasi KLHR">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label"></label>
                                                <div class="col-sm-9">
                                                    <i class="feather icon-file" style="italic"></i><em><a
                                                            href="https://docs.google.com/spreadsheets/d/19d5IDyn23V8-Jlk0JyNVrxXzuapCZdl5/edit?usp=drive_link&ouid=106276902669714169102&rtpof=true&sd=true"
                                                            target="_blank">Download Template File Submission</a></em>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">File Submission (.xlsx) *</label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control requiredform"
                                                        name="file_submission" accept=".xlsx,.xls">
                                                    <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">File Submission Tanda Tangan (.pdf)
                                                    *</label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control requiredform"
                                                        name="file_ttdkanwil" accept=".pdf">
                                                    <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label"></label>
                                                <div class="col-sm-9">
                                                    <i class="feather icon-file" style="italic"></i><em><a
                                                            href="https://docs.google.com/presentation/d/1iviSSpHTpEkjCIHSvp7RCzktj5Fjp7kC/edit?usp=drive_link&ouid=106276902669714169102&rtpof=true&sd=true"
                                                            target="_blank">Download Template File Submission
                                                            Evidence</a></em>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">File Submission Evidence Pelaksaan
                                                    (.pdf) *</label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control requiredform"
                                                        name="file_dokumpelaksanaan" accept=".pdf">
                                                    <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-success"><i class="ion-checkmark"></i>
                                                    Submit</button>
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
