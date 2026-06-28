<div class="card border-0 shadow-sm mt-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.875rem;">
            <thead class="table-light text-uppercase tracking-wider" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                <tr>
                    <th class="text-center py-3 text-secondary" style="width: 5%;">No</th>
                    <th class="py-3 text-secondary" style="width: 45%;">Deskripsi Layanan / Item</th>
                    <th class="text-center py-3 text-secondary" style="width: 15%;">Keterangan</th>
                    <th class="text-center py-3 text-secondary" style="width: 10%;">Qty</th>
                    <th class="text-end py-3 text-secondary" style="width: 25%; padding-right: 24px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $d)
                    @php
                        // Deteksi jika item dibatalkan/retur (opsional, sesuaikan dengan logic status_layanan Anda)
                        $isBatal = ($d->status_layanan ?? 0) == 3;
                        $isGratis = ($d->subtotal ?? 0) == 0;
                    @endphp
                    <tr class="{{ $isBatal ? 'table-light text-muted text-decoration-line-through' : '' }}">
                        <td class="text-center font-weight-bold text-secondary fs-7">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            <div class="fw-bold text-dark">{{ $d->nama_tarif ?? 'Layanan Tanpa Nama' }}</div>
                            <small class="text-muted" style="font-size: 0.75rem;">ID Ref: #{{ $d->id }}</small>
                        </td>

                        <td class="text-center text-secondary">
                            <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 0.75rem;">
                                {{ $header[0]->keterangan ?? '-' }}
                            </span>
                        </td>

                        <td class="text-center fw-semibold text-dark fs-6">
                            {{ number_format($d->jumlah ?? 0, 0, ',', '.') }}
                        </td>

                        <td class="text-end fw-bold text-dark" style="padding-right: 24px;">
                            @if ($isGratis)
                                <span class="text-success small fw-semibold">Gratis</span>
                            @else
                                Rp {{ number_format($d->subtotal ?? 0, 0, ',', '.') }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-folder-x d-block fs-2 mb-2 text-secondary"></i>
                            Tidak ada rincian item tagihan untuk transaksi ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
