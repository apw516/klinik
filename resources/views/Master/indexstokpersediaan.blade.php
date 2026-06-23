@extends('Template.Main')
@section('container')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Stok Persediaan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Stok Persediaan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="v_1">
                <button type="button" class="btn btn-outline-primary tambahstok"> <i class="bi bi-plus"
                        style="margin-right:8px"></i>
                    Tambah Stok Persediaan</button>
                <div class="card mt-3">
                    <div class="card-header"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Tabel Data Stok Persediaan
                    </div>
                    <div class="card-body">
                        <table id="tbstokpersediaan" class="table table-sm table-bordered table-hover w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th>Tanggal Stok Masuk</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Nama Generik</th>
                                    <th>Nama Pabrik</th>
                                    <th>Nomor Batch</th>
                                    <th>ED</th>
                                    <th>Stok Awal</th>
                                    <th>Stok Sekarang</th>
                                    <th class="text-center" style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div hidden class="v_2">
                <button type="button" class="btn btn-outline-danger kembali"> <i class="bi bi-backspace-fill"
                        style="margin-right:8px"></i>
                    Kembali</button>
                <div class="card mt-1">
                    <div class="card-header">Silahkan Pilih Barang</div>
                    <div class="card-body">
                        <table id="tabelmasterbarang" class="table table-sm table-bordered table-hover">
                            <thead>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Nama Generik</th>
                                <th>Nama Pabrik</th>
                                <th>Jenis Barang</th>
                                <th>Kategori</th>
                                <th>Satuan</th>
                                <th>Isi konversi</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $d->kode_barang }}</td>
                                        <td>{{ $d->nama_barang }}</td>
                                        <td>{{ $d->nama_generik }}</td>
                                        <td>{{ $d->nama_pabrik }}</td>
                                        <td>{{ $d->jenis_barang }}</td>
                                        <td>{{ $d->kategori_obat }}</td>
                                        <td>{{ $d->satuan_besar }} , {{ $d->satuan_sedang }} , {{ $d->satuan_kecil }}</td>
                                        <td>{{ $d->isi_konversi }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-success pilihbarang"
                                                idbarang="{{ $d->kode_barang }}"><i
                                                    class="bi bi-arrow-down-square-fill"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header"><i class="bi bi-cart-check-fill"></i> List Barang yang sudah dipilih</div>
                    <div class="card-body">
                        <form id="formSimpanStokPersediaan" method="POST" action="{{ url('stok-obat/bulk-store') }}">
                            @csrf
                            <div class="table-responsive">
                                <table id="tabelSelectedBarang" class="table table-sm table-bordered align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th style="width: 10%">Kode</th>
                                            <th style="width: 25%">Nama Barang</th>
                                            <th style="width: 25%">Harga Modal + ppn ( dalam satuan terkecil )</th>
                                            <th style="width: 15%">No. Batch</th>
                                            <th style="width: 15%">Expired Date (ED)</th>
                                            <th style="width: 12%">Stok Awal Masuk</th>
                                            <th style="width: 5%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listBarangTerpilih">
                                        <tr id="emptyRow">
                                            <td colspan="6" class="text-center text-muted py-3">Belum ada barang yang
                                                dipilih. Klik tombol hijau di atas.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-end mt-3 d-none" id="divAksiSimpan">
                                <button type="button" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Semua
                                    Persediaan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalReturSediaan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalReturSediaanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="modalReturSediaanLabel"><i class="bi bi-arrow-counterclockwise"></i> Form
                        Retur Persediaan Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formSubmitRetur">
                    @csrf
                    <div class="modal-body">
                        <input type="" id="retur_id_persediaan" name="id_persediaan">
                        <input type="hidden" id="retur_kode_barang" name="kode_barang">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Barang</label>
                            <input type="text" id="retur_nama_barang"
                                class="form-control-plaintext fw-semibold text-secondary pt-0" readonly>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold">No. Batch</label>
                                <input type="text" id="retur_no_batch"
                                    class="form-control-plaintext text-secondary pt-0" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold">Stok yang Tersedia</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="retur_stok_maksimal"
                                        class="form-control text-center fw-bold bg-light" readonly
                                        style="max-width: 80px;">
                                    <span class="input-group-text">Sediaan</span>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label for="jumlah_retur" class="form-label fw-bold text-danger">Jumlah yang Diretur <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="jumlah_retur" name="jumlah_retur"
                                min="1" placeholder="Masukkan jumlah barang..." required>
                            <div class="form-text">Jumlah tidak boleh melebihi stok yang tersedia saat ini.</div>
                        </div>

                        <div class="mb-3">
                            <label for="alasan_retur" class="form-label fw-bold">Alasan Retur <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="alasan_retur" name="alasan_retur" rows="3"
                                placeholder="Contoh: Barang rusak, mendekati ED, salah input, dll..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning fw-semibold" id="btnProsesRetur">
                            <i class="bi bi-check-circle-fill"></i> Proses Retur
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#tbstokpersediaan').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('stok-obat/data') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [{
                        data: 'tanggal_masuk',
                        name: 'stok_batch_obat.created_at'
                    },
                    {
                        data: 'kode_barang',
                        name: 'mt_barang.kode_barang'
                    },
                    {
                        data: 'nama_barang',
                        name: 'mt_barang.nama_barang',
                        render: function(data, type, row) {
                            let supplier = row.id_supplier ? row.id_supplier : '-';
                            return `<div>${data}</div>
                    <small class="text-muted d-block" style="font-size: 0.75rem; margin-top: 2px;">
                        <i class="bi bi-truck me-1"></i>Supplier: <span class="fw-semibold">${supplier}</span>
                    </small>`;
                        }
                    },
                    {
                        data: 'nama_generik',
                        name: 'mt_barang.nama_generik'
                    },
                    {
                        data: 'nama_pabrik',
                        name: 'mt_barang.nama_pabrik'
                    },
                    {
                        data: 'no_batch',
                        name: 'stok_batch_obat.no_batch'
                    },
                    {
                        data: 'tanggal_kadaluwarsa',
                        name: 'stok_batch_obat.tanggal_kadaluwarsa'
                    },
                    {
                        data: 'stok_awal',
                        name: 'stok_batch_obat.stok_awal',
                        className: 'text-center'
                    },
                    {
                        data: 'stok_sekarang',
                        name: 'stok_batch_obat.stok_sekarang',
                        className: 'text-center'
                    },
                    {
                        // TAMBAHAN KOLOM BARU: AKSI RETUR
                        data: null,
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            // Tombol retur dikunci (disabled) jika stok_sekarang sudah 0
                            let isDisabled = row.stok_sekarang <= 0 ? 'disabled' : '';

                            return `
                        <button type='button' 
                                class='btn btn-sm btn-warning btn-retur-sediaan' 
                                data-id='${row.id}' 
                                data-kode='${row.kode_barang2}' 
                                data-nama='${row.nama_barang}' 
                                data-batch='${row.no_batch2}' 
                                data-stok='${row.stok_sekarang2}'
                                ${isDisabled}>
                            <i class="bi bi-arrow-counterclockwise"></i></button>
                    `;
                        }
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                }
            });
        });
        // 1. Event Handler ketika tombol "Retur" di dalam DataTables diklik
        $('#tbstokpersediaan').on('click', '.btn-retur-sediaan', function() {
            // Ambil data dari atribut data- di dalam button tombol retur
            let idPersediaan = $(this).data('id');
            let kodeBarang = $(this).data('kode');
            let namaBarang = $(this).data('nama');
            let noBatch = $(this).data('batch');
            let maksStok = $(this).data('stok');
            // Suntikkan data ke dalam field input yang ada di dalam Modal Retur
            $('#retur_id_persediaan').val(idPersediaan);
            $('#retur_kode_barang').val(kodeBarang);
            $('#retur_nama_barang').val(namaBarang);
            $('#retur_no_batch').val(noBatch);
            $('#retur_stok_maksimal').val(maksStok);

            // Set batas maksimal input number sesuai sisa stok sekarang
            $('#jumlah_retur').attr('max', maksStok).val('');
            $('#alasan_retur').val('');

            // Tampilkan Modal Retur
            $('#modalReturSediaan').modal('show');
        });

        // 2. Event Handler saat Form Retur di-Submit via Ajax
        $('#formSubmitRetur').on('submit', function(e) {
            e.preventDefault(); // Mencegah reload halaman

            // Validasi tambahan di sisi client sebelum kirim data
            let jmlRetur = parseInt($('#jumlah_retur').val());
            let maksStok = parseInt($('#retur_stok_maksimal').val());

            if (jmlRetur > maksStok) {
                Swal.fire({
                    icon: 'error',
                    title: 'Jumlah Retur Tidak Valid',
                    text: 'Jumlah yang diretur tidak boleh melebihi sisa stok saat ini!'
                });
                return false;
            }

            let spinner = $('#loader'); // Gunakan element loader Anda
            spinner.show();
            $('#btnProsesRetur').attr('disabled', true); // Kunci tombol biar gak double click

            $.ajax({
                type: 'POST',
                url: "{{ url('stok-obat/proses-retur') }}", // Sesuaikan dengan target route Anda
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    spinner.hide();
                    $('#btnProsesRetur').attr('disabled', false);

                    if (response.kode == 200) {
                        // Tutup modal
                        $('#modalReturSediaan').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message
                        }).then(() => {
                            // Reload DataTables secara halus tanpa refresh halaman penuh
                            $('#tbstokpersediaan').DataTable().ajax.reload(null, false);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Opps...',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    spinner.hide();
                    $('#btnProsesRetur').attr('disabled', false);

                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops....',
                        text: 'Terjadi kesalahan sistem saat memproses retur barang.',
                    });
                }
            });
        });
        $(".tambahstok").on('click', function(event) {
            $('.v_1').attr('hidden', true)
            $('.v_2').removeAttr('hidden', true)
        })
        $(".kembali").on('click', function(event) {
            $('.v_2').attr('hidden', true)
            $('.v_1').removeAttr('hidden', true)
        })
        $(document).ready(function() {
            // Inisialisasi DataTables untuk master barang
            let tableMaster = $("#tabelmasterbarang").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "pageLength": 5,
                "searching": true,
                "ordering": false,
                "dom": "<'row'<'col-md-6'><'col-md-6 mb-2'f>>" + "<'row'<'col-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
            });
            // Event ketika tombol panah hijau (.pilihbarang) diklik
            $('#tabelmasterbarang').on('click', '.pilihbarang', function() {
                let idBarang = $(this).attr('idbarang');

                if ($(`#row_${idBarang}`).length > 0) {
                    alert('Barang ini sudah ada di dalam list pilihan bawah!');
                    return false;
                }
                let row = $(this).closest('tr');
                let kode = row.find('td:eq(0)').text();
                let nama = row.find('td:eq(1)').text();
                $('#emptyRow').remove();
                // PERBAIKAN: Mengubah id menjadi class (harga-modal-mask & harga-modal-asli)
                let htmlRow = `
            <tr id="row_${idBarang}">
                <td>
                    <span class="fw-bold text-secondary">${kode}</span>
                    <input type="hidden" name="barang_id[]" value="${idBarang}">
                </td>
                <td>
                    <span class="small d-block fw-semibold">${nama}</span>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm harga-modal-mask text-end" placeholder="Rp 0" required>
                    <input type="hidden" name="harga_modal[]" class="harga-modal-asli">
                </td>
                <td>
                    <input type="text" name="no_batch[]" class="form-control form-control-sm text-uppercase" placeholder="Batch Pabrik" required>
                </td>
                <td>
                    <input type="date" name="tanggal_kadaluwarsa[]" class="form-control form-control-sm" required>
                </td>
                <td>
                    <input type="number" name="stok_awal[]" min="1" class="form-control form-control-sm text-center" placeholder="0" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger btnHapusBaris" idbarang="${idBarang}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;

                $('#listBarangTerpilih').append(htmlRow);
                ekstensiTombolSimpan();
            });
            // Event untuk menghapus baris tertentu
            $('#listBarangTerpilih').on('click', '.btnHapusBaris', function() {
                let idBarang = $(this).attr('idbarang');
                $(`#row_${idBarang}`).remove();

                if ($('#listBarangTerpilih tr').length === 0) {
                    $('#listBarangTerpilih').append(`
                <tr id="emptyRow">
                    <td colspan="7" class="text-center text-muted py-3">Belum ada barang yang dipilih. Klik tombol hijau di atas.</td>
                </tr>
            `);
                }
                ekstensiTombolSimpan();
            });
            // PERBAIKAN UTAMA: Menggunakan Event Delegation jQuery untuk elemen dinamis
            $('#listBarangTerpilih').on('keyup', '.harga-modal-mask', function() {
                // 1. Ambil angka bersih saja
                let nominal = $(this).val().replace(/[^,\d]/g, '').toString();

                // 2. Cari input hidden 'harga_modal[]' yang berada di baris TR yang sama
                let tr = $(this).closest('tr');
                tr.find('.harga-modal-asli').val(nominal);

                // 3. Set kembali value mask menjadi format ribuan Rupiah
                $(this).val(formatRupiah(nominal));
            });

            function ekstensiTombolSimpan() {
                if ($('#emptyRow').length > 0) {
                    $('#divAksiSimpan').addClass('d-none');
                } else {
                    $('#divAksiSimpan').removeClass('d-none');
                }
            }
            // Fungsi format rupiah pelengkap
            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }
        });
        $('#divAksiSimpan').on('click', function(e) {
            var data = $('#formSimpanStokPersediaan').serializeArray();
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data),
                },
                url: '<?= route('simpanstokpersediaan') ?>',
                error: function(data) {
                    spinner.hide()
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops....',
                        text: 'Sepertinya ada masalah......',
                        footer: ''
                    })
                },
                success: function(data) {
                    spinner.hide()
                    if (data.kode == 500) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oopss...',
                            text: data.message,
                            footer: ''
                        })
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'OK',
                            text: data.message,
                            footer: ''
                        })
                        location.reload()
                    }
                }
            });

        });
    </script>
@endsection
