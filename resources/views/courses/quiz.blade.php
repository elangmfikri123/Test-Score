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
                                        <div
                                            class="card-header border-bottom d-flex justify-content-between align-items-center">
                                            <h5 id="question-title">Soal Nomor. {{ $questionNumber }}</h5>
                                            <label id="timer"
                                                class="label label-inverse-warning fw-bold px-4 py-2 text-dark"
                                                style="font-size: 1rem;"></label>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-block" id="question-content">
                                            <p>{{ $question->pertanyaan }}</p>
                                            <form>
                                                @foreach ($question->answers as $key => $answer)
                                                    <div class="form-check d-flex align-items-center mb-2">
                                                        <button type="button"
                                                            class="btn btn-outline-primary me-2 option-btn"
                                                            data-answer-id="{{ $answer->id }}"
                                                            data-question-id="{{ $question->id }}"
                                                            style="width: 40px; height: 40px; font-size: 16px; padding: 0;">
                                                            {{ chr(65 + $key) }}
                                                        </button>
                                                        <label class="form-check-label" style="cursor: pointer;">
                                                            {{ $answer->jawaban }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </form>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-footer " id="nav-buttons">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Soal Yang Sudah Terjawab</h5>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-block">
                                            <div class="container" style="max-height: 300px; overflow-y: auto;">
                                                <div class="row row-cols-1 gx-1 gy-1">
                                                    <!-- Ubah gx-1 gy-1 agar lebih rapi secara vertikal -->
                                                    @foreach ($questions as $i => $q)
                                                        @php
                                                            $isAnswered = \App\Models\PesertaAnswer::where(
                                                                'peserta_id',
                                                                auth()->user()->id ?? null,
                                                            )
                                                                ->where('question_id', $q->id ?? 0)
                                                                ->exists();
                                                        @endphp
                                                        <div class="col p-0 m-1">
                                                            <button
                                                                class="btn {{ $isAnswered ? 'btn-success' : 'btn-light' }} sidebar-soal-btn"
                                                                data-nomor="{{ $i + 1 }}"
                                                                style="width: 40px; height: 40px; font-size: 14px; padding: 0; margin: 2px;">
                                                                {{ $i + 1 }}
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-footer text-center">
                                            <button class="btn btn-primary mt-3">Akhiri Ujian <i
                                                    class="ion-archive"></i></button>
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
        let currentQuestion = {{ $questionNumber }};
        const totalQuestions = {{ $totalQuestions }};
        const pesertaCourseId = {{ $id }};
        const pesertaId = {{ auth()->user()->id }};
        const courseId = {{ $id }};
        const localStorageKey = "timer_ujian_" + pesertaId + "_" + pesertaCourseId;
        const durationMinutes = {{ $question->course->duration_minutes ?? 90 }};
        const timerElement = document.getElementById('timer');

        // Timer calculation functions
        function getRemainingTime() {
            const startTime = localStorage.getItem(localStorageKey);
            const now = Math.floor(Date.now() / 1000);
            if (startTime) {
                const elapsed = now - parseInt(startTime);
                const remaining = durationMinutes * 60 - elapsed;
                return remaining > 0 ? remaining : 0;
            } else {
                localStorage.setItem(localStorageKey, now);
                return durationMinutes * 60;
            }
        }

        let duration = getRemainingTime();

        function formatTime(seconds) {
            const hrs = String(Math.floor(seconds / 3600)).padStart(2, '0');
            const mins = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
            const secs = String(seconds % 60).padStart(2, '0');
            return `${hrs}:${mins}:${secs}`;
        }

        const countdown = setInterval(() => {
            duration--;
            if (duration <= 0) {
                clearInterval(countdown);
                alert("Waktu habis!");
                // redirect to submit
            }
            timerElement.textContent = formatTime(duration);
        }, 1000);

        // Load question dynamically with AJAX
        function loadQuestion(nomor) {
            $.get(`/exam/ajax/question/${pesertaCourseId}/${nomor}`, function(data) {
                console.log(data); // Tambahkan ini untuk mengecek respons
                currentQuestion = data.question_number;
                $('#question-title').text(`Soal Nomor. ${data.question_number}`);
                $('#question-content').html(generateSoalHTML(data));
                updateNavigationButtons(data);
                highlightSidebar(data.question_number);
            }).fail(function() {
                alert("Error loading question.");
            });
        }

        function updateNavigationButtons(data) {
            const nomor = data.question_number;
            let prevButton = '';
            let nextButton = '';

            if (nomor > 1) {
                prevButton = `<button onclick="loadQuestion(${nomor - 1})" class="btn btn-secondary">
            <i class="ion-chevron-left"></i> Sebelumnya</button>`;
            } else {
                prevButton = `<div></div>`; // Placeholder jika soal pertama
            }

            if (nomor < totalQuestions) {
                nextButton = `<button onclick="loadQuestion(${nomor + 1})" class="btn btn-primary">
            Selanjutnya <i class="ion-chevron-right"></i></button>`;
                console.log("Loading question number:", currentQuestion + 1);
            } else {
                nextButton = `<div></div>`; // Placeholder jika sudah mencapai soal terakhir
            }

            const navHtml = `
        <div class="d-flex justify-content-between w-100">
            <div>${prevButton}</div>
            <div>${nextButton}</div>
        </div>`;

            $('#nav-buttons').html(navHtml);
        }


        // Store the answer and reload the current question
        $(document).on('click', '.option-btn', function() {
            const answerId = $(this).data('answer-id');
            const questionId = $(this).data('question-id');

            $.post('/exam/ajax/answer', {
                peserta_id: pesertaId,
                question_id: questionId,
                answer_id: answerId,
                _token: '{{ csrf_token() }}'
            }, function(res) {
                console.log(res); // Log respons dari server untuk memastikan status jawaban
                loadQuestion(currentQuestion); // Memuat soal yang baru
                updateSidebarAnswers(); // Memperbarui status soal di sidebar setelah jawaban disimpan
            });
        });

        function generateSoalHTML(data) {
            let html = `<p>${data.pertanyaan}</p><form>`;
            data.answers.forEach((answer, index) => {
                const isSelected = answer.id === data.selected_answer_id ? 'btn-primary' : 'btn-outline-primary';
                html += `
                <div class="form-check d-flex align-items-center mb-2">
                    <button type="button" class="btn ${isSelected} me-2 option-btn" data-answer-id="${answer.id}" data-question-id="${data.question_id}"
                        style="width: 40px; height: 40px; font-size: 16px; padding: 0;">
                        ${String.fromCharCode(65 + index)}
                    </button>
                    <label class="form-check-label">${answer.jawaban}</label>
                </div>`;
            });
            html += `</form>`;
            return html;
        }

        // Sidebar question navigation
        $(document).on('click', '.sidebar-soal-btn', function() {
            const nomor = $(this).data('nomor');
            loadQuestion(nomor);
        });

        // Fungsi untuk memperbarui status soal yang sudah dijawab di sidebar
        function updateSidebarAnswers() {
            $.get(`/exam/ajax/answered-status/${pesertaId}/${courseId}`, function(data) {
                data.forEach(function(status) {
                    const button = $(`.sidebar-soal-btn[data-nomor=${status.nomor}]`);
                    if (status.is_answered) {
                        button.removeClass('btn-light').addClass('btn-success');
                    } else {
                        button.removeClass('btn-success').addClass('btn-light');
                    }
                });
            });
        }


        $(document).ready(function() {
            updateNavigationButtons({
                question_number: currentQuestion
            });
            updateSidebarAnswers(); // Memperbarui status soal yang sudah dijawab saat pertama kali halaman dimuat
        });
    </script>
@endsection
