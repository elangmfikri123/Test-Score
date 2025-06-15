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
                                    <h5><i class="feather icon-edit"></i> Tambah Ujian</h5>
                                </div>
                                <hr class="m-0">
                                <div class="card-block">
                                    <form action="{{ url('/admin/course/store') }}" method="POST" id="courseForm">
                                        @csrf

                                        <div class="form-group">
                                            <label for="namacourse">Nama Ujian</label>
                                            <input type="text" class="form-control" id="namacourse" name="namacourse"
                                                required placeholder="Nama Ujian">
                                        </div>

                                        <div class="form-group">
                                            <label for="category_id">Kategori</label>
                                            <select class="form-control" id="category_id" name="category_id" required>
                                                <option disabled selected>Pilih Kategori</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->namacategory }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Quill Editor --}}
                                        <div class="form-group">
                                            <label for="description">Deskripsi</label>
                                            <div id="editor-container" style="height: 200px;"></div>
                                            <input type="hidden" name="description" id="description">
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="randomquestion">Acak Soal</label>
                                                    <select class="form-control" id="randomquestion" name="randomquestion" required>
                                                        <option disabled selected>Pilih</option>
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="randomanswer">Acak Jawaban</label>
                                                    <select class="form-control" id="randomanswer" name="randomanswer" required>
                                                        <option disabled selected>Pilih</option>
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="showscore">Tampilkan Hasil</label>
                                                    <select class="form-control" id="showscore" name="showscore" required>
                                                        <option disabled selected>Pilih</option>
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="duration_minutes">Durasi (Menit)</label>
                                                    <input type="number" class="form-control" id="duration_minutes"
                                                        name="duration_minutes" required placeholder="Menit">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="start_date">Tanggal Mulai</label>
                                                    <input type="datetime-local" class="form-control" id="start_date"
                                                        name="start_date" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="end_date">Tanggal Selesai</label>
                                                    <input type="datetime-local" class="form-control" id="end_date"
                                                        name="end_date" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success">
                                                <i class="ion-checkmark"></i> Submit
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
    // Inisialisasi Quill
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Tulis deskripsi ujian di sini...',
        modules: {
            toolbar: [
                [{ header: [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                ['blockquote', 'code-block'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    document.getElementById('courseForm').addEventListener('submit', function () {
        document.getElementById('description').value = quill.root.innerHTML;
    });
</script>
@endsection
