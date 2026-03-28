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
                                <div class="card w-100">
                                    <div class="card-header text-center">
                                        <h3><strong>Registrasi Peserta KLHN 2026</strong></h3>
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
                                            <input type="hidden" name="peserta_id" id="peserta_id" value="">
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
                                                <div class="d-flex justify-content-between align-items-center mt-4">
                                                    <small id="draft-status" class="text-muted">Draft belum disimpan</small>
                                                    <div>
                                                    <button type="button" class="btn btn-warning" id="save-draft-btn">Simpan Draft</button>
                                                    <button type="button"
                                                        class="btn btn-secondary prev-step">Previous</button>
                                                    <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
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
        const pesertaId = $('#peserta_id').val();

        return new Promise((resolve, reject) => {
            $.ajax({
                url: '{{ route("check.hondaid.email") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    honda_id: hondaId,
                    email: email,
                    peserta_id: pesertaId
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
                'Dealer AHASS Head',
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
                } else if (selectedName === 'Dealer AHASS Head') {
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
            function setupFileSizeValidator(selector, maxSizeMB, label) {
                $(selector).on('change', function() {
                    const file = this.files[0];
                    if (file && file.size / (1024 * 1024) > maxSizeMB) {
                        this.value = '';
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ukuran File Melebihi Batas',
                            text: `${label} maksimal ${maxSizeMB} MB.`,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
            setupFileSizeValidator('input[name="file_project"]', 50,
                'File project');
            setupFileSizeValidator('input[name="foto_profil"]', 5,
                'Foto profil');
            setupFileSizeValidator('input[name="ktp"]', 5, 'File KTP');
            setupFileSizeValidator('input[name="file_lampiranklhn"]', 20,
                'File lampiran');
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
            const allInputs = document.querySelectorAll('#step4Form input, #step4Form select, #step4Form textarea');
            const urlFields = [
                'link_facebook',
                'link_instagram',
                'link_tiktok',
                'link_google_business',
                'link_facebook_dealer',
                'link_instagram_dealer',
                'link_tiktok_dealer'
            ];

            function getMessageEl(input) {
                const container = input.closest('.col-sm-9') || input.closest('.form-check');
                return container ? container.querySelector('.messages') : null;
            }

            function isVisible(input) {
                return input.offsetParent !== null && !input.closest('.d-none');
            }

            function isValidUrl(value) {
                try {
                    const parsed = new URL(value);
                    return ['http:', 'https:'].includes(parsed.protocol);
                } catch (e) {
                    return false;
                }
            }

            function showError(input, message) {
                if (input.type !== 'checkbox') {
                    input.classList.add('is-invalid');
                }
                const messageEl = getMessageEl(input);
                if (messageEl) messageEl.textContent = message;
            }

            function clearError(input) {
                if (input.type !== 'checkbox') {
                    input.classList.remove('is-invalid');
                }
                const messageEl = getMessageEl(input);
                if (messageEl) messageEl.textContent = '';
            }

            function validateField(input, enforceRequired = false) {
                if (!isVisible(input)) {
                    clearError(input);
                    return true;
                }

                const rawValue = (input.value || '').trim();
                const isRequired = input.classList.contains('requiredform');
                const value = input.type === 'checkbox' ? (input.checked ? 'checked' : '') : rawValue;

                if (enforceRequired && isRequired && !value) {
                    showError(input, 'Perlu diisi / Tidak boleh kosong.');
                    return false;
                }

                if (rawValue && (input.type === 'url' || urlFields.includes(input.name)) && !isValidUrl(rawValue)) {
                    showError(input, 'Format link tidak valid. Gunakan http:// atau https://');
                    return false;
                }

                clearError(input);
                return true;
            }

            function validateForm(form, enforceRequired = true) {
                let firstInvalidInput = null;
                let isValid = true;

                form.querySelectorAll('.requiredform, input[type="url"]').forEach(input => {
                    if (!validateField(input, enforceRequired)) {
                        isValid = false;
                        if (!firstInvalidInput) firstInvalidInput = input;
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

            allInputs.forEach(input => {
                input.addEventListener('input', () => validateField(input, false));
                input.addEventListener('change', () => validateField(input, false));
            });

            document.getElementById('registrationForm').classList.remove('d-none');

            document.querySelectorAll('.next-step').forEach(button => {
                button.addEventListener('click', async function () {
                    const currentForm = this.closest('.step-form');

                    const currentStep = parseInt(currentForm.dataset.step);
                    const nextStep = currentStep + 1;
                    forms.forEach(form => form.classList.add('d-none'));

                    const nextForm = document.querySelector(`.step-form[data-step="${nextStep}"]`);
                    if (nextForm) {
                        nextForm.classList.remove('d-none');

                        const progressPercentage = (nextStep / 4) * 100;
                        progressBar.style.width = `${progressPercentage}%`;
                        progressBar.setAttribute('aria-valuenow', progressPercentage);
                        stepIndicator.textContent = `Step ${nextStep} of 4`;

                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                    await saveDraft(false, true);
                });
            });

            document.querySelectorAll('.prev-step').forEach(button => {
                button.addEventListener('click', async function() {
                    const currentForm = this.closest('.step-form');
                    const currentStep = parseInt(currentForm.dataset.step);
                    const prevStep = currentStep - 1;

                    forms.forEach(form => form.classList.add('d-none'));

                    const prevForm = document.getElementById(prevStep === 1 ? 'registrationForm' : `step${prevStep}Form`);
                    if (prevForm) {
                        prevForm.classList.remove('d-none');

                        const progressPercentage = (prevStep / 4) * 100;
                        progressBar.style.width = `${progressPercentage}%`;
                        progressBar.setAttribute('aria-valuenow', progressPercentage);
                        stepIndicator.textContent = `Step ${prevStep} of 4`;

                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                    await saveDraft(false, true);
                });
            });

            document.getElementById('step4Form').addEventListener('submit', async function(e) {
                e.preventDefault();

                if (!validateForm(this, true)) return;

                const isValidHonda = await checkHondaIdEmail();
                if (!isValidHonda) return;

                this.submit();
            });
        });
    </script>

    <script>
        const draftStatusEl = document.getElementById('draft-status');
        let draftTimer = null;

        function setDraftStatus(text, isError = false) {
            if (!draftStatusEl) return;
            draftStatusEl.textContent = text;
            draftStatusEl.classList.toggle('text-danger', isError);
            draftStatusEl.classList.toggle('text-muted', !isError);
        }

        function scheduleDraftSave(includeFiles) {
            if (draftTimer) clearTimeout(draftTimer);
            draftTimer = setTimeout(() => saveDraft(includeFiles, true), 1200);
        }

        function hasMinimumDraftFields(form) {
            const hondaId = (form.querySelector('[name="honda_id"]')?.value || '').trim();
            const nama = (form.querySelector('[name="nama"]')?.value || '').trim();
            const maindealer = (form.querySelector('[name="maindealer_id"]')?.value || '').trim();
            return hondaId !== '' && nama !== '' && maindealer !== '';
        }

        function saveDraft(includeFiles, silent = false) {
            const form = document.getElementById('step4Form');
            if (!form) return Promise.resolve(false);

            if (!hasMinimumDraftFields(form)) {
                if (!silent) {
                    setDraftStatus('Honda ID, Nama, dan Main Dealer wajib diisi untuk draft.', true);
                }
                return Promise.resolve(false);
            }

            const formData = new FormData(form);
            if (!includeFiles) {
                form.querySelectorAll('input[type="file"]').forEach(input => {
                    if (input.name) formData.delete(input.name);
                });
            }

            if (!silent) {
                setDraftStatus('Menyimpan draft...');
            }

            return new Promise((resolve) => {
                $.ajax({
                    url: '{{ route("registrasi.draft") }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response && response.peserta_id) {
                            $('#peserta_id').val(response.peserta_id);
                        }
                        setDraftStatus('Draft tersimpan');
                        resolve(true);
                    },
                    error: function (xhr) {
                        const msg = xhr?.responseJSON?.message || 'Gagal menyimpan draft';
                        setDraftStatus(msg, true);
                        resolve(false);
                    }
                });
            });
        }

        $(document).ready(function () {
            const $form = $('#step4Form');
            function clearAllValidationUI() {
                const formEl = document.getElementById('step4Form');
                if (!formEl) return;
                formEl.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                formEl.querySelectorAll('.messages').forEach(el => el.textContent = '');
            }

            $form.on('input', 'input[type="text"], input[type="number"], input[type="date"], input[type="email"], input[type="url"], textarea', function () {
                scheduleDraftSave(false);
            });
            $form.on('change', 'select, input[type="checkbox"], input[type="radio"]', function () {
                scheduleDraftSave(false);
            });
            $form.on('change', 'input[type="file"]', function () {
                scheduleDraftSave(false);
            });
            $('#save-draft-btn').on('click', async function () {
                clearAllValidationUI();
                const formEl = document.getElementById('step4Form');
                if (!hasMinimumDraftFields(formEl)) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Field Draft Wajib',
                        text: 'Honda ID, Nama, dan Main Dealer wajib diisi sebelum simpan draft.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                const ok = await saveDraft(false, false);
                if (!ok) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan Draft',
                        text: draftStatusEl?.textContent || 'Silakan coba lagi.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Draft Disimpan',
                    text: 'Draft tersimpan dan akan diarahkan ke daftar peserta.',
                    timer: 1400,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = '{{ route("list.peserta") }}';
                });
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
