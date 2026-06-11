@extends('Template.Main')
@section('container')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data User</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <button hidden type="button" class="btn btn-outline-primary"> <i class="bi bi-plus" style="margin-right:8px"></i>
                Master User</button>
            <div class="card mt-3">
                <div class="card-header"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Tabel Data User</div>
                <div class="card-body">
                    <table id="tableuser" class="table table-sm table-bordered">
                        <thead>
                            <th>ID</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Hak Akses</th>
                            <th>Nama Klinik</th>
                            <th>Tanggal Entry</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->nama }}</td>
                                    <td>{{ $d->username }}</td>
                                    <td>{{ $d->nama_hak }}</td>
                                    <td>{{ $d->nama_klinik }}</td>
                                    <td>{{ $d->tanggal_entry }}</td>
                                    <td>
                                        @if ($d->is_activated == 1)
                                            Aktif
                                        @else
                                            Tidak Aktif
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-danger hapususer" iduser="{{ $d->id }}"><i
                                                class="bi bi-trash3"></i></button>
                                        <button class="btn btn-warning edituser" iduser="{{ $d->id }}"
                                            data-bs-toggle="modal" data-bs-target="#modaledituser"><i
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
    <div class="modal fade" id="modaledituser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Silahkan Edit User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="v_edit_user">

                    </div>
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
            $("#tableuser").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "pageLength": 12,
                "searching": true,
                "ordering": false,
            })
        });
        $(".hapususer").on('click', function(event) {
            iduser = $(this).attr('iduser')
            Swal.fire({
                title: "Anda yakin ?",
                text: "Data user akan dihapus ...",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus !"
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
                            iduser
                        },
                        url: '<?= route('hapususer') ?>',
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
        $(".edituser").on('click', function(event) {
            iduser = $(this).attr('iduser')
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    iduser
                },
                url: '<?= route('ambildatauser') ?>',
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
                        $('.v_edit_user').html(data.html);
                    }
                }
            });
        })

        function simpanalert2() {
            Swal.fire({
                title: "Anda yakin ?",
                text: "Data user akan diedit ...",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, simpan !"
            }).then((result) => {
                if (result.isConfirmed) {
                    spinner = $('#loader')
                    spinner.show();
                    simpandata()
                }
            });
        }

        function simpandata() {
            var data = $('.formedituser').serializeArray();
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
                url: '<?= route('simpanedituser') ?>',
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
                        const myForm = document.getElementById('formedituser');
                        myForm.reset();
                    }
                }
            });
        }
    </script>
@endsection
