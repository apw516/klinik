<input hidden type="text" id="idlayanan" value="{{ $idlayananheader }}">
<input hidden type="text" id="idkunjungan" value="{{ $idkunjungan }}">
<div class="row mt-2">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">Data Order Obat</div>
            <div class="card-body">
                <div class="v_orderan">

                </div>
            </div>
            <div class="card-footer">
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="paketresep" value="1">
                    <label class="form-check-label" for="exampleCheck1">Ceklis jika Harga obat sudah termasuk kedalam
                        paket pemeriksaan</label>
                </div>
                <button class="btn btn-success" onclick="terimaresep()"><i class="bi bi-bookmark-plus"></i> Terima
                    Resep</button>
            </div>
        </div>
    </div>
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
                        title: "Data sewa berhasil disimpan ...",
                        text: "Silahkan cetak bukti penyewaan dengan klik tombol dibawah ...",
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
</script>
