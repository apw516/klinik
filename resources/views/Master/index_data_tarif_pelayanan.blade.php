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
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i
                    class="bi bi-plus" style="margin-right:8px"></i>
                Master Tarif Pelayanan</button>
            <div class="card mt-3">
                <div class="card-header"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Tabel Data Tarif Pelayanan
                </div>
                <div class="card-body">
                    <table id="tabelprovinsi" class="table table-sm table-bordered">
                        <thead>
                            <th>ID</th>
                            <th>Nama Tarif</th>
                            <th>Jenis Tarif</th>
                            <th>Tarif 1</th>
                            <th>Tarif 2</th>
                            <th>Tarif 3</th>
                            <th>Status</th>
                            <th>Tanggal Entry</th>
                            <th>Klinik</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->nama_tarif }}</td>
                                    <td>{{ $d->jenis_tarif }}</td>
                                    <td> Rp. {{ number_format($d->tarif_1, 0, ',', '.') }}</td>
                                    <td> Rp. {{ number_format($d->tarif_2, 0, ',', '.') }}</td>
                                    <td> Rp. {{ number_format($d->tarif_3, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($d->status == 1)
                                            Aktif
                                        @else
                                            Tidak Aktif
                                        @endif
                                    </td>
                                    <td>{{ $d->tgl_entry }}</td>
                                    <td>{{ $d->nama_klinik }}</td>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="formtambahtarif">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Tarif</label>
                            <input type="text" class="form-control" id="nama_tarif" name="nama_tarif"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tarif</label>
                            <label hidden for="exampleInputEmail1" class="form-label label_asli"
                                id="label_asli">Tarif</label>
                            <input type="text" class="form-control inputmask" id="tarif" name="tarif"
                                aria-describedby="emailHelp">
                            <input hidden type="text" class="form-control inputmaskasli" id="tarifasli" name="tarifasli"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Jenis Tarif</label>
                            <select class="form-select" aria-label="Default select example" id="jenis_tarif"
                                name="jenis_tarif">
                                <option selected value="0">Silahkan Pilih</option>
                                <option value="RAWAT JALAN">Rawat Jalan</option>
                                <option value="RAWAT INAP">Rawat Inap</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpanmasterpelayanan()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function simpanmasterpelayanan() {
            Swal.fire({
                title: "Data tarif akan disimpan ?",
                text: "",
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
        function save() {
            let namatarif = $('#nama_tarif').val();
            let tarif = $('#tarifasli').val();
            let jenis_tarif = $('#jenis_tarif').val();
            let spinner = $('#loader');
            spinner.show();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    namatarif: namatarif,
                    tarif: tarif,
                    jenis_tarif: jenis_tarif
                },
                url: '{{ route('simpantarifbaru') }}',
                error: function() {
                    spinner.hide();
                    $('#tombolbayar').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'System Error',
                        text: 'Gagal mengeksekusi data transaksi.'
                    });
                },
                success: function(response) {
                    spinner.hide();
                    if (response.kode == '500') {
                        $('#tombolbayar').prop('disabled', false);
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            text: response.message,
                        });
                    } else {
                        Swal.fire({
                            icon: "success",
                            title: "Pembayaran Sukses!",
                            text: "Data tersimpan. Silakan cetak bukti transaksi.",
                            showConfirmButton: true,
                            confirmButtonColor: "#198754"
                        });
                        location.reload()
                    }
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
            })
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
