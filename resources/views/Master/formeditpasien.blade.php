     <form class="formeditpasien" id="formeditpasien">
         <div class="row">
             <div class="col-md-4">
                 <div class="mb-3">
                     <label for="exampleInputEmail1" class="form-label">Pilih Jenis Kartu Identitas</label>
                     <select class="form-select" aria-label="Default select example" name="editjenisidentitas"
                         id="jenisidentitas">
                         <option value="0" @if ($pasien[0]->jenis_identitas == 0) selected @endif>-</option>
                         <option value="1" @if ($pasien[0]->jenis_identitas == 1) selected @endif>KTP</option>
                     </select>
                 </div>
             </div>
             <div class="col-md-4">
                 <div class="mb-3">
                     <label for="exampleInputEmail1" class="form-label">Nomor Kartu Identitas</label>
                     <input type="email" class="form-control" id="nomoridentitas" name="editnomoridentitas"
                         placeholder="Masukan nomor kartu identitas ..." aria-describedby="emailHelp"
                         value="{{ $pasien[0]->nomor_identitas }}">
                     <input hidden type="email" class="form-control" id="idpasien" name="idpasien"
                         placeholder="Masukan nomor kartu identitas ..." aria-describedby="emailHelp"
                         value="{{ $pasien[0]->id }}">
                 </div>
             </div>
             <div hidden class="col-md-4">
                 <div class="mb-3">
                     <label for="exampleInputEmail1" class="form-label">Nomor Asuransi</label>
                     <input type="email" class="form-control" id="nomorasuransi" name="editnomorasuransi"
                         aria-describedby="emailHelp" value="{{ $pasien[0]->nomor_asuransi }}">
                 </div>
             </div>
         </div>
         <div class="row">
             <div class="col-md-4">
                 <div class="mb-3">
                     <label for="exampleInputEmail1" class="form-label">Nama Pasien</label>
                     <input type="email" class="form-control" id="namapasien" name="editnamapasien"
                         aria-describedby="emailHelp" placeholder="Masukan Nama Pasien ..."
                         value="{{ $pasien[0]->nama_pasien }}">
                 </div>
             </div>
             <div class="col-md-2">
                 <div class="mb-3">
                     <label for="exampleInputEmail1" class="form-label">Status Pernikahan</label>
                     <select class="form-select" aria-label="Default select example" name="editstatus_pernikahan"
                         id="status_pernikahan">
                         <option value="0" @if ($pasien[0]->status_pernikahan == 0) selected @endif>-</option>
                         <option value="1" @if ($pasien[0]->status_pernikahan == 1) selected @endif>Menikah</option>
                         <option value="2" @if ($pasien[0]->status_pernikahan == 2) selected @endif>Belum Menikah</option>
                     </select>
                 </div>
             </div>
         </div>
         <div class="row">
             <div class="col-md-4">
                 <div class="mb-3">
                     <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                     <select class="form-select" aria-label="Default select example" name="editjeniskelamin"
                         id="jeniskelamin">
                         <option value="PRIA" @if ($pasien[0]->jenis_kelamin == 'PRIA') selected @endif>PRIA</option>
                         <option value="WANITA" @if ($pasien[0]->jenis_kelamin == 'WANITA') selected @endif>WANITA</option>
                     </select>
                 </div>
             </div>
             <div class="col-md-3">
                 <div class="mb-3">
                     <label for="exampleInputEmail1" class="form-label">Tempat Lahir</label>
                     <input type="email" class="form-control" id="tempatelahir" name="edittempatlahir"
                         aria-describedby="emailHelp" placeholder="Masukan kota tempat lahir ..."
                         value="{{ $pasien[0]->tempat_lahir }}">
                 </div>
             </div>
             <div class="col-md-3">
                 <div class="mb-3">
                     <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                     <input type="date" class="form-control" id="tanggallahir" name="edittanggallahir"
                         aria-describedby="emailHelp" value="{{ $pasien[0]->tanggal_lahir }}">
                 </div>
             </div>
         </div>
         <div class="card mt-2">
             <div class="card-header">ALAMAT</div>
             <div class="card-body">
                 {{-- <div class="row">
                     <div class="col-md-3">
                         <div class="mb-3">
                             <label for="exampleInputEmail1" class="form-label">Provinsi</label>
                             <input type="text" class="form-control" id="editprovinsi" name="editprovinsi"
                                 aria-describedby="emailHelp" placeholder="silahkan pilih provinsi ..."
                                 value="{{ $provinsi[0]->name }}">
                             <input readonly type="text" class="form-control" id="editidprovinsi"
                                 name="editidprovinsi" aria-describedby="emailHelp"
                                 value="{{ $pasien[0]->provinsi }}">
                         </div>
                     </div>
                     <div class="col-md-3">
                         <div class="mb-3">
                             <label for="exampleInputEmail1" class="form-label">Kabupaten</label>
                             <input type="email" class="form-control" id="editkabupaten" name="editkabupaten"
                                 aria-describedby="emailHelp" placeholder="Silahkan pilih kabupaten ..."
                                 value="{{ $kab[0]->name }}">
                             <input readonly type="email" class="form-control" id="editidkabupaten"
                                 name="editidkabupaten" aria-describedby="emailHelp"
                                 value="{{ $pasien[0]->kabupaten }}">
                         </div>
                     </div>
                     <div class="col-md-3">
                         <div class="mb-3">
                             <label for="exampleInputEmail1" class="form-label">Kecamatan</label>
                             <input type="email" class="form-control" id="editkecamatan" name="editkecamatan"
                                 aria-describedby="emailHelp" placeholder="Silahkan pilih kecamatan ..."
                                 value="{{ $kec[0]->name }}">
                             <input readonly type="email" class="form-control" id="editidkecamatan"
                                 name="editidkecamatan" aria-describedby="emailHelp"
                                 value="{{ $pasien[0]->kecamatan }}">
                         </div>
                     </div>
                     <div class="col-md-3">
                         <div class="mb-3">
                             <label for="exampleInputEmail1" class="form-label">Desa</label>
                             <input type="email" class="form-control" id="editdesa" name="editdesa"
                                 aria-describedby="emailHelp" placeholder="Silahkan Pilih Desa ..."
                                 value="{{ $desa[0]->name }}">
                             <input readonly type="email" class="form-control" id="editiddesa" name="editiddesa"
                                 aria-describedby="emailHelp" value="{{ $pasien[0]->desa }}">
                         </div>
                     </div>
                 </div> --}}
                 <div class="row">
                     <div class="col-md-5">
                         <div class="mb-3">
                             <label for="exampleInputEmail1" class="form-label">Alamat Lengkap</label>
                             <textarea type="email" class="form-control" id="alamatlengkap" name="editalamatlengkap"
                                 aria-describedby="emailHelp" placeholder="masukan alamat lengkap , contoh : RT 002 RW 006 JL. MERDEKA BLOK 1">{{ $pasien[0]->alamat_domisili }}</textarea>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </form>
     <script>
         $(document).ready(function() {
             $("#editprovinsi").autocomplete({
                 source: function(request, response) {
                     $.ajax({
                         url: "{{ route('route.cari.provinsi') }}", // Ganti dengan route Anda
                         data: {
                             term: request.term
                         },
                         dataType: "json",
                         success: function(data) {
                             response(data);
                         }
                     });
                 },
                 minLength: 2, // Minimal ketik 2 huruf baru mencari
                 select: function(event, ui) {
                     // Saat obat dipilih, masukkan label ke input dan ID ke hidden input
                     $("#editprovinsi").val(ui.item.label);
                     $("#editidprovinsi").val(ui.item.id);
                     return false;
                 }
             });
             $("#editkabupaten").autocomplete({
                 source: function(request, response) {
                     $.ajax({
                         url: "{{ route('route.cari.kabupaten') }}", // Ganti dengan route Anda
                         data: {
                             term: request.term,
                             idprovinsi: $('#editidprovinsi').val()
                         },
                         dataType: "json",
                         success: function(data) {
                             response(data);
                         }
                     });
                 },
                 minLength: 2, // Minimal ketik 2 huruf baru mencari
                 select: function(event, ui) {
                     // Saat obat dipilih, masukkan label ke input dan ID ke hidden input
                     $("#editkabupaten").val(ui.item.label);
                     $("#editidkabupaten").val(ui.item.id);
                     return false;
                 }
             });
             $("#editkecamatan").autocomplete({
                 source: function(request, response) {
                     $.ajax({
                         url: "{{ route('route.cari.kecamatan') }}", // Ganti dengan route Anda
                         data: {
                             term: request.term,
                             idkabupaten: $('#editidkabupaten').val()
                         },
                         dataType: "json",
                         success: function(data) {
                             response(data);
                         }
                     });
                 },
                 minLength: 2, // Minimal ketik 2 huruf baru mencari
                 select: function(event, ui) {
                     // Saat obat dipilih, masukkan label ke input dan ID ke hidden input
                     $("#editkecamatan").val(ui.item.label);
                     $("#editidkecamatan").val(ui.item.id);
                     return false;
                 }
             });
             $("#editdesa").autocomplete({
                 source: function(request, response) {
                     $.ajax({
                         url: "{{ route('route.cari.desa') }}", // Ganti dengan route Anda
                         data: {
                             term: request.term,
                             idkecamatan: $('#editidkecamatan').val()
                         },
                         dataType: "json",
                         success: function(data) {
                             response(data);
                         }
                     });
                 },
                 minLength: 2, // Minimal ketik 2 huruf baru mencari
                 select: function(event, ui) {
                     // Saat obat dipilih, masukkan label ke input dan ID ke hidden input
                     $("#editdesa").val(ui.item.label);
                     $("#editiddesa").val(ui.item.id);
                     return false;
                 }
             });
         });
     </script>
