<div class="card mt-2">
    <div class="card-header mt-2">Info Pasien</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <table class="table table-sm table-boredered">
                    <tr>
                        <td>Nomor Identitas</td>
                        <td>: {{ $mt_pasien[0]->nomor_identitas }}</td>
                    </tr>
                    <tr>
                        <td>ID Satu Sehat</td>
                        <td>{{ $mt_pasien[0]->id_satu_sehat }}</td>
                    </tr>
                    <tr>
                        <td>Nomor RM</td>
                        <td>{{ $mt_pasien[0]->nomor_rm }}</td>
                    </tr>
                    <tr>
                        <td>Nama Pasien</td>
                        <td>{{ $mt_pasien[0]->nama_pasien }}</td>
                    </tr>
                    <tr>
                        <td>Tempat, Tanggal lahir</td>
                        <td>{{ $mt_pasien[0]->tempat_lahir }},
                            {{ \Carbon\Carbon::parse($mt_pasien[0]->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>{{ $mt_pasien[0]->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>{{ $mt_pasien[0]->alamat_domisili }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Riwayat Kunjungan</div>
                    <div class="card-body">
                        <table id="tabelriwayat" class="table table-sm table-bordered text-center table-hover">
                            <thead>
                                <th width="20%">Tanggal masuk | Kunjungan</th>
                                <th width="16%">Unit</th>
                                <th width="16%">Dokter</th>
                                <th width="16%">Keluhan Utama</th>
                                <th>S.O.A.P</th>
                            </thead>
                            <tbody>
                                @foreach ($data_kunjungan as $t)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($t->tgl_masuk)->locale('id')->translatedFormat('d F Y') }}
                                            | ke - {{ $t->counter }}</td>
                                        <td>{{ $t->nama_unit }}</td>
                                        <td>{{ $t->nama_dokter }}</td>
                                        <td>{{ $t->keluhan_utama }}</td>
                                        <td>
                                            {{ $t->SUBJECT }}
                                            ,{{ $t->OBJECT }},{{ $t->ASSESMENT }},{{ $t->PLANNING }}
                                            <span class="badge text-bg-secondary pilihriwayat" subject="{{ $t->SUBJECT }}"
                                                object="{{ $t->OBJECT }}" assesmen="{{ $t->ASSESMENT }}"
                                                planning="{{ $t->PLANNING }}"><i class="bi bi-cursor"></i></span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card mt-2">
                <div class="card-header">Form Hasil Pemeriksaan</div>
                <div class="card-body">
                    <form action="" class="formassesmen">
                        <input hidden type="text" value="{{ $idkunjungan }}" name="idkunjungan" id="idkunjungan">
                        <table class="table table-sm">
                            <tr>
                                <td>Tekanan Darah : {{ $dk[0]->tekanan_darah }} mmHg</td>
                                <td>Suhu Tubuh : {{ $dk[0]->suhu_tubuh }} (°C)</td>
                                <td colspan="2">Keluhan Utama : {{ $dk[0]->keluhan_utama }}</td>
                            </tr>
                            <tr>
                                <td class="bg-light fw-bold">
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">SUBJECT <i
                                                class="bi bi-arrow-down-short"></i></label>
                                        <textarea class="form-control" id="subject" name="subject" rows="3"
                                            placeholder="Ketik hasil pemeriksaan subject... ">{{ $dk[0]->SUBJECT }}</textarea>
                                    </div>
                                </td>
                                <td class="bg-light fw-bold">
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">OBJECT <i
                                                class="bi bi-arrow-down-short"></i></label>
                                        <textarea class="form-control" id="object" name="object" rows="3"
                                            placeholder="Ketik hasil pemeriksaan obeject... ">{{ $dk[0]->OBJECT }}</textarea>
                                    </div>
                                </td>
                                <td class="bg-light fw-bold">
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">ASSESMENT <i
                                                class="bi bi-arrow-down-short"></i></label>
                                        <textarea class="form-control" id="assesmen" name="assesmen" rows="3"
                                            placeholder="Ketik hasil pemeriksaan assesmen ... ">{{ $dk[0]->ASSESMENT }}</textarea>
                                    </div>
                                </td>
                                <td class="bg-light fw-bold">
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">PLANNING <i
                                                class="bi bi-arrow-down-short"></i></label>
                                        <textarea class="form-control" id="planning" name="planning" rows="3"
                                            placeholder="Ketik hasil pemeriksaan planning ... ">{{ $dk[0]->PLANNING }}</textarea>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header fw-bold fst-italic">Input billing sistem</div>
                                <div class="card-body">
                                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modaltarif"> <i
                                            class="bi bi-search"></i> tarif Pelayanan</button>
                                    <form action="" method="post" class="formbilling mt-2">
                                        <div class="draftbilling">
                                            <div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="card mt-4">
                                        <div class="card-header fw-bold fst-italic bg-light">data billing yang sudah
                                            tersimpan ...</div>
                                        <div class="card-body">
                                            <div class="v_riwayat_billing"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header fw-bold fst-italic">Resep Obat</div>
                                <div class="card-body">
                                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalobat"> <i
                                            class="bi bi-search"></i> Obat </button>
                                    <form action="" method="post" class="formbillingobat mt-2">
                                        <div class="draftbillingobat">
                                            <div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="card mt-4">
                                        <div class="card-header fw-bold fst-italic bg-light">data resep yang sudah
                                            tersimpan ...</div>
                                        <div class="card-body">
                                            <div class="v_riwayat_resep"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success" onclick="simpandata()"><i class="bi bi-floppy"></i>
                        Simpan</button>
                    <button class="btn btn-danger" onclick="kembali()"><i class="bi bi-back"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modaltarif" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Silahkan Pilih Tarif Pelayanan</h1>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalobat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Silahkan Pilih Obat</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="tabelstok" class="table table-sm tabel-bordered table-hover">
                    <thead>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Aturan pakai</th>
                    </thead>
                    <tbody>
                        @foreach ($stokSemua as $item)
                            <tr class="pilihobat" kode_barang="{{ $item->kode_barang }}"
                                nama_barang="{{ $item->nama_barang }}" stok={{ $item->stok_sekarang }}
                                aturan_pakai="{{ $item->aturan_pakai }}">
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->stok_sekarang }}</td>
                                <td>{{ $item->aturan_pakai }}</td>
                                {{-- <td>{{ $item->stok_sekarang}}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tabelriwayat").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 2,
            "searching": true,
            "ordering": false,
        })
    });
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

    function simpandata() {
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
                title: "Data akan disimpan sebagai catatan medis pasien ?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Simpan",
                denyButtonText: `Batal`
            }).then((result) => {
                if (result.isConfirmed) {
                    simpancatatanmedis()
                }
            });
        });
    }

    function simpancatatanmedis() {
        var data1 = $('.formassesmen').serializeArray();
        var data2 = $('.formbilling').serializeArray();
        var data3 = $('.formbillingobat').serializeArray();
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data1: JSON.stringify(data1),
                data2: JSON.stringify(data2),
                data3: JSON.stringify(data3),
            },
            url: '<?= route('simpancatatanmedis') ?>',
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
                    const myForm = document.getElementById('formassesmen');
                    myForm.reset();
                }
            }
        });
    }
    $(".pilihriwayat").on('click', function(event) {
        subject = $(this).attr('subject')
        object = $(this).attr('object')
        assesmen = $(this).attr('assesmen')
        planning = $(this).attr('planning')
        $('#subject').val(subject)
        $('#object').val(object)
        $('#assesmen').val(assesmen)
        $('#planning').val(planning)
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
        kode_barang = $(this).attr('kode_barang')
        nama_barang = $(this).attr('nama_barang')
        stok = $(this).attr('stok')
        aturan_pakai = $(this).attr('aturan_pakai')
        var wrapper = $(".draftbillingobat");
        $(wrapper).append(
            '<div class="row text-xs"><div class="form-group col-md-4"><label for="">Nama Tarif</label><input readonly type="" class="form-control form-control-sm text-xs edit_field" id="namabarang" name="namabarang" value="' +
            nama_barang +
            '"><input   hidden readonly type="" class="form-control form-control-sm" id="kodebarang" name="kodebarang" value="' +
            kode_barang +
            '"><input   hidden readonly type="" class="form-control form-control-sm" id="harga2" name="harga2" value=""></div><div class="form-group col-md-1"><label for="">Stok</label><input readonly type="" class="form-control form-control-sm text-xs edit_field" id="stok" name="stok" value="' +
            stok +
            '"></div><div class="form-group col-md-2"><label for="">qty</label><input type="" class="form-control form-control-sm text-xs edit_field" id="qty" name="qty" value="0"></div><div class="form-group col-md-3"><label for="">Aturan Pakai</label><textarea readonly type="" class="form-control form-control-sm text-xs edit_field" id="aturanpakai" name="aturanpakai">' +
            aturan_pakai +
            '</textarea></div><i class="bi bi-x-square remove_field form-group col-md-1 text-danger" kode2=""></i></div>'
        );
        Swal.fire({
            title: "Obat dipilih " + nama_barang,
            text: "ok!",
            icon: "success"
        });
        $(wrapper).on("click", ".remove_field", function(e) { //user click on remove
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });
    $(document).ready(function() {
        ambilriwayatbilling()
        ambilriwayatresep()
    })

    function ambilriwayatbilling() {
        idkunjungan = $('#idkunjungan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idkunjungan
            },
            url: '<?= route('ambilriwayatbilling') ?>',
            success: function(response) {
                spinner.hide();
                $('.v_riwayat_billing').html(response);
            }
        });
    }

    function ambilriwayatresep() {
        idkunjungan = $('#idkunjungan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idkunjungan
            },
            url: '<?= route('ambilriwayatresep') ?>',
            success: function(response) {
                spinner.hide();
                $('.v_riwayat_resep').html(response);
            }
        });
    }
</script>
