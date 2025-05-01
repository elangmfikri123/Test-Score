                                <!-- Identitas Atasan -->    
                                    <h6 class="mb-3"><strong>Identitas Atasan Langsung Peserta</strong></h6>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Nama Lengkap Atasan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Masukkan Nama Atasan" name="nama_lengkap_atasan"
                                            value="{{ old('nama_lengkap_atasan', $peserta->identitasAtasan->nama_lengkap_atasan ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Jabatan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Masukkan Jabatan" name="jabatan_atasan"
                                            value="{{ old('jabatan_atasan', $peserta->identitasAtasan->jabatan ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">No. Handphone/WhatsApp</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" placeholder="Masukkan No. HP" name="no_hp_atasan"
                                            value="{{ old('no_hp_atasan', $peserta->identitasAtasan->no_hp ?? '') }}">
                                        </div>
                                    </div>
                                  