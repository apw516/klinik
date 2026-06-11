 <div class="card">
     <div class="card-header">
         <h6 class="fw-bold text-secondary text-uppercase mb-3 d-flex align-items-center"
             style="font-size: 0.8rem; letter-spacing: 0.5px;">
             <i class="bi bi-file-earmark-medical-fill text-primary me-2"></i>
             Hasil Laboratorium            
         </h6>
     </div>
     <div class="card-body">
         <style>
             /* CSS Kustom agar Input Menyatu Sempurna dengan Tabel */
             .table-input-seamless {
                 vertical-align: middle !important;
             }

             .table-input-seamless td {
                 padding: 4px 8px !important;
                 /* Memperkecil padding agar tabel lebih ringkas */
                 vertical-align: middle !important;
             }

             .table-input-seamless .input-group {
                 margin-bottom: 0 !important;
                 /* Menghilangkan margin bawaan bootstrap */
                 border: 1px solid #dee2e6;
                 /* Membuat border luar membungkus input + satuan */
                 border-radius: 4px;
                 background-color: #fff;
                 transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
             }

             /* Efek Fokus saat User Mengklik Kolom Hasil */
             .table-input-seamless .input-group:focus-within {
                 border-color: #80bdff;
                 outline: 0;
                 box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
             }

             .table-input-seamless .form-control-minimal {
                 border: none !important;
                 /* Menghapus border internal input */
                 background-color: transparent !important;
                 padding: 4px 8px;
                 height: auto;
                 text-align: right;
                 /* Angka hasil lab umumnya rata kanan */
                 font-weight: 600;
                 color: #495057;
             }

             .table-input-seamless .form-control-minimal:focus {
                 box-shadow: none !important;
                 outline: none !important;
             }

             .table-input-seamless .unit-text {
                 border: none !important;
                 /* Menghapus border internal addon */
                 background-color: transparent !important;
                 color: #6c757d;
                 font-size: 0.85rem;
                 padding-left: 4px;
                 padding-right: 8px;
             }
         </style>
         <div class="border rounded-3 bg-white overflow-hidden mb-5 shadow-xs">
             <table class="table table-sm table-bordered table-input-seamless">
                 <thead class="bg-light text-center">
                     <tr>
                         <th class="align-middle">JENIS PEMERIKSAAN</th>
                         <th class="align-middle" rowspan="2" style="width: 25%;">HASIL</th>
                         <th class="align-middle" rowspan="2" colspan="2">NILAI RUJUKAN</th>
                     </tr>
                     <tr>
                         <th class="text-left text-primary fw-bold">HEMATOLOGI RUTIN</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td class="fw-semibold">Hemoglobin Rutin</td>
                         <td>
                             <div class="input-group">
                                 {{-- 
                        Menggunakan Null Coalescing Operator (??) untuk mengisi value.
                        Jika $hasillab ada nilainya, tampilkan hb_hasil. Jika kosong, isi dengan string kosong ''.
                    --}}
                                 <input readonly type="text" name="hb_hasil"
                                     class="form-control form-control-minimal" placeholder="0.0"
                                     value="{{ $hasillab->hb_hasil ?? '' }}">
                                 <span class="input-group-text unit-text">gr/dl</span>
                             </div>
                         </td>
                         <td>P : 12 – 15,5 gr/dl</td>
                         <td>L : 13,5 – 17,5 gr/dl</td>
                     </tr>

                     <tr>
                         <td class="fw-semibold">Hematokrit</td>
                         <td>
                             <div class="input-group">
                                 <input readonly type="text" name="ht_hasil"
                                     class="form-control form-control-minimal" placeholder="0"
                                     value="{{ $hasillab->ht_hasil ?? '' }}">
                                 <span class="input-group-text unit-text">%</span>
                             </div>
                         </td>
                         <td>P : 34,9 – 44,5%</td>
                         <td>L : 38,8 – 50%</td>
                     </tr>

                     <tr>
                         <td class="fw-semibold">Eritrosit</td>
                         <td>
                             <div class="input-group">
                                 <input readonly type="text" name="eritrosit_hasil"
                                     class="form-control form-control-minimal" placeholder="0.0"
                                     value="{{ $hasillab->eritrosit_hasil ?? '' }}">
                                 <span class="input-group-text unit-text">juta/mm³</span>
                             </div>
                         </td>
                         <td>P : 4 – 5 Juta/mm³</td>
                         <td>L : 4,5 – 5,5 juta/mm³</td>
                     </tr>

                     <tr>
                         <td class="fw-semibold">Leukosit</td>
                         <td>
                             <div class="input-group">
                                 <input readonly type="text" name="leukosit_hasil"
                                     class="form-control form-control-minimal" placeholder="0"
                                     value="{{ $hasillab->leukosit_hasil ?? '' }}">
                                 <span class="input-group-text unit-text">/µL</span>
                             </div>
                         </td>
                         <td>P : 4.500 – 10.000 /µL</td>
                         <td>L : 4.500 – 10.000 /µL</td>
                     </tr>

                     <tr>
                         <td class="fw-semibold">Trombosit</td>
                         <td>
                             <div class="input-group">
                                 <input readonly type="text" name="trombosit_hasil"
                                     class="form-control form-control-minimal" placeholder="0"
                                     value="{{ $hasillab->trombosit_hasil ?? '' }}">
                                 <span class="input-group-text unit-text">/µL</span>
                             </div>
                         </td>
                         <td>P : 150.000 – 450.000 /µL</td>
                         <td>L : 150.000 – 450.000 /µL</td>
                     </tr>

                     <tr class="bg-light">
                         <td colspan="4" class="p-3">
                             <div class="form-group mb-0">
                                 <label for="hasillab"
                                     class="fw-bold text-secondary small mb-1.5 d-flex align-items-center">
                                     <i class="fas fa-comment-medical text-primary mr-2" style="font-size: 1.1rem;"></i>
                                     KESAN / INTERPRETASI LABORATORIUM
                                 </label>
                                 <textarea readonly class="form-control border-secondary-subtle rounded-2 p-2.5" rows="4" id="hasillab"
                                     name="kesan_lab" placeholder="Tuliskan kesan atau catatan keahlian dokter/petugas laboratorium di sini...">{{ $hasillab->kesan_lab ?? '' }}</textarea>
                             </div>
                         </td>
                     </tr>
                 </tbody>
             </table>

             {{-- INFORMASI TAMBAHAN STATUS DATA DI BAWAH TABEL --}}
             <div class="mt-2 text-right">
                 @if (empty($hasillab))
                     <small class="text-muted font-italic">
                         <i class="fas fa-info-circle text-warning"></i> Pasien belum memiliki riwayat input lab
                         untuk kunjungan ini. Form akan membuat data baru saat disimpan.
                     </small>
                 @else
                     <small class="text-success font-weight-bold">
                         <i class="fas fa-check-circle"></i> Menampilkan data simpanan terakhir (Terakhir
                         diperbarui: {{ \Carbon\Carbon::parse($hasillab->tgl_entry)->format('d-m-Y H:i') }}
                         WIB)
                     </small>
                 @endif
             </div>
         </div>
     </div>
 </div
