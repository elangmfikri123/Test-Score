@extends('layout.template')
@section('title', 'Registrasi Peserta')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- Ajax data source (Arrays) table start -->
                                <div class="card w-100">
                                    <div class="card-header text-center">
                                        <h3><strong>Registrasi Peserta KLHN 2025</strong></h3>
                                    </div>
                                    <div class="card-block">
                                        <!-- Progress Bar -->
                                        <div class="progress mb-4">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 16.66%"
                                                aria-valuenow="16.66" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <!-- Step Indicator -->
                                        <div class="d-flex justify-content-between mb-4">
                                            <span class="text-primary font-weight-bold">Step 1 of 4</span>
                                        </div>
                                        <form id="step4Form" method="POST" enctype="multipart/form-data"
                                            action="{{ route('registrasi.store') }}">
                                            @csrf
                                            <div id="registrationForm" class="step-form" data-step="1">
                                                @include('partials.step1')
                                                <div class="text-right mt-4">
                                                    <button type="button" class="btn btn-primary next-step">Next</button>
                                                </div>
                                            </div>

                                            <div id="step2Form" class="step-form d-none" data-step="2">
                                                @include('partials.step2')
                                                <div class="text-right mt-4">
                                                    <button type="button"
                                                        class="btn btn-secondary prev-step">Previous</button>
                                                    <button type="button" class="btn btn-primary next-step">Next</button>
                                                </div>
                                            </div>

                                            <div id="step3Form" class="step-form d-none" data-step="3">
                                                @include('partials.step3')
                                                <div class="text-right mt-4">
                                                    <button type="button"
                                                        class="btn btn-secondary prev-step">Previous</button>
                                                    <button type="button" class="btn btn-primary next-step"
                                                        id="to-step4">Next</button>
                                                </div>
                                            </div>

                                            <div id="step4Container" class="step-form d-none" data-step="4">
                                                @include('partials.step4')

                                                <!-- Konten step 4 -->
                                                <div class="text-right mt-4">
                                                    <button type="button"
                                                        class="btn btn-secondary prev-step">Previous</button>
                                                    <button type="submit" class="btn btn-success">Submit</button>
                                                </div>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
