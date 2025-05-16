<h6 class="mb-3"><strong>Upload File Peserta</strong></h6>
<div id="project_fields"> <!-- Tambahkan wrapper ini -->
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Judul Project *</label>
        <div class="col-sm-9">
            <input type="text" class="form-control requiredform" placeholder="Masukkan Judul Project" name="judul_project"
            value="{{ old('judul_project', $peserta->filesPeserta->judul_project ?? '') }}">
            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Tahun Pembuatan *</label>
        <div class="col-sm-9">
            <input type="text" class="form-control requiredform" placeholder="Masukkan Tahun Pembuatan"
                name="tahun_pembuatan_project" value="{{ old('tahun_pembuatan_project', $peserta->filesPeserta->tahun_pembuatan_project ?? '') }}">
            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">File Project (.ppt,.pdf) - Max.File 20 Mb *</label>
        <div class="col-sm-9">
            <input type="file" class="form-control" accept=".pdf,.ppt,.pptx" name="file_project">
            
            @if (!empty($peserta->filesPeserta->file_project))
                <small class="form-text text-muted mt-2">
                    File Project Sebelumnya: 
                    <a href="{{ asset('storage/' . $peserta->filesPeserta->file_project) }}" target="_blank">Lihat File</a>
                </small>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">File Lampiran Peserta (.xlsx) *</label>
        <div class="col-sm-9">
            <input type="file" class="form-control" accept=".xlsx,.xls" name="file_lampiranklhn">
            @if (!empty($peserta->filesPeserta->file_lampiranklhn))
                <small class="form-text text-muted mt-2">
                    File Lampiran Sebelumnya: 
                    <a href="{{ asset('storage/' . $peserta->filesPeserta->file_lampiranklhn) }}" target="_blank">Lihat File</a>
                </small>
            @endif
        </div>
    </div>    
</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Foto Profil (jpg,png) *</label>
    <div class="col-sm-9">
        <input type="file" class="form-control" accept=".jpeg,.jpg,.png" name="foto_profil">
        @if (!empty($peserta->filesPeserta->foto_profil))
            <small class="form-text text-muted mt-2">
                Foto Profil Sebelumnya: 
                <a href="{{ asset('storage/' . $peserta->filesPeserta->foto_profil) }}" target="_blank">Lihat File</a>
            </small>
        @endif
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">KTP (jpg, png, pdf) *</label>
    <div class="col-sm-9">
        <input type="file" class="form-control" accept=".jpeg,.jpg,.png,.pdf" name="ktp">
        @if (!empty($peserta->filesPeserta->ktp))
            <small class="form-text text-muted mt-2">
                File KTP Sebelumnya: 
                <a href="{{ asset('storage/' . $peserta->filesPeserta->ktp) }}" target="_blank">Lihat File</a>
            </small>
        @endif
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Pernyataan *</label>
    <div class="col-sm-9">
        <div class="form-check d-flex align-items-start" style="margin-left: 3px;">
            <input class="form-check-input mt-1 ml-1 requiredform" type="checkbox" name="validasi" value="Ya"
            {{ old('validasi', $peserta->filesPeserta->validasi ?? '') == 'Ya' ? 'checked' : '' }}>
            <label class="form-check-label ml-2 text-justify" for="setuju" style="font-size: 0.85rem; text-align: justify;">
                Dengan ini saya menyatakan bahwa data yang saya berikan adalah benar dan lengkap. 
                Saya memberikan izin kepada PT <strong>[Astra Honda Motor]</strong> untuk mengumpulkan, menyimpan, dan memproses data pribadi peserta KLHN 2025, 
                serta membagikannya kepada pihak ketiga yang bekerja sama dengan perusahaan sesuai kebutuhan, dengan tetap menjaga kerahasiaannya.
            </label>
            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
        </div>
    </div>
</div>






