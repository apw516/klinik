<h5>ID TRANSAKSI : {{ $idtrans }}</h5>
<table class="table table-bordered table-striped table-hover" id="datatablesSimple">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            {{-- Kolom dari ts_transaksi_kasir_detail --}}
            <th>Kode tarif / Barang</th>
            {{-- Kolom dari ts_layanan_detail (hasil join) --}}
            <th>Nama Layanan</th>
            <th>Harga Satuan</th>
            {{-- Kolom dari ts_transaksi_kasir_detail --}}
            <th>Jumlah (Qty)</th>
            <th>Subtotal</th>
            {{-- Tambahkan kolom lain jika perlu --}}
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
            $grandTotal = 0;
        @endphp
        @foreach ($data as $item)
            @php
                // Asumsi: Subtotal dihitung jika tidak ada di DB
                // $subtotal = $item->qty * $item->harga_satuan;
                // $grandTotal += $subtotal;
            @endphp
            <tr>
                <td>{{ $no++ }}</td>
                {{-- Menggunakan sintaks objek ($item->nama_kolom) --}}
                <td>{{ $item->kode_barang }}{{ $item->id_tarif }}</td>

                {{-- Data dari tabel join b (ts_layanan_detail) --}}
                {{-- Gunakan operator ?? untuk handle jika data join null --}}
                <td>{{ $item->nama_tarif ?? 'Layanan Tidak Ditemukan' }}</td>
                <td class="text-end">Rp {{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}</td>

                <td class="text-center">{{ $item->jumlah }}</td> {{-- Sesuaikan nama kolom qty Anda --}}

                {{-- Contoh Subtotal (sesuaikan nama kolom subtotal Anda jika ada di DB) --}}
                <td class="text-end">Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
    {{-- Opsional: Menampilkan Total di Bawah --}}
    {{-- 
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-end">Total Akhir:</th>
                                <th class="text-end">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                        --}}
</table>
