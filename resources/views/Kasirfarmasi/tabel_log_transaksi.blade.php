<table class="table table-hover table-bordered align-middle" id="tabelTransaksi">
    <thead class="table-light">
        <tr>
            <th class="text-center">No.</th>
            <th>ID Transaksi</th>
            <th>Tanggal</th>
            <th>No. RM / Nama Pasien</th>
            {{-- <th>Unit Tujuan</th> --}}
            <th class="text-end">Sub Total Tagihan</th>
            <th class="text-end">Bayar</th>
            <th class="text-end">Diskon</th>
            <th class="text-end">Kembalian</th>
            <th class="text-end">Total Tagihan</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $grandTotal = 0; @endphp
        @forelse($data as $key => $d)
            @php $grandTotal += $d->total_neto; @endphp
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td><span class="fw-bold text-primary">{{ $d->id_transaksi }}</span></td>
                <td>{{ \Carbon\Carbon::parse($d->tgl_transaksi)->format('d/m/Y H:i') }}</td>
                <td>
                    <div class="fw-bold">{{ $d->nomor_rm }}</div>
                    <small class="text-muted">{{ $d->nama_pasien }}</small>
                </td>
                {{-- <td><span class="badge bg-info text-dark">{{ $d->nama_unit }}</span></td> --}}
                <td class="text-end fw-bold text-dark">
                    Rp {{ number_format($d->total_bruto, 0, ',', '.') }}
                </td>
                <td class="text-end text-success">
                    Rp {{ number_format($d->bayar, 0, ',', '.') }}
                </td>
                <td class="text-end text-success">
                    Rp {{ number_format($d->total_diskon, 0, ',', '.') }}
                </td>
                <td class="text-end text-danger">
                    Rp {{ number_format($d->kembalian, 0, ',', '.') }}
                </td>
                <td class="text-end text-danger">
                    Rp {{ number_format($d->total_neto, 0, ',', '.') }}
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-secondary" onclick="printStruk('{{ $d->id_transaksi }}')">
                        <i class="bi bi-printer"></i>
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center py-4 text-muted italic">Data tidak ditemukan untuk periode ini.
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot class="table-secondary">
        <tr>
            <th colspan="5" class="text-end">TOTAL PENDAPATAN :</th>
            <th class="text-end">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
            <th colspan="3"></th>
        </tr>
    </tfoot>
</table>
