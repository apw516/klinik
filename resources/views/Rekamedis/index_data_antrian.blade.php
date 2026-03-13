@extends('Template.Main')
@section('container')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data antrian</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data antrian</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="v_1">
                <div class="card">
                    <div class="card-header"><i class="bi bi-search" style="margin-right:8px"></i>Tentukan Tanggal Antrian
                    </div>
                    <div class="card-body">
                        <form action="" class="formpencarianpasien">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Tanggal Antrian</label>
                                        <input type="date" name="tanggal" id="tanggal" value="{{ $datenow }}" placeholder="Masukan Nomor Rekamedis ..."
                                            class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success" style="margin-top:32px"
                                        onclick="tampilkanantrian()"><i class="bi bi-search" style="margin-right:8px"></i>Tampilkan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header"><i class="bi bi-database-fill-check " style="margin-right: 8px"></i> Tabel antrian pasien</div>
                    <div class="card-body">
                        <div class="v_tabel_antrian">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            tampilkanantrian()
        })
        function tampilkanantrian() {
            tgl = $('#tanggal').val()
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    tgl,

                },
                url: '<?= route('ambildataantrian') ?>',
                success: function(response) {
                    spinner.hide();
                    $('.v_tabel_antrian').html(response);
                }
            });
        }
    </script>
@endsection
