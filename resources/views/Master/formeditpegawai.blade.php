       <form class="formpegawaiedit" id="formpegawaiedit">
           <div class="row">
               <div class="col-md-6">
                   <div class="mb-3">
                       <label for="exampleInputEmail1" class="form-label">NIP</label>
                       <input type="text" class="form-control" value="{{ $data->NIP }}" id="NIP"
                           name="NIP" placeholder="Masukan NIP ..." aria-describedby="emailHelp">
                       <input hidden type="text" class="form-control" value="{{ $data->id }}" id="ID"
                           name="ID" placeholder="Masukan NIP ..." aria-describedby="emailHelp">
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="mb-3">
                       <label for="exampleInputPassword1" class="form-label">NIK</label>
                       <input type="text" class="form-control" value="{{ $data->NIK }}" id="NIK"
                           name="NIK" placeholder="Masukan NIK ...">
                   </div>
               </div>
               <div class="col-md-12">
                   <div class="mb-3">
                       <label for="exampleInputPassword1" class="form-label">Nama Lengkap</label>
                       <input type="text" class="form-control" value="{{ $data->nama_lengkap }}" id="namalengkap"
                           name="namalengkap" placeholder="Masukan nama lengkap ...">
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="mb-3">
                       <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                       <input type="date" class="form-control" value="{{ $data->tanggal_lahir }}" id="tanggallahir"
                           name="tanggallahir" aria-describedby="emailHelp">
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="mb-3">
                       <label for="exampleInputEmail1" class="form-label">Tempat Lahir</label>
                       <input type="text" class="form-control" value="{{ $data->tempat_lahir }}" id="tempatlahir"
                           name="tempatlahir" placeholder="Masukan tempat lahir ..." aria-describedby="emailHelp">
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="mb-3">
                       <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                       <select class="form-select" aria-label="Default select example" name="jeniskelamin"
                           id="jeniskelamin">
                           <option @if ($data->jenis_kelamin == 'L') selected @endif value="L">Laki - Laki</option>
                           <option @if ($data->jenis_kelamin == 'P') selected @endif value="P">Perempuan</option>
                       </select>
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="mb-3">
                       <label for="exampleInputEmail1" class="form-label">Nomor Telp</label>
                       <input type="text" class="form-control" value="{{ $data->no_telp }}" id="nomortelepon"
                           name="nomortelepon" aria-describedby="emailHelp">
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="mb-3">
                       <label for="exampleInputPassword1" class="form-label">Alamat</label>
                       <textarea type="text" class="form-control" value="{{ $data->alamat }}" id="alamat" name="alamat"
                           placeholder="Masukan alamat ..."></textarea>
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="mb-3">
                       <label for="exampleInputEmail1" class="form-label">Jabatan</label>
                       <input type="text" class="form-control" value="{{ $data->posisi_kerja }}" id="jabatan"
                           name="jabatan" aria-describedby="emailHelp"
                           placeholder="Masukan jabatan pekerjaan cth : DOKTER ">
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="mb-3">
                       <label for="exampleInputEmail1" class="form-label">Tanggal Masuk</label>
                       <input type="date" class="form-control" value="{{ $data->tanggal_masuk }}"
                           id="tanggalmasuk" name="tanggalmasuk" aria-describedby="emailHelp">
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="mb-3">
                       <label for="exampleInputEmail1" class="form-label">Status</label>
                       <select class="form-select" aria-label="Default select example" name="status"
                           id="status">
                           <option @if ($data->status == '1') selected @endif value="1">Aktif
                           </option>
                           <option @if ($data->status == '0') selected @endif value="0">Tidak Aktif</option>
                       </select>
                   </div>
               </div>
           </div>
       </form>
