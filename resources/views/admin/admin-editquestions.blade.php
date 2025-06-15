@extends('layout.template')
@section('title', 'Edit Soal Ujian')
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

                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5><i class="ion-help-circled"></i> Edit Soal Ujian</h5>
                                </div>
                                <hr class="m-0">
                                <form action="{{ url('/admin/exams/question-update/' . $question->id) }}" method="POST" id="questionForm">
                                    @csrf
                                    <div class="card-block">
                                        {{-- SOAL --}}
                                        <table class="table table-bordered" id="soalTable">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th class="text-center">Pertanyaan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div id="soal-editor" style="height: 250px;">{!! $question->pertanyaan !!}</div>
                                                        <input type="hidden" name="deskripsi" id="soal-content">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        {{-- JAWABAN --}}
                                        <table class="table table-bordered" id="jawabanTable">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th class="text-center">Pilihan</th>
                                                    <th class="text-center">Jawaban</th>
                                                    <th class="text-center">Koreksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($question->answers as $i => $answer)
                                                <tr @if($answer->is_correct) style="background-color: #D4EDDA" @endif>
                                                    <th>Pilihan {{ chr(65 + $i) }}</th>
                                                    <td>
                                                        <div class="jawaban-editor" id="jawaban-editor-{{ $i }}" style="height: 150px;">{!! $answer->jawaban !!}</div>
                                                        <input type="hidden" name="jawaban[]" id="jawaban-content-{{ $i }}">
                                                        @if($i >= 4)
                                                        <button type="button" class="btn btn-danger btn-sm removeAnswer mt-2">
                                                            <i class="ion-trash-a"></i> Hapus
                                                        </button>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="checkbox" class="is_correct" data-index="{{ $i }}" @if($answer->is_correct) checked @endif>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @php $answerCount = count($question->answers); @endphp
                                                @for($i = $answerCount; $i < 4; $i++)
                                                <tr>
                                                    <th>Pilihan {{ chr(65 + $i) }}</th>
                                                    <td>
                                                        <div class="jawaban-editor" id="jawaban-editor-{{ $i }}" style="height: 150px;"></div>
                                                        <input type="hidden" name="jawaban[]" id="jawaban-content-{{ $i }}">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="checkbox" class="is_correct" data-index="{{ $i }}">
                                                    </td>
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                        <div id="isCorrectInputs"></div>

                                        @if(count($question->answers) < 10)
                                        <button type="button" class="btn btn-sm btn-primary" id="addAnswer">
                                            <i class="icofont icofont-plus"></i> Tambah Pilihan
                                        </button>
                                        @endif
                                        <div class="text-right mt-3">
                                            <button type="submit" class="btn btn-success">
                                                <i class="ion-checkmark"></i> Update
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Include Quill stylesheet -->
                            <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
                            <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
                            <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module@3.0.0/image-resize.min.js"></script>
                            
                            <script>
                                let answerIndex = {{ count($question->answers) }};
                                const abjad = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                                let quillInstances = {};
                                const ImageResize = window.ImageResize;
                                const resizeModules = [{
                                    name: 'imageResize',
                                    module: ImageResize,
                                    options: {
                                        displaySize: true,
                                        displayStyles: {
                                            backgroundColor: 'black',
                                            border: 'none',
                                            color: 'white'
                                        }
                                    }
                                }];
                                
                                async function uploadGambar(quill) {
                                    const input = document.createElement('input');
                                    input.setAttribute('type', 'file');
                                    input.setAttribute('accept', 'image/*');
                                    input.click();

                                    input.onchange = async function() {
                                        const file = input.files[0];
                                        if (!file) return;
                                        const range = quill.getSelection();
                                        quill.insertText(range.index, 'Mengupload gambar...', 'bold', true);
                                        
                                        try {
                                            const formData = new FormData();
                                            formData.append('file', file);

                                            const response = await fetch('{{ route("image.upload") }}', {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                },
                                                body: formData
                                            });

                                            const data = await response.json();
                                            if (data.location) {
                                                quill.deleteText(range.index, 20);
                                                quill.insertEmbed(range.index, 'image', data.location);
                                            } else {
                                                throw new Error('Upload gagal');
                                            }
                                        } catch (error) {
                                            console.error('Error:', error);
                                            quill.deleteText(range.index, 20);
                                            quill.insertText(range.index, 'Upload gambar gagal!', { color: 'red' });
                                        }
                                    };
                                }

                                // Inisialisasi Quill untuk pertanyaan
                                const soalQuill = new Quill('#soal-editor', {
                                    theme: 'snow',
                                    modules: {
                                        toolbar: [
                                            [{ 'header': [1, 2, 3, false] }],
                                            ['bold', 'italic', 'underline', 'strike'],
                                            [{ 'color': [] }, { 'background': [] }],
                                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                            ['link', 'image'],
                                            ['clean']
                                        ],
                                        imageResize: {
                                            displaySize: true,
                                            modules: ['Resize', 'DisplaySize']
                                        }
                                    },
                                    placeholder: 'Tulis pertanyaan disini...'
                                });

                                soalQuill.getModule('toolbar').addHandler('image', () => {
                                    uploadGambar(soalQuill);
                                });

                                quillInstances['soal'] = soalQuill;
                                
                                @for($i = 0; $i < max(count($question->answers), 4); $i++)
                                quillInstances['jawaban-{{ $i }}'] = new Quill('#jawaban-editor-{{ $i }}', {
                                    theme: 'snow',
                                    modules: {
                                        toolbar: [
                                            ['bold', 'italic', 'underline', 'strike'],
                                            [{ 'color': [] }, { 'background': [] }],
                                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                            ['link', 'image'],
                                            ['clean']
                                        ],
                                        imageResize: {
                                            displaySize: true,
                                            modules: ['Resize', 'DisplaySize']
                                        }
                                    },
                                    placeholder: 'Tulis jawaban disini...'
                                });
                                
                                quillInstances['jawaban-{{ $i }}'].getModule('toolbar').addHandler('image', () => {
                                    uploadGambar(quillInstances['jawaban-{{ $i }}']);
                                });
                                @endfor

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
                                            const textareaId = row.querySelector('.jawaban-editor').id;
                                            delete quillInstances[textareaId.replace('jawaban-editor-', 'jawaban-')];
                                            row.remove();
                                            answerIndex--;
                                        };
                                    });
                                }

                                // Initialize with existing correct answer
                                updateCheckboxBehavior();
                                updateRemoveButtonBehavior();
                                
                                document.getElementById('addAnswer').addEventListener('click', function() {
                                    if (answerIndex >= abjad.length) {
                                        alert('Batas maksimal pilihan jawaban telah tercapai!');
                                        return;
                                    }

                                    let abjadLabel = abjad[answerIndex];
                                    let newRow = document.createElement('tr');
                                    let editorId = 'jawaban-editor-' + answerIndex;
                                    let contentId = 'jawaban-content-' + answerIndex;

                                    newRow.innerHTML = `
                                        <th>Pilihan ${abjadLabel}</th>
                                        <td>
                                            <div class="jawaban-editor" id="${editorId}" style="height: 150px;"></div>
                                            <input type="hidden" name="jawaban[]" id="${contentId}">
                                            <button type="button" class="btn btn-danger btn-sm removeAnswer mt-2">
                                                <i class="ion-trash-a"></i> Hapus
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="is_correct" data-index="${answerIndex}">
                                        </td>
                                    `;

                                    document.querySelector('#jawabanTable tbody').appendChild(newRow);
                                    
                                    quillInstances['jawaban-' + answerIndex] = new Quill('#' + editorId, {
                                        theme: 'snow',
                                        modules: {
                                            toolbar: [
                                                ['bold', 'italic', 'underline', 'strike'],
                                                [{ 'color': [] }, { 'background': [] }],
                                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                                ['link', 'image'],
                                                ['clean']
                                            ],
                                            imageResize: {
                                                displaySize: true,
                                                modules: ['Resize', 'DisplaySize']
                                            }
                                        },
                                        placeholder: 'Tulis jawaban ' + abjadLabel + ' disini...'
                                    });
                                    quillInstances['jawaban-' + answerIndex].getModule('toolbar').addHandler('image', () => {
                                        uploadGambar(quillInstances['jawaban-' + answerIndex]);
                                    });

                                    answerIndex++;
                                    updateCheckboxBehavior();
                                    updateRemoveButtonBehavior();
                                });
                                
                                document.getElementById('questionForm').addEventListener('submit', function(e) {
                                    document.getElementById('soal-content').value = soalQuill.root.innerHTML;
                                    for (let i = 0; i < answerIndex; i++) {
                                        if (quillInstances['jawaban-' + i]) {
                                            document.getElementById('jawaban-content-' + i).value = 
                                                quillInstances['jawaban-' + i].root.innerHTML;
                                        }
                                    }
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