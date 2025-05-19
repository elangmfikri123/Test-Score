                            <!-- Identitsa Peserta -->
                                <h6 class="mb-3"><strong>Identitas Peserta</strong></h6>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Kategory *</label>
                                        <div class="col-sm-9">
                                            <select class="form-control requiredform select2-init" name="category_id" id="category_id">
                                                <option value="" disabled {{ old('category_id', $peserta->category_id ?? '') == '' ? 'selected' : '' }}>Pilih Kategori</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $peserta->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->namacategory }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Main Dealer *</label>
                                        <div class="col-sm-9">
                                            <select class="form-control requiredform select2-init" name="maindealer_id">
                                                <option value="" disabled {{ old('maindealer_id', $peserta->maindealer_id ?? '') == '' ? 'selected' : '' }}>Pilih Main Dealer</option>
                                                @foreach($mainDealers as $row)
                                                    <option value="{{ $row->id }}"
                                                        {{ old('maindealer_id', $peserta->maindealer_id ?? '') == $row->id ? 'selected' : '' }}>
                                                        {{ $row->kodemd }} - {{ $row->nama_md }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>  
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Jabatan Saat Ini *</label>
                                        <div class="col-sm-9">
                                            <select class="form-control requiredform select2-init" name="jabatan">
                                                <option value="" disabled {{ old('jabatan', $peserta->jabatan ?? '') == '' ? 'selected' : '' }}>Pilih Jabatan</option>
                                                @php
                                                    $jabatanList = [
                                                        'Delivery Man', 'Salesman', 'Admin STNK/BPKB', 'PIC Parts', 'Kasir',
                                                        'Kepala Bengkel', 'Koordinator Salesman', 'Sales Counter',
                                                        'Koordinator Sales Counter', 'Kepala Cabang', 'PIC CRM',
                                                        'Pemilik In Charge (Owner)', 'Wing Sales People', 'Big Bike Consultant'
                                                    ];
                                                @endphp
                                                @foreach($jabatanList as $jabatan)
                                                    <option value="{{ $jabatan }}" {{ old('jabatan', $peserta->jabatan ?? '') == $jabatan ? 'selected' : '' }}>
                                                        {{ $jabatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>                                                                        
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Honda ID *</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control requiredform" placeholder="Masukkan Honda ID" name="honda_id"  value="{{ old('honda_id', $peserta->honda_id) }}" readonly>
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Nama Lengkap *</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control requiredform" placeholder="Masukkan Nama" name="nama" value="{{ old('nama', $peserta->nama) }}">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tanggal Mendapat Honda ID *</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control requiredform" name="tanggal_hondaid"
                                                value="{{ old('tanggal_hondaid', optional($peserta)->tanggal_hondaid ? \Carbon\Carbon::parse($peserta->tanggal_hondaid)->format('Y-m-d') : '') }}">
                                                <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="peserta_id" value="{{ $peserta->id }}">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tanggal Mulai Bekerja di Dealer Saat Ini *</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control requiredform" name="tanggal_awalbekerja"
                                            value="{{ old('tanggal_hondaid', optional($peserta)->tanggal_awalbekerja ? \Carbon\Carbon::parse($peserta->tanggal_awalbekerja)->format('Y-m-d') : '') }}">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Lama Bekerja di Dealer Saat Ini *</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control requiredform" placeholder="Masukkan Dalam Bulan" name="lamabekerja_dealer"
                                            value="{{ old('lamabekerja_dealer', $peserta->lamabekerja_dealer ?? '') }}">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Jenis Kelamin *</label>
                                        <div class="col-sm-9">
                                            <select class="form-control requiredform" name="jenis_kelamin">
                                                <option value="" disabled {{ old('jenis_kelamin', $peserta->jenis_kelamin ?? '') == '' ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                                                <option value="Laki-Laki" {{ old('jenis_kelamin', $peserta->jenis_kelamin ?? '') == 'Laki-Laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan" {{ old('jenis_kelamin', $peserta->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                    </div>                                    
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tempat Lahir *</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control requiredform" placeholder="Masukkan Kab/Kota Lahir" name="tempat_lahir"
                                            value="{{ old('tempat_lahir', $peserta->tempat_lahir ?? '') }}">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tanggal Lahir *</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control requiredform" name="tanggal_lahir"
                                            value="{{ old('tanggal_lahir', $peserta->tanggal_lahir ?? '') }}">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Agama *</label>
                                        <div class="col-sm-9">
                                            <select class="form-control requiredform" name="agama">
                                                <option value="" disabled {{ old('agama', $peserta->agama ?? '') == '' ? 'selected' : '' }}>Pilih Agama</option>
                                                @php
                                                    $agamaList = ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu'];
                                                @endphp
                                                @foreach($agamaList as $agama)
                                                    <option value="{{ $agama }}" {{ old('agama', $peserta->agama ?? '') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                                @endforeach
                                            </select>
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">No. Handphone/WhatsApp *</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control requiredform" placeholder="Masukkan No. Handphone/WhatsApp" name="no_hp"
                                            value="{{ old('no_hp', $peserta->no_hp ?? '') }}">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">No. Handphone (AstraPay) *</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control requiredform" placeholder="Masukkan No. Handphone (AstraPay)" name="no_hp_astrapay"
                                            value="{{ old('no_hp_astrapay', $peserta->no_hp_astrapay ?? '') }}">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Pendidikan Terakhir *</label>
                                        <div class="col-sm-9">
                                            <select class="form-control requiredform" name="pendidikan_terakhir">
                                                <option value="" disabled {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir ?? '') == '' ? 'selected' : '' }}>Pilih Pendidikan</option>
                                                @php
                                                    $pendidikanList = ['SMA/SMK Sederajat', 'Diploma', 'S1', 'S2', 'S3'];
                                                @endphp
                                                @foreach($pendidikanList as $pendidikan)
                                                    <option value="{{ $pendidikan }}" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir ?? '') == $pendidikan ? 'selected' : '' }}>
                                                        {{ $pendidikan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>                                    
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Email *</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control requiredform" placeholder="Masukkan email" name="email"
                                            value="{{ old('email', $peserta->email ?? '') }}">
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Ukuran Baju Peserta *</label>
                                        <div class="col-sm-9">
                                            <select class="form-control requiredform" name="ukuran_baju">
                                                <option value="" disabled {{ old('ukuran_baju', $peserta->ukuran_baju ?? '') == '' ? 'selected' : '' }}>Pilih Ukuran Baju</option>
                                                @php
                                                    $ukuranList = ['S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL'];
                                                @endphp
                                                @foreach($ukuranList as $ukuran)
                                                    <option value="{{ $ukuran }}" {{ old('ukuran_baju', $peserta->ukuran_baju ?? '') == $ukuran ? 'selected' : '' }}>
                                                        {{ $ukuran }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                        </div>
                                    </div>                                    
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Pantangan Makanan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Masukkan Pantangan Makanan" name="pantangan_makanan"
                                            value="{{ old('pantangan_makanan', $peserta->pantangan_makanan ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Riwayat Penyakit</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Masukkan Riwayat Penyakit" name="riwayat_penyakit"
                                            value="{{ old('riwayat_penyakit', $peserta->riwayat_penyakit ?? '') }}">
                                        </div>
                                    </div>

                                    <h6 class="mb-3"><strong>Social Media Pribadi</strong></h6>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Link URL Profile Facebook</label>
                                        <div class="col-sm-9">
                                            <input type="url" class="form-control" placeholder="https://" name="link_facebook" 
                                                   value="{{ old('link_facebook', $peserta->link_facebook ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Link URL Profile Instagram</label>
                                        <div class="col-sm-9">
                                            <input type="url" class="form-control" placeholder="https://" name="link_instagram" 
                                                   value="{{ old('link_instagram', $peserta->link_instagram ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Link URL Profile Tiktok</label>
                                        <div class="col-sm-9">
                                            <input type="url" class="form-control" placeholder="https://" name="link_tiktok" 
                                                   value="{{ old('link_tiktok', $peserta->link_tiktok ?? '') }}">
                                        </div>
                                    </div>                                    

                                    <h6 class="mb-3"><strong>History Keikutsertaan KLHN</strong></h6>
                                    <div id="riwayat-klhn-container">
                                        @php
                                            $maxRiwayat = 3;
                                            $formRiwayat = old('riwayat_klhn', $riwayat_klhn ?? []);
                                            $initialRiwayatCount = count($formRiwayat);
                                        @endphp
                                    
                                        @foreach ($formRiwayat as $i => $riwayat)
                                            <div class="form-group row riwayat-klhn">
                                                <label class="col-sm-3 col-form-label">Tahun Keikutsertaan KLHN Periode Sebelumnya</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" placeholder="Masukkan Tahun"
                                                           name="riwayat_klhn[{{ $i }}][tahun_keikutsertaan]"
                                                           value="{{ old("riwayat_klhn.$i.tahun_keikutsertaan", $riwayat['tahun_keikutsertaan'] ?? '') }}">
                                                </div>
                                            </div>
                                    
                                            <div class="form-group row riwayat-klhn">
                                                <label class="col-sm-3 col-form-label">Kategori</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2-init" name="riwayat_klhn[{{ $i }}][vcategory]">
                                                        <option value="" disabled {{ !isset($riwayat['vcategory']) ? 'selected' : '' }}>Pilih Kategori</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->namacategory }}"
                                                                {{ old("riwayat_klhn.$i.vcategory", $riwayat['vcategory'] ?? '') == $category->namacategory ? 'selected' : '' }}>
                                                                {{ $category->namacategory }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                    
                                            <div class="form-group row riwayat-klhn mb-3">
                                                <label class="col-sm-3 col-form-label">Status Kepesertaan</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="riwayat_klhn[{{ $i }}][status_kepesertaan]">
                                                        <option value="" disabled {{ !isset($riwayat['status_kepesertaan']) ? 'selected' : '' }}>Pilih Status</option>
                                                        @foreach(['Peserta', 'Juara 1', 'Juara 2', 'Juara 3'] as $status)
                                                            <option value="{{ $status }}"
                                                                {{ old("riwayat_klhn.$i.status_kepesertaan", $riwayat['status_kepesertaan'] ?? '') == $status ? 'selected' : '' }}>
                                                                {{ $status }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    @if ($initialRiwayatCount < $maxRiwayat)
                                        <button type="button" id="add-riwayat-klhn" class="btn btn-warning">Add History KLHN</button>
                                    @endif
                            <!-- Data Social Media -->       

