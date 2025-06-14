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
                                                <div id="quill-description" style="height: 300px;"></div>
                                                <textarea name="description" id="description" style="display: none;"></textarea>
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

    <!-- Load Quill -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    
    <!-- Load Image Resize Module -->
    <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module@3.0.0/image-resize.min.js"></script>

    <script>
        // Daftarkan modul image resize
        const ImageResize = window.ImageResize;
        Quill.register('modules/imageResize', ImageResize);

        // Konfigurasi Quill editor
        const quill = new Quill('#quill-description', {
            theme: 'snow',
            placeholder: 'Tulis deskripsi ujian di sini...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'image', 'code-block'],
                    ['clean']
                ],
                imageResize: {
                    displaySize: true,
                    modules: ['Resize', 'DisplaySize', 'Toolbar'],
                    handleStyles: {
                        backgroundColor: '#000',
                        border: 'none',
                        color: '#fff'
                    }
                }
            }
        });

        // Fungsi untuk upload gambar
        function handleImageUpload() {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();

            input.onchange = async function() {
                const file = input.files[0];
                if (!file) return;

                try {
                    // Tampilkan indikator loading
                    const range = quill.getSelection();
                    quill.insertText(range.index, 'Mengupload gambar...', { color: '#999' });
                    
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
                        // Hapus teks loading
                        quill.deleteText(range.index, 18);
                        // Sisipkan gambar
                        quill.insertEmbed(range.index, 'image', data.location);
                        
                        // Setelah gambar dimasukkan, aktifkan resize
                        const img = quill.container.querySelector(`img[src="${data.location}"]`);
                        if (img) {
                            img.style.maxWidth = '100%';
                            img.style.height = 'auto';
                        }
                    } else {
                        throw new Error('Upload gagal');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    quill.deleteText(range.index, 18);
                    quill.insertText(range.index, 'Upload gambar gagal!', { color: 'red' });
                }
            };
        }

        // Tambahkan handler untuk tombol gambar di toolbar
        quill.getModule('toolbar').addHandler('image', handleImageUpload);

        // Simpan isi editor ke textarea saat submit form
        document.getElementById('courseForm').addEventListener('submit', function() {
            document.getElementById('description').value = quill.root.innerHTML;
        });

        // Validasi form sebelum submit
        document.getElementById('courseForm').addEventListener('submit', function(e) {
            // Validasi tanggal
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);
            
            if (startDate >= endDate) {
                e.preventDefault();
                alert('Tanggal akhir harus setelah tanggal mulai!');
                return false;
            }
            
            return true;
        });
    </script>
@endsection