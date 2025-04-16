                                    <h6 class="mb-3"><strong>Identitas Peserta</strong></h6>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Kategory</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2-init" name="category_id">
                                                <option value="">Pilih Kategori</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->namacategory }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Main Dealer</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2-init" name="main_dealer_id">
                                                <option value="">Pilih Main Dealer</option>
                                                @foreach($mainDealers as $dealer)
                                                    <option value="{{ $dealer->id }}">{{ $dealer->kodemd }} - {{ $dealer->nama_md }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>  
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Jabatan</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2-init" name="position_id">
                                                <option value="">Pilih Jabatan</option>
                                                <option value="1">Manager</option>
                                                <option value="2">Supervisor</option>
                                                <option value="3">Staff</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Honda ID</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Masukkan Honda ID">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Masukkan Nama">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tanggal Mendapat Honda ID</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tanggal Mulai Bekerja di Dealer Saat Ini *</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Lama Bekerja Bersama Honda</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" placeholder="Masukkan Dalam Bulan">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Lama Bekerja di Dealer Saat Ini *</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" placeholder="Masukkan Dalam Bulan">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tempat Lahir</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Masukkan Kab/Kota Lahir">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tanggal Lahir *</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Agama</label>
                                        <div class="col-sm-9">
                                            <select class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Kristen Protestan">Kristen Protestan</option>
                                                <option value="Kristen Katolik">Kristen Katolik</option>
                                                <option value="Hindu">Hindu</option>
                                                <option value="Buddha">Buddha</option>
                                                <option value="Konghucu">Konghucu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">No. Handphone</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" placeholder="Masukkan No. Handphone">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">No. Handphone +62</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" placeholder="Masukkan No. WhatsApp">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
                                        <div class="col-sm-9">
                                            <select class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="SMA/SMK Sederajat">SMA/SMK Sederajat</option>
                                                <option value="Diploma">Diploma</option>
                                                <option value="S1">S1</option>
                                                <option value="S2">S2</option>
                                                <option value="S3">S3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" placeholder="Masukkan email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tahun Keikutsertaan KLHN Periode Sebelumnya</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Masukkan nama">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Ukuran Baju Peserta *</label>
                                        <div class="col-sm-9">
                                            <select class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="S">S</option>
                                                <option value="M">M</option>
                                                <option value="L">L</option>
                                                <option value="XL">XL</option>
                                                <option value="2XL">2XL</option>
                                                <option value="3XL">3XL</option>
                                                <option value="4XL">4XL</option>
                                                <option value="5XL">5XL</option>
                                            </select>
                                        </div>
                                    </div>

                                    <h6 class="mb-3"><strong>Social Media Pribadi (Jika Ada)</strong></h6>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Link URL Profile Facebook</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Masukkan nama">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Link URL Profile X (Twitter)</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Masukkan nama">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Link URL Profile Instagram</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Masukkan nama">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Link URL Profile Tiktok</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Masukkan nama">
                                        </div>
                                    </div>
                                    