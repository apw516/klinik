      <form action="" class="formeditmasterbarang">
          <div class="row g-3">
              <div class="col-md-8">
                  <label for="nama_barang" class="form-label small fw-bold text-secondary">Nama Barang</label>
                  <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                      placeholder="Contoh: Amoxicillin 500mg" required value="{{ $data['nama_barang'] }}">
                  <input hidden type="text" class="form-control" id="id_barang" name="id_barang"
                      placeholder="Contoh: Amoxicillin 500mg" required value="{{ $data['id'] }}">
              </div>

              <div class="col-md-6">
                  <label for="nama_generik" class="form-label small fw-bold text-secondary">Nama Display</label>
                  <input type="text" class="form-control" id="nama_generik" name="nama_generik"
                      placeholder="Contoh: Amoxicillin Trihydrate" value="{{ $data['nama_display'] }}">
              </div>
              <hr class="my-2 text-muted">
              <div class="col-md-4">
                  <label for="satuan_besar" class="form-label small fw-bold text-secondary">Harga Normal</label>
                  <input type="text" class="form-control" id="satuan_besar" name="satuan_besar"
                      placeholder="Contoh: Box / Karton" required value="{{ $data['harga_normal'] }}">
              </div>

              <div class="col-md-4">
                  <label for="satuan_sedang" class="form-label small fw-bold text-secondary">Harga Tebus</label>
                  <input type="text" class="form-control" id="satuan_sedang" name="satuan_sedang"
                      placeholder="Contoh: Strip / Botol" value="{{ $data['harga_tebus'] }}">
              </div>

              <div class="col-md-4">
                  <label for="satuan_kecil" class="form-label small fw-bold text-secondary">Golongan Obat</label>
                  <input type="text" class="form-control" id="satuan_kecil" name="satuan_kecil"
                      placeholder="Contoh: Tablet / Pcs" required value="{{ $data['golongan_obat'] }}">
              </div>

              <div class="col-6">
                  <label for="isi_konversi" class="form-label small fw-bold text-secondary">Aturan Pakai
                      Satuan</label>
                  <input type="text" class="form-control" id="bentuk_sediaan" name="bentuk_sediaan"
                      placeholder="Contoh: inject atau tablet" value="{{ $data['aturan_pakai'] }}">
              </div>             
          </div>
      </form>
      <script>
         
      </script>
