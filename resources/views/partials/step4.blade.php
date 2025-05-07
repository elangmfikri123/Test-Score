<h6 class="mb-3"><strong>Upload File Peserta</strong></h6>
<div id="project_fields"> <!-- Tambahkan wrapper ini -->
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Judul Project *</label>
        <div class="col-sm-9">
            <input type="text" class="form-control requiredform" placeholder="Masukkan Judul Project" name="judul_project">
            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Tahun Pembuatan *</label>
        <div class="col-sm-9">
            <input type="text" class="form-control requiredform" placeholder="Masukkan Tahun Pembuatan"
                name="tahun_pembuatan_project">
            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">File Project (.ppt,.pdf) - Max.File 50 Mb *</label>
        <div class="col-sm-9">
            <input type="file" class="form-control" accept=".pdf,.ppt,.pptx" name="file_project">
        </div>
    </div>

    {{-- Untuk CRO --}}
    <div class="form-group row template-download" id="template-cro" style="display: none;">
        <label class="col-sm-3 col-form-label"></label>
        <div class="col-sm-9">
            <i class="feather icon-file" style="italic"></i><em>
                <a href="https://docs.google.com/spreadsheets/d/1MClKMhVJYO7VX1bEwggBJUlL06JLK92C/edit?usp=drive_link&ouid=106276902669714169102&rtpof=true&sd=true" target="_blank">
                    Download Template File Lampiran Peserta CRO
                </a>
            </em>
        </div>
    </div>

    {{-- Untuk Team Leader --}}
    <div class="form-group row template-download" id="template-tl" style="display: none;">
        <label class="col-sm-3 col-form-label"></label>
        <div class="col-sm-9">
            <i class="feather icon-file" style="italic"></i><em>
                <a href="https://docs.google.com/spreadsheets/d/1uEeXNxn4XEZH9btziejpAQPZ_viBSIA1QapulppULr8/edit?usp=sharing" target="_blank">
                    Download Template File Lampiran Peserta Team Leader
                </a>
            </em>
        </div>
    </div>

    {{-- Untuk Pimpinan Jaringan --}}
    <div class="form-group row template-download" id="template-pj" style="display: none;">
        <label class="col-sm-3 col-form-label"></label>
        <div class="col-sm-9">
            <i class="feather icon-file" style="italic"></i><em>
                <a href="https://docs.google.com/spreadsheets/d/1Akxd_oixGeg6j7ZlZSxFof6saOvy-7Le/edit?usp=sharing&ouid=106276902669714169102&rtpof=true&sd=true" target="_blank">
                    Download Template File Lampiran Peserta Pimpinan Jaringan
                </a>
            </em>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">File Lampiran Peserta (.xlsx) *</label>
        <div class="col-sm-9">
            <input type="file" class="form-control" accept=".xlsx,.xls" name="file_lampiranklhn">
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Foto Profil (jpg,png) *</label>
    <div class="col-sm-9">
        <input type="file" class="form-control requiredform" accept=".jpeg,.jpg,.png" name="foto_profil">
        <span class="messages text-danger" style="font-size: 0.7rem;"></span>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">KTP (jpg, png, pdf) *</label>
    <div class="col-sm-9">
        <input type="file" class="form-control requiredform" accept=".jpeg,.jpg,.png,.pdf" name="ktp">
        <span class="messages text-danger" style="font-size: 0.7rem;"></span>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Pernyataan *</label>
    <div class="col-sm-9">
        <div class="form-check d-flex align-items-start" style="margin-left: 3px;">
            <input class="form-check-input mt-1 ml-1 requiredform" type="checkbox" name="validasi" value="Ya">
            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
            <label class="form-check-label ml-2 text-justify" for="setuju" style="font-size: 0.85rem; text-align: justify;">
                Dengan ini saya menyatakan bahwa data yang saya berikan adalah benar dan lengkap. 
                Saya memberikan izin kepada PT <strong>[Astra Honda Motor]</strong> untuk mengumpulkan, menyimpan, dan memproses data pribadi peserta KLHN 2025, 
                serta membagikannya kepada pihak ketiga yang bekerja sama dengan perusahaan sesuai kebutuhan, dengan tetap menjaga kerahasiaannya.
            </label>
        </div>
    </div>
</div>

