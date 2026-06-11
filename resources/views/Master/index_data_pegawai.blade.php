@extends('Template.Main')
@section('container')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Pegawai</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Pegawai</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i
                    class="bi bi-plus" style="margin-right:8px"></i>
                Master Pegawai</button>
            <div class="card mt-3">
                <div class="card-header"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Tabel Data Pegawai</div>
                <div class="card-body">
                    <table id="tabelprovinsi" class="table table-sm table-bordered">
                        <thead>
                            <th>ID</th>
                            <th>NIP</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Tempat,Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Posisi Kerja</th>
                            <th>Klinik</th>
                            <th>Mulai Kerja</th>
                            <th>No telepon</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->NIP }}</td>
                                    <td>{{ $d->NIK }}</td>
                                    <td>{{ $d->nama_lengkap }}</td>
                                    <td>{{ $d->tempat_lahir }},{{ $d->tanggal_lahir }}</td>
                                    <td>{{ $d->jenis_kelamin }}</td>
                                    <td>{{ $d->alamat }}</td>
                                    <td>{{ $d->posisi_kerja }}</td>
                                    <td>{{ $d->nama_klinik }}</td>
                                    <td>{{ $d->tanggal_masuk }}</td>
                                    <td>{{ $d->no_telp }}</td>
                                    <td>
                                        @if ($d->status == 1)
                                            Aktif
                                        @else
                                            Tidak Aktif
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-danger hapusdata" idpegawai="{{ $d->id }}"><i
                                                class="bi bi-trash3"></i></button>
                                        <button class="btn btn-warning editdata" idpegawai="{{ $d->id }}"
                                            data-bs-toggle="modal" data-bs-target="#modaledit"><i
                                                class="bi bi-pencil-square"></i></button>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Pegawai</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="formpegawai" id="formpegawai">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="NIP" name="NIP"
                                        placeholder="Masukan NIP ..." aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">NIK</label>
                                    <input type="text" class="form-control" id="NIK" name="NIK"
                                        placeholder="Masukan NIK ...">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="namalengkap" name="namalengkap"
                                        placeholder="Masukan nama lengkap ...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggallahir" name="tanggallahir"
                                        aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempatlahir" name="tempatlahir"
                                        placeholder="Masukan tempat lahir ..." aria-describedby="emailHelp" value="CIREBON">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" aria-label="Default select example" name="jeniskelamin"
                                        id="jeniskelamin">
                                        <option value="L">Laki - Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nomor Telp</label>
                                    <input type="text" class="form-control" id="nomortelepon" name="nomortelepon"
                                        aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Alamat</label>
                                    <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat ..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan"
                                        aria-describedby="emailHelp"
                                        placeholder="Masukan jabatan pekerjaan cth : DOKTER ">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Tanggal Masuk</label>
                                    <input type="date" class="form-control" id="tanggalmasuk" name="tanggalmasuk"
                                        aria-describedby="emailHelp">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpanpegawai()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Pegawai</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="v_form_edit">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpaneditpegawai()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $("#tabelprovinsi").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "pageLength": 12,
                "searching": true,
                "ordering": false,
            })
        });

        function simpaneditpegawai() {
            Swal.fire({
                title: "Data pegawai akan diedit !",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Simpan",
                denyButtonText: `Batal`
            }).then((result) => {
                if (result.isConfirmed) {
                    simpanpegawaieditx()
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        }

        function simpanpegawai() {
            Swal.fire({
                title: "Data pegawai akan disimpan !",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Simpan",
                denyButtonText: `Batal`
            }).then((result) => {
                if (result.isConfirmed) {
                    simpanpegawaix()
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        }

        function simpanpegawaix() {
            var data = $('.formpegawai').serializeArray();
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
                url: '<?= route('simpanpegawai') ?>',
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
                        const myForm = document.getElementById('formpegawai');
                        myForm.reset();
                    }
                }
            });
        }

        function simpanpegawaieditx() {
            var data = $('.formpegawaiedit').serializeArray();
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
                url: '<?= route('simpanpegawaiedit') ?>',
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
                        const myForm = document.getElementById('formpegawaiedit');
                        myForm.reset();
                    }
                }
            });
        }
        $(".editdata").on('click', function(event) {
            idpegawai = $(this).attr('idpegawai')
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    idpegawai
                },
                url: '<?= route('ambildatapegawai') ?>',
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
                            timer: 1500, // Agar Swal menutup otomatis
                            showConfirmButton: false
                        })
                        $('.v_form_edit').html(data.html);
                    }
                }
            });
        })
        $(".hapusdata").on('click', function(event) {
            idpegawai = $(this).attr('idpegawai')
            Swal.fire({
                title: "Data pegawai akan dihapus !",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Simpan",
                denyButtonText: `Batal`
            }).then((result) => {
                if (result.isConfirmed) {
                    hapuspegawai(idpegawai)
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        })

        function hapuspegawai(id) {
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    id
                },
                url: '<?= route('hapuspegawai') ?>',
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
    </script>
@endsection
