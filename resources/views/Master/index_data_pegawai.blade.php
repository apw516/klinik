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
            <button type="button" class="btn btn-outline-primary"> <i class="bi bi-plus" style="margin-right:8px"></i>
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
