@extends('Template.Main')
@section('container')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Tarif Pelayanan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Tarif Pelayanan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <button type="button" class="btn btn-outline-primary" onclick="tambahTarif()"> 
                <i class="bi bi-plus" style="margin-right:8px"></i> Master Tarif Pelayanan
            </button>
            <div class="card mt-3">
                <div class="card-header"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Tabel Data Tarif Pelayanan</div>
                <div class="card-body">
                    <table id="tabelprovinsi" class="table table-sm table-bordered">
                        <thead>
                            <th>ID</th>
                            <th>Nama Tarif</th>
                            <th>Harga</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->nama_tarif }}</td>
                                    <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" onclick="editTarif({{ $d->id }}, '{{ $d->nama_tarif }}', '{{ $d->harga }}')">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="hapusTarif({{ $d->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form (Bisa untuk Tambah & Edit) -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tarif Pelayanan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="formtambahtarif" id="formTarif">
                        <!-- Input ID untuk penanda Mode Edit -->
                        <input type="hidden" id="id_tarif" name="id_tarif">
                        
                        <div class="mb-3">
                            <label for="nama_tarif" class="form-label">Nama Tarif</label>
                            <input type="text" class="form-control" id="nama_tarif" name="nama_tarif">
                        </div>
                        <div class="mb-3">
                            <label for="tarif" class="form-label">Tarif</label>
                            <label hidden class="form-label label_asli" id="label_asli">Tarif</label>
                            <input type="text" class="form-control inputmask" id="tarif" name="tarif">
                            <input hidden type="text" class="form-control inputmaskasli" id="tarifasli" name="tarifasli">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="simpanmasterpelayanan()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Reset form untuk mode Tambah Data
        function tambahTarif() {
            $('#id_tarif').val('');
            $('#formTarif')[0].reset();
            $('#tarifasli').val('');
            $('#exampleModalLabel').text('Tambah Data Tarif');
            $('#exampleModal').modal('show');
        }

        // Tampilkan modal dan isi field untuk mode Edit Data
        function editTarif(id, nama, harga) {
            $('#id_tarif').val(id);
            $('#nama_tarif').val(nama);
            $('#tarifasli').val(harga);
            $('#tarif').val(formatRupiah(harga.toString()));
            $('#exampleModalLabel').text('Edit Data Tarif');
            $('#exampleModal').modal('show');
        }

        // Konfirmasi Simpan (Tambah / Edit)
        function simpanmasterpelayanan() {
            let id = $('#id_tarif').val();
            let pesan = id ? "Data tarif akan diperbarui?" : "Data tarif akan disimpan?";

            Swal.fire({
                title: pesan,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#0d6efd",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Simpan!"
            }).then((result) => {
                if (result.isConfirmed) {
                    save();
                }
            });
        }

        // Fungsi Simpan (AJAX)
        function save() {
            let id = $('#id_tarif').val();
            let namatarif = $('#nama_tarif').val();
            let tarif = $('#tarifasli').val();
            let spinner = $('#loader');
            
            // Tentukan URL berdasarkan mode (Tambah atau Update)
            let targetUrl = id ? '{{ route("updatetarif") }}' : '{{ route("simpantarifbaru") }}';

            spinner.show();
            $.ajax({
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    namatarif: namatarif,
                    tarif: tarif,
                },
                url: targetUrl,
                error: function() {
                    spinner.hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'System Error',
                        text: 'Gagal mengeksekusi data.'
                    });
                },
                success: function(response) {
                    spinner.hide();
                    if (response.kode == '500') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            text: response.message,
                        });
                    } else {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: response.message || "Data berhasil disimpan.",
                            showConfirmButton: true,
                            confirmButtonColor: "#198754"
                        }).then(() => {
                            location.reload();
                        });
                    }
                }
            });
        }

        // Fungsi Hapus Data
        function hapusTarif(id) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data tarif yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                if (result.isConfirmed) {
                    let spinner = $('#loader');
                    spinner.show();
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        url: '{{ route("hapustarif") }}',
                        error: function() {
                            spinner.hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'System Error',
                                text: 'Gagal menghapus data.'
                            });
                        },
                        success: function(response) {
                            spinner.hide();
                            if (response.kode == '500') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message,
                                });
                            } else {
                                Swal.fire({
                                    icon: "success",
                                    title: "Terhapus!",
                                    text: "Data tarif berhasil dihapus.",
                                    confirmButtonColor: "#198754"
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            });
        }

        $(function() {
            $("#tabelprovinsi").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "pageLength": 12,
                "searching": true,
                "ordering": false,
            });
        });

        // Masking input Rupiah
        const inputMask = document.getElementById('tarif');
        const inputAsli = document.getElementById('tarifasli');
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
    </script>
@endsection