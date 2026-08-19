   <form class="formpendaftaran">
       <label for="exampleFormControlInput1" class="form-label">Tanggal Kunjungan</label>
       <input type="date" class="form-control" id="tanggalkunjungan" name="tanggalkunjungan"
           placeholder="name@example.com" value="{{ $data->tgl_entry }}">
       <input hidden type="text" class="form-control" id="id_kunjungan" name="id_kunjungan" placeholder="name@example.com"
           value="{{ $data->id}}">
       <div class="row mt-2">
           <div class="col-md-6">
               <div class="mb-3">
                   <label for="exampleInputEmail1" class="form-label">Jenis Kunjungan</label>
                   <select class="form-select" aria-label="Default select example" name="jeniskunjungan"
                       id="jeniskunjungan">
                       <option value="0" @if ($data->jenis_kunjungan == 0) selected @endif>Silahkan Pilih</option>
                       <option value="1" @if ($data->jenis_kunjungan == 1) selected @endif>Rawat Jalan</option>
                       <option value="2" @if ($data->jenis_kunjungan == 2) selected @endif>Rawat Inap</option>
                   </select>
               </div>
           </div>
           <div class="col-md-6">
               <div class="mb-3">
                   <label for="exampleInputEmail1" class="form-label">Tujuan Kunjungan</label>
                   <select class="form-select" aria-label="Default select example" name="tujuankunjungan"
                       id="tujuankunjungan">
                       <option value="0">Silahkan Pilih</option>
                       @foreach ($mt_unit as $m)
                           <option value="{{ $m->id }}" @if ($m->id == $data->unit_tujuan) selected @endif>
                               {{ $m->nama_unit }}
                           </option>
                       @endforeach
                   </select>
               </div>
           </div>
       </div>
       <div class="mb-3">
           <label for="exampleInputEmail1" class="form-label">Pilih Dokter</label>
           <select class="form-select" aria-label="Default select example" name="dokter" id="dokter">
               <option value="0">Silahkan Pilih</option>
               @foreach ($dokter as $m)
                   <option value="{{ $m->id }}" @if ($m->id == $data->dokter) selected @endif>
                       {{ $m->nama_lengkap }}</option>
               @endforeach
           </select>
       </div>
       <div class="row">
           <div class="col-md-4">
               <label for="exampleFormControlInput1" class="form-label">Usia</label>
               <div class="input-group mb-3">
                   <input type="text" class="form-control" placeholder="masukan tekanan darah ..."
                       aria-label="Recipient’s username" aria-describedby="basic-addon2" name="usia_kunjungan"
                       id="usia_kunjungan" value="{{ \Carbon\Carbon::parse($mt_pasien[0]->tanggal_lahir)->diff(\Carbon\Carbon::now())->format('%y Tahun, %m Bulan, %d Hari') }}">
                   <span class="input-group-text" id="basic-addon2"></span>
               </div>
           </div>
           <div class="col-md-4">
               <label for="exampleFormControlInput1" class="form-label">Tekanan Darah</label>
               <div class="input-group mb-3">
                   <input type="text" class="form-control" placeholder="masukan tekanan darah ..."
                       aria-label="Recipient’s username" aria-describedby="basic-addon2" name="tekanandarah"
                       id="tekanandarah" value="{{ $data->suhu_tubuh }}">
                   <span class="input-group-text" id="basic-addon2">mmHg </span>
               </div>
           </div>
           <div class="col-md-4">
               <label for="exampleFormControlInput1" class="form-label">Suhu Tubuh</label>
               <div class="input-group mb-3">
                   <input type="text" class="form-control" placeholder="masukan suhu tubuh ..."
                       aria-label="Recipient’s username" aria-describedby="basic-addon2" name="suhutubuh" id="suhutubuh"
                       value="{{ $data->suhu_tubuh }}">
                   <span class="input-group-text" id="basic-addon2">°C </span>
               </div>
           </div>
           <div class="col-md-6">
               <label for="exampleFormControlInput1" class="form-label">Frekuensi Nadi</label>
               <div class="input-group mb-3">
                   <input type="text" class="form-control" placeholder="masukan frekuensi nadi ..."
                       aria-label="Recipient’s username" aria-describedby="basic-addon2" name="frekuensinadi"
                       id="frekuensinadi" value="{{ $data->suhu_tubuh }}">
                   <span class="input-group-text" id="basic-addon2">x / menit </span>
               </div>
           </div>
           <div class="col-md-6">
               <label for="exampleFormControlInput1" class="form-label">Frekuensi Nafas</label>
               <div class="input-group mb-3">
                   <input type="text" class="form-control" placeholder="masukan frekuensi Nafas ..."
                       aria-label="Recipient’s username" aria-describedby="basic-addon2" name="frekuensinafas"
                       id="frekuensinafas" value="{{ $data->suhu_tubuh }}">
                   <span class="input-group-text" id="basic-addon2">x / menit</span>
               </div>
           </div>
           <div class="col-md-6">
               <label for="exampleFormControlInput1" class="form-label">Saturasi ( SpO₂ )</label>
               <div class="input-group mb-3">
                   <input type="text" class="form-control" placeholder="masukan saturasi oksigen ..."
                       aria-label="Recipient’s username" aria-describedby="basic-addon2" name="saturasi_oksigen"
                       id="saturasi_oksigen" value="{{ $data->suhu_tubuh }}">
                   <span class="input-group-text" id="basic-addon2">%</span>
               </div>
           </div>
           <div class="col-md-6">
               <label for="exampleFormControlInput1" class="form-label">Tinggi Badan</label>
               <div class="input-group mb-3">
                   <input type="text" class="form-control" placeholder="masukan tinggi badan ..."
                       aria-label="Recipient’s username" aria-describedby="basic-addon2" name="tinggi_badan"
                       id="tinggi_badan" value="{{ $data->suhu_tubuh }}">
                   <span class="input-group-text" id="basic-addon2"></span>
               </div>
           </div>
           <div class="col-md-6">
               <label for="exampleFormControlInput1" class="form-label">Berat Badan</label>
               <div class="input-group mb-3">
                   <input type="text" class="form-control" placeholder="masukan berat badan ..."
                       aria-label="Recipient’s username" aria-describedby="basic-addon2" name="berat_badan"
                       id="berat_badan" value="{{ $data->suhu_tubuh }}">
                   <span class="input-group-text" id="basic-addon2"></span>
               </div>
           </div>
           <div class="col-md-6">
               <label for="exampleFormControlInput1" class="form-label">Riwayat Alergi</label>
               <div class="input-group mb-3">
                   <textarea type="text" class="form-control" placeholder="masukan riwayat alergi ..."
                       aria-label="Recipient’s username" aria-describedby="basic-addon2" name="riwayat_alergi" id="riwayat_alergi">{{ $data->riwayat_alergi }}</textarea>
               </div>
           </div>
           <div class="col-md-6">
               <label for="exampleFormControlInput1" class="form-label">Riwayat penyakit</label>
               <div class="input-group mb-3">
                   <textarea type="text" class="form-control" placeholder="masukan riwayat penyakit ..."
                       aria-label="Recipient’s username" aria-describedby="basic-addon2" name="riwayat_penyakit" id="riwayat_penyakit">{{ $data->riwayat_penyakit }}</textarea>
               </div>
           </div>
       </div>
       <label for="exampleFormControlInput1" class="form-label">Keluhan Utama</label>
       <div class="input-group mb-3">
           <textarea rows="5" type="text" class="form-control" placeholder="masukan keluhan pasien ..."
               aria-label="Recipient’s username" aria-describedby="basic-addon2" name="keluhanutama" name="keluhanutama">{{ $data->keluhan_utama }}</textarea>
       </div>
       <button type="button" class="btn btn-primary" onclick="simpanedit()"><i class="bi bi-floppy"
               style="margin-right: 12px"></i> Simpan</button>
   </form>
   <script>
       function simpanedit() {
           Swal.fire({
               title: "Anda yakin ?",
               text: "Data Pendaftaran akan disimpan !",
               icon: "question",
               showCancelButton: true,
               confirmButtonColor: "#3085d6",
               cancelButtonColor: "#d33",
               confirmButtonText: "Ya Simpan ..."
           }).then((result) => {
               if (result.isConfirmed) {
                   simpanpendaftaran2()
               }
           });
       }

       function simpanpendaftaran2() {
           var data = $('.formpendaftaran').serializeArray();
           spinner = $('#loader')
           spinner.show();
           $.ajax({
               async: true,
               type: 'post',
               dataType: 'json',
               data: {
                   _token: "{{ csrf_token() }}",
                   data: JSON.stringify(data),
               },
               url: '<?= route('simpaneditpendaftaranpasien') ?>',
               error: function(data) {
                   spinner.hide()
                   Swal.fire({
                       icon: 'error',
                       title: 'Ooops....',
                       text: 'Sepertinya ada masalah......',
                       footer: ''
                   })
               },
               success: function(data) {
                   spinner.hide()
                   if (data.kode == 500) {
                       Swal.fire({
                           icon: 'error',
                           title: 'Oopss...',
                           text: data.message,
                           footer: ''
                       })
                   } else {
                       Swal.fire({
                           icon: 'success',
                           title: 'OK',
                           text: data.message,
                           footer: ''
                       })
                       location.reload()
                       const myForm = document.getElementById('formpendaftaran');
                       myForm.reset();
                   }
               }
           });
       }
   </script>
