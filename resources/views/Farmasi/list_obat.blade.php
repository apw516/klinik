<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        @if ($data[0]->status_order == 'SUDAH DIBERIKAN KEPADA PASIEN')
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l4.992-5.5a.75.75 0 0 0-.018-1.042z" />
                </svg>
                <div>
                    <strong>Berhasil!</strong> Resep/Obat untuk pasien ini telah selesai dilayani.
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div><br>
        @endif
        <h6 class="m-0 fw-bold text-dark">
            <i class="bi bi-capsule text-primary me-2"></i> Draf Resep Obat Pasien
        </h6>
        <span class="badge bg-secondary-subtle text-secondary rounded-pill fw-semibold px-2.5 py-1">
            <span id="counterObat">{{ count($data) }}</span> Jenis Obat
        </span>
    </div>
    <ul class="list-group list-group-flush" id="containerListObat">
        @forelse($data as $index => $d)
            <li class="list-group-item py-3 px-4 obat-item" data-kode="{{ $d->kode_barang }}">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h6 class="mb-1 fw-bold text-dark nama-barang-text">{{ $d->nama_barang }}</h6>
                        <small class="text-muted d-block">
                            KODE: <span class="fw-semibold text-secondary">{{ $d->kode_barang }}</span>
                        </small>
                        <input type="hidden" name="kodebarang[]" value="{{ $d->kode_barang }}">
                        <input type="hidden" name="namabarang[]" value="{{ $d->nama_barang }}">
                        <input type="hidden" name="id_detail[]" value="{{ $d->id_detail }}">
                        <input type="hidden" name="id_header[]" value="{{ $d->id_header }}">
                    </div>
                    <div class="col-md-2">
                        <label class="text-muted text-xs d-block mb-1">Jumlah</label>
                        <div class="input-group input-group-sm" style="max-width: 110px;">
                            <input type="number" name="qty[]" class="form-control text-center fw-bold text-primary"
                                min="1" value="{{ $d->jumlah }}">
                            <span class="input-group-text text-xs">Pcs</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted text-xs d-block mb-1">Aturan Pakai / Catatan</label>
                        <div class="bg-light p-1.5 rounded border text-xs text-dark fw-medium mb-1">
                            <i class="bi bi-clock me-1 text-primary"></i> {{ $d->aturan_pakai ?? '-' }} /
                            {{ $d->signa ?? '-' }}
                        </div>
                        <input type="hidden" name="aturan_pakai_raw[]" value="{{ $d->aturan_pakai }}">
                    </div>
                    <div
                        class="col-md-2 text-md-end text-start mt-2 mt-md-0 d-flex d-md-block justify-content-between align-items-center">
                        <div class="mb-md-2 mb-0">
                            <small class="text-muted d-block text-xs">Stok Global</small>
                            <span class="fw-bold text-xs {{ $d->stok_global > 10 ? 'text-success' : 'text-danger' }}">
                                {{ $d->stok_global }} item
                            </span>
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-danger p-0 h-auto btn-hapus-obat"
                            title="Hapus Obat" data-iddetail="{{ $d->id_detail }}" data-nama="{{ $d->nama_barang }}"
                            data-idheader="{{ $d->id_header }}"> <!-- Ditambahkan ini -->
                            <i class="bi bi-trash3-fill fs-6"></i> Hapus
                        </button>
                    </div>

                </div>
            </li>
        @empty
            <li class="list-group-item py-5 text-center text-muted id="emptyStateObat"">
                <i class="bi bi-capsule-ext d-block fs-2 mb-2 text-secondary"></i>
                Belum ada obat yang dipilih. Silakan pilih dari tabel master barang.
            </li>
        @endforelse
    </ul>
    <input hidden type="text" value="{{ $idlayananheader }}" id="idlayananheader">
    <div class="card-footer bg-white py-3 border-top text-end">
        <button @if ($data[0]->status_order == 'SUDAH DIBERIKAN KEPADA PASIEN') disabled @endif type="button"
            class="btn btn-primary btn-sm fw-bold px-4" id="btnSimpanResep" onclick="prosesresep()">
            <i class="bi bi-save2 me-1.5"></i> Proses Resep Obat
        </button>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Handler ketika baris produk di #tabelstok diklik
        $('#tabelstok').on('click', '.btn-pilih-barang', function(e) {
            e.preventDefault();
            // 1. Ambil data dari atribut data- di baris tr yang diklik
            var kode_barang = $(this).data('kode');
            var nama_barang = $(this).data('nama');
            var stok_global = parseInt($(this).data('stok')) || 0;
            var aturan_pakai = $(this).data('aturan') || '-';
            // 2. Validasi: Cek apakah obat sudah ada di dalam draf list resep
            var sudahAda = false;
            $('#containerListObat .obat-item').each(function() {
                if ($(this).data('kode') == kode_barang) {
                    sudahAda = true;
                    return false; // Berhenti looping .each()
                }
            });
            if (sudahAda) {
                Swal.fire({
                    title: "Sudah Ada",
                    text: nama_barang + " sudah masuk di dalam draf list resep!",
                    icon: "warning",
                    confirmButtonColor: "#3085d6"
                });
                return false;
            }

            // 3. Hilangkan baris "Belum ada obat" (empty state) jika ini obat pertama
            $('#emptyStateObat').remove();

            // 4. Buat template row <li> baru secara dinamis
            var htmlNewRow = `
            <li class="list-group-item py-3 px-4 obat-item" data-kode="${kode_barang}">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h6 class="mb-1 fw-bold text-dark nama-barang-text">${nama_barang}</h6>
                        <small class="text-muted d-block">KODE: <span class="fw-semibold text-secondary">${kode_barang}</span></small>
                        <input type="hidden" name="kodebarang[]" value="${kode_barang}">
                        <input type="hidden" name="namabarang[]" value="${nama_barang}">
                        <input type="hidden" name="iddetail[]" value="0">
                        <input type="hidden" name="idheader[]" value="0">
                    </div>
                    
                    <div class="col-md-2">
                        <label class="text-muted text-xs d-block mb-1">Jumlah</label>
                        <div class="input-group input-group-sm" style="max-width: 110px;">
                            <input type="number" name="qty[]" class="form-control text-center fw-bold text-primary" min="1" max="${stok_global}" value="1">
                            <span class="input-group-text text-xs">Pcs</span>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="text-muted text-xs d-block mb-1">Aturan Pakai / Catatan</label>
                        <div class="bg-light p-1.5 rounded border text-xs text-dark fw-medium mb-1">
                            <i class="bi bi-clock me-1 text-primary"></i> ${aturan_pakai}
                        </div>
                        <input type="hidden" name="aturan_pakai_raw[]" value="${aturan_pakai}">
                    </div>
                    
                    <div class="col-md-2 text-md-end text-start mt-2 mt-md-0 d-flex d-md-block justify-content-between align-items-center">
                        <div class="mb-md-2 mb-0">
                            <small class="text-muted d-block text-xs">Stok Global</small>
                            <span class="fw-bold text-xs ${stok_global > 10 ? 'text-success' : 'text-danger'}">${stok_global} item</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-danger p-0 h-auto btn-hapus-obat" title="Hapus Obat">
                            <i class="bi bi-trash3-fill fs-6"></i> Hapus
                        </button>
                    </div>
                </div>
            </li>
        `;
            // 5. Append row baru ke container list obat
            $('#containerListObat').append(htmlNewRow);

            // 6. Jalankan fungsi update hitungan counter obat
            updateCounterObat();

            // 7. Tampilkan notifikasi toast/alert singkat
            Swal.fire({
                title: "Ditambahkan!",
                text: nama_barang + " berhasil masuk ke draf resep.",
                icon: "success",
                timer: 1000,
                showConfirmButton: false
            });
        });
        // Helper Fungsi Update Counter (Pastikan fungsi ini ada di script Anda)
        function updateCounterObat() {
            var count = $('#containerListObat .obat-item').length;
            $('#counterObat').text(count);

            if (count === 0) {
                $('#containerListObat').html(`
                <li class="list-group-item py-5 text-center text-muted" id="emptyStateObat">
                    <i class="bi bi-capsule-ext d-block fs-2 mb-2 text-secondary"></i>
                    Belum ada obat yang dipilih. Silakan pilih dari tabel master barang.
                </li>
            `);
            }
        }
    });
    $(document).on('click', '.btn-hapus-obat', function() {
        // 1. Ambil data id_detail dan id_header dari atribut tombol
        let iddetail = $(this).data('iddetail');
        let idHeader = $(this).data('idheader');
        let nama = $(this).data('nama');
        let itemRow = $(this).closest('.obat-item'); // Mengambil baris item untuk dihapus dari list nanti
        // 2. Tampilkan SweetAlert2 Konfirmasi
        Swal.fire({
            title: "Anda yakin ?",
            text: "Layanan " + nama + " Akan dibatalkan ...",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, batalkan !"
        }).then((result) => {
            if (result.isConfirmed) {
                spinner = $('#loader')
                spinner.show();
                $.ajax({
                    async: true,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        iddetail
                    },
                    url: '<?= route('returlayanan') ?>',
                    error: function(data) {
                        spinner.hide()
                        Swal.fire({
                            icon: 'error',
                            title: 'Ooops....',
                            text: 'Sepertinya ada masalah......',
                            footer: ''
                        })
                    },
                    success: function(data) {
                        spinner.hide()
                        if (data.kode == 500) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oopss...',
                                text: data.message,
                                footer: ''
                            })
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'OK',
                                text: data.message,
                                footer: ''
                            })
                            ambilriwayatbilling()
                        }
                    }
                });
            }
        });
    });

    function prosesresep() {
        Swal.fire({
            title: "Anda yakin ?",
            text: "Obat akan diserahkan ke pasien !",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya serahkan obat ..."
        }).then((result) => {
            if (result.isConfirmed) {
                serahkanobat()
            }
        });
    }

    function serahkanobat() {
        idlayananheader = $('#idlayananheader').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                idlayananheader
            },
            url: '<?= route('berikanobatpasien') ?>',
            error: function(data) {
                spinner.hide()
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops....',
                    text: 'Sepertinya ada masalah......',
                    footer: ''
                })
            },
            success: function(data) {
                spinner.hide()
                if (data.kode == 500) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopss...',
                        text: data.message,
                        footer: ''
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'OK',
                        text: data.pesan,
                        footer: ''
                    })
                    location.reload()
                }
            }
        });
    }
</script>
