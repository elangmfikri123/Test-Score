<h6 class="mb-3"><strong>Informasi Dealer / AHASS</strong></h6>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Kode Dealer (AHM) *</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="Masukkan Kode Dealer" name="kode_dealer"
        value="{{ old('kode_dealer', $peserta->identitasDealer->kode_dealer ?? '') }}">
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Nama Resmi Dealer/AHASS *</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="Masukkan Nama Dealer" name="nama_dealer"
        value="{{ old('nama_dealer', $peserta->identitasDealer->nama_dealer ?? '') }}">
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Link Google Business Profil Dealer *</label>
    <div class="col-sm-9">
        <input type="url" class="form-control" placeholder="https://" name="link_google_business"
        value="{{ old('link_google_business', $peserta->identitasDealer->link_google_business ?? '') }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Kota/Kabupatean Dealer *</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="Masukkan Kota/Kabupaten" name="kota"
        value="{{ old('kota', $peserta->identitasDealer->kota ?? '') }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Provinsi Dealer *</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="Masukkan Provinsi Dealer" name="provinsi"
        value="{{ old('provinsi', $peserta->identitasDealer->provinsi ?? '') }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">No. Telp Dealer *</label>
    <div class="col-sm-9">
        <input type="number" class="form-control" placeholder="Masukkan No Telp Dealer" name="no_telp_dealer"
        value="{{ old('no_telp_dealer', $peserta->identitasDealer->no_telp_dealer ?? '') }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Tahun Dealer Meraih Juara di KLHN Sebelumnya</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="Masukkan Tahun" name="tahun_menang_klhn"
        value="{{ old('tahun_menang_klhn', $peserta->identitasDealer->tahun_menang_klhn ?? '') }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Kategori Juara Yang Pernah Dimenangkan Dealer Sebelumnya</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="Masukkan Periode" name="keikutsertaan_klhn_sebelumnya"
        value="{{ old('keikutsertaan_klhn_sebelumnya', $peserta->identitasDealer->keikutsertaan_klhn_sebelumnya ?? '') }}">
    </div>
</div>

<h6 class="mb-3"><strong>Social Media Dealer (Jika Ada)</strong></h6>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Link URL Profile Facebook</label>
    <div class="col-sm-9">
        <input type="url" class="form-control" placeholder="https://" name="link_facebook"
        value="{{ old('link_facebook', $peserta->identitasDealer->link_facebook ?? '') }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Link URL Profile Instagram</label>
    <div class="col-sm-9">
        <input type="url" class="form-control" placeholder="https://" name="link_instagram"
        value="{{ old('link_instagram', $peserta->identitasDealer->link_instagram ?? '') }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Link URL Profile Tiktok</label>
    <div class="col-sm-9">
        <input type="url" class="form-control" placeholder="https://" name="link_tiktok"
        value="{{ old('link_tiktok', $peserta->identitasDealer->link_tiktok ?? '') }}">
    </div>
</div>
