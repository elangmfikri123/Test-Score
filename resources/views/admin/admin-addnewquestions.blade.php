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
                                                    <td>Test KLHN 2025 - FLP</td>
                                                </tr>
                                                <tr>
                                                    <th>Category</th>
                                                    <td>Frontline People</td>
                                                </tr>
                                                <tr>
                                                    <th>Durasi</th>
                                                    <td>90 menit</td>
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
                                    <div class="card-block">
                                        <table class="table table-bordered" id="soalTable">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th class="text-center">Question</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><textarea class="form-control soal-editor" name="deskripsi"></textarea></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered" id="jawabanTable">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th class="text-center">Pilihan</th>
                                                    <th class="text-center">Answers</th>
                                                    <th class="text-center">Koreksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Jawaban Default A-D -->
                                                <tr>
                                                    <th>Pilihan A</th>
                                                    <td><textarea class="form-control jawaban-editor" name="jawaban[]"></textarea></td>
                                                    <td class="text-center"><input type="checkbox" class="correct-answer" name="correct-answer"></td>
                                                </tr>
                                                <tr>
                                                    <th>Pilihan B</th>
                                                    <td><textarea class="form-control jawaban-editor" name="jawaban[]"></textarea></td>
                                                    <td class="text-center"><input type="checkbox" class="correct-answer" name="correct-answer"></td>
                                                </tr>
                                                <tr>
                                                    <th>Pilihan C</th>
                                                    <td><textarea class="form-control jawaban-editor" name="jawaban[]"></textarea></td>
                                                    <td class="text-center"><input type="checkbox" class="correct-answer" name="correct-answer"></td>
                                                </tr>
                                                <tr>
                                                    <th>Pilihan D</th>
                                                    <td><textarea class="form-control jawaban-editor" name="jawaban[]"></textarea></td>
                                                    <td class="text-center"><input type="checkbox" class="correct-answer" name="correct-answer"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-primary" id="addAnswer"><i class="icofont icofont-plus"></i> Add Answer</button>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success"><i class="ion-checkmark"></i>Submit</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <script src="https://cdn.tiny.cloud/1/2tvyzqqps6o97w5bncqfwpavklp6rlv7mx7voja1cst93eub/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
                                <script>
                                    let answerIndex = 4; 
                                    const abjad = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J']; 
                                
                                    function initTinyMCE() {
                                        tinymce.init({
                                            selector: '.soal-editor, .jawaban-editor',
                                            height: 200,
                                            menubar: false,
                                            resize: false,
                                            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
                                            toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | preview code'
                                        });
                                    }
                                    initTinyMCE();
                                
                                    function updateCheckboxBehavior() {
                                        document.querySelectorAll('.correct-answer').forEach(checkbox => {
                                            checkbox.addEventListener('change', function () {
                                                document.querySelectorAll('.correct-answer').forEach(cb => {
                                                    cb.checked = false;
                                                    cb.closest('tr').style.backgroundColor = "";
                                                });
                                
                                                this.checked = true;
                                                this.closest('tr').style.backgroundColor = "#9FE9BF";
                                            });
                                        });
                                    }
                                
                                    updateCheckboxBehavior();
                                
                                    document.getElementById('addAnswer').addEventListener('click', function () {
                                        if (answerIndex >= abjad.length) {
                                            alert('Batas maksimal jawaban tercapai!');
                                            return;
                                        }
                                
                                        let newRow = document.createElement('tr');
                                        let abjadLabel = abjad[answerIndex];
                                
                                        newRow.innerHTML = `
                                            <th>Pilihan ${abjadLabel}</th>
                                            <td>
                                                <textarea class="form-control jawaban-editor" name="jawaban[]"></textarea>
                                                <button type="button" class="btn btn-danger btn-sm removeAnswer">Delete</button>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" class="correct-answer" name="correct-answer">
                                            </td>
                                        `;
                                
                                        document.getElementById('jawabanTable').querySelector('tbody').appendChild(newRow);
                                        answerIndex++;
                                
                                        tinymce.init({
                                            selector: '.jawaban-editor',
                                            height: 150,
                                            menubar: false,
                                            resize: false,
                                            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
                                            toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | preview code'
                                        });
                                
                                        updateCheckboxBehavior();
                                        updateRemoveButtonBehavior();
                                    });
                                
                                    function updateRemoveButtonBehavior() {
                                        document.querySelectorAll('.removeAnswer').forEach(button => {
                                            button.addEventListener('click', function () {
                                                this.closest('tr').remove();
                                                answerIndex--;
                                            });
                                        });
                                    }
                                </script>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
