@extends('Template.Main')
@section('container')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Nama Generik</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Nama Generik</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <button type="button" class="btn btn-outline-primary" class="btn btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#modalobatgenerik"> <i class="bi bi-plus" style="margin-right:8px"></i> Master Nama
                Generik</button>
            <button hidden type="button" class="btn btn-outline-primary"> <i class="bi bi-plus" style="margin-right:8px"></i>
                Master Sediaan</button>
            <button hidden type="button" class="btn btn-outline-primary"> <i class="bi bi-plus" style="margin-right:8px"></i>
                Master Satuan Dosis</button>
            <button hidden type="button" class="btn btn-outline-primary"> <i class="bi bi-plus" style="margin-right:8px"></i>
                Master master Kategori Obat</button>
            <div class="card mt-3">
                <div class="card-header"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Tabel Data Obat Generik</div>
                <div class="card-body">
                    <table id="tabelnamagenerik" class="table table-sm table-bordered table-hover">
                        <thead>
                            <th>ID</th>
                            <th>Kode Obat</th>
                            <th>Nama Generik</th>
                            <th>Nama Lengkap</th>
                            <th>Sediaan</th>
                            <th>Dosis</th>
                            <th>Kategori Obat</th>
                            <th>ogb</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->kode_obat }}</td>
                                    <td>{{ $d->nama_zat_aktif }}</td>
                                    <td>{{ $d->nama_generik_lengkap }}</td>
                                    <td>{{ $d->nama_sediaan }}</td>
                                    <td>{{ $d->dosis }} {{ $d->nama_satuan_dosis }}</td>
                                    <td>{{ $d->nama_kategori }}</td>
                                    <td>
                                        @if ($d->is_ogb == 0)
                                            Tidak
                                        @else
                                            Ya
                                        @endif
                                    </td>
                                    <td><button class="btn btn-warning"><i class="bi bi-pencil-square"></i></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalobatgenerik" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Nama Generik</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="formgenerik" id="formgenerik">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nama Generik</label>
                            <input type="email" class="form-control" id="namagenerik" name="namagenerik"
                                placeholder="Masukan nama generik contoh ( Paracetamol )...">
                        </div>
                        <div hidden class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nama Zat Aktif</label>
                            <input hidden type="email" class="form-control" id="namazataktif" name="namazataktif"
                                placeholder="Masukan nama zat aktif contoh ( Paracetamol )...">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Dosis</label>
                            <input type="email" class="form-control" id="dosis" name="dosis"
                                placeholder="Masukan dosis contoh ( 500 )...">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Satuan Dosis</label>
                            <select class="form-select" aria-label="Default select example" name="satuandosis"
                                id="satuandosis">
                                <option selected>Silahkan Pilih</option>
                                @foreach ($dosis as $r)
                                    <option value="{{ $r->id }}">{{ $r->nama_satuan_dosis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Sediaan</label>
                            <select class="form-select" aria-label="Default select example" name="sediaan"
                                id="sediaan">
                                <option selected>Silahkan Pilih</option>
                                @foreach ($sediaan as $r)
                                    <option value="{{ $r->id }}">{{ $r->nama_sediaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Kategori Obat</label>
                            <select class="form-select" aria-label="Default select example" name="kategoriobat"
                                id="kategoriobat">
                                <option selected>Silahkan Pilih</option>
                                @foreach ($kategori as $r)
                                    <option value="{{ $r->id }}">{{ $r->nama_kategori }} ( {{ $r->keterangan }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nama Generik Lengkap</label>
                            <input type="email" class="form-control" id="namageneriklengkap" name="namageneriklengkap"
                                placeholder="Masukan nama generik lengkap contoh : Paracetamol 500 MG">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="simpanmastergenerik()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
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

        function simpanmastergenerik() {
            Swal.fire({
                title: "Data nama generik akan disimpan !",
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

        function simpan() {
            var data = $('.formgenerik').serializeArray();
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
                url: '<?= route('simpanmastergenerik') ?>',
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
                        const myForm = document.getElementById('formgenerik');
                        myForm.reset();
                    }
                }
            });
        }
    </script>
@endsection
