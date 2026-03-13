@extends('Template.Main')
@section('container')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Daftar Pelayanan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Daftar Pelayanan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="v_1">
                <button type="button" class="btn  mb-2 btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modaltambahpasien"> <i class="bi bi-plus" style="margin-right:8px"></i>
                    Master Pasien</button>
                <div class="card">
                    <div class="card-header"><i class="bi bi-search" style="margin-right:8px"></i>Form Pencarian Pasien
                    </div>
                    <div class="card-body">
                        <form action="" class="formpencarianpasien">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Nomor RM</label>
                                        <input type="email" name="nomorrm" placeholder="Masukan Nomor Rekamedis ..."
                                            class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Nomor Identitas</label>
                                        <input type="email" name="nomoridentitas"
                                            placeholder="Masukan Nomor Identitas ( KTP, SIM Dsb ) ..." class="form-control"
                                            id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Nomor Asuransi</label>
                                        <input type="email" name="nomorasuransi" placeholder="Masukan Nomor Asuransi ..."
                                            class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Nama Pasien</label>
                                        <input type="email" name="namapasien" placeholder="Masukan Nama Pasien ..."
                                            class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Alamat</label>
                                        <input placeholder="Masukan Nama Desa ..." type="email" name="namadesa"
                                            class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success" style="margin-top:32px"
                                        onclick="caripasien()"><i class="bi bi-search" style="margin-right:8px"></i> Cari
                                        Pasien</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header"><i class="bi bi-database-fill-check " style="margin-right: 8px"></i> Hasil
                        Pencarian Pasien</div>
                    <div class="card-body">
                        <div class="v_tabel_pasien">

                        </div>
                    </div>
                </div>
            </div>
            <div hidden class="v_2">
                <button onclick="kembali()" class="btn btn-danger"><i class="bi bi-backspace"
                        style="margin-right:12px"></i>Kembali</button>
                <div class="v_data_pasien mt-2">

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modaltambahpasien" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="formmasterpasien" id="formmasterpasien">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Pilih Jenis Kartu Identitas</label>
                                    <select class="form-select" aria-label="Default select example" name="jenisidentitas"
                                        id="jenisidentitas">
                                        <option value="0">-</option>
                                        <option value="1">KTP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nomor Kartu Identitas</label>
                                    <input type="email" class="form-control" id="nomoridentitas" name="nomoridentitas"
                                        placeholder="Masukan nomor kartu identitas ..." aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div hidden class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nomor Asuransi</label>
                                    <input type="email" class="form-control" id="nomorasuransi" name="nomorasuransi"
                                        aria-describedby="emailHelp">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nama Pasien</label>
                                    <input type="email" class="form-control" id="namapasien" name="namapasien"
                                        aria-describedby="emailHelp" placeholder="Masukan Nama Pasien ...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Status Pernikahan</label>
                                    <select class="form-select" aria-label="Default select example"
                                        name="status_pernikahan" id="status_pernikahan">
                                        <option value="0">-</option>
                                        <option value="1">Menikah</option>
                                        <option value="2">Belum Menikah</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" aria-label="Default select example" name="jeniskelamin"
                                        id="jeniskelamin">
                                        <option value="PRIA">PRIA</option>
                                        <option value="WANITA">WANITA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Tempat Lahir</label>
                                    <input type="email" class="form-control" id="tempatelahir" name="tempatlahir"
                                        aria-describedby="emailHelp" placeholder="Masukan kota tempat lahir ...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggallahir" name="tanggallahir"
                                        aria-describedby="emailHelp">
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-header">ALAMAT</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Provinsi</label>
                                            <input type="text" class="form-control" id="provinsi" name="provinsi"
                                                aria-describedby="emailHelp" placeholder="silahkan pilih provinsi ...">
                                            <input readonly type="text" class="form-control" id="idprovinsi"
                                                name="idprovinsi" aria-describedby="emailHelp">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Kabupaten</label>
                                            <input type="email" class="form-control" id="kabupaten" name="kabupaten"
                                                aria-describedby="emailHelp" placeholder="Silahkan pilih kabupaten ...">
                                            <input readonly type="email" class="form-control" id="idkabupaten"
                                                name="idkabupaten" aria-describedby="emailHelp">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Kecamatan</label>
                                            <input type="email" class="form-control" id="kecamatan" name="kecamatan"
                                                aria-describedby="emailHelp" placeholder="Silahkan pilih kecamatan ...">
                                            <input readonly type="email" class="form-control" id="idkecamatan"
                                                name="idkecamatan" aria-describedby="emailHelp">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Desa</label>
                                            <input type="email" class="form-control" id="desa" name="desa"
                                                aria-describedby="emailHelp" placeholder="Silahkan Pilih Desa ...">
                                            <input readonly type="email" class="form-control" id="iddesa"
                                                name="iddesa" aria-describedby="emailHelp">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Alamat Lengkap</label>
                                            <textarea type="email" class="form-control" id="alamatlengkap" name="alamatlengkap" aria-describedby="emailHelp"
                                                placeholder="masukan alamat lengkap , contoh : RT 002 RW 006 JL. MERDEKA BLOK 1"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="simpanpasien()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            caripasien()
        })

        function kembali() {
            $('.v_1').removeAttr('hidden', true)
            $('.v_2').attr('hidden', true)
        }

        function caripasien() {
            var data = $('.formpencarianpasien').serializeArray();
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data),

                },
                url: '<?= route('caridatapasien') ?>',
                success: function(response) {
                    spinner.hide();
                    $('.v_tabel_pasien').html(response);
                }
            });
        }

        $(document).ready(function() {
            $("#provinsi").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('route.cari.provinsi') }}", // Ganti dengan route Anda
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
                    $("#provinsi").val(ui.item.label);
                    $("#idprovinsi").val(ui.item.id);
                    return false;
                }
            });
            $("#kabupaten").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('route.cari.kabupaten') }}", // Ganti dengan route Anda
                        data: {
                            term: request.term,
                            idprovinsi: $('#idprovinsi').val()
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
                    $("#kabupaten").val(ui.item.label);
                    $("#idkabupaten").val(ui.item.id);
                    return false;
                }
            });
            $("#kecamatan").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('route.cari.kecamatan') }}", // Ganti dengan route Anda
                        data: {
                            term: request.term,
                            idkabupaten: $('#idkabupaten').val()
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
                    $("#kecamatan").val(ui.item.label);
                    $("#idkecamatan").val(ui.item.id);
                    return false;
                }
            });
            $("#desa").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('route.cari.desa') }}", // Ganti dengan route Anda
                        data: {
                            term: request.term,
                            idkecamatan: $('#idkecamatan').val()
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
                    $("#desa").val(ui.item.label);
                    $("#iddesa").val(ui.item.id);
                    return false;
                }
            });
        });

        function simpanpasien() {
            Swal.fire({
                title: "Data Pasien akan disimpan !",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Simpan",
                denyButtonText: `Batal`
            }).then((result) => {
                if (result.isConfirmed) {
                    simpanpasienx()
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        }

        function simpanpasienx() {
            var data = $('.formmasterpasien').serializeArray();
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
                url: '<?= route('simpanpasien') ?>',
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
                        const myForm = document.getElementById('formmasterpasien');
                        myForm.reset();
                    }
                }
            });
        }
    </script>
@endsection
