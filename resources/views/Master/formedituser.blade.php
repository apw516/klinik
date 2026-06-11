       <form class="formedituser" id="formedituser">
           <div class="row">
               <div class="col-md-12">
                   <div class="mb-3">
                       <label for="exampleInputEmail1" class="form-label">Username</label>
                       <input type="text" class="form-control" value="{{ $data->username }}" id="username"
                           name="username" placeholder="Masukan username ..." aria-describedby="emailHelp">
                       <input hidden type="text" class="form-control" value="{{ $data->id }}" id="ID"
                           name="ID" placeholder="Masukan NIP ..." aria-describedby="emailHelp">
                   </div>
               </div>
               <div class="col-md-12">
                   <div class="mb-3">
                       <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                       <input type="text" class="form-control" value="{{ $data->nama }}" id="namalengkap"
                           name="namalengkap" placeholder="Masukan NIP ..." aria-describedby="emailHelp">
                   </div>
               </div>
               <div class="col-md-12">
                   <div class="mb-3">
                       <label for="exampleInputEmail1" class="form-label">Hak Akses</label>
                       <select class="form-select" aria-label="Default select example" name="hak_akses" id="hak_akses">
                           @foreach ($hak as $f)
                               <option @if ($data->hak_akses == $f->id) selected @endif value="{{ $f->id }}">
                                   {{ $f->nama }}
                               </option>
                           @endforeach
                       </select>
                   </div>
               </div>
               <div class="col-md-12">
                   <div class="mb-3">
                       <label for="exampleInputEmail1" class="form-label">Status</label>
                       <select class="form-select" aria-label="Default select example" name="status" id="status">
                           <option @if ($data->is_activated == 1) selected @endif value="1">
                               Aktif
                           </option>
                           <option @if ($data->is_activated == 0) selected @endif value="0">
                               Tidak Aktif
                           </option>
                       </select>
                   </div>
               </div>
               <div class="col-md-12">
                   <div class="mb-3">
                       <label for="exampleInputEmail1" class="form-label">Reset Password</label>
                       <select class="form-select" aria-label="Default select example" name="resetpassword" id="resetpassword">
                           <option value="1">
                               Tidak
                           </option>
                           <option value="2">
                               Ya, Reset
                           </option>
                       </select>
                   </div>
               </div>
           </div>
       </form>
