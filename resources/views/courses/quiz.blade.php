@extends('layout.templatecourse')
@section('title', 'Online-Quiz')
@section('content')
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper px-1"> {{-- Tambah padding kecil kanan-kiri --}}
                        <div class="page-header m-t-50"></div>
                        <div class="page-body">
                            <div class="row gx-1"> {{-- Hapus jarak gutter default --}}
                                <div class="col-12 col-md-9 mb-2"> {{-- Full width di mobile --}}
                                    <div class="card">
                                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                            <h5 id="question-number">Soal Nomor. </h5>
                                            <label id="timer" class="label label-inverse-warning fw-bold px-4 py-2 text-dark" style="font-size: 1rem;"></label>
                                        </div>                                                                               
                                        <hr class="m-0">
                                        <div class="card-block" style="overflow-y: auto; max-height: 400px;">
                                            <p id="question-text">Memuat data dari server...</p>
                                            <form id="quiz-form">
                                                <div id="answer-options"></div>
                                            </form>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-footer d-flex justify-content-between">
                                            <button id="btn-prev" class="btn btn-secondary btn-sm"><i class="ion-chevron-left"></i>Previous</button>
                                            <button id="btn-next" class="btn btn-warning btn-sm">Next <i class="ion-chevron-right"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-3 mb-2"> {{-- Full width di mobile --}}
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between">
                                                <p>Total Soal : <strong id="total-questions">-</strong></p>
                                                <p>Sudah Dijawab : <strong id="answered-count">-</strong></p>
                                            </div>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-block">
                                            <div class="container" style="max-height: 300px; overflow-y: auto;">
                                                <div class="row row-cols-5 gx-1 gy-1" id="question-buttons">

                                                </div>
                                            </div>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-footer text-center">
                                            <button class="btn btn-primary btn-sm submit">Submit <i class="fa fa-save"></i></button>
                                        </div>
                                    </div>
                                </div>

                            </div> {{-- row --}}
                        </div> {{-- page-body --}}
                    </div> {{-- page-wrapper --}}
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentQuestion = 1;
        const pesertaCourseId = {{ $pesertaCourse->id }};
        const durationMinutes = {{ $pesertaCourse->course->duration_minutes }};
        const timerKey = `quiz_end_time_${pesertaCourseId}`;
        let answeredQuestions = {}; 
        let endTime;
        let totalQuestions = 0;
    
        // TIMER START
        if (localStorage.getItem(timerKey)) {
            endTime = parseInt(localStorage.getItem(timerKey));
        } else {
            endTime = new Date().getTime() + durationMinutes * 60 * 1000;
            localStorage.setItem(timerKey, endTime);
        }
    
        // Fungsi untuk menghitung sisa waktu
        function getRemainingTime() {
            const now = new Date().getTime();
            return Math.max(0, endTime - now);
        }
    
        // Format waktu menjadi HH:MM:SS
        function formatTime(ms) {
            const hours = Math.floor(ms / (1000 * 60 * 60));
            const minutes = Math.floor((ms % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((ms % (1000 * 60)) / 1000);
            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }
    
        // Update timer setiap detik
        function updateTimer() {
            const remaining = getRemainingTime();
            if (remaining <= 0) {
                clearInterval(timerInterval);
                $('#timer').text('00:00:00');
                localStorage.removeItem(timerKey);
                Swal.fire({
                    title: 'Waktu Anda Habis',
                    text: 'Ujian akan diakhiri otomatis.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then(() => {
                    selesaikanUjian();
                });
            } else {
                $('#timer').text(formatTime(remaining));
            }
        }
    
        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer();

        // Fungsi untuk menyimpan jawaban
        function simpanJawaban(answerId, btnElement) {
            $('#answer-options .btn').removeClass('btn-primary text-white').addClass('btn-outline-primary');
            $(btnElement).removeClass('btn-outline-primary').addClass('btn-primary text-white');
            answeredQuestions[currentQuestion] = answerId;
    
            $.post(`/exam/answer`, {
                _token: '{{ csrf_token() }}',
                peserta_course_id: pesertaCourseId,
                question_number: currentQuestion,
                answer_id: answerId
            }, function(response) {
                if (response.status !== 'success') {
                    alert(response.message);
                }
            });
    
            $(`.question-btn[data-number="${currentQuestion}"]`)
                .removeClass('btn-light')
                .addClass('btn-success');
                
            updateAnsweredCount();
        }
    
        // Fungsi untuk memuat soal
        function muatSoal(questionNumber) {
            $.get(`/exam/${pesertaCourseId}/${questionNumber}`, function (response) {
                if (response.status === 'success') {
                    answeredQuestions = response.answered_questions || {};
                    totalQuestions = response.total_questions;
                    $('#question-number').text('Soal Nomor. ' + response.question_number);
                    $('#question-text').html(response.pertanyaan);
    
                    let answersHtml = '';
                    response.answers.forEach(answer => {
                        const isAnswered = response.selected_answer === answer.id;
                        answersHtml += `
                            <div class="d-flex align-items-center mb-2" style="min-height: 40px;">
                                <button type="button" class="btn ${isAnswered ? 'btn-primary text-white' : 'btn-outline-primary'} me-2" 
                                    style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;" 
                                    onclick="simpanJawaban(${answer.id}, this)">
                                    ${answer.label}
                                </button>
                                <label class="form-check-label" for="option${answer.id}" style="cursor:pointer;">${answer.text}</label>
                                <input class="form-check-input d-none" type="radio" name="answer" id="option${answer.id}" value="${answer.id}">
                            </div>`;
                    });
    
                    $('#answer-options').html(answersHtml);
                    $('#btn-prev').prop('disabled', questionNumber === 1);
                    $('#btn-next').prop('disabled', questionNumber === response.total_questions);
                    $('#total-questions').text(response.total_questions);
                    updateAnsweredCount();
                    renderTombolSoal(response.total_questions);
                } else {
                    alert('Error: ' + response.message);
                }
            });
        }
    
        // Fungsi untuk memperbarui jumlah jawaban yang sudah diisi
        function updateAnsweredCount() {
            const answeredCount = Object.keys(answeredQuestions).length;
            $('#answered-count').text(answeredCount);
        }
    
        // Fungsi untuk menampilkan tombol navigasi soal
        function renderTombolSoal(total) {
            const container = $('#question-buttons');
            container.empty();
    
            for (let i = 1; i <= total; i++) {
                let btnClass = 'btn-light';
                if (answeredQuestions[i]) {
                    btnClass = 'btn-success';
                }
                container.append(`
                    <div class="col p-0 m-1">
                        <button 
                            class="btn ${btnClass} d-flex align-items-center justify-content-center question-btn" 
                            data-number="${i}"
                            style="width: 40px; height: 40px; font-size: 14px; padding: 0; margin: 2px;">
                            ${i}
                        </button>
                    </div>
                `);
            }
        }
        
        // Fungsi untuk menyelesaikan ujian
        function selesaikanUjian() {
            const remainingTime = getRemainingTime();
            const sisa_waktu = formatTime(remainingTime); 

            $.ajax({
                url: `/exam/finish/${pesertaCourseId}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    sisa_waktu: sisa_waktu
                },
                success: function(response) {
                    if (response.status === 'success') {
                        localStorage.removeItem(timerKey);
                        window.location.href = "/finished/exam/{{ $pesertaCourse->id }}";
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Gagal mengakhiri ujian.', 'error');
                }
            });
        }
        
        // Fungsi untuk memeriksa soal yang belum dijawab
        function cekSoalBelumTerjawab() {
            const belumTerjawab = [];
            for (let i = 1; i <= totalQuestions; i++) {
                if (!answeredQuestions[i]) {
                    belumTerjawab.push(i);
                }
            }
            return belumTerjawab;
        }
        
        // Fungsi untuk menampilkan peringatan soal yang terlewat
        function tampilkanPeringatanSoalTerlewat(belumTerjawab) {
            Swal.fire({
                    title: 'Ada Soal Yang Belum Terjawab',
                    text: 'Anda masih memiliki soal yang belum dijawab: ' + belumTerjawab.join(', '),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Submit!',
            }).then((result) => {
                if (result.isConfirmed) {
                    tampilkanKonfirmasiAkhir();
                }
            });
        }
        
        // Fungsi untuk menampilkan konfirmasi akhir
        function tampilkanKonfirmasiAkhir() {
            Swal.fire({
                    title: 'Apakah Anda yakin ?',
                    text: 'Apakah Anda yakin ingin mengakhiri ujian ini? Semua jawaban akan disimpan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Submit!'
            }).then((result) => {
                if (result.isConfirmed) {
                    selesaikanUjian();
                }
            });
        }

        // Event handler untuk tombol navigasi
        $(document).on('click', '#btn-prev', function () {
            if (currentQuestion > 1) {
                currentQuestion--;
                muatSoal(currentQuestion);
            }
        });
    
        $(document).on('click', '#btn-next', function () {
            currentQuestion++;
            muatSoal(currentQuestion);
        });
    
        $(document).on('click', '.question-btn', function () {
            const number = parseInt($(this).data('number'));
            currentQuestion = number;
            muatSoal(number);
        });
    
        $(document).ready(function () {
            muatSoal(currentQuestion);
    
            $('.btn-primary.submit').on('click', function () {
                const belumTerjawab = cekSoalBelumTerjawab();
                
                if (belumTerjawab.length > 0) {
                    tampilkanPeringatanSoalTerlewat(belumTerjawab);
                } else {
                    tampilkanKonfirmasiAkhir();
                }
            });
        });
    </script>
@endsection