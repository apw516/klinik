<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <div class="bg-primary-subtle text-primary rounded p-2 me-3">
                <i class="bi bi-file-earmark-text-fill fs-5"></i>
            </div>
            <div>
                <h6 class="m-0 fw-bold text-secondary text-uppercase tracking-wider" style="font-size: 0.75rem;">ID
                    Transaksi Billing</h6>
                <span class="fs-5 fw-bold text-dark tracking-wide">{{ $idtrans }}</span>
            </div>
        </div>
        <div>
            <button class="btn btn-outline-primary fw-bold px-3 py-2 border-2 rounded-3" onclick="cetakNotaIni()">
                <i class="bi bi-printer-fill me-2"></i> Cetak Nota Resmi
            </button>
            <button class="btn btn-outline-dark fw-bold px-3 py-2 border-2 rounded-3" onclick="cetakNotaThermal()">
                <i class="bi bi-receipt-cutoff me-2"></i> Cetak Thermal (Kasir)
            </button>
        </div>
    </div>
    <div class="card-body p-4" id="areaCetakNota">
        <div class="d-none d-print-block mb-4">
            <table class="w-100 border-0">
                <tr>
                    <td style="width: 60%;">
                        <h4 class="fw-bold text-dark m-0">NP MEDIKA</h4>
                        <small class="text-muted d-block" style="font-size: 0.8rem;">Jalan Pangeran Sutajaya, Desa
                            Gebang, Kecamatan Gebang, Kabupaten Cirebon, Jawa Barat 45191</small>
                    </td>
                    <td class="text-end" style="width: 40%; vertical-align: top;">
                        <h5 class="fw-bold text-secondary m-0">RESI/NOTA PEMBAYARAN</h5>
                        <div class="fw-semibold text-dark mt-1" style="font-size: 0.9rem;">ID: {{ $idtrans }}</div>
                        <small class="text-muted" style="font-size: 0.8rem;">Tanggal Cetak:
                            {{ now()->translatedFormat('d F Y H:i') }} WIB</small>
                    </td>
                </tr>
            </table>
            <hr class="border-dark my-3" style="border-top: 2px dashed #000 !important;">
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                <thead class="table-light text-uppercase tracking-wider" style="font-size: 0.75rem;">
                    <tr>
                        <th class="text-center py-3" style="width: 6%;">No</th>
                        <th class="py-3" style="width: 44%;">Deskripsi Layanan / Nama Obat</th>
                        <th class="text-end py-3" style="width: 18%;">Harga Satuan</th>
                        <th class="text-center py-3" style="width: 12%;">Qty</th>
                        <th class="text-end py-3" style="width: 20%;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotal = 0;
                    @endphp
                    @forelse ($data as $item)
                        @php
                            $subtotalItem = $item->subtotal ?? 0;
                            $grandTotal += $subtotalItem;
                        @endphp
                        <tr
                            class="{{ $item->status_layanan == 3 ? 'table-light text-muted text-decoration-line-through' : '' }}">
                            <td class="text-center fw-bold text-secondary">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-semibold text-dark">
                                    @php
                                        $namaLayananFull = $item->nama_tarif ?? 'Layanan Tidak Ditemukan';
                                        $kodeBarang = $item->kode_barang ?? '';
                                        // Jika kode_barang berawalan 'B' (case-insensitive)
                                        if ($kodeBarang != 0) {
                                            if (auth()->user()->hak_akses == 2) {
                                                $namaLayananTampil = \Illuminate\Support\Str::limit(
                                                    $namaLayananFull,
                                                    3,
                                                    'ObT',
                                                );
                                            } else {
                                                $namaLayananTampil = $namaLayananFull;
                                            }
                                        } else {
                                            $namaLayananTampil = $namaLayananFull;
                                        }
                                    @endphp

                                    {{ $namaLayananTampil }}
                                </div>
                                @if ($item->kode_barang && $item->kode_barang != '0')
                                    <small class="text-muted d-block ps-0" style="font-size: 0.75rem;">
                                        <i class="bi bi-qr-code me-1"></i>Sediaan: {{ $item->kode_barang }}
                                    </small>
                                @endif
                            </td>
                            <td class="text-end fw-semibold text-secondary">
                                Rp {{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="text-center fw-bold text-dark fs-6">
                                {{ number_format($item->jumlah ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="text-end fw-bold text-dark">
                                Rp {{ number_format($subtotalItem, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox d-block fs-3 mb-2 text-secondary"></i>
                                Tidak ada rincian data untuk nomor transaksi ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="border-top-2">
                    <tr>
                        <td colspan="3" class="border-0 d-none d-print-table-cell"></td>
                        <td colspan="3" class="text-end fw-bold py-3 text-secondary border-0 fs-6">Total Gross
                            Tagihan :</td>
                        <td class="text-end fw-bold py-3 text-dark border-0 fs-6">
                            Rp {{ number_format($grandTotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="border-0 d-none d-print-table-cell"></td>
                        <td colspan="3" class="text-end fw-bold py-3 text-secondary border-0 fs-6">Total Bayar :</td>
                        <td class="text-end fw-bold py-3 text-dark border-0 fs-6">
                            Rp {{ number_format($header[0]->bayar ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="border-0 d-none d-print-table-cell"></td>
                        <td colspan="3" class="text-end fw-bold py-3 text-secondary border-0 fs-6">Kembalian :</td>
                        <td class="text-end fw-bold py-3 text-dark border-0 fs-6">
                            Rp {{ number_format($header[0]->kembalian ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-none d-print-block mt-5 pt-3">
            <table class="w-100 border-0">
                <tr>
                    <td style="width: 70%;">
                        <small class="text-muted italic d-block">* Bukti pembayaran ini sah diterbitkan secara
                            elektronik oleh sistem.</small>
                        <small class="text-muted d-block">Terima kasih atas kepercayaan Anda pada layanan kami.</small>
                    </td>
                    <td class="text-center" style="width: 30%; vertical-align: top;">
                        <span class="small d-block text-secondary mb-5">Petugas Kasir / Farmasi,</span>
                        <div class="fw-bold text-dark border-bottom d-inline-block px-4 pb-1">
                            {{ auth()->user()->name ?? 'Petugas Klinik' }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script>
    function cetakNotaIni() {
        var isiNota = document.getElementById("areaCetakNota").innerHTML;
        var jendelaCetak = window.open('', '_blank', 'width=900,height=700');

        jendelaCetak.document.write('<html><head><title>Cetak Nota Pembayaran - {{ $idtrans }}</title>');
        jendelaCetak.document.write(
            '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">'
        );
        jendelaCetak.document.write('<style>');
        jendelaCetak.document.write(
            'body { font-family: "Segoe UI", sans-serif; padding: 20px; background-color: #fff !important; color: #000 !important; }'
        );
        jendelaCetak.document.write(
            '.table th { background-color: #f8f9fa !important; color: #000 !important; border-bottom: 2px solid #000 !important; }'
        );
        jendelaCetak.document.write('.text-decoration-line-through { color: #a0a0a0 !important; }');
        jendelaCetak.document.write('</style></head><body>');
        jendelaCetak.document.write(isiNota);
        jendelaCetak.document.write('</body></html>');

        jendelaCetak.document.close();

        setTimeout(function() {
            jendelaCetak.focus();
            jendelaCetak.print();
            jendelaCetak.close();
        }, 350);
    }

    function cetakNotaThermal() {
        var jendelaCetak = window.open('', '_blank', 'width=400,height=600');

        var htmlThermal = '<html><head><title>Thermal - {{ $idtrans }}</title>';
        htmlThermal += '<style>';
        htmlThermal += '@page { size: auto; margin: 0mm; }';
        htmlThermal +=
            'body { font-family: "Courier New", Courier, monospace; width: 280px; margin: 0 auto; padding: 10px; color: #000; font-size: 11px; line-height: 1.3; }';
        htmlThermal += '.text-center { text-align: center; }';
        htmlThermal += '.text-right { text-align: right; }';
        htmlThermal += '.fw-bold { font-weight: bold; }';
        htmlThermal += '.mb-1 { margin-bottom: 4px; }';
        htmlThermal += '.mb-2 { margin-bottom: 8px; }';
        htmlThermal += '.divider { border-top: 1px dashed #000; margin: 6px 0; }';
        htmlThermal += '.item-table { width: 100%; border-collapse: collapse; }';
        htmlThermal += '.item-table td { padding: 2px 0; vertical-align: top; }';
        htmlThermal += '</style></head><body>';

        // Header Klinik/Apotek
        htmlThermal += '<div class="text-center">';
        htmlThermal += '  <span class="fw-bold" style="font-size: 14px;">NP MEDIKA</span><br>';
        htmlThermal +=
            '  <span style="font-size: 10px;">Jalan Pangeran Sutajaya, Desa Gebang, Kecamatan Gebang, Kabupaten Cirebon, Jawa Barat 45191</span><br>';
        htmlThermal += '</div>';

        htmlThermal += '<div class="divider"></div>';

        // Metadata Transaksi
        htmlThermal += '<div>';
        htmlThermal += '  ID   : {{ $idtrans }}<br>';
        htmlThermal += '  Tgl  : {{ now()->translatedFormat('d/m/Y H:i') }}<br>';
        htmlThermal += '  Kasir: {{ auth()->user()->nama ?? (auth()->user()->name ?? 'Petugas') }}<br>';
        htmlThermal += '</div>';

        htmlThermal += '<div class="divider"></div>';

        // Loop Item Belanjaan
        htmlThermal += '<table class="item-table">';
        @php
            $gTotal = 0;
            $nomorItem = 1;
        @endphp

        @foreach ($data as $item)
            @php
                $hargaSatuan = $item->harga_satuan ?? 0;
                $sub = $item->subtotal ?? 0;

                if (($item->status_layanan ?? 0) == 3 || $hargaSatuan == 0 || $sub == 0) {
                    continue;
                }

                $gTotal += $sub;

                // Penyingkatan otomatis nama obat/layanan (dibatasi 25 karakter)
                $namaLayananFull = $item->nama_tarif ?? 'Layanan';
                $namaLayananSingkat = \Illuminate\Support\Str::limit($namaLayananFull, 25, '...');
            @endphp

            htmlThermal += '<tr>';
            htmlThermal += '  <td colspan="2" class="fw-bold">{{ $nomorItem }}. {{ $namaLayananSingkat }}</td>';
            htmlThermal += '</tr>';

            htmlThermal += '<tr>';
            htmlThermal +=
                '  <td>   {{ number_format($item->jumlah ?? 0, 0, ',', '.') }} x Rp{{ number_format($hargaSatuan, 0, ',', '.') }}</td>';
            htmlThermal += '  <td class="text-right">Rp{{ number_format($sub, 0, ',', '.') }}</td>';
            htmlThermal += '</tr>';

            @php $nomorItem++; @endphp
        @endforeach
        htmlThermal += '</table>';

        htmlThermal += '<div class="divider"></div>';

        // Ringkasan Pembayaran
        htmlThermal += '<table class="item-table" style="font-size: 11px;">';
        htmlThermal += '  <tr class="fw-bold">';
        htmlThermal += '    <td>TOTAL BILL:</td>';
        htmlThermal += '    <td class="text-right">Rp{{ number_format($gTotal, 0, ',', '.') }}</td>';
        htmlThermal += '  </tr>';
        htmlThermal += '  <tr>';
        htmlThermal += '    <td>TUNAI/BAYAR:</td>';
        htmlThermal += '    <td class="text-right">Rp{{ number_format($header[0]->bayar ?? 0, 0, ',', '.') }}</td>';
        htmlThermal += '  </tr>';
        htmlThermal += '  <tr class="fw-bold">';
        htmlThermal += '    <td>KEMBALIAN:</td>';
        htmlThermal +=
            '    <td class="text-right">Rp{{ number_format($header[0]->kembalian ?? 0, 0, ',', '.') }}</td>';
        htmlThermal += '  </tr>';
        htmlThermal += '</table>';

        htmlThermal += '<div class="divider"></div>';

        // Footer Struk
        htmlThermal += '<div class="text-center mb-2" style="font-size: 10px; margin-top: 10px;">';
        htmlThermal += '  * Terima Kasih *<br>';
        htmlThermal += '  Semoga Lekas Sembuh<br>';
        htmlThermal += '  Bukti Pembayaran Elektronik Sah<br>';
        htmlThermal += '</div>';

        htmlThermal += '</body></html>';

        jendelaCetak.document.write(htmlThermal);
        jendelaCetak.document.close();

        setTimeout(function() {
            jendelaCetak.focus();
            jendelaCetak.print();
            jendelaCetak.close();
        }, 250);
    }
</script>
