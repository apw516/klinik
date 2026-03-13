@extends('Template.Main')
@section('container')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Unit</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Unit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modaladdunit"> <i
                    class="bi bi-plus" style="margin-right:8px"></i>
                Master Unit / Ruangan</button>
            <div class="card mt-3">
                <div class="card-header"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Tabel Data Unit</div>
                <div class="card-body">
                    <table id="tabelunit" class="table table-sm table-bordered table-hover">
                        <thead>
                            <th>ID</th>
                            <th>Nama Unit</th>
                            <th>Tipe Unit dan Kelas</th>
                            <th>Klinik</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->nama_unit }}</td>
                                    <td>{{ $d->tipe_unit }} / Kelas {{ $d->kelas }}</td>
                                    <td>{{ $d->nama_klinik }}</td>
                                    <td>
                                        @if ($d->status == 1)
                                            Aktif
                                        @else
                                            Tidak Aktif
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-warning editunit" 
                                            idunit="{{ $d->id }}"
                                            nama="{{ $d->nama_unit }}" 
                                            kelas="{{ $d->kelas}}"
                                            tipeunit="{{ $d->tipe_unit}}"
                                            status="{{ $d->status}}"

                                            data-bs-toggle="modal"
                                            data-bs-target="#modaleditunit"><i class="bi bi-pencil-square"></i></button>
                                        <button class="btn btn-danger hapusunit" idunit="{{ $d->id }}"
                                            nama="{{ $d->nama_unit }}"><i class="bi bi-trash3"></i></button>
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
    <div class="modal fade" id="modaladdunit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Unit Baru</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="formaddunit" id="formaddunit">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Unit</label>
                            <input type="text" class="form-control" id="namaunit" name="namaunit"
                                aria-describedby="emailHelp" placeholder="Masukan nama unit ...">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tipe Unit</label>
                            <select class="form-select" aria-label="Default select example" id="tipeunit" name="tipeunit">
                                <option value="RAWAT JALAN">Rawat Jalan</option>
                                <option value="RAWAT INAP">Rawat Inap</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Kelas</label>
                            <select class="form-select" aria-label="Default select example" id="kelas" name="kelas">
                                <option selected>Silahkan pilih</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Status</label>
                            <select class="form-select" aria-label="Default select example" id="status" name="status">
                                <option selected>Silahkan pilih</option>
                                <option value="1">aKTIF</option>
                                <option value="2">TIDAK AKTIF</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="simpanalert()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modaleditunit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Silahkan Edit Unit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="formeditunit" name="formeditunit">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Unit</label>
                            <input type="text" class="form-control" id="namaunitedit" name="namaunitedit"
                                aria-describedby="emailHelp" placeholder="Masukan nama unit ...">
                            <input hidden type="text" class="form-control" id="idunit" name="idunit"
                                aria-describedby="emailHelp" placeholder="Masukan nama unit ...">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tipe Unit</label>
                            <select class="form-select" aria-label="Default select example" name="tipeunitedit" id="tipeunitedit">
                                <option value="RAWAT JALAN">Rawat Jalan</option>
                                <option value="RAWAT INAP">Rawat Inap</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Kelas</label>
                            <select class="form-select" aria-label="Default select example" name="kelasunitedit" id="kelasunitedit">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Status</label>
                            <select class="form-select" aria-label="Default select example" name="statusedit" id="statusedit">
                                <option value="1">AKTIF</option>
                                <option value="2">TIDAK AKTIF</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="simpanalert2()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $("#tabelunit").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "pageLength": 12,
                "searching": true,
                "ordering": false,
            })
        });
        $(".editunit").on('click', function(event) {
            idunit = $(this).attr('idunit')
            nama = $(this).attr('nama')
            kelas = $(this).attr('kelas')
            tipeunit = $(this).attr('tipeunit')
            status = $(this).attr('status')        
            $('#namaunitedit').val(nama);
            $('#idunit').val(idunit);
            $('#tipeunitedit').val(tipeunit).trigger('change');
            $('#kelasunitedit').val(kelas).trigger('change');
            $('#statusedit').val(status).trigger('change');
        })
        $(".hapusunit").on('click', function(event) {
            idunit = $(this).attr('idunit')
            nama = $(this).attr('nama')
            Swal.fire({
                title: "Anda yakin ?",
                text: "Pastikan data sudah diisi dengan benar ...",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, simpan !"
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
                            idunit
                        },
                        url: '<?= route('hapusunit') ?>',
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
            });
        })
        function simpanalert()
        {
            Swal.fire({
                title: "Anda yakin ?",
                text: "Data Unit " + nama + " Akan disimpan ...",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus !"
            }).then((result) => {
                if (result.isConfirmed) {
                    simpanunit()
                }
            });
        }
        function simpanalert2()
        {
            Swal.fire({
                title: "Anda yakin ?",
                text: "Data Unit " + nama + " Akan diedit ...",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus !"
            }).then((result) => {
                if (result.isConfirmed) {
                    formeditunit()
                }
            });
        }

        function simpanunit() {
            var data = $('.formaddunit').serializeArray();
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
                url: '<?= route('simpanunit') ?>',
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
                        const myForm = document.getElementById('formaddunit');
                        myForm.reset();
                    }
                }
            });
        }
        function formeditunit() {
            var data = $('.formeditunit').serializeArray();
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
                url: '<?= route('simpaneditunit') ?>',
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
                        const myForm = document.getElementById('formeditunit');
                        myForm.reset();
                    }
                }
            });
        }
    </script>
@endsection
