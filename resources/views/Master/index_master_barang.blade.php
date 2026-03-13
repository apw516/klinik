@extends('Template.Main')
@section('container')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Master Barang</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Master Barang</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#modaltambahbarang"> <i class="bi bi-plus" style="margin-right:8px"></i> Master
                Barang</button>
            <button hidden type="button" class="btn btn-outline-primary"> <i class="bi bi-plus"
                    style="margin-right:8px"></i>
                Master Jenis</button>
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#modaltambahsupplier"> <i class="bi bi-plus" style="margin-right:8px"></i>
                Master Supplier</button>
            <div class="card mt-3">
                <div class="card-header"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Tabel Data Master Barang</div>
                <div class="card-body">
                    <table id="tabelnamagenerik" class="table table-sm table-bordered table-hover">
                        <thead>
                            <th>ID</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jenis Barang</th>
                            <th>Satuan Besar</th>
                            <th>Satuan Kecil</th>
                            <th>Isi konversi</th>
                            <th>Nama Pencarian</th>
                            <th>Nama Supplier</th>
                            <th>Cara Pakai</th>
                            <th>Harga Beli</th>
                            <th>Margin</th>
                            <th>Harga Jual</th>
                            {{-- <th>Keterangan</th> --}}
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->kode_barang }}</td>
                                    <td>{{ $d->nama_barang }}</td>
                                    <td>{{ $d->nama_jenis_barang }}</td>
                                    <td>{{ $d->satuan_besar }}</td>
                                    <td>{{ $d->satuan_kecil }}</td>
                                    <td>{{ $d->isi_konversi }}</td>
                                    <td>{{ $d->nama_generik }}</td>
                                    <td>{{ $d->nama_supplier }}</td>
                                    <td>{{ $d->aturan_pakai }}</td>
                                    <td>{{ number_format($d->harga_beli, 0, ',', '.') }}
                                        <button style="margin-left:20px " class="btn btn-sm btn-dark editharga"
                                            idbarang = "{{ $d->id }}" nama = "{{ $d->nama_barang }}"
                                            harga_beli = "{{ $d->harga_beli }}"
                                            harga_beli_mask = "{{ number_format($d->harga_beli, 0, ',', '.') }}"
                                            margin = "{{ $d->margin }}" data-bs-toggle="modal"
                                            data-bs-target="#modaledithargabeli"><i class="bi bi-pencil-square"></i>
                                    </td>
                                    <td>{{ $d->margin }} % </td>
                                    <td>{{ number_format($d->harga_jual, 0, ',', '.') }}</button>
                                    </td>
                                    {{-- <td>{{ $d->keterangan }}</td> --}}
                                    <td>
                                        <button class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button>
                                        <button class="btn btn-warning"><i class="bi bi-pencil-square"></i></button>
                                        <button class="btn btn-info addstok" data-bs-toggle="modal"
                                            data-bs-target="#modaltambahstok" namabarang="{{ $d->nama_barang }}"
                                            kodebarang="{{ $d->kode_barang }}" satuan_besar="{{ $d->satuan_besar }}"
                                            satuan_kecil="{{ $d->satuan_kecil }}"><i
                                                class="bi bi-database-fill-add"></i></button>
                                        <button class="btn btn-success infosediaan" data-bs-toggle="modal"
                                            data-bs-target="#modalinfosediaan" namabarang="{{ $d->nama_barang }}"
                                            kodebarang="{{ $d->kode_barang }}" satuan_besar="{{ $d->satuan_besar }}"
                                            satuan_kecil="{{ $d->satuan_kecil }}"><i
                                                class="bi bi-graph-up-arrow"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modaledithargabeli" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Harga Beli</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="formedithargabeli" id="formedithargabeli">
                        <form>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" id="namabarangedit" name="namabarangedit"
                                    aria-describedby="emailHelp">
                                <input hidden type="text" class="form-control" id="idbarangedit" name="idbarangedit"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Harga Beli</label>
                                <input type="text" class="form-control" id="hargabelimaskedit"
                                    name="hargabelimaskedit">
                                <input hidden type="text" class="form-control" id="hargabeliasliedit"
                                    name="hargabeliasliedit">
                                <small hidden class="text-muted">Nilai asli: <span id="label_asli2">0</span></small>

                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Margin Penjualan</label>
                                <input type="text" class="form-control" id="marginpenjualanedit"
                                    name="marginpenjualanedit">
                            </div>
                        </form>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="simpaneditharga()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modaltambahsupplier" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Supplier</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="formsupplier" id="formsupplier">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nama Supplier</label>
                            <input type="email" class="form-control" id="namasupplier2" name="namasupplier2"
                                placeholder="Masukan nama supplier ...">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">No telp</label>
                            <input type="email" class="form-control" id="notelp" name="notelp"
                                placeholder="Masukan nomor telp ...">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3"
                                placeholder="Masukan alamat supplier ..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="simpanmastersupplier()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modaltambahbarang" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Master Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="formmasterbarang" id="formmasterbarang">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nama Barang</label>
                            <input type="email" class="form-control" id="namabarang" name="namabarang"
                                placeholder="Masukan nama barang ...">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nama Generik</label>
                            <input type="email" class="form-control" id="namagenerik" name="namagenerik"
                                placeholder="Masukan nama generik ...">
                            <input hidden type="" id="id_generik" name="id_generik">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Pilih Supplier</label>
                            <input type="email" class="form-control" id="namasupplier" name="namasupplier"
                                placeholder="Masukan nama supplier ...">
                            <input hidden type="" id="id_supplier" name="id_supplier">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Satuan Besar</label>
                            <select class="form-select" aria-label="Default select example" name="satuanbesar">
                                <option selected>Silahkan Pilih</option>
                                @foreach ($data_s as $r)
                                    <option value="{{ $r->nama_sediaan }}">{{ $r->nama_sediaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Satuan Kecil</label>
                            <select class="form-select" aria-label="Default select example" name="satuankecil">
                                <option selected>Silahkan Pilih</option>
                                @foreach ($data_s as $r)
                                    <option value="{{ $r->nama_sediaan }}">{{ $r->nama_sediaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Isi Konversi</label>
                            <input type="email" class="form-control" id="konversi" name="konversi"
                                placeholder="Masukan nama supplier ...">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Aturan Pakai</label>
                            <textarea class="form-control" id="aturanpakai" name="aturanpakai" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="simpanmasterbarang()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modaltambahstok" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Stok Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="formstokbarang" id="formstokbarang">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="namabarangstok" name="namabarangstok"
                                aria-describedby="emailHelp">
                            <input hidden type="text" class="form-control" id="kodebarang" name="kodebarang"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Satuan Besar</label>
                                    <input type="text" class="form-control" id="satuanbesar" name="satuanbesar"
                                        aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Satuan Kecil</label>
                                    <input type="text" class="form-control" id="satuankecil" name="satuankecil"
                                        aria-describedby="emailHelp">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Kode Batch</label>
                            <input type="text" class="form-control" id="kodebatch" name="kodebatch"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Expired Date</label>
                            <input type="date" class="form-control" id="ed" name="ed"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Stok Masuk ( dalam satuan besar
                                )</label>
                            <input type="text" class="form-control" id="stokmasuk" name="stokmasuk">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Harga ( dalam satuan besar )</label>
                            <input type="text" class="form-control" id="harga_mask" name="harga_mask">
                            <input hidden type="text" class="form-control" id="harga_asli" name="harga_asli">
                            <small hidden class="text-muted">Nilai asli: <span id="label_asli">0</span></small>
                            {{-- <input type="text" id="input_mask" class="form-control" placeholder="Masukkan nominal...">
                        <input hidden type="" id="input_asli" name="uangbayar"> --}}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpanstokbarang()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalinfosediaan" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Info Stok Sediaan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="v_stok_sediaan">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .ui-autocomplete {
            z-index: 215000000 !important;
            /* Pastikan lebih tinggi dari z-index Modal */
        }
    </style>
    <script>
        $(function() {
            $("#tabelnamagenerik").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "pageLength": 12,
                "searching": true,
                "ordering": false,
            })
        });
        $(document).ready(function() {
            $("#namagenerik").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('route.cari.generik') }}", // Ganti dengan route Anda
                        data: {
                            term: request.term
                        },
                        dataType: "json",
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 2, // Minimal ketik 2 huruf baru mencari
                select: function(event, ui) {
                    // Saat obat dipilih, masukkan label ke input dan ID ke hidden input
                    $("#namagenerik").val(ui.item.label);
                    $("#id_generik").val(ui.item.id);
                    return false;
                }
            });
            $("#namasupplier").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('cari-supplier') }}", // Ganti dengan route Anda
                        data: {
                            term: request.term
                        },
                        dataType: "json",
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 2, // Minimal ketik 2 huruf baru mencari
                select: function(event, ui) {
                    // Saat obat dipilih, masukkan label ke input dan ID ke hidden input
                    $("#namasupplier").val(ui.item.label);
                    $("#id_supplier").val(ui.item.id);
                    return false;
                }
            });
        });
        const inputMask = document.getElementById('harga_mask');
        const inputAsli = document.getElementById('harga_asli');
        const labelAsli = document.getElementById('label_asli');

        const inputMask2 = document.getElementById('hargabelimaskedit');
        const inputAsli2 = document.getElementById('hargabeliasliedit');
        const labelAsli2 = document.getElementById('label_asli2');


        inputMask.addEventListener('keyup', function(e) {
            // 1. Ambil angka saja dari input
            let nominal = this.value.replace(/[^,\d]/g, '').toString();

            // 2. Masukkan angka bersih ke input hidden & label
            inputAsli.value = nominal;
            labelAsli.innerText = nominal;

            // 3. Ubah tampilan input menjadi format ribuan
            this.value = formatRupiah(nominal);
        });

        inputMask2.addEventListener('keyup', function(e) {
            // 1. Ambil angka saja dari input
            let nominal = this.value.replace(/[^,\d]/g, '').toString();

            // 2. Masukkan angka bersih ke input hidden & label
            inputAsli2.value = nominal;
            labelAsli2.innerText = nominal;

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

        function simpanmasterbarang() {
            Swal.fire({
                title: "Data barang akan disimpan !",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Simpan",
                denyButtonText: `Batal`
            }).then((result) => {
                if (result.isConfirmed) {
                    simpan()
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        }

        function simpanmastersupplier() {
            Swal.fire({
                title: "Data supplier akan disimpan !",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Simpan",
                denyButtonText: `Batal`
            }).then((result) => {
                if (result.isConfirmed) {
                    simpansupplier()
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        }

        function simpanstokbarang() {
            Swal.fire({
                title: "Data stok barang akan disimpan !",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Simpan",
                denyButtonText: `Batal`
            }).then((result) => {
                if (result.isConfirmed) {
                    simpanstokbaranginjek()
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        }

        function simpansupplier() {
            var data = $('.formsupplier').serializeArray();
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data),
                },
                url: '<?= route('simpansupplier') ?>',
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
                        const myForm = document.getElementById('formsupplier');
                        myForm.reset();
                    }
                }
            });
        }

        function simpan() {
            var data = $('.formmasterbarang').serializeArray();
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data),
                },
                url: '<?= route('simpanmasterbarang') ?>',
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
                        const myForm = document.getElementById('formmasterbarang');
                        myForm.reset();
                    }
                }
            });
        }

        function simpanstokbaranginjek() {
            var data = $('.formstokbarang').serializeArray();
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data),
                },
                url: '<?= route('simpanstokbaranginjek') ?>',
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
                        const myForm = document.getElementById('formstokbarang');
                        myForm.reset();
                    }
                }
            });
        }

        function simpaneditharga() {
            var data = $('.formedithargabeli').serializeArray();
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data)
                },
                url: '<?= route('simpaneditharga') ?>',
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
                        const myForm = document.getElementById('formedithargabeli');
                        myForm.reset();
                    }
                }
            });
        }
        $(".addstok").on('click', function(event) {
            namabarang = $(this).attr('namabarang')
            kodebarang = $(this).attr('kodebarang')
            satuan_besar = $(this).attr('satuan_besar')
            satuan_kecil = $(this).attr('satuan_kecil')
            $('#namabarangstok').val(namabarang)
            $('#kodebarang').val(kodebarang)
            $('#satuanbesar').val(satuan_besar)
            $('#satuankecil').val(satuan_kecil)
        });
        $(".editharga").on('click', function(event) {
            idbarang = $(this).attr('idbarang')
            nama = $(this).attr('nama')
            harga_beli = $(this).attr('harga_beli')
            harga_beli_mask = $(this).attr('harga_beli_mask')
            margin = $(this).attr('margin')
            $('#namabarangedit').val(nama);
            $('#idbarangedit').val(idbarang);
            $('#hargabeliasliedit').val(harga_beli);
            $('#hargabelimaskedit').val(harga_beli_mask);
            $('#marginpenjualanedit').val(margin);
        })
        $(".infosediaan").on('click', function(event) {
            idbarang = $(this).attr('kodebarang')
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    idbarang
                },
                url: '<?= route('ambilinfosediaan') ?>',
                success: function(response) {
                    spinner.hide();
                    $('.v_stok_sediaan').html(response);
                }
            });
        })
    </script>
@endsection
