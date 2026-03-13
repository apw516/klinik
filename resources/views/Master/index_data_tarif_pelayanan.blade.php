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
            <button type="button" class="btn btn-outline-primary"> <i class="bi bi-plus" style="margin-right:8px"></i>
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
    </script>
@endsection
