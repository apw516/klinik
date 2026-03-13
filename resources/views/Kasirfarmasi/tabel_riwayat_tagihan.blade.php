<table class="table table-sm table-hover table-bordered align-middle">
    <thead class="table-secondary text-center">
        <tr>
            <th>No</th>
            <th>Tgl Masuk</th>
            <th>No. RM / Nama Pasien</th>
            <th>Unit Tujuan</th>
            <th>Kode Layanan</th>
            <th>Status Bayar</th>
            <th>Tagihan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $key => $d)
        @if($d->status_layanan != 3)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($d->tgl_masuk)->format('d-m-Y H:i') }}</td>
                <td>
                    <span class="fw-bold">{{ $d->nomor_rm }}</span><br>
                    <small class="text-uppercase">{{ $d->nama_pasien }}</small>
                </td>
                <td><span class="badge bg-outline-info text-dark border">{{ $d->nama_unit }}</span></td>

                {{-- Logika Jika Layanan Kosong (Hasil Left Join) --}}
                @if ($d->kode_layanan_header)
                    <td class="text-center text-primary fw-bold">{{ $d->kode_layanan_header }}</td>
                    <td class="text-center">
                        @if($d->status_layanan != 3)
                        @if ($d->status_bayar == 1)
                            <span class="badge bg-success"><i class="bi bi-check-circle"></i> Lunas</span>
                        @else
                            <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Belum Bayar</span>
                        @endif
                        @else
                            <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Batal</span>
                        @endif
                    </td>
                    <td class="text-end fw-bold">
                        Rp {{ number_format($d->total_tagihan, 0, ',', '.') }}
                    </td>
                @else
                    <td colspan="3" class="text-center text-muted italic small">Belum ada input layanan</td>
                @endif

                <td class="text-center">
                    <div class="btn-group" role="group">
                        <button title="Detail Kunjungan" class="btn btn-sm btn-info text-white">
                            <i class="bi bi-eye"></i>
                        </button>
                        @if ($d->status_bayar != 1 && $d->kode_layanan_header)
                            <button title="Proses Bayar" class="btn btn-sm btn-warning"
                                onclick="pilihLayanan('{{ $d->id_kunjungan }}')">
                                <i class="bi bi-cash-stack"></i>
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
        @endif
        @empty
            <tr>
                <td colspan="8" class="text-center py-4">Data tidak ditemukan untuk periode ini.</td>
            </tr>
        @endforelse
    </tbody>
</table>
