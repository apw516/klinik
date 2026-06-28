@extends('Template.Main')
@section('container')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Pasien</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Pasien</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        @if (count($cek_sesi) > 0)
            <div class="container-fluid">
                <div class="v_1">
                    @php
                        $sesiAktif = $cek_sesi[0]; // Ambil data sesi pertama
                    @endphp
                    <div class="card border-success shadow-sm mb-4">
                        <div class="card-body bg-light py-3">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                <div class="d-flex align-items-center mb-2 mb-md-0">
                                    <div class="bg-success text-white rounded-circle p-2 d-flex align-items-center justify-content-center mr-5"
                                        style="width: 45px; height: 45px;">
                                        <i class="bi bi-person-badge-fill" style="font-size: 1.3rem;"></i>
                                    </div>
                                    <div>
                                        {{-- <h6 class="m-0 font-weight-bold text-success text-uppercase ml-4"
                                            style="font-size: 0.85rem; letter-spacing: 0.5px;">
                                        </h6> --}}
                                        <span class="text-dark font-weight-bold"
                                            style="font-size: 1.05rem; margin-left:12px">
                                            Sesi Kasir :
                                            {{ $sesiAktif->nama_user }}
                                        </span>
                                    </div>
                                </div>

                                <div class="row text-md-right mt-2 mt-md-0">
                                    <div class="col-6 col-md-auto border-right-md px-3">
                                        <small class="text-muted d-block text-uppercase"
                                            style="font-size: 0.75rem; letter-spacing: 0.5px;">Waktu Mulai</small>
                                        <span class="font-weight-bold text-secondary" style="font-size: 0.95rem;">
                                            <i class="bi bi-clock-history mr-1"></i>
                                            {{ date('d-m-Y H:i', strtotime($sesiAktif->tgl_mulai)) }} WIB
                                        </span>
                                    </div>
                                    <div class="col-6 col-md-auto px-3">
                                        <small class="text-muted d-block text-uppercase"
                                            style="font-size: 0.75rem; letter-spacing: 0.5px;">Saldo Awal
                                            (Modal)</small>
                                        <span class="font-weight-bold text-primary" style="font-size: 0.95rem;">
                                            Rp {{ number_format($sesiAktif->saldo_awal, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-warning mr-4 ml-5 tutupsesi" idsesi="{{ $sesiAktif->id }}">Tutup Sesi
                            </button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header"><i class="bi bi-search" style="margin-right:8px"></i>Tentukan Range Tanggal
                        </div>
                        <div class="card-body">
                            <form action="" class="formpencarianpasien">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="tanggalawal" class="form-label">Tanggal Awal</label>
                                            <input type="date" name="tanggalawal" id="tanggalawal"
                                                value="{{ $datenow }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="tanggalakhir" class="form-label">Tanggal Akhir</label>
                                            <input type="date" name="tanggalakhir" id="tanggalakhir"
                                                value="{{ $datenow }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-success" style="margin-top:32px"
                                            onclick="tampilkandatapasien()">
                                            <i class="bi bi-search" style="margin-right:8px"></i>Tampilkan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-header"><i class="bi bi-database-fill-check" style="margin-right: 8px"></i> Tabel
                            Data Pasien</div>
                        <div class="card-body">
                            <div class="v_data_pasien"></div>
                        </div>
                    </div>
                </div>

                <div hidden class="v_2">
                    <button class="btn btn-danger" onclick="kembali()"><i class="bi bi-back"></i> Kembali</button>
                    <div class="v_kasirfarmasi"></div>
                </div>
            </div>
        @else
            <div class="container-fluid mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card border-warning shadow-sm text-center py-4">
                            <div class="card-body">
                                <div class="text-warning mb-3">
                                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 3.5rem;"></i>
                                </div>

                                <h4 class="font-weight-bold text-dark text-uppercase mb-2" style="letter-spacing: 0.5px;">
                                    Sesi Kasir Belum Aktif
                                </h4>

                                <p class="text-muted px-4 mb-4" style="font-size: 0.95rem; line-height: 1.6;">
                                    Anda tidak dapat mengakses data pasien atau memproses transaksi obat karena belum ada
                                    sesi kasir yang dibuka hari ini. Silakan mulai sesi terlebih dahulu.
                                </p>

                                <button type="button"
                                    class="btn btn-warning text-dark font-weight-bold px-4 py-2 shadow-sm"
                                    data-bs-toggle="modal" data-bs-target="#modalmulai">
                                    <i class="bi bi-play-circle-fill mr-2"></i> Buka Sesi Kasir Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="modal" tabindex="-1" id="modalmulai">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Masukan Saldo Awal Sesi Kasir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Saldo Awal</label>
                        <label hidden for="exampleFormControlInput1" class="form-label" id="label_asli">Saldo
                            Awal</label>
                        <input type="text" class="form-control" id="saldoawaldisp"
                            placeholder="Masukan saldo awal kasir ...">
                        <input hidden type="text" class="form-control" id="saldoawal"
                            placeholder="Masukan saldo awal kasir ...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="mulaisesi()">Mulai Sesi</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            tampilkandatapasien()
        })

        function mulaisesi() {
            Swal.fire({
                title: "Anda yakin ?",
                text: "Data Sesi anda akan disimpan !",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya Simpan ..."
            }).then((result) => {
                if (result.isConfirmed) {
                    savesesi()
                }
            });
        }

        function savesesi() {
            saldoawal = $('#saldoawal').val();
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    saldoawal,
                },
                url: '<?= route('simpansesikasir') ?>',
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
                        location.reload()
                    }
                }
            });
        }

        function tampilkandatapasien() {
            tanggalawal = $('#tanggalawal').val()
            tanggalakhir = $('#tanggalakhir').val()
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    tanggalawal,
                    tanggalakhir

                },
                url: '<?= route('ambildatapasienkasirfarmasi') ?>',
                success: function(response) {
                    spinner.hide();
                    $('.v_data_pasien').html(response);
                }
            });
        }

        function kembali() {
            $('.v_1').removeAttr('hidden', true)
            $('.v_2').attr('hidden', true)
        }

        $(document).ready(function() {

            const inputMask = document.getElementById('saldoawaldisp');
            const inputAsli = document.getElementById('saldoawal');
            const labelAsli = document.getElementById('label_asli');

            inputMask.addEventListener('keyup', function() {
                let nominal = this.value.replace(/[^,\d]/g, '').toString();
                inputAsli.value = nominal;
                labelAsli.innerText = nominal ? formatRupiah(nominal) : '0';
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
        })


        $(".tutupsesi").on('click', function(event) {
            idsesi = $(this).attr('idsesi')
            spinner = $('#loader')
            spinner.show();
            Swal.fire({
                title: "Anda yakin ?",
                text: "Data Sesi anda akan ditutup !",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya Tutup Sesi ..."
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        data: {
                            _token: "{{ csrf_token() }}",
                            idsesi,
                        },
                        url: '<?= route('tutupsesikasir') ?>',
                        errir: function(response) {
                            spinner.hide();
        
                        },
                        success: function(response) {
                            spinner.hide();
                            location.reload()
                        }
                    });
                }
            });
        });
    </script>
@endsection
