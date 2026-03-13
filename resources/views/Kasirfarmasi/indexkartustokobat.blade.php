@extends('Template.Main')
@section('container')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Kartu Stok</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kartu Stok</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="v_1">
                <div class="card mt-4">
                    <div class="card-header"><i class="bi bi-database-fill-check " style="margin-right: 8px"></i> Tabel
                        Kartu Stok</div>
                    <div class="card-body">
                        <div class="v_data_pasien">
                            <table id="tabelStok" class="table table-striped table-bordered w-100 table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>No. Batch </th>
                                        <th>keterangan </th>
                                        <th>Tgl Update</th>
                                        <th class="text-end">Stok Awal</th>
                                        <th class="text-end">Mutasi (In/Out)</th>
                                        <th class="text-end bg-primary text-dark">Stok Sekarang</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
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
    <style>
        /* Memberi jarak antara tabel dan pagination */
        .dataTables_paginate {
            margin-top: 20px !important;
            padding-top: 10px;
        }

        /* Jika ingin memberi jarak pada informasi "Showing x to x of x entries" */
        .dataTables_info {
            margin-top: 20px !important;
        }

        /* Jika menggunakan Bootstrap, ini akan mempercantik tampilan tombolnya */
        .pagination {
            gap: 5px;
            /* Memberi jarak antar angka halaman */
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#tabelStok').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kartu-stok.data') }}", // Sesuaikan route Anda
                pageLength: 8, // Default menampilkan 25 baris
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: 'text-center'
                    },
                    {
                        data: 'kode_barang',
                        name: 'kode_barang'
                    },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang'
                    },
                    {
                        data: 'no_batch',
                        name: 'no_batch',
                        class: 'text-center'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan',
                        class: 'text-center'
                    },
                    {
                        data: 'tgl_transaksi',
                        name: 'tgl_transaksi',
                        class: 'text-center'
                    },
                    {
                        data: 'stok_terakhir',
                        name: 'stok_terakhir',
                        class: 'text-end'
                    },
                    {
                        render: function(data, type, row) {
                            return `<small class="text-success">+${row.stok_masuk}</small> / 
                            <small class="text-danger">-${row.stok_keluar}</small>`;
                        },
                        class: 'text-center'
                    },
                    {
                        data: 'stok_sekarang',
                        name: 'stok_sekarang',
                        class: 'text-end fw-bold text-primary'
                    }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
                }
            });
        });
    </script>
@endsection