function checkHondaIdEmail() {
        const hondaId = $('input[name="honda_id"]').val();
        const email = $('input[name="email"]').val();

        return new Promise((resolve, reject) => {
            $.ajax({
                url: '{{ route("check.hondaid.email") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    honda_id: hondaId,
                    email: email
                },
                success: function (response) {
                    if (response.honda_id_exists || response.email_exists) {
                        if (response.honda_id_exists) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Honda ID sudah terdaftar',
                                text: 'Silakan gunakan Honda ID lain.',
                                confirmButtonText: 'OK'
                            });
                        }

                        if (response.email_exists) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Email sudah terdaftar',
                                text: 'Silakan gunakan email lain.',
                                confirmButtonText: 'OK'
                            });
                        }

                        resolve(false);
                    } else {
                        resolve(true);
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        text: 'Gagal mengecek email dan Honda ID.',
                        confirmButtonText: 'OK'
                    });
                    reject();
                }
            });
        });
    }
        </script>
        
    <script>
        $(document).ready(function() {
            $('.select2-init').select2({
                minimumResultsForSearch: 1
            });

            const hiddenCategoryNames = [
                'Team Leader',
                'Pimpinan Jaringan',
                'Customer Relation Officer'
            ];
            const categoryMapping = {
                @foreach ($categories as $category)
                    {{ $category->id }}: "{{ $category->namacategory }}",
                @endforeach
            };

            //Simpelkan
            function toggleProjectFields() {
                const selectedId = $('#category_id').val();
                const selectedName = categoryMapping[selectedId];
                const projectFields = $('#project_fields');
                const inputs = projectFields.find('input, select, textarea');

                if (hiddenCategoryNames.includes(selectedName)) {
                    projectFields.show();
                    inputs.addClass('requiredform');

                            // Kondisi khusus: jika Team Leader, sembunyikan dan disable Tahun Pembuatan
                        if (selectedName === 'Team Leader') {
                            const tahunPembuatanInput = $('input[name="tahun_pembuatan_project"]');
                            tahunPembuatanInput.closest('.form-group').hide();
                            tahunPembuatanInput.removeClass('requiredform is-invalid');
                            tahunPembuatanInput.siblings('.messages').text('');
                            tahunPembuatanInput.val('');
                        } else {
                            $('input[name="tahun_pembuatan_project"]').closest('.form-group').show();
                        }
                } else {
                    projectFields.hide();
                    clearProjectFields();
                    inputs.removeClass('requiredform is-invalid');
                    inputs.siblings('.messages').text('');
                }
            }

            function toggleTemplateLinks() {
                const selectedId = $('#category_id').val();
                const selectedName = categoryMapping[selectedId];
                $('.template-download').hide();

                if (selectedName === 'Team Leader') {
                    $('#template-tl').show();
                } else if (selectedName === 'Pimpinan Jaringan') {
                    $('#template-pj').show();
                } else if (selectedName === 'Customer Relation Officer') {
                    $('#template-cro').show();
                }
            }

            function clearProjectFields() {
                $('input[name="judul_project"]').val('');
                $('input[name="tahun_pembuatan_project"]').val('');
                $('input[name="file_project"]').val('');
                $('input[name="file_lampiranklhn"]').val('');
            }
            $('#category_id').on('change', function() {
                toggleProjectFields();
                toggleTemplateLinks();
            });

            $('#to-step4').on('click', function() {
                toggleProjectFields();
                toggleTemplateLinks();
            });
            toggleProjectFields();
            toggleTemplateLinks();
        });

        //Alert Maksimum File
        $(document).ready(function() {
            function setupFileSizeValidator(selector, maxSizeMB, message) {
                $(selector).on('change', function() {
                    const file = this.files[0];
                    if (file && file.size / (1024 * 1024) > maxSizeMB) {
                        alert(message);
                        this.value = '';
                    }
                });
            }
            setupFileSizeValidator('input[name="file_project"]', 50,
                'Ukuran file project terlalu besar. Maksimum 50 MB.');
            setupFileSizeValidator('input[name="foto_profil"]', 5,
                'Ukuran file foto profil terlalu besar. Maksimum 5 MB.');
            setupFileSizeValidator('input[name="ktp"]', 5, 'Ukuran file KTP terlalu besar. Maksimum 5 MB.');
            setupFileSizeValidator('input[name="file_lampiranklhn"]', 50,
                'Ukuran file lampiran terlalu besar. Maksimum 50 MB.');
        });
    </script>

    <script>
        let riwayatCount = 1;
        const maxRiwayat = 3;
        document.getElementById('add-riwayat-klhn').addEventListener('click', function() {
            if (riwayatCount >= maxRiwayat) {
                alert('Maksimal hanya 3 riwayat yang dapat ditambahkan.');
                return;
            }

            const riwayatContainer = document.getElementById('riwayat-klhn-container');
            const newRiwayat = `
        <div class="form-group row riwayat-klhn">
            <label class="col-sm-3 col-form-label">Tahun Keikutsertaan KLHN Periode Sebelumnya</label>
            <div class="col-sm-9">
                <input type="number" class="form-control" placeholder="Masukkan Tahun" name="riwayat_klhn[${riwayatCount}][tahun_keikutsertaan]">
            </div>
        </div>
        <div class="form-group row riwayat-klhn">
            <label class="col-sm-3 col-form-label">Kategori</label>
            <div class="col-sm-9">
                <select class="form-control select2-init" name="riwayat_klhn[${riwayatCount}][vcategory]">
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->namacategory }}">{{ $category->namacategory }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row riwayat-klhn mb-3">
            <label class="col-sm-3 col-form-label">Status Kepesertaan</label>
            <div class="col-sm-9">
                <select class="form-control select2-init" name="riwayat_klhn[${riwayatCount}][status_kepesertaan]">
                    <option value="" disabled selected>Pilih Status</option>
                    <option value="Peserta">Peserta</option>
                    <option value="Juara 1">Juara 1</option>
                    <option value="Juara 2">Juara 2</option>
                    <option value="Juara 3">Juara 3</option>
                </select>
            </div>
        </div>
    `;
            riwayatContainer.insertAdjacentHTML('beforeend', newRiwayat);
            riwayatCount++;
        });

        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.step-form');
            const progressBar = document.querySelector('.progress-bar');
            const stepIndicator = document.querySelector('.d-flex.justify-content-between.mb-4 span');

            document.getElementById('registrationForm').classList.remove('d-none');

            document.querySelectorAll('.next-step').forEach(button => {
                button.addEventListener('click', async function () {
                    const currentForm = this.closest('.step-form');
                    const currentStep = parseInt(currentForm.dataset.step);
                    const nextStep = currentStep + 1;

                    if (currentStep === 1) {
        const isValidHonda = await checkHondaIdEmail();
        if (!isValidHonda) return; // Hentikan proses next
    }

                    if (validateForm(currentForm)) {
                        forms.forEach(form => form.classList.add('d-none'));

                        const nextForm = document.querySelector(
                            `.step-form[data-step="${nextStep}"]`);
                        if (nextForm) {
                            nextForm.classList.remove('d-none');

                            const progressPercentage = (nextStep / 4) * 100;
                            progressBar.style.width = `${progressPercentage}%`;
                            progressBar.setAttribute('aria-valuenow', progressPercentage);

                            stepIndicator.textContent = `Step ${nextStep} of 4`;

                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            });

            document.querySelectorAll('.prev-step').forEach(button => {
                button.addEventListener('click', function() {
                    const currentForm = this.closest('.step-form');
                    const currentStep = parseInt(currentForm.dataset.step);
                    const prevStep = currentStep - 1;

                    forms.forEach(form => form.classList.add('d-none'));

                    const prevForm = document.getElementById(prevStep === 1 ? 'registrationForm' :
                        `step${prevStep}Form`);
                    if (prevForm) {
                        prevForm.classList.remove('d-none');

                        const progressPercentage = (prevStep / 4) * 100;
                        progressBar.style.width = `${progressPercentage}%`;
                        progressBar.setAttribute('aria-valuenow', progressPercentage);

                        stepIndicator.textContent = `Step ${prevStep} of 4`;

                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            function validateForm(form) {
                let isValid = true;
                let firstInvalidInput = null;

                form.querySelectorAll('.requiredform').forEach(input => {
                    const value = input.value.trim();
                    const messageEl = input.parentElement.querySelector('.messages');

                    if (!value) {
                        input.classList.add('is-invalid');
                        if (messageEl) messageEl.textContent = 'Perlu diisi / Tidak boleh kosong.';
                        if (!firstInvalidInput) firstInvalidInput = input;
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                        if (messageEl) messageEl.textContent = '';
                    }
                });
                if (!isValid && firstInvalidInput) {
                    firstInvalidInput.focus();
                    window.scrollTo({
                        top: firstInvalidInput.getBoundingClientRect().top + window.scrollY - 100,
                        behavior: 'smooth'
                    });
                }
                return isValid;
            }

            document.getElementById('step4Form').addEventListener('submit', function(e) {
                let isValid = true;
                const requiredFields = this.querySelectorAll('.requiredform');

                requiredFields.forEach(function(field) {
                    const value = field.value.trim();
                    const messageSpan = field.closest('.col-sm-9').querySelector('.messages');

                    if (!value) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        if (messageSpan) {
                            messageSpan.textContent = 'Wajib diisi.';
                        }
                    } else {
                        field.classList.remove('is-invalid');
                        if (messageSpan) {
                            messageSpan.textContent = '';
                        }
                    }
                });

                if (!isValid) {
                    e.preventDefault(); 
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
