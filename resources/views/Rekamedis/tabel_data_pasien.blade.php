     <table id="tbmasterpasien" class="table table-sm table-bordered table-hover">
         <thead>
             <th>Nomor RM</th>
             <th>Nomor Identitas</th>
             <th>ID Satu Sehat</th>
             <th>Nama Pasien</th>
             <th>Tempat,Tanggal lahir & Jenis Kelamin</th>
             <th>Alamat Domisili</th>
             <th>Nomor Asuransi</th>
             <th>Nama Asuransi</th>
             {{-- <th>Nama Klinik</th> --}}
             <th></th>
         </thead>
         <tbody>
             @foreach ($data as $d)
                 <tr>
                     <td>{{ $d->no_rm }}</td>
                     <td>{{ $d->NIK }} | {{ $d->jenis_identitas }}</td>
                     <td>{{ $d->id_satu_sehat }}</td>
                     <td>{{ $d->nama_pasien }}</td>
                     <td>{{ $d->tempat_lahir }}, {{ $d->TGL_LAHIR }} , {{ $d->jenis_kelamin }}</td>
                     <td>{{ $d->alamat }}</td>
                     <td>{{ $d->nomor_asuransi }}</td>
                     <td>{{ $d->nama_asuransi }}</td>
                     {{-- <td>{{ $d->nama_klinik }}</td> --}}
                     <td>
                         <button class="btn btn-success pendaftaran" nomor_rm="{{ $d->no_rm }}"><i
                                 class="bi bi-box-arrow-in-right"></i></button>
                         {{-- <button class="btn btn-info"><i class="bi bi-pencil-square"></i></button> --}}
                     </td>
                 </tr>
             @endforeach
         </tbody>
     </table>
     <script>
         $(function() {
             $("#tbmasterpasien").DataTable({
                 "responsive": true,
                 "lengthChange": false,
                 "autoWidth": false,
                 "pageLength": 12,
                 "searching": true,
                 "ordering": false,
             })
         });
         $(".pendaftaran").on('click', function(event) {
             rm = $(this).attr('nomor_rm')
             spinner = $('#loader')
             spinner.show();
             $.ajax({
                 type: 'post',
                 data: {
                     _token: "{{ csrf_token() }}",
                     rm
                 },
                 url: '<?= route('ambilformpendaftaran') ?>',
                 error: function(response) {
                     spinner.hide();
                     alert('error')
                 },
                 success: function(response) {
                     spinner.hide();
                     $('.v_1').attr('hidden', true)
                     $('.v_2').removeAttr('hidden', true)
                     $('.v_data_pasien').html(response);

                 }
             });
         });
     </script>
