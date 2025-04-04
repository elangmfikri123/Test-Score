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
                                        <form action="{{ url('/user/store') }}" method="POST">
                                            @csrf
                                            
                                            <div class="form-group">
                                                <label for="username">Nama Ujian</label>
                                                <input type="text" class="form-control" id="username" name="username" required placeholder="Name Course">
                                            </div>

                                            <div class="form-group">
                                                <label for="category">Category</label>
                                                <select class="form-control" id="category" name="category">
                                                    <option value="">Select Category</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="peserta">Peserta</option>
                                                    <option value="juri">Juri</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="deskripsi">Deskripsi</label>
                                                <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
                                            </div>

                                            <!-- Mulai Pembagian Form ke Kanan-Kiri -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="acak_soal">Acak Soal</label>
                                                        <select class="form-control" id="acak_soal" name="acak_soal">
                                                            <option value="">Select</option>
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="acak_jawaban">Acak Jawaban</label>
                                                        <select class="form-control" id="acak_jawaban" name="acak_jawaban">
                                                            <option value="">Select</option>
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="tampilkan_hasil">Tampilkan Hasil</label>
                                                        <select class="form-control" id="tampilkan_hasil" name="tampilkan_hasil">
                                                            <option value="">Select</option>
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="durasi">Durasi (Menit)</label>
                                                        <input type="number" class="form-control" id="durasi" name="durasi" required placeholder="Menit">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-success"><i class="ion-checkmark"></i>Submit</button>
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
    <script src="https://cdn.tiny.cloud/1/2tvyzqqps6o97w5bncqfwpavklp6rlv7mx7voja1cst93eub/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#deskripsi',
            height: 300,
            menubar: false,
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
            toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | preview code'
        });
    </script>

@endsection
