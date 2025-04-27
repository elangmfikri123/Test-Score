@extends('layout.template')
@section('title', 'Manage Course')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5><i class="feather icon-edit"></i> Detail Ujian</h5>
                                    </div>
                                    <hr class="m-0">
                                    <div class="card-block">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Nama Ujian</th>
                                                    <td>{{ $course->namacourse }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Category</th>
                                                    <td>{{ $course->category->namacategory }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Jumlah Soal</th>
                                                    <td>{{ $course->questions_count ?? 0 }} Soal</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5><i class="ion-help-circled"></i> Tambah Soal Ujian</h5>
                                    </div>
                                    <hr class="m-0">
                                    <form action="{{ url('/admin/exams/' . $course->id . '/question-store') }}"
                                        method="POST" id="questionForm">
                                        @csrf
                                        <div class="card-block">
                                            {{-- SOAL --}}
                                            <table class="table table-bordered" id="soalTable">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th class="text-center">Question</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <textarea class="form-control soal-editor" name="deskripsi"></textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            {{-- JAWABAN --}}
                                            <table class="table table-bordered" id="jawabanTable">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th class="text-center">Pilihan</th>
                                                        <th class="text-center">Answers</th>
                                                        <th class="text-center">Koreksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (['A', 'B', 'C', 'D'] as $i => $label)
                                                        <tr>
                                                            <th>Pilihan {{ $label }}</th>
                                                            <td>
                                                                <textarea class="form-control jawaban-editor" name="jawaban[]"></textarea>
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="checkbox" class="is_correct"
                                                                    data-index="{{ $i }}">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div id="isCorrectInputs"></div>

                                            <button type="button" class="btn btn-primary" id="addAnswer">
                                                <i class="icofont icofont-plus"></i> Add Answer
                                            </button>
                                            <div class="text-right mt-3">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="ion-checkmark"></i> Submit
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <script src="https://cdn.tiny.cloud/1/2tvyzqqps6o97w5bncqfwpavklp6rlv7mx7voja1cst93eub/tinymce/7/tinymce.min.js"
                                    referrerpolicy="origin"></script>
                                <script>
                                    let answerIndex = 4;
                                    const abjad = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

                                    function initTinyMCE(selector = '.soal-editor, .jawaban-editor') {
                                        tinymce.init({
                                            selector: selector,
                                            height: 200,
                                            menubar: false,
                                            resize: false,
                                            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
                                            toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | preview code | image',
                                            automatic_uploads: true, 
                                            file_picker_types: 'image',
                                            file_picker_callback: function(callback, value, meta) {
                                                var input = document.createElement('input');
                                                input.setAttribute('type', 'file');
                                                input.setAttribute('accept', 'image/*');
                                                input.click();
                                                input.onchange = function() {
                                                    var file = input.files[0];
                                                    var reader = new FileReader();
                                                    reader.onload = function(e) {
                                                        // Use the callback to insert the image
                                                        callback(e.target.result, {
                                                            alt: file.name
                                                        });
                                                    };
                                                    reader.readAsDataURL(file);
                                                };
                                            }
                                        });
                                    }

                                    initTinyMCE();
                                    updateCheckboxBehavior();
                                    updateRemoveButtonBehavior();

                                    document.getElementById('addAnswer').addEventListener('click', function() {
                                        if (answerIndex >= abjad.length) {
                                            alert('Batas maksimal jawaban tercapai!');
                                            return;
                                        }

                                        let abjadLabel = abjad[answerIndex];
                                        let newRow = document.createElement('tr');
                                        let textareaId = `jawaban_${answerIndex}`;

                                        newRow.innerHTML = `
                                                <th>Pilihan ${abjadLabel}</th>
                                                <td>
                                                    <textarea class="form-control jawaban-editor" id="${textareaId}" name="jawaban[]"></textarea>
                                                    <button type="button" class="btn btn-danger btn-sm removeAnswer mt-2">
                                                        <i class="ion-trash-a"></i> Delete
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="is_correct" data-index="${answerIndex}">
                                                </td>
                                            `;

                                        document.querySelector('#jawabanTable tbody').appendChild(newRow);
                                        tinymce.init({
                                            target: document.getElementById(textareaId),
                                            height: 200,
                                            menubar: false,
                                            resize: false,
                                            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
                                            toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | preview code | image',
                                            automatic_uploads: true, 
                                            file_picker_types: 'image',
                                            file_picker_callback: function(callback, value, meta) {
                                                var input = document.createElement('input');
                                                input.setAttribute('type', 'file');
                                                input.setAttribute('accept', 'image/*');
                                                input.click();
                                                input.onchange = function() {
                                                    var file = input.files[0];
                                                    var reader = new FileReader();
                                                    reader.onload = function(e) {
                                                        // Use the callback to insert the image
                                                        callback(e.target.result, {
                                                            alt: file.name
                                                        });
                                                    };
                                                    reader.readAsDataURL(file);
                                                };
                                            }
                                        });

                                        answerIndex++;
                                        updateCheckboxBehavior();
                                        updateRemoveButtonBehavior();
                                    });

                                    function updateCheckboxBehavior() {
                                        document.querySelectorAll('.is_correct').forEach(checkbox => {
                                            checkbox.removeEventListener('change', checkbox.changeHandler); // avoid duplicate
                                            checkbox.changeHandler = function() {
                                                document.querySelectorAll('.is_correct').forEach(cb => {
                                                    cb.checked = false;
                                                    cb.closest('tr').style.backgroundColor = "";
                                                });
                                                this.checked = true;
                                                this.closest('tr').style.backgroundColor = "#9FE9BF";
                                            };
                                            checkbox.addEventListener('change', checkbox.changeHandler);
                                        });
                                    }

                                    function updateRemoveButtonBehavior() {
                                        document.querySelectorAll('.removeAnswer').forEach(button => {
                                            button.onclick = function() {
                                                let row = this.closest('tr');
                                                // Remove TinyMCE instance
                                                let textarea = row.querySelector('textarea');
                                                if (tinymce.get(textarea.id)) {
                                                    tinymce.get(textarea.id).remove();
                                                }
                                                row.remove();
                                                answerIndex--;
                                            };
                                        });
                                    }

                                    document.getElementById('questionForm').addEventListener('submit', function(e) {
                                        const container = document.getElementById('isCorrectInputs');
                                        container.innerHTML = '';

                                        const checkboxes = document.querySelectorAll('.is_correct');
                                        checkboxes.forEach((checkbox, index) => {
                                            const hidden = document.createElement('input');
                                            hidden.type = 'hidden';
                                            hidden.name = 'is_correct[]';
                                            hidden.value = checkbox.checked ? 1 : 0;
                                            container.appendChild(hidden);
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
