                            <!-- Identitsa Peserta -->
                                <h6 class="mb-3"><strong>Identitas Peserta</strong></h6>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Kategory *</label>
                                        <div class="col-sm-9">
                                            <select class="form-control requiredform select2-init" name="category_id" id="category_id">
                                                <option value="" disabled selected>Pilih Kategori</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->namacategory }}</option>
                                                @endforeach
                                            </select>
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Main Dealer *</label>
                                        <div class="col-sm-9">
                                            <select class="form-control requiredform select2-init" name="maindealer_id" >
                                                <option value="" disabled selected>Pilih Main Dealer</option>
                                                @foreach($mainDealers as $row)
                                                    <option value="{{ $row->id }}">{{ $row->kodemd }} - {{ $row->nama_md }}</option>
                                                @endforeach
                                            </select>
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>  
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Jabatan Saat Ini *</label>
                                        <div class="col-sm-9">
                                            <select class="form-control requiredform select2-init" name="jabatan">
                                                <option value="" disabled selected>Pilih Jabatan</option>
                                                @php
                                                    $jabatanList = ['Delivery Man', 'Salesman', 'Admin STNK/BPKB', 'PIC Parts', 'Kasir', 'Kepala Bengkel', 'Koordinator Salesman',
                                                'Sales Counter', 'Koordinator Sales Counter', 'Kepala Cabang', 'PIC CRM', 'Pemilik In Charge (Owner)', 'Wing Sales People', 'Big Bike Consultant', 'Big Bike Manager'];
                                                @endphp
                                                @foreach($jabatanList as $jabatan)
                                                    <option value="{{ $jabatan }}">{{ $jabatan }}</option>
                                                @endforeach
                                            </select>
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Honda ID *</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control requiredform" placeholder="Masukkan Honda ID" name="honda_id">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Nama Lengkap *</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control requiredform" placeholder="Masukkan Nama" name="nama">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tanggal Mendapat Honda ID *</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control requiredform" name="tanggal_hondaid">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tanggal Mulai Bekerja di Dealer Saat Ini *</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control requiredform" name="tanggal_awalbekerja">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Lama Bekerja di Dealer Saat Ini *</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control requiredform" placeholder="Masukkan Dalam Bulan" name="lamabekerja_dealer">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Jenis Kelamin *</label>
                                        <div class="col-sm-9">
                                            <select class="form-control requiredform" name="jenis_kelamin" >
                                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                                <option value="Laki-Laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tempat Lahir *</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control requiredform" placeholder="Masukkan Kab/Kota Lahir" name="tempat_lahir">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tanggal Lahir *</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control requiredform" name="tanggal_lahir"> 
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Agama *</label>
                                        <div class="col-sm-9">
                                            <select class="form-control requiredform" name="agama">
                                                <option value="" disabled selected>Pilih Agama</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Kristen Protestan">Kristen Protestan</option>
                                                <option value="Kristen Katolik">Kristen Katolik</option>
                                                <option value="Hindu">Hindu</option>
                                                <option value="Buddha">Buddha</option>
                                                <option value="Konghucu">Konghucu</option>
                                            </select>
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">No. Handphone/WhatsApp *</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control requiredform" placeholder="Masukkan No. Handphone/WhatsApp" name="no_hp">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">No. Handphone (AstraPay) *</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control requiredform" placeholder="Masukkan No. Handphone (AstraPay)" name="no_hp_astrapay">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Pendidikan Terakhir *</label>
                                        <div class="col-sm-9">
                                            <select class="form-control requiredform" name="pendidikan_terakhir">
                                                <option value="" disabled selected>Pilih Pendidikan</option>
                                                <option value="SD Sederajat">SD Sederajat</option>
                                                <option value="SMP Sederajat">SMP Sederajat</option>
                                                <option value="SMA/SMK Sederajat">SMA/SMK Sederajat</option>
                                                <option value="Diploma">Diploma</option>
                                                <option value="S1">S1</option>
                                                <option value="S2">S2</option>
                                                <option value="S3">S3</option>
                                            </select>
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Email *</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control requiredform" placeholder="Masukkan email" name="email">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Ukuran Baju Peserta *</label>
                                        <div class="col-sm-9">
                                            <select class="form-control requiredform" name="ukuran_baju">
                                                <option value="" disabled selected>Pilih Ukuran Baju</option>
                                                <option value="S">S</option>
                                                <option value="M">M</option>
                                                <option value="L">L</option>
                                                <option value="XL">XL</option>
                                                <option value="2XL">2XL</option>
                                                <option value="3XL">3XL</option>
                                                <option value="4XL">4XL</option>
                                                <option value="5XL">5XL</option>
                                            </select>
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Pantangan Makanan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Masukkan Pantangan Makanan" name="pantangan_makanan">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Riwayat Penyakit</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Masukkan Riwayat Penyakit" name="riwayat_penyakit">
                                        </div>
                                    </div>

                                    <h6 class="mb-3"><strong>Social Media Pribadi</strong></h6>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Link URL Profile Facebook</label>
                                        <div class="col-sm-9">
                                            <input type="url" class="form-control" placeholder="https://" name="link_facebook">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Link URL Profile Instagram</label>
                                        <div class="col-sm-9">
                                            <input type="url" class="form-control" placeholder="https://" name="link_instagram">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Link URL Profile Tiktok</label>
                                        <div class="col-sm-9">
                                            <input type="url" class="form-control" placeholder="https://" name="link_tiktok">
                                        </div>
                                    </div>

                                    <h6 class="mb-3"><strong>History Keikutsertaan KLHN</strong></h6>
                                    <div id="riwayat-klhn-container">
                                        <div class="form-group row riwayat-klhn">
                                            <label class="col-sm-3 col-form-label">Tahun Keikutsertaan KLHN Periode Sebelumnya</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" placeholder="Masukkan Tahun" name="riwayat_klhn[0][tahun_keikutsertaan]">
                                            </div>
                                        </div>
                                        <div class="form-group row riwayat-klhn">
                                            <label class="col-sm-3 col-form-label">Kategori</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2-init" name="riwayat_klhn[0][vcategory]">
                                                    <option value="" disabled selected>Pilih Kategori</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->namacategory }}">{{ $category->namacategory }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row riwayat-klhn">
                                            <label class="col-sm-3 col-form-label">Status Kepesertaan</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="riwayat_klhn[0][status_kepesertaan]">
                                                    <option value="" disabled selected>Pilih Status</option>
                                                    <option value="Peserta">Peserta</option>
                                                    <option value="Juara 1">Juara 1</option>
                                                    <option value="Juara 2">Juara 2</option>
                                                    <option value="Juara 3">Juara 3</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button type="button" id="add-riwayat-klhn" class="btn btn-warning">Add History KLHN</button>
                            <!-- Data Social Media -->       

