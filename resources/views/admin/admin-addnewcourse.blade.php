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
                                        <form action="{{ url('/admin/course/store') }}" method="POST">
                                            @csrf

                                            <div class="form-group">
                                                <label for="namacourse">Nama Ujian</label>
                                                <input type="text" class="form-control" id="namacourse" name="namacourse"
                                                    required placeholder="Nama Ujian">
                                            </div>

                                            <div class="form-group">
                                                <label for="category">Category</label>
                                                <select class="form-control" id="category" name="category_id" required>
                                                    <option disabled selected>Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->namacategory }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Deskripsi</label>
                                                <textarea class="form-control" id="description" name="description"></textarea>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="randomquestion">Acak Soal</label>
                                                        <select class="form-control" id="randomquestion"
                                                            name="randomquestion" required>
                                                            <option disabled selected>Select</option>
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="randomanswer">Acak Jawaban</label>
                                                        <select class="form-control" id="randomanswer" name="randomanswer"
                                                            required>
                                                            <option disabled selected>Select</option>
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
                                                        <select class="form-control" id="showscore" name="showscore"
                                                            required>
                                                            <option disabled selected>Select</option>
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
                                                    <label for="start_date">Start Date</label>
                                                    <input type="datetime-local" class="form-control" id="start_date"
                                                        name="start_date" required>
                                                </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="end_date">End Date</label>
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

    <!-- Load TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/2tvyzqqps6o97w5bncqfwpavklp6rlv7mx7voja1cst93eub/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#description',
            height: 300,
            menubar: false,
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
            toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | preview code'
        });
    </script>
@endsection
