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
                        <th class="text-end py-3 text-secondary">Saldo Akhir</th>
                        <th class="text-center py-3 text-secondary" style="width: 12%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $d)
                        <tr>
                            <td class="text-center fw-semibold text-secondary">{{ $loop->iteration }}</td>
                            <td class="fw-bold text-dark">{{ $d->nama_user }}</td>
                            <td class="text-secondary">
                                {{ $d->tgl_mulai ? date('d/m/Y H:i', strtotime($d->tgl_mulai)) : '-' }} WIB</td>
                            <td class="text-secondary">
                                {{ $d->tgl_selesai ? date('d/m/Y H:i', strtotime($d->tgl_selesai)) : '-' }} WIB</td>
                            <td class="text-end fw-semibold text-dark">Rp
                                {{ number_format($d->saldo_awal ?? 0, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold text-primary">Rp
                                {{ number_format($d->saldo_akhir ?? 0, 0, ',', '.') }}</td>
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
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada riwayat sesi kasir.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light fw-bold border-top-2" style="font-size: 0.85rem;">
                    <tr>
                        <td colspan="5" class="text-end text-secondary py-2">Total per Halaman:</td>
                        <td id="totalHalaman" class="text-end text-primary py-2">Rp 0</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-end text-secondary py-2">Grand Total Seluruh Halaman:</td>
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
                "targets": [0, 6]
            }],

            // Perubahan Utama: Logic Kalkulasi Total Saldo Akhir (Kolom indeks ke-5)
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api();

                // Helper untuk membersihkan format Rp dan titik ribuan menjadi integer murni
                var intVal = function(i) {
                    if (typeof i === 'string') {
                        // Hilangkan teks 'Rp ', titik (ribuan), dan spasi
                        var cleaned = i.replace(/[\sR p.]/g, '');
                        return cleaned ? parseInt(cleaned, 10) : 0;
                    }
                    return typeof i === 'number' ? i : 0;
                };

                // 1. Hitung Total Seluruh Halaman (Global)
                var totalSemua = api
                    .column(5) // Indeks kolom Saldo Akhir adalah 5
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // 2. Hitung Total Hanya Halaman yang Sedang Aktif (Page Total)
                var totalHalaman = api
                    .column(5, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Helper Fungsi Format Rupiah untuk Output Tampilan
                function formatRupiahJs(angka) {
                    return 'Rp ' + angka.toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });
                }

                // Masukkan hasil kalkulasi ke dalam element DOM footer tadi
                $('#totalHalaman').html(formatRupiahJs(totalHalaman));
                $('#totalSemua').html(formatRupiahJs(totalSemua));
            }
        });
    });
</script>
