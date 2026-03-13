<table class="table table-sm">
    <thead>
        <th>Nomor Rm</th>
        <th>Nama Pasien</th>
    </thead>
    <tbody>
        <tr>
            <td>{{ $pasien[0]->nomor_rm }}</td>
            <td>{{ $pasien[0]->nama_pasien }}</td>
        </tr>
    </tbody>
</table>
<input hidden type="text" value="{{ $idkunjungan}}" name="idkunjungan" id="idkunjungan">
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Silahkan Pilih Layanan</div>
            <div class="card-body">
                <table id="tabeltarif" class="table table-sm table-hover" style="font-size:14px">
                    <thead>
                        <th>Nama Tarif</th>
                        <th>Jenis</th>
                        <th>Tarif</th>
                    </thead>
                    <tbody>
                        @foreach ($tarif as $t)
                            <tr class="pilihtarif" idtarif="{{ $t->id }}"
                                harga1="Rp. {{ number_format($t->tarif_1, 0, ',', '.') }}" harga2="{{ $t->tarif_1 }}"
                                nama="{{ $t->nama_tarif }}">
                                <td>{{ $t->nama_tarif }}</td>
                                <td>{{ $t->jenis_tarif }}</td>
                                <td>Rp {{ number_format($t->tarif_1, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Silahkan Pilih Obat</div>
            <div class="card-body">
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Tarif layanan</div>
            <div class="card-body">
                <form action="" method="post" class="formbilling mt-2">
                    <div class="draftbilling">
                        <div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Obat dipilih</div>
            <div class="card-body">
                <form action="" method="post" class="formbillingobat mt-2">
                    <div class="draftbillingobat">
                        <div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
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
</script>
