      <form action="" class="formeditmasterbarang">
          <div class="row g-3">
              <div class="col-md-8">
                  <label for="nama_barang" class="form-label small fw-bold text-secondary">Nama Komersial /
                      Barang</label>
                  <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                      placeholder="Contoh: Amoxicillin 500mg" required value="{{ $data['nama_barang'] }}">
                  <input hidden type="text" class="form-control" id="id_barang" name="id_barang"
                      placeholder="Contoh: Amoxicillin 500mg" required value="{{ $data['id'] }}">
              </div>

              <div class="col-md-6">
                  <label for="nama_generik" class="form-label small fw-bold text-secondary">Nama Generik
                      (Kandungan)</label>
                  <input type="text" class="form-control" id="nama_generik" name="nama_generik"
                      placeholder="Contoh: Amoxicillin Trihydrate" value="{{ $data['nama_generik'] }}">
              </div>

              <div class="col-md-6">
                  <label for="nama_pabrik" class="form-label small fw-bold text-secondary">Nama Pabrik /
                      Produsen</label>
                  <input type="text" class="form-control" id="nama_pabrik" name="nama_pabrik"
                      placeholder="Contoh: Kimia Farma / Sanbe" value="{{ $data['nama_pabrik'] }}">
              </div>

              <hr class="my-2 text-muted">

              <div class="col-md-6">
                  <label for="jenis_barang" class="form-label small fw-bold text-secondary">Jenis
                      Barang</label>
                  <select class="form-select" id="jenis_barang" name="jenis_barang" required>
                      <option @if ($data['jenis_barang'] == 'Obat') selected @endif value="Obat" selected>Obat</option>
                      <option @if ($data['jenis_barang'] == 'Alkes') selected @endif value="Alkes">Alat Kesehatan (Alkes)
                      </option>
                      <option @if ($data['jenis_barang'] == 'BHP') selected @endif value="BHP">Bahan Habis Pakai (BHP)
                      </option>
                  </select>
              </div>

              <div class="col-md-6">
                  <label for="kategori_obat" class="form-label small fw-bold text-secondary">Kategori Regulasi
                      Obat</label>
                  <select class="form-select" id="kategori_obat" name="kategori_obat" required>
                      <option @if ($data['kategori_obat'] == 'Bebas') selected @endif value="Bebas">Obat Bebas (Hijau)
                      </option>
                      <option @if ($data['kategori_obat'] == 'Bebas Terbatas') selected @endif value="Bebas Terbatas">Obat Bebas
                          Terbatas (Biru)</option>
                      <option @if ($data['kategori_obat'] == 'Keras') selected @endif value="Keras">Obat Keras (Merah / K)
                      </option>
                      <option @if ($data['kategori_obat'] == 'Psikotropika') selected @endif value="Psikotropika">Psikotropika
                      </option>
                      <option @if ($data['kategori_obat'] == 'Narkotika') selected @endif value="Narkotika">Narkotika</option>
                      <option @if ($data['kategori_obat'] == 'Non-Obat') selected @endif value="Non-Obat">Non-Obat / Alkes
                      </option>
                  </select>
              </div>

              <hr class="my-2 text-muted">

              <div class="col-md-4">
                  <label for="satuan_besar" class="form-label small fw-bold text-secondary">Satuan Besar
                      (Pembelian)</label>
                  <input type="text" class="form-control" id="satuan_besar" name="satuan_besar"
                      placeholder="Contoh: Box / Karton" required value="{{ $data['satuan_besar'] }}">
              </div>

              <div class="col-md-4">
                  <label for="satuan_sedang" class="form-label small fw-bold text-secondary">Satuan Sedang
                      (Opsional)</label>
                  <input type="text" class="form-control" id="satuan_sedang" name="satuan_sedang"
                      placeholder="Contoh: Strip / Botol" value="{{ $data['satuan_sedang'] }}">
              </div>

              <div class="col-md-4">
                  <label for="satuan_kecil" class="form-label small fw-bold text-secondary">Satuan Kecil
                      (Eceran/Resep)</label>
                  <input type="text" class="form-control" id="satuan_kecil" name="satuan_kecil"
                      placeholder="Contoh: Tablet / Pcs" required value="{{ $data['satuan_kecil'] }}">
              </div>

              <div class="col-6">
                  <label for="isi_konversi" class="form-label small fw-bold text-secondary">Bentuk Sediaan
                      Satuan</label>
                  <input type="text" class="form-control" id="bentuk_sediaan" name="bentuk_sediaan"
                      placeholder="Contoh: inject atau tablet" value="{{ $data['bentuk_sediaan'] }}">
              </div>
              <div class="col-6">
                  <label for="isi_konversi" class="form-label small fw-bold text-secondary">Isi Konversi
                      Satuan</label>
                  <input type="text" class="form-control" id="isi_konversi" name="isi_konversi"
                      placeholder="Contoh: 1 box berisi 100 tablet, maka isi dengan angka 100"
                      value="{{ $data['isi_konversi'] }}">
              </div>
              <div class="col-6">
                  <label for="isi_konversi" class="form-label small fw-bold text-secondary">Harga Jual Satuan
                      kecil</label>
                  <label hidden for="isi_konversi" class="form-label small fw-bold text-secondary"
                      id="label_asli">Harga Jual Satuan
                      kecil</label>
                  <input type="text" class="form-control" id="harga_jual_disp" name="harga_jual_disp"
                      placeholder="Contoh: 1.000" value="{{ $data['harga_jual'] }}">
                  <input hidden type="text" class="form-control" id="harga_jual" name="harga_jual"
                      placeholder="Contoh: 1.000" value="{{ $data['harga_jual'] }}">
              </div>
          </div>
      </form>
      <script>
          $(document).ready(function() {

              const inputMask = document.getElementById('harga_jual_disp');
              const inputAsli = document.getElementById('harga_jual');
              const labelAsli = document.getElementById('label_asli');

              inputMask.addEventListener('keyup', function() {
                  let nominal = this.value.replace(/[^,\d]/g, '').toString();
                  inputAsli.value = nominal;
                  labelAsli.innerText = nominal ? formatRupiah(nominal) : '0';
                  this.value = nominal ? formatRupiah(nominal) : '';
              });
              function formatRupiah(angka) {
                  let number_string = angka.replace(/[^,\d]/g, '').toString(),
                      split = number_string.split(','),
                      sisa = split[0].length % 3,
                      rupiah = split[0].substr(0, sisa),
                      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                  if (ribuan) {
                      let separator = sisa ? '.' : '';
                      rupiah += separator + ribuan.join('.');
                  }
                  return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
              }
          })
      </script>
