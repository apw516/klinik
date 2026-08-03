<div class="card border-0 shadow-sm mt-4">
    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="tabelSesiKasir" class="table table-hover align-middle mb-0 w-100" style="font-size: 0.875rem;">
                <thead class="table-light text-uppercase tracking-wider"
                    style="font-size: 0.75rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="text-center py-3 text-secondary" style="width: 5%;">No</th>
                        <th class="py-3 text-secondary">Nama User</th>
                        <th class="py-3 text-secondary">Tanggal Mulai</th>
                        <th class="py-3 text-secondary">Tanggal Selesai</th>
                        <th class="text-end py-3 text-secondary">Saldo Awal</th>
                        <th class="text-end py-3 text-secondary">Pendapatan</th>
                        <th class="text-end py-3 text-secondary">Subtotal</th>
                        <th class="text-center py-3 text-secondary" style="width: 12%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $d)
                        @php
                            // PERBAIKAN 1: Pastikan null-handling diproses sebelum penjumlahan
                            $saldoAwal = $d->saldo_awal ?? 0;
                            $saldoAkhir = $d->saldo_akhir ?? 0;
                            $subtotal = $saldoAwal + $saldoAkhir;
                        @endphp
                        <tr>
                            <td class="text-center fw-semibold text-secondary">{{ $loop->iteration }}</td>
                            <td class="fw-bold text-dark">{{ $d->nama_user }}</td>
                            <td class="text-secondary">
                                {{ $d->tgl_mulai ? date('d/m/Y H:i', strtotime($d->tgl_mulai)) : '-' }} WIB
                            </td>
                            <td class="text-secondary">
                                {{ $d->tgl_selesai ? date('d/m/Y H:i', strtotime($d->tgl_selesai)) : '-' }} WIB
                            </td>
                            <td class="text-end fw-semibold text-dark">
                                Rp {{ number_format($saldoAwal, 0, ',', '.') }}
                            </td>
                            <td class="text-end fw-bold text-primary">
                                Rp {{ number_format($saldoAkhir, 0, ',', '.') }}
                            </td>
                            <td class="text-end fw-bold text-success">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                @if ($d->status == 1)
                                    <span
                                        class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded-2 tracking-wide fw-bold">
                                        <i class="bi bi-unlock-fill me-1"></i> Terbuka
                                    </span>
                                @else
                                    <span
                                        class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1.5 rounded-2 tracking-wide fw-bold">
                                        <i class="bi bi-lock-fill me-1"></i> Sudah Ditutup
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada riwayat sesi kasir.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light fw-bold border-top-2" style="font-size: 0.85rem;">
                    <tr>
                        <td colspan="6" class="text-end text-secondary py-2">Total Subtotal Halaman Ini:</td>
                        <td id="totalHalaman" class="text-end text-primary py-2">Rp 0</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-end text-secondary py-2">Grand Total Subtotal Seluruh Halaman:
                        </td>
                        <td id="totalSemua" class="text-end text-dark py-2">Rp 0</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabelSesiKasir').DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data sesi tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "search": "Cari Sesi Kasir:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            },
            "pageLength": 10,
            "order": [
                [0, "asc"]
            ],
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 7] // Matikan sorting untuk kolom No dan Status
            }],

            "footerCallback": function(row, data, start, end, display) {
                var api = this.api();

                // Helper untuk konversi teks format 'Rp 10.000' menjadi angka 10000
                var intVal = function(i) {
                    if (typeof i === 'string') {
                        var cleaned = i.replace(/[\sR p.]/g, '');
                        return cleaned ? parseInt(cleaned, 10) : 0;
                    }
                    return typeof i === 'number' ? i : 0;
                };

                // PERBAIKAN 2: Mengambil data dari Kolom Index 6 (Subtotal)
                // 1. Total Subtotal Seluruh Halaman
                var totalSemua = api
                    .column(6)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // 2. Total Subtotal Halaman Aktif
                var totalHalaman = api
                    .column(6, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Helper Format Rupiah
                function formatRupiahJs(angka) {
                    return 'Rp ' + angka.toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });
                }

                // Render ke DOM
                $('#totalHalaman').html(formatRupiahJs(totalHalaman));
                $('#totalSemua').html(formatRupiahJs(totalSemua));
            }
        });
    });
</script>
