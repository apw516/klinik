@extends('Template.Main')
@section('container')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data ICD 10</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data ICD 10</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
             <button type="button" class="btn btn-outline-primary"> <i class="bi bi-plus" style="margin-right:8px"></i> Master ICD 10</button>
            <div class="card mt-3">
                <div class="card-header"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Tabel Data ICD 10</div>
                <div class="card-body">
                    <table id="tabelunit" class="table table-sm table-bordered table-hover">
                        <thead>
                            <th>DIAG</th>
                            <th>Nama Panjang</th>
                            <th>dtd</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ $d->diag }}</td>
                                    <td>{{ $d->nama }}</td>
                                    <td>{{ $d->dtd}}</td>
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
        $("#tabelunit").DataTable({
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
