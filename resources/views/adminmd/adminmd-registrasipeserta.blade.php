@extends('layout.template')
@section('title', 'Peserta List - Admin')
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
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 16.66%" aria-valuenow="16.66" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    
                                    <!-- Step Indicator -->
                                    <div class="d-flex justify-content-between mb-4">
                                        <span class="text-primary font-weight-bold">Step 1 of 4</span>
                                    </div>
                                    
                                    <!-- Form Step 1 -->
                                    <form id="registrationForm" class="step-form" data-step="1">
                                        @include('partials.step1')
                                        
                                        <!-- Tambahkan field lainnya sesuai kebutuhan -->
                                        
                                        <div class="text-right mt-4">
                                            <button type="button" class="btn btn-primary next-step">Next</button>
                                        </div>
                                    </form>
                                    
                                    <!-- Form Step 2 (akan ditampilkan melalui JavaScript) -->
                                    <form id="step2Form" class="step-form d-none" data-step="2">
                                        @include('partials.step2')
                                        <!-- Konten step 2 -->
                                        <div class="text-right mt-4">
                                            <button type="button" class="btn btn-secondary prev-step">Previous</button>
                                            <button type="button" class="btn btn-primary next-step">Next</button>
                                        </div>
                                    </form>
                                    
                                    <!-- Form Step 3 (akan ditampilkan melalui JavaScript) -->
                                    <form id="step3Form" class="step-form d-none" data-step="3">
                                        @include('partials.step3')
    
                                        <!-- Konten step 3 -->
                                        <div class="text-right mt-4">
                                            <button type="button" class="btn btn-secondary prev-step">Previous</button>
                                            <button type="button" class="btn btn-primary next-step">Next</button>
                                        </div>
                                    </form>
                                    
                                    <!-- Form Step 4 (akan ditampilkan melalui JavaScript) -->
                                    <form id="step4Form" class="step-form d-none" data-step="4">
                                        @include('partials.step4')
    
                                        <!-- Konten step 4 -->
                                        <div class="text-right mt-4">
                                            <button type="button" class="btn btn-secondary prev-step">Previous</button>
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>    
                            <!-- Deferred rendering for speed table end -->
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        
        $('.select2-init').select2({
            minimumResultsForSearch: 1 
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.step-form');
        const progressBar = document.querySelector('.progress-bar');
        const stepIndicator = document.querySelector('.d-flex.justify-content-between.mb-4 span');
        
        // Inisialisasi - pastikan hanya step 1 yang tampil
        document.getElementById('registrationForm').classList.remove('d-none');
        
        // Handle next step button
        document.querySelectorAll('.next-step').forEach(button => {
            button.addEventListener('click', function() {
                const currentForm = this.closest('.step-form');
                const currentStep = parseInt(currentForm.dataset.step);
                const nextStep = currentStep + 1;
                
                // Validasi form sebelum lanjut
                if (validateForm(currentForm)) {
                    // Sembunyikan semua form
                    forms.forEach(form => form.classList.add('d-none'));
                    
                    // Tampilkan form berikutnya
                    const nextForm = document.getElementById(`step${nextStep}Form`);
                    if (nextForm) {
                        nextForm.classList.remove('d-none');
                        
                        // Update progress bar
                        const progressPercentage = (nextStep / 4) * 100;
                        progressBar.style.width = `${progressPercentage}%`;
                        progressBar.setAttribute('aria-valuenow', progressPercentage);
                        
                        // Update step indicator
                        stepIndicator.textContent = `Step ${nextStep} of 4`;
                        
                        // Scroll ke atas form
                        window.scrollTo({top: 0, behavior: 'smooth'});
                    }
                }
            });
        });
        
        // Handle previous step button
        document.querySelectorAll('.prev-step').forEach(button => {
            button.addEventListener('click', function() {
                const currentForm = this.closest('.step-form');
                const currentStep = parseInt(currentForm.dataset.step);
                const prevStep = currentStep - 1;
                
                // Sembunyikan semua form
                forms.forEach(form => form.classList.add('d-none'));
                
                // Tampilkan form sebelumnya
                const prevForm = document.getElementById(prevStep === 1 ? 'registrationForm' : `step${prevStep}Form`);
                if (prevForm) {
                    prevForm.classList.remove('d-none');
                    
                    // Update progress bar
                    const progressPercentage = (prevStep / 4) * 100;
                    progressBar.style.width = `${progressPercentage}%`;
                    progressBar.setAttribute('aria-valuenow', progressPercentage);
                    
                    // Update step indicator
                    stepIndicator.textContent = `Step ${prevStep} of 4`;
                    
                    // Scroll ke atas form
                    window.scrollTo({top: 0, behavior: 'smooth'});
                }
            });
        });
        
        // Fungsi validasi form
        function validateForm(form) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                alert('Harap isi semua field yang wajib diisi!');
            }
            
            return isValid;
        }
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