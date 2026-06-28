 <button class="btn btn-info mt-2" data-bs-toggle="modal" data-bs-target="#modalobat">
     <i class="bi bi-search"></i> Obat </button>
 <div class="card mt-2">
     <div class="card-header">Data Obat Yang Akan diberikan ...</div>
     <div class="card-body">
         <div class="v_obat"></div>
     </div>
 </div>
 <div class="modal fade" id="modalobat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h1 class="modal-title fs-5" id="exampleModalLabel">Silahkan Pilih Obat</h1>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <table id="tabelstok" class="table table-sm table-bordered table-hover align-middle">
                     <thead class="table-light text-xs">
                         <tr>
                             <th>Nama Barang</th>
                             <th class="text-center" style="width: 15%;">Stok</th>
                             <th>Aturan Pakai</th>
                         </tr>
                     </thead>
                     <tbody class="text-xs">
                         @foreach ($mt_barang as $item)
                             <tr class="btn-pilih-barang" style="cursor: pointer;" data-kode="{{ $item->kode_barang }}"
                                 data-nama="{{ $item->nama_barang }}" data-stok="{{ $item->stok_global }}"
                                 data-aturan="{{ $item->aturan_pakai ?? 'Sesudah Makan' }}">

                                 <td class="fw-semibold text-dark">{{ $item->nama_barang }}</td>
                                 <td class="text-center">
                                     <span
                                         class="badge {{ $item->stok_global > 10 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} px-2 py-1">
                                         {{ $item->stok_global }}
                                     </span>
                                 </td>
                                 <td class="text-muted">{{ $item->aturan_pakai ?? '-' }}</td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
             </div>
         </div>
     </div>
 </div>
 <input hidden type="text" value="{{ $idlayananheader }}" id="idlayananheader">
 <script>
     $(document).ready(function() {
         tampilkanorderresep();
     });

     function tampilkanorderresep() {
         let idlayananheader = $('#idlayananheader').val();
         let spinner = $('#loader');
         spinner.show();
         $.ajax({
             type: 'post',
             data: {
                 _token: "{{ csrf_token() }}",
                 idlayananheader: idlayananheader
             },
             url: '{{ route('ambildataorderobat') }}',
             success: function(response) {
                 spinner.hide();
                 $('.v_obat').html(response);
             }
         });
     }
 </script>
