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
                                        <th class="text-end">Jumlah Transaksi</th>
                                        <th class="text-end">Jenis transaksi</th>
                                        <th class="text-end">Stok Akhir</th>
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
                pageLength: 8, // Default menampilkan 8 baris
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
                        data: 'tanggal_log',
                        name: 'tanggal_log',
                        class: 'text-center'
                    },
                    {
                        data: 'stok_awal',
                        name: 'stok_awal',
                        class: 'text-end'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah',
                        class: 'text-end'
                    },
                    {
                        data: 'jenis_transaksi',
                        name: 'jenis_transaksi',
                        class: 'text-end'
                    },
                    {
                        data: 'stok_akhir',
                        name: 'stok_akhir',
                        class: 'text-end'
                    }

                ],
                // Fungsi createdRow untuk mewarnai baris berdasarkan kondisi data
                createdRow: function(row, data, dataIndex) {
                    // Ambil data jenis_transaksi, ubah ke lowercase untuk perbandingan yang aman
                    // Sesuaikan 'masuk' dan 'keluar' dengan nilai yang dikirimkan oleh backend Anda
                    var jenis = data.jenis_transaksi.toLowerCase();

                    // Gunakan kelas Bootstrap untuk pewarnaan
                    if (jenis === 'keluar') {
                        $(row).addClass('table-warning'); // Merah untuk transaksi keluar
                    } else if (jenis === 'masuk') {
                        $(row).addClass('table-success'); // Hijau untuk transaksi masuk
                    }
                },
                "language": {
                    "sEmptyTable": "Tidak ada data yang tersedia pada tabel ini",
                    "sProcessing": "Sedang memproses...",
                    "sLengthMenu": "Tampilkan _MENU_ data per halaman",
                    "sZeroRecords": "Data sesi tidak ditemukan",
                    "sInfo": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "sInfoEmpty": "Tidak ada data tersedia",
                    "sInfoFiltered": "(difilter dari _MAX_ total data)",
                    "sInfoPostFix": "",
                    "sSearch": "Cari Sesi Kasir:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "Pertama",
                        "sPrevious": "Sebelumnya",
                        "sNext": "Berikutnya",
                        "sLast": "Terakhir"
                    }
                },
            });
        });
    </script>
@endsection
