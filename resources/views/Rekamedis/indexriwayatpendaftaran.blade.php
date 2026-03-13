@extends('Template.Main')
@section('container')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Riwayat Pendaftaran</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Riwayat Pendaftaran</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="v_1">
                <div class="card">
                    <div class="card-header"><i class="bi bi-search" style="margin-right:8px"></i>Tentukan Range Tanggal
                    </div>
                    <div class="card-body">
                        <form action="" class="formpencarianpasien">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Tanggal Awal</label>
                                        <input type="date" name="tanggalawal" id="tanggalawal"
                                            value="{{ $datenow }}" placeholder="Masukan Nomor Rekamedis ..."
                                            class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Tanggal Akhir</label>
                                        <input type="date" name="tanggalakhir" id="tanggalakhir"
                                            value="{{ $datenow }}" placeholder="Masukan Nomor Rekamedis ..."
                                            class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success" style="margin-top:32px"
                                        onclick="tampilkandatapasien()"><i class="bi bi-search"
                                            style="margin-right:8px"></i>Tampilkan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header"><i class="bi bi-database-fill-check " style="margin-right: 8px"></i> Tabel Riwayat Pendaftaran </div>
                    <div class="card-body">
                        <div class="v_data_log">

                        </div>
                    </div>
                </div>
            </div>
            <div hidden class="v_2">
                <button class="btn btn-danger" onclick="kembali()"><i class="bi bi-back"></i> Kembali</button>
                <div class="v_kasirfarmasi"></div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            tampilkandatapasien()
        })

        function tampilkandatapasien() {
            tanggalawal = $('#tanggalawal').val()
            tanggalakhir = $('#tanggalakhir').val()
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    tanggalawal,
                    tanggalakhir

                },
                url: '<?= route('ambilriwayatpendaftaran') ?>',
                success: function(response) {
                    spinner.hide();
                    $('.v_data_log').html(response);
                }
            });
        }
        function kembali()
        {
            $('.v_1').removeAttr('hidden',true)
            $('.v_2').attr('hidden',true)
        }
        
    </script>
@endsection
