<input type="hidden" id="idlayanan" value="{{ $idlayananheader }}">
<input type="hidden" id="idkunjungan" value="{{ $idkunjungan }}">

<div class="btn-group mt-4" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modaladdtindakan"><i
            class="bi bi-plus-circle"></i> Tambah Tindakan</button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modaladdobat"><i
            class="bi bi-plus-circle"></i> Tambah Obat</button>
</div>
<div class="row g-3 mt-1">
    <div class="col-xl-12">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                <i class="bi bi-receipt-cutoff text-primary fs-5 me-2"></i>
                <h6 class="m-0 fw-bold text-secondary">Layanan & Sediaan yang Akan Dibayar</h6>
            </div>
            <div class="card-body p-0">
                <div class="v_tagihan p-3">
                </div>
            </div>
            <div class="card-footer bg-light border-top p-4">
                <div class="row g-3 align-items-end">
                    <div class="col-sm-4 col-md-3">
                        <div class="form-group">
                            <label for="totaltagihan"
                                class="form-label fw-bold text-secondary small text-uppercase">Total Tagihan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 fw-semibold text-muted">Rp</span>
                                <input readonly type="text"
                                    class="form-control form-control-sm bg-white border-start-0 fw-bold text-dark fs-6"
                                    id="totaltagihan" name="totaltagihan" placeholder="0">
                            </div>
                            <input type="hidden" id="totaltagihanasli" name="totaltagihanasli" value="">
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-3">
                        <div class="form-group">
                            <label for="diskon" class="form-label fw-bold text-secondary small text-uppercase">Diskon
                                / Potongan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted">Rp</span>
                                <input type="text"
                                    class="form-control form-control-sm border-start-0 fw-semibold text-danger fs-6"
                                    id="diskondisplay" name="diskondisplay" value="0">
                                <input hidden type="text"
                                    class="form-control border-start-0 fw-semibold text-danger fs-5" id="diskon"
                                    name="diskon" value="0">
                                <span id="label_asli2" class="fw-semibold" hidden>0</span>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-3">
                        <div class="form-group">
                            <label for="uangbayar" class="form-label fw-bold text-primary small text-uppercase">Jumlah
                                Bayar</label>
                            <div class="input-group">
                                <span
                                    class="input-group-text bg-primary-subtle border-primary border-end-0 text-primary fw-bold">Rp</span>
                                <input type="text"
                                    class="form-control form-control-sm border-primary border-start-0 fw-bold text-primary fs-6"
                                    id="uangbayar" name="uangbayar" placeholder="Masukkan nominal...">
                            </div>
                            <input type="hidden" id="uangbayarasli" name="uangbayarasli" value="0">
                            <span id="label_asli" class="fw-semibold" hidden>0</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <button class="btn btn-primary btn-sm w-100 fw-bold shadow-sm py-2" id="tombolbayar"
                            onclick="bayartagihan()">
                            <i class="bi bi-wallet2 me-2"></i> Proses Bayar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="v_info mt-3"></div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="v_orderan"></div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modaladdtindakan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Tindakan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="tabeltarif" class="table table-sm table-hover" style="font-size:14px">
                    <thead>
                        <th>Nama Tarif</th>
                        <th>Jenis</th>
                        <th>Tarif</th>
                    </thead>
                    <tbody>
                        @foreach ($tarif as $t)
                            <tr class="pilihtarif" idtarif="{{ $t->id }}"
                                harga1="Rp. {{ number_format($t->tarif_1, 0, ',', '.') }}"
                                harga2="{{ $t->tarif_1 }}" nama="{{ $t->nama_tarif }}">
                                <td>{{ $t->nama_tarif }}</td>
                                <td>{{ $t->jenis_tarif }}</td>
                                <td>Rp {{ number_format($t->tarif_1, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card">
                    <div class="card-header">Tindakan / tarif yang dipilih</div>
                    <div class="card-body">
                        <form action="" method="post" class="formbilling mt-2" id="formtindakan">
                            <div class="draftbilling">
                                <div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="simpantindakan()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modaladdobat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Obat</h1>
            </div>
            <div class="modal-body">
                <table id="tabelstok" class="table table-sm tabel-bordered table-hover">
                    <thead>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Aturan pakai</th>
                    </thead>
                    <tbody>
                        @foreach ($mt_barang as $item)
                            <tr class="pilihobat" kode_barang="{{ $item->kode_barang }}"
                                nama_barang="{{ $item->nama_barang }}" stok={{ $item->stok_global }}
                                aturan_pakai="{{ $item->aturan_pakai }}">
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->stok_global }}</td>
                                <td>{{ $item->stok_global }}</td>
                                {{-- <td>{{ $item->stok_sekarang}}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card">
                    <div class="card-header">Obat yang dipilih</div>
                    <div class="card-body">
                        <form action="" method="post" class="formbillingobat mt-2" id="formobat">
                            <div class="draftbillingobat">
                                <div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="simpanobat()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        tampilkanorderresep();
        tampilkantagihanpasien();
        const inputMask = document.getElementById('uangbayar');
        const inputAsli = document.getElementById('uangbayarasli');
        const labelAsli = document.getElementById('label_asli');

        const inputMask2 = document.getElementById('diskondisplay');
        const inputAsli2 = document.getElementById('diskon');
        const labelAsli2 = document.getElementById('label_asli2');

        inputMask.addEventListener('keyup', function() {
            let nominal = this.value.replace(/[^,\d]/g, '').toString();
            inputAsli.value = nominal;
            labelAsli.innerText = nominal ? formatRupiah(nominal) : '0';
            this.value = nominal ? formatRupiah(nominal) : '';
        });
        inputMask2.addEventListener('keyup', function() {
            let nominal = this.value.replace(/[^,\d]/g, '').toString();
            inputAsli2.value = nominal;
            labelAsli2.innerText = nominal ? formatRupiah(nominal) : '0';
            this.value = nominal ? formatRupiah(nominal) : '';
        });
    });

    function tampilkanorderresep() {
        let idkunjungan = $('#idkunjungan').val();
        let spinner = $('#loader');
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idkunjungan: idkunjungan
            },
            url: '{{ route('ambildataorderresep') }}',
            success: function(response) {
                spinner.hide();
                $('.v_orderan').html(response);
            }
        });
    }

    function tampilkantagihanpasien() {
        let idkunjungan = $('#idkunjungan').val();
        let spinner = $('#loader');
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idkunjungan: idkunjungan
            },
            url: '{{ route('ambildatatagihan') }}',
            success: function(response) {
                spinner.hide();
                $('.v_tagihan').html(response);
            }
        });
    }

    function bayartagihan() {
        let bayar = parseInt($('#uangbayarasli').val()) || 0;
        let tagihan = parseInt($('#totaltagihanasli').val()) || 0;
        let diskon = parseInt($('#diskon').val().replace(/[^,\d]/g, '')) || 0;

        let sisaTagihan = tagihan - diskon;

        if (bayar < sisaTagihan) {
            Swal.fire({
                icon: 'warning',
                title: 'Uang Kurang',
                text: 'Jumlah pembayaran tidak boleh lebih kecil dari total tagihan neto!'
            });
            return false;
        }

        Swal.fire({
            title: "Konfirmasi Pembayaran",
            text: "Selesaikan transaksi kasir untuk pasien ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#0d6efd",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Ya, Selesaikan!"
        }).then((result) => {
            if (result.isConfirmed) {
                simpanpembayaran();
            }
        });
    }

    function simpanpembayaran() {
        let totaltagihanasli = $('#totaltagihanasli').val();
        let uangbayarasli = $('#uangbayarasli').val();
        let diskon = $('#diskon').val();
        let idkunjungan = $('#idkunjungan').val();
        let spinner = $('#loader');

        spinner.show();
        $('#tombolbayar').prop('disabled', true);
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                totaltagihanasli: totaltagihanasli,
                uangbayarasli: uangbayarasli,
                diskon: diskon,
                idkunjungan: idkunjungan
            },
            url: '{{ route('simpanpembayaran') }}',
            error: function() {
                spinner.hide();
                $('#tombolbayar').prop('disabled', false);
                Swal.fire({
                    icon: 'error',
                    title: 'System Error',
                    text: 'Gagal mengeksekusi data transaksi.'
                });
            },
            success: function(response) {
                spinner.hide();
                if (response.kode == '500') {
                    $('#tombolbayar').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: response.message,
                    });
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Pembayaran Sukses!",
                        text: "Data tersimpan. Silakan cetak bukti transaksi.",
                        showConfirmButton: true,
                        confirmButtonColor: "#198754"
                    });
                    $('#returlayanan').prop('disabled', true);
                    $('.v_info').html(response.view);
                }
            }
        });
    }
    // Masking input Rupiah


    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    }
    $(function() {
        $("#tabelstok").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 2,
            "searching": true,
            "ordering": false,
        })
    });
    $(function() {
        $("#tabeltarif").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 5,
            "searching": true,
            "ordering": false,
        })
    });
    $(".pilihtarif").on('click', function(event) {
        idtarif = $(this).attr('idtarif')
        nama = $(this).attr('nama')
        harga1 = $(this).attr('harga1')
        harga2 = $(this).attr('harga2')
        var wrapper = $(".draftbilling");
        $(wrapper).append(
            '<div class="row text-xs"><div class="form-group col-md-6"><label for="">Nama Tarif</label><input readonly type="" class="form-control form-control-sm text-xs edit_field" id="namatarif" name="namatarif" value="' +
            nama +
            '"><input   hidden readonly type="" class="form-control form-control-sm" id="idtarif" name="idtarif" value="' +
            idtarif +
            '"><input   hidden readonly type="" class="form-control form-control-sm" id="harga2" name="harga2" value="' +
            harga2 +
            '"></div><div class="form-group col-md-4"><label for="">Harga</label><input readonly type="" class="form-control form-control-sm text-xs edit_field" id="harga" name="harga" value="' +
            harga1 +
            '"></div><i class="bi bi-x-square remove_field form-group col-md-1 text-danger" kode2=""></i></div>'
        );
        Swal.fire({
            title: "Tarif dipilih " + nama,
            text: "ok!",
            icon: "success"
        });
        $(wrapper).on("click", ".remove_field", function(e) { //user click on remove
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });
    $(".pilihobat").on('click', function(event) {
        var kode_barang = $(this).attr('kode_barang');
        var nama_barang = $(this).attr('nama_barang');
        var stok = $(this).attr('stok');
        var wrapper = $(".draftbillingobat");

        // HTML template menggunakan Backtick (``) agar kode rapi dan tidak pusing dengan string concatenation (+)
        var htmlRow = `
        <div class="row text-xs align-items-center mb-2 border-bottom pb-2">
            <!-- Nama & Kode Barang -->
            <div class="form-group col-md-2">
                <label class="fw-bold mb-1">Nama Obat</label>
                <input readonly type="text" class="form-control form-control-sm text-xs" name="namabarang" value="${nama_barang}">
                <input hidden readonly type="text" name="kodebarang" value="${kode_barang}">
                <input hidden readonly type="text" name="harga2" value="">
            </div>

            <!-- Stok -->
            <div class="form-group col-md-1">
                <label class="fw-bold mb-1">Stok</label>
                <input readonly type="text" class="form-control form-control-sm text-xs text-center" name="stok" value="${stok}">
            </div>

            <!-- Qty -->
            <div class="form-group col-md-1">
                <label class="fw-bold mb-1">Qty</label>
                <input type="number" min="1" class="form-control form-control-sm text-xs text-center fw-bold" name="qty" value="1">
            </div>

            <!-- Aturan Pakai Checkbox Grid -->
            <div class="form-group col-md-4">
                <label class="fw-bold mb-1 d-block">Aturan Pakai</label>
                <div class="d-flex flex-wrap gap-2 bg-light p-2 rounded border">
                    <!-- Waktu Makan -->
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="checkbox" name="sebelum_makan" value="Sebelum Makan">
                        <label class="form-check-label text-xs">Sebelum Makan</label>
                    </div>
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="checkbox" name="sesudah_makan" value="Sesudah Makan" checked>
                        <label class="form-check-label text-xs">Sesudah Makan</label>
                    </div>
                    <div class="w-100 my-0 border-top style="opacity:0.2;"></div> <!-- Pembatas baris kecil -->
                    <!-- Sesi Minum -->
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="checkbox" name="pagi" value="Pagi">
                        <label class="form-check-label text-xs">Pagi</label>
                    </div>
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="checkbox" name="siang" value="Siang">
                        <label class="form-check-label text-xs">Siang</label>
                    </div>
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="checkbox" name="sore" value="Sore">
                        <label class="form-check-label text-xs">Sore</label>
                    </div>
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="checkbox" name="malam" value="Malam">
                        <label class="form-check-label text-xs">Malam</label>
                    </div>
                </div>
            </div>

            <!-- Kolom Keterangan Tambahan -->
            <div class="form-group col-md-2">
                <label class="fw-bold mb-1">Keterangan</label>
                <input type="text" class="form-control form-control-sm text-xs" name="keterangan_obat" placeholder="Contoh: masukan pesan atau catatan ...">
            </div>

            <!-- Paket Status -->
            <div class="form-group col-md-1 text-center">
                <label class="fw-bold mb-1 d-block">Paket?</label>
                <div class="form-check form-switch d-inline-block mt-1">
                    <input class="form-check-input check-paket" type="checkbox" name="is_paket" value="1" checked>
                    <input type="hidden" class="status-paket-val" name="status_paket" value="0">
                </div>
            </div>

            <!-- Tombol Hapus Row -->
            <div class="col-md-1 text-center mt-3">
                <i class="bi bi-x-square-fill remove_field text-danger fs-5 style="cursor: pointer;" title="Hapus Obat"></i>
            </div>
        </div>
    `;
        // Append baris baru ke wrapper
        $(wrapper).append(htmlRow);

        // SweetAlert Notifikasi Sukses
        Swal.fire({
            title: "Obat dipilih",
            text: nama_barang + " berhasil ditambahkan ke draf.",
            icon: "success",
            timer: 1500,
            showConfirmButton: false
        });
    });

    // PENTING: Pindahkan event handler .remove_field ke luar dari event click induknya (.pilihobat)
    // Ini agar event click hapus tidak menumpuk (double bind) setiap kali Anda memilih obat baru.
    $(".draftbillingobat").on("click", ".remove_field", function(e) {
        e.preventDefault();
        $(this).closest('.row').remove();
    });
    $(document).on('change', '.check-paket', function() {
        let $row = $(this).closest('.row');
        if ($(this).is(':checked')) {
            $row.find('.status-paket-val').val(1);
            $row.css('background-color', '#f0faff'); // Beri highlight biru muda jika PAKET
        } else {
            $row.find('.status-paket-val').val(0);
            $row.css('background-color', 'transparent');
        }
    });

    function simpantindakan() {
        Swal.fire({
            title: "Anda yakin ?",
            text: "Pastikan data sudah terisi dengan benar!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, simpan"
        }).then((result) => {
            Swal.fire({
                title: "Data akan disimpan sebagai tagihan tindakan baru ?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Simpan",
                denyButtonText: `Batal`
            }).then((result) => {
                if (result.isConfirmed) {
                    savebill()
                }
            });
        });
    }

    function simpanobat() {
        Swal.fire({
            title: "Anda yakin ?",
            text: "Pastikan data sudah terisi dengan benar!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, simpan"
        }).then((result) => {
            Swal.fire({
                title: "Data akan disimpan sebagai order obat yang baru ?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Simpan",
                denyButtonText: `Batal`
            }).then((result) => {
                if (result.isConfirmed) {
                    saveobat()
                }
            });
        });
    }

    function savebill() {
        var data3 = $('.formbilling').serializeArray();
        idkunjungan = $('#idkunjungan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data3: JSON.stringify(data3),
                idkunjungan
            },
            url: '<?= route('savenewbill') ?>',
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
                    let myModalEl = document.getElementById('modaladdtindakan');
                    let modal = bootstrap.Modal.getInstance(myModalEl);
                    if (modal) modal.hide();

                    // Jika pakai Bootstrap 4 / jQuery lama, cukup pakai baris ini:
                    // $('#modalObat').modal('hide');

                    // 2. Bersihkan Form (Ganti #formObat dengan ID form Anda)
                    $('#formtindakan')[0].reset();
                    tampilkantagihanpasien()
                }
            }
        });
    }

    function saveobat() {
        var data3 = $('.formbillingobat').serializeArray();
        idkunjungan = $('#idkunjungan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data3: JSON.stringify(data3),
                idkunjungan
            },
            url: '<?= route('saveobt') ?>',
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
                    let myModalEl = document.getElementById('modaladdobat');
                    let modal = bootstrap.Modal.getInstance(myModalEl);
                    if (modal) modal.hide();

                    // Jika pakai Bootstrap 4 / jQuery lama, cukup pakai baris ini:
                    // $('#modalObat').modal('hide');

                    // 2. Bersihkan Form (Ganti #formObat dengan ID form Anda)
                    $('#formobat')[0].reset();
                    tampilkantagihanpasien()
                }
            }
        });
    }
</script>
