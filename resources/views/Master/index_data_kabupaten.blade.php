@extends('Template.Main')
@section('container')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Kabupaten / Kota</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Kabupaten / Kota</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <button type="button" class="btn btn-outline-primary"> <i class="bi bi-plus" style="margin-right:8px"></i>
                Master Kabupaten</button>
            <div class="card mt-3">
                <div class="card-header"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Tabel Data Kabupaten / Kota
                </div>
                <div class="card-body">
                    <table id="tabelprovinsi" class="table table-sm table-bordered">
                        <thead>
                            <th>ID</th>
                            <th>Nama Kabupaten / Kota</th>
                            <th>Code</th>
                            <th>Parent Code</th>
                            <th>Bps Code</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->name }}</td>
                                    <td>{{ $d->code }}</td>
                                    <td>{{ $d->parent_code }}</td>
                                    <td>{{ $d->bps_code }}</td>
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
