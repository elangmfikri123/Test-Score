@extends('layout.template')
@section('title', 'Edit Course Questions')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">

                            {{-- DETAIL COURSE --}}
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5><i class="feather icon-edit"></i> Edit Soal</h5>
                                </div>
                                <div class="card-block">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Nama Ujian</th>
                                            <td>{{ $course->namacourse }}</td>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <td>{{ $course->category->namacategory }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            {{-- FORM EDIT --}}
                            <div class="card">
                                <form action="{{ url('/admin/exams/question-update/' . $question->id) }}" method="POST" id="questionForm">
                                    @csrf
                                    <div class="card-block">

                                        {{-- Soal --}}
                                        <table class="table table-bordered">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th class="text-center">Question</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <textarea class="form-control soal-editor" name="deskripsi">{!! $question->pertanyaan !!}</textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        {{-- Jawaban --}}
                                        <table class="table table-bordered" id="jawabanTable">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th class="text-center">Pilihan</th>
                                                    <th class="text-center">Answers</th>
                                                    <th class="text-center">Koreksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($question->answers as $i => $answer)
                                                <tr style="{{ $answer->is_correct ? 'background-color: #D4EDDA;' : '' }}">
                                                    <th>Pilihan {{ chr(65 + $i) }}</th>
                                                    <td>
                                                        <textarea class="form-control jawaban-editor" name="jawaban[]">{!! $answer->jawaban !!}</textarea>
                                                        @if($i >= 4) {{-- Show remove button for E onwards --}}
                                                        <button type="button" class="btn btn-danger btn-sm removeAnswer mt-2">
                                                            <i class="ion-trash-a"></i> Delete
                                                        </button>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="checkbox" class="is_correct" value="{{ $i }}" {{ $answer->is_correct ? 'checked' : '' }}>
                                                        @if($answer->is_correct)
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function() {
                                                                document.querySelector('input[name="is_correct[{{ $i }}]"]').closest('tr').style.backgroundColor = "#D4EDDA";
                                                            });
                                                        </script>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div id="isCorrectInputs"></div>

                                        <button type="button" class="btn btn-sm btn-primary" id="addAnswer">
                                            <i class="icofont icofont-plus"></i> Add Option
                                        </button>

                                        <div class="text-right mt-3">
                                            <button type="submit" class="btn btn-success">
                                                <i class="ion-checkmark"></i> Update
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- TINYMCE --}}
                            <script src="https://cdn.tiny.cloud/1/2tvyzqqps6o97w5bncqfwpavklp6rlv7mx7voja1cst93eub/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
                            <script>
                                let answerIndex = {{ count($question->answers) }};
                                const abjad = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');

                                function initTinyMCE(selector = '.soal-editor, .jawaban-editor') {
                                    tinymce.init({
                                        selector,
                                        height: 250,
                                        menubar: false,
                                        resize: false,
                                        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
                                        toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | preview code | image',
                                        automatic_uploads: true,
                                        images_upload_url: '{{ route("image.upload") }}',
                                        images_upload_credentials: true,
                                        file_picker_types: 'image',
                                        file_picker_callback: function(callback, value, meta) {
                                            var input = document.createElement('input');
                                            input.setAttribute('type', 'file');
                                            input.setAttribute('accept', 'image/*');
                                            input.click();
                                            input.onchange = function() {
                                                var file = input.files[0];
                                                var formData = new FormData();
                                                formData.append('file', file);

                                                fetch('{{ route("image.upload") }}', {
                                                    method: 'POST',
                                                    headers: {
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    },
                                                    body: formData
                                                })
                                                .then(response => response.json())
                                                .then(data => callback(data.location))
                                                .catch(() => alert('Upload gagal.'));
                                            };
                                        }
                                    });
                                }

                                initTinyMCE();

                                function updateCheckboxBehavior() {
                                    document.querySelectorAll('.is_correct').forEach(checkbox => {
                                        checkbox.removeEventListener('change', checkbox.changeHandler);
                                        checkbox.changeHandler = function() {
                                            document.querySelectorAll('.is_correct').forEach(cb => {
                                                cb.checked = false;
                                                cb.closest('tr').style.backgroundColor = "";
                                            });
                                            this.checked = true;
                                            this.closest('tr').style.backgroundColor = "#D4EDDA";
                                        };
                                        checkbox.addEventListener('change', checkbox.changeHandler);
                                    });
                                }

                                function updateRemoveButtonBehavior() {
                                    document.querySelectorAll('.removeAnswer').forEach(button => {
                                        button.onclick = function() {
                                            let row = this.closest('tr');
                                            let textarea = row.querySelector('textarea');
                                            if (tinymce.get(textarea.id)) {
                                                tinymce.get(textarea.id).remove();
                                            }
                                            row.remove();
                                            answerIndex--;
                                        };
                                    });
                                }

                                document.getElementById('addAnswer').addEventListener('click', function() {
                                    if (answerIndex >= abjad.length) {
                                        alert('Batas maksimal jawaban tercapai!');
                                        return;
                                    }

                                    let abjadLabel = abjad[answerIndex];
                                    let newRow = document.createElement('tr');
                                    let textareaId = 'jawaban_' + answerIndex;

                                    newRow.innerHTML = `
                                        <th>Pilihan ${abjadLabel}</th>
                                        <td>
                                            <textarea class="form-control jawaban-editor" id="${textareaId}" name="jawaban[]"></textarea>
                                            <button type="button" class="btn btn-danger btn-sm removeAnswer mt-2">
                                                <i class="ion-trash-a"></i> Delete
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="is_correct" name="is_correct[${answerIndex}]" value="1" data-index="${answerIndex}">
                                        </td>
                                    `;

                                    document.querySelector('#jawabanTable tbody').appendChild(newRow);
                                    initTinyMCE('#' + textareaId);
                                    answerIndex++;
                                    updateCheckboxBehavior();
                                    updateRemoveButtonBehavior();
                                });

                                updateCheckboxBehavior();
                                updateRemoveButtonBehavior();

                                document.getElementById('questionForm').addEventListener('submit', function(e) {
                                    const container = document.getElementById('isCorrectInputs');
                                    container.innerHTML = '';

                                    // Reset nilai is_correct
                                    for (let i = 0; i < answerIndex; i++) {
                                        const hidden = document.createElement('input');
                                        hidden.type = 'hidden';
                                        hidden.name = 'is_correct[]';
                                        hidden.value = 0;
                                        container.appendChild(hidden);
                                    }

                                    // Set jawaban yang dicentang ke 1
                                    document.querySelectorAll('.is_correct:checked').forEach(cb => {
                                        const index = cb.value;
                                        container.children[index].value = 1;
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection