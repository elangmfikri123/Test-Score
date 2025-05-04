<h6 class="mb-3"><strong>Informasi Dealer / AHASS</strong></h6>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Kode Dealer (AHM) *</label>
    <div class="col-sm-9">
        <input type="text" class="form-control requiredform" placeholder="Masukkan Kode Dealer" name="kode_dealer"
        value="{{ old('kode_dealer', $peserta->identitasDealer->kode_dealer ?? '') }}">
        <span class="messages text-danger" style="font-size: 0.7rem;"></span>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Nama Resmi Dealer/AHASS *</label>
    <div class="col-sm-9">
        <input type="text" class="form-control requiredform" placeholder="Masukkan Nama Dealer" name="nama_dealer"
        value="{{ old('nama_dealer', $peserta->identitasDealer->nama_dealer ?? '') }}">
        <span class="messages text-danger" style="font-size: 0.7rem;"></span>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Link Google Business Profil Dealer *</label>
    <div class="col-sm-9">
        <input type="url" class="form-control requiredform" placeholder="https://" name="link_google_business"
        value="{{ old('link_google_business', $peserta->identitasDealer->link_google_business ?? '') }}">
        <span class="messages text-danger" style="font-size: 0.7rem;"></span>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Kota/Kabupatean Dealer *</label>
    <div class="col-sm-9">
        <input type="text" class="form-control requiredform" placeholder="Masukkan Kota/Kabupaten" name="kota"
        value="{{ old('kota', $peserta->identitasDealer->kota ?? '') }}">
        <span class="messages text-danger" style="font-size: 0.7rem;"></span>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Provinsi Dealer *</label>
    <div class="col-sm-9">
        <input type="text" class="form-control requiredform" placeholder="Masukkan Provinsi Dealer" name="provinsi"
        value="{{ old('provinsi', $peserta->identitasDealer->provinsi ?? '') }}">
        <span class="messages text-danger" style="font-size: 0.7rem;"></span>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">No. Telp Dealer *</label>
    <div class="col-sm-9">
        <input type="number" class="form-control requiredform" placeholder="Masukkan No Telp Dealer" name="no_telp_dealer"
        value="{{ old('no_telp_dealer', $peserta->identitasDealer->no_telp_dealer ?? '') }}">
        <span class="messages text-danger" style="font-size: 0.7rem;"></span>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Tahun terakhir dealer meraih gelar juara di KLHN</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="Masukkan Tahun" name="tahun_menang_klhn"
        value="{{ old('tahun_menang_klhn', $peserta->identitasDealer->tahun_menang_klhn ?? '') }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Kategori juara yang terakhir diraih oleh dealer di KLHN</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="Masukkan Periode" name="keikutsertaan_klhn_sebelumnya"
        value="{{ old('keikutsertaan_klhn_sebelumnya', $peserta->identitasDealer->keikutsertaan_klhn_sebelumnya ?? '') }}">
    </div>
</div>

<h6 class="mb-3"><strong>Social Media Dealer (Jika Ada)</strong></h6>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Link URL Profile Facebook</label>
    <div class="col-sm-9">
        <input type="url" class="form-control" placeholder="https://" name="link_facebook_dealer"
        value="{{ old('link_facebook_dealer', $peserta->identitasDealer->link_facebook ?? '') }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Link URL Profile Instagram</label>
    <div class="col-sm-9">
        <input type="url" class="form-control" placeholder="https://" name="link_instagram_dealer"
        value="{{ old('link_instagram_dealer', $peserta->identitasDealer->link_instagram ?? '') }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Link URL Profile Tiktok</label>
    <div class="col-sm-9">
        <input type="url" class="form-control" placeholder="https://" name="link_tiktok_dealer"
        value="{{ old('link_tiktok_dealer', $peserta->identitasDealer->link_tiktok ?? '') }}">
    </div>
</div>
