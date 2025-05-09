@extends('layout.templatecourse')
@section('title', 'Online-Quiz')
@section('content')
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-header m-t-50"></div>
                        <div class="page-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="card">
                                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                            {{-- Nomor Soal --}}
                                            <h5 id="question-number">Soal Nomor. </h5>
                                            <label id="timer" class="label label-inverse-warning fw-bold px-4 py-2 text-dark" style="font-size: 1rem;"></label>
                                        </div>                                                                               
                                        <hr class="m-0">
                                        {{-- Konten Soal --}}
                                        <div class="card-block">
                                            <p id="question-text">Loading Data Server...</p>
                                            <form id="quiz-form">
                                                <div id="answer-options"></div>
                                            </form>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-footer d-flex justify-content-between">
                                            <button id="btn-prev" class="btn btn-secondary"><i class="ion-chevron-left"></i> Sebelumnya</button>
                                            <button id="btn-next" class="btn btn-primary">Selanjutnya <i class="ion-chevron-right"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Jumlah Soal</h5>
                                            <div class="d-flex justify-content-between">
                                                <p><strong>Total Soal:</strong> 100</p>
                                                <p><strong>Sudah Dijawab:</strong> 3</p>
                                            </div>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-block">
                                        <!-- Bagian Kanan: Tanda Nomer Soal Sudah dikerjakan dan Dapat Diklik Mengarah ke Nomor Soal -->
                                            <div class="container" style="max-height: 300px; overflow-y: auto;">
                                                <div class="row row-cols-5 gx-1 gy-1" id="question-buttons">

                                                </div>
                                            </div>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-footer text-center">
                                            <button class="btn btn-primary mt-3">Akhiri Ujian <i class="ion-archive"></i></button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentQuestion = 1;
        const pesertaCourseId = {{ $pesertaCourse->id }};
        let answeredQuestions = {}; 
        function submitAnswer(answerId, btnElement) {
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
        }
        
        function loadQuestion(questionNumber) {
            $.get(`/exam/${pesertaCourseId}/${questionNumber}`, function (response) {
                if (response.status === 'success') {
                    answeredQuestions = response.answered_questions || {};
                    $('#question-number').text('Soal Nomor. ' + response.question_number);
                    $('#question-text').html(response.pertanyaan);

                    let answersHtml = '';
                    response.answers.forEach(answer => {
                        const isAnswered = response.selected_answer === answer.id;
                        answersHtml += `
                            <div class="d-flex align-items-center mb-2" style="min-height: 40px;">
                                <button type="button" class="btn ${isAnswered ? 'btn-primary text-white' : 'btn-outline-primary'} me-2" 
                                    style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;" 
                                    onclick="submitAnswer(${answer.id}, this)">
                                    ${answer.label}
                                </button>
                                <label class="form-check-label" for="option${answer.id}" style="cursor:pointer;">${answer.text}</label>
                                <input class="form-check-input d-none" type="radio" name="answer" id="option${answer.id}" value="${answer.id}">
                            </div>`;
                    });

                    $('#answer-options').html(answersHtml);
                    $('#btn-prev').prop('disabled', questionNumber === 1);
                    $('#btn-next').prop('disabled', questionNumber === response.total_questions);
                    renderQuestionButtons(response.total_questions);
                } else {
                    alert('Error: ' + response.message);
                }
            });
        }

        function renderQuestionButtons(total) {
            const container = $('#question-buttons');
            container.empty();

            for (let i = 1; i <= total; i++) {
                let btnClass = 'btn-light';
                const questionId = i;
                if (answeredQuestions[questionId]) {
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

        $(document).on('click', '#btn-prev', function () {
            if (currentQuestion > 1) {
                currentQuestion--;
                loadQuestion(currentQuestion);
            }
        });

        $(document).on('click', '#btn-next', function () {
            currentQuestion++;
            loadQuestion(currentQuestion);
        });

        $(document).on('click', '.question-btn', function () {
            const number = parseInt($(this).data('number'));
            currentQuestion = number;
            loadQuestion(number);
        });

        $(document).ready(function () {
            loadQuestion(currentQuestion);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        const pesertaCourseId = {{ $pesertaCourse->id }};
        const durationMinutes = {{ $pesertaCourse->course->duration_minutes }};
        const timerKey = `quiz_end_time_${pesertaCourseId}`;
        let endTime;

        if (localStorage.getItem(timerKey)) {
            endTime = parseInt(localStorage.getItem(timerKey));
        } else {
            endTime = new Date().getTime() + durationMinutes * 60 * 1000;
            localStorage.setItem(timerKey, endTime);
        }

        function updateTimer() {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance <= 0) {
                clearInterval(timerInterval);
                $('#timer').text('00:00:00');
                localStorage.removeItem(timerKey);
                Swal.fire({
                    title: 'Waktu Anda Habis',
                    text: 'Ujian telah selesai secara otomatis',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "/exam/finish/{{ $pesertaCourse->id }}";
                });

                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            $('#timer').text(
                `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`
            );
        }

        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer();
    });
</script>
@endsection
