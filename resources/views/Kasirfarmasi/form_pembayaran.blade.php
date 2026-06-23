{{-- <input hidden type="text" id="idlayanan" value="{{ $idlayananheader }}">
<input hidden type="text" id="idkunjungan" value="{{ $idkunjungan }}">
<div class="row mt-2">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                Layanan yang akan dibayar
            </div>
            <div class="card-body">
                <div class="v_tagihan">

                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Total tagihan</label>
                            <input readonly type="text" class="form-control" id="totaltagihan" name="totaltagihan"
                                aria-describedby="emailHelp" placeholder="Total tagihan ..." value="">
                            <input hidden readonly type="text" class="form-control" id="totaltagihanasli"
                                name="totaltagihanasli" aria-describedby="emailHelp" placeholder="Total tagihan ..."
                                value="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Bayar</label>
                            <input type="email" class="form-control" id="uangbayar" name="uangbayar"
                                aria-describedby="emailHelp" placeholder="Masukan jumlah uang yang dibayar ...">
                            <input hidden type="email" class="form-control" id="uangbayarasli" name="uangbayarasli"
                                aria-describedby="emailHelp" placeholder="Masukan jumlah uang yang dibayar ...">
                            <small hidden class="text-muted">Nilai asli: <span id="label_asli">0</span></small>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Diskon</label>
                            <input type="email" class="form-control" id="diskon" name="diskon"
                                aria-describedby="emailHelp" value="0">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success" id="tombolbayar" style="margin-top:32px" onclick="bayartagihan()"><i
                                class="bi bi-aspect-ratio"></i> Bayar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="v_info mt-2">

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        tampilkanorderresep()
        tampilkantagihanpasien()
    })

    function tampilkanorderresep() {
        idkunjungan = $('#idkunjungan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idkunjungan
            },
            url: '<?= route('ambildataorderresep') ?>',
            success: function(response) {
                spinner.hide();
                $('.v_orderan').html(response);
            }
        });
    }

    function tampilkantagihanpasien() {
        idkunjungan = $('#idkunjungan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idkunjungan
            },
            url: '<?= route('ambildatatagihan') ?>',
            success: function(response) {
                spinner.hide();
                $('.v_tagihan').html(response);
            }
        });
    }

    function terimaresep() {
        Swal.fire({
            title: "Pastikan data resep yang diterima sudah benar ...",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Ya, terima",
            denyButtonText: `Batal`
        }).then((result) => {
            if (result.isConfirmed) {
                id = $('#idkunjungan').val()
                paketresep = $('#paketresep:checked').val()
                spinner = $('#loader')
                spinner.show();
                $.ajax({
                    async: true,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id,
                        paketresep
                    },
                    url: '<?= route('terimaresep') ?>',
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
                            tampilkantagihanpasien()
                            tampilkanorderresep()()
                        }
                    }
                });
            } else if (result.isDenied) {}
        });
    }

    function bayartagihan() {
        Swal.fire({
            title: "Bayar tagihan ?",
            text: "Pastikan data sudah diisi dengan benar !",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, bayar!"
        }).then((result) => {
            if (result.isConfirmed) {
                simpanpembayaran()
            }
        });
    }

    function simpanpembayaran() {
        totaltagihanasli = $('#totaltagihanasli').val()
        uangbayarasli = $('#uangbayarasli').val()
        diskon = $('#diskon').val()
        idkunjungan = $('#idkunjungan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                totaltagihanasli,
                uangbayarasli,
                diskon,
                idkunjungan
            },
            url: '<?= route('simpanpembayaran') ?>',
            error: function(data) {
                spinner.hide()
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops....',
                    text: 'Sepertinya ada masalah......',
                    footer: ''
                })
            },
            success: function(response) {
                spinner.hide()
                // alert(response.kode)
                if (response.kode == '500') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ups!',
                        text: response.message,
                    });
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Data pembayaran berhasil disimpan ...",
                        text: "Silahkan cetak bukti pembayaran dengan klik tombol dibawah ...",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#tombolbayar').prop('disabled', true);
                    $('#returlayanan').prop('disabled', true);
                    $('.v_info').html(response.view);
                }
            }
        });
    }
    inputMask = document.getElementById('uangbayar');
    inputAsli = document.getElementById('uangbayarasli');
    labelAsli = document.getElementById('label_asli');
    inputMask.addEventListener('keyup', function(e) {
        // 1. Ambil angka saja dari input
        let nominal = this.value.replace(/[^,\d]/g, '').toString();

        // 2. Masukkan angka bersih ke input hidden & label
        inputAsli.value = nominal;
        labelAsli.innerText = nominal;

        // 3. Ubah tampilan input menjadi format ribuan
        this.value = formatRupiah(nominal);
    });
    /* Fungsi Format Ribuan */
    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    }
</script> --}}
<input type="hidden" id="idlayanan" value="{{ $idlayananheader }}">
<input type="hidden" id="idkunjungan" value="{{ $idkunjungan }}">

<div class="row g-3 mt-1">
    <div class="col-xl-8 col-lg-7">
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
                                    class="form-control bg-white border-start-0 fw-bold text-dark fs-5"
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
                                <input type="text" class="form-control border-start-0 fw-semibold text-danger fs-5"
                                    id="diskondisplay" name="diskondisplay" value="0">
                                <input hidden type="text" class="form-control border-start-0 fw-semibold text-danger fs-5"
                                    id="diskon" name="diskon" value="0">
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
                                    class="form-control border-primary border-start-0 fw-bold text-primary fs-5"
                                    id="uangbayar" name="uangbayar" placeholder="Masukkan nominal...">
                            </div>
                            <input type="hidden" id="uangbayarasli" name="uangbayarasli" value="0">
                            <span id="label_asli" class="fw-semibold" hidden>0</span>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12">
                        <button class="btn btn-primary btn-lg w-100 fw-bold shadow-sm py-2" id="tombolbayar"
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

<script>
    $(document).ready(function() {
        tampilkanorderresep();
        tampilkantagihanpasien();
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
</script>
