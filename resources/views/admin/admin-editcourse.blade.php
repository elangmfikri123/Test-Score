@extends('layout.template')
@section('title', 'Edit Course')
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
                                        <h5><i class="feather icon-edit"></i> Edit Ujian</h5>
                                    </div>
                                    <hr class="m-0">
                                    <div class="card-block">
                                        <form action="{{ url('/admin/exams/' . $course->id) }}" method="POST"
                                            id="editCourseForm">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-group">
                                                <label for="namacourse">Nama Ujian</label>
                                                <input type="text" class="form-control" id="namacourse" name="namacourse"
                                                    value="{{ old('namacourse', $course->namacourse) }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="category">Kategori</label>
                                                <select class="form-control" id="category" name="category_id" required>
                                                    <option disabled selected>Pilih Kategori</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $course->category_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->namacategory }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- QuillJS Editor --}}
                                            <div class="form-group">
                                                <label for="description">Deskripsi</label>
                                                <div id="editor-container" style="height: 200px;"></div>
                                                <input type="hidden" name="description" id="description">
                                            </div>

                                            <div class="form-group">
                                                <label for="subcategories">Subkategori Soal</label>
                                                <div id="subcategory-wrapper">
                                                    @foreach ($subcategories as $subcategory)
                                                        <div class="input-group mb-2">
                                                            <input type="hidden" name="subcategory_ids[]"
                                                                value="{{ $subcategory->id }}">
                                                            <input type="text" name="subcategories[]"
                                                                class="form-control"
                                                                value="{{ $subcategory->vnamacategory }}"
                                                                placeholder="Nama Subkategori" required>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-danger btn-remove-subcat"
                                                                    type="button">&times;</button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button type="button" class="btn btn-primary btn-sm mt-2"
                                                    id="btn-add-subcat">+ Tambah Subkategori</button>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="randomquestion">Acak Soal</label>
                                                        <select class="form-control" id="randomquestion"
                                                            name="randomquestion" required>
                                                            <option disabled>Select</option>
                                                            <option value="Ya"
                                                                {{ $course->randomquestion == 'Ya' ? 'selected' : '' }}>Ya
                                                            </option>
                                                            <option value="Tidak"
                                                                {{ $course->randomquestion == 'Tidak' ? 'selected' : '' }}>
                                                                Tidak</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="randomanswer">Acak Jawaban</label>
                                                        <select class="form-control" id="randomanswer" name="randomanswer"
                                                            required>
                                                            <option disabled>Select</option>
                                                            <option value="Ya"
                                                                {{ $course->randomanswer == 'Ya' ? 'selected' : '' }}>Ya
                                                            </option>
                                                            <option value="Tidak"
                                                                {{ $course->randomanswer == 'Tidak' ? 'selected' : '' }}>
                                                                Tidak</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="showscore">Tampilkan Hasil</label>
                                                        <select class="form-control" id="showscore" name="showscore"
                                                            required>
                                                            <option disabled>Select</option>
                                                            <option value="Ya"
                                                                {{ $course->showscore == 'Ya' ? 'selected' : '' }}>Ya
                                                            </option>
                                                            <option value="Tidak"
                                                                {{ $course->showscore == 'Tidak' ? 'selected' : '' }}>Tidak
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="duration_minutes">Durasi (Menit)</label>
                                                        <input type="number" class="form-control" id="duration_minutes"
                                                            name="duration_minutes"
                                                            value="{{ old('duration_minutes', $course->duration_minutes) }}"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="start_date">Tanggal Mulai</label>
                                                        <input type="datetime-local" class="form-control" id="start_date"
                                                            name="start_date"
                                                            value="{{ old('start_date', $course->start_date) }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="end_date">Tanggal Selesai</label>
                                                        <input type="datetime-local" class="form-control" id="end_date"
                                                            name="end_date"
                                                            value="{{ old('end_date', $course->end_date) }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="ion-checkmark"></i> Update
                                                </button>
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
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        // Inisialisasi editor
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Tulis deskripsi ujian di sini...',
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['blockquote', 'code-block'],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });
        var initialContent = {!! json_encode($course->description) !!};
        quill.root.innerHTML = initialContent;
        document.getElementById('editCourseForm').addEventListener('submit', function(e) {
            e.preventDefault();
            document.getElementById('description').value = quill.root.innerHTML;
            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = '/admin/exams';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal memperbarui data'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan server'
                    });
                });
        });

        // Fungsi untuk menambah subkategori
        document.getElementById('btn-add-subcat').addEventListener('click', function() {
            const wrapper = document.getElementById('subcategory-wrapper');
            const div = document.createElement('div');
            div.classList.add('input-group', 'mb-2');
            div.innerHTML = `
            <input type="hidden" name="subcategory_ids[]" value="">
            <input type="text" name="subcategories[]" class="form-control" placeholder="Nama Subkategori" required>
            <div class="input-group-append">
                <button class="btn btn-danger btn-remove-subcat" type="button">&times;</button>
            </div>
        `;
            wrapper.appendChild(div);
        });

        // Fungsi untuk menghapus subkategori
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-remove-subcat')) {
                e.target.closest('.input-group').remove();
            }
        });
    </script>
@endsection
