@extends('Template.Main')
@section('container')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Master Barang</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Master Barang</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#modaltambahbarang"><i class="bi bi-plus" style="margin-right:8px"></i> Master
                Barang</button>
            <div class="card mt-3">
                <div class="card-header"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Tabel Data Master Barang</div>
                <div class="card-body">
                    <table id="tabelnamagenerik" class="table table-sm table-bordered table-hover">
                        <thead>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Nama Generik</th>
                            <th>Nama Pabrik</th>
                            <th>Jenis Barang</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Isi konversi</th>
                            <th>Stok Sekarang</th>
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
                                    <td>{{ $d->stok_global }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning editmasterbarang"
                                            idbarang="{{ $d->id }}" data-bs-toggle="modal"
                                            data-bs-target="#modaleditbarang"><i class="bi bi-pencil-square"></i></button>
                                        <button class="btn btn-sm btn-danger hapusbarang"
                                            namabarang="{{ $d->nama_barang }}" idbarang="{{ $d->id }}"><i
                                                class="bi bi-trash3"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modaltambahbarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahBarang" action="{{ url('barang/store') }}" method="POST">
                    @csrf
                    <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="nama_barang" class="form-label small fw-bold text-secondary">Nama Komersial /
                                    Barang</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                    placeholder="Contoh: Amoxicillin 500mg" required>
                            </div>

                            <div class="col-md-6">
                                <label for="nama_generik" class="form-label small fw-bold text-secondary">Nama Generik
                                    (Kandungan)</label>
                                <input type="text" class="form-control" id="nama_generik" name="nama_generik"
                                    placeholder="Contoh: Amoxicillin Trihydrate">
                            </div>

                            <div class="col-md-6">
                                <label for="nama_pabrik" class="form-label small fw-bold text-secondary">Nama Pabrik /
                                    Produsen</label>
                                <input type="text" class="form-control" id="nama_pabrik" name="nama_pabrik"
                                    placeholder="Contoh: Kimia Farma / Sanbe">
                            </div>

                            <hr class="my-2 text-muted">

                            <div class="col-md-6">
                                <label for="jenis_barang" class="form-label small fw-bold text-secondary">Jenis
                                    Barang</label>
                                <select class="form-select" id="jenis_barang" name="jenis_barang" required>
                                    <option value="Obat" selected>Obat</option>
                                    <option value="Alkes">Alat Kesehatan (Alkes)</option>
                                    <option value="BHP">Bahan Habis Pakai (BHP)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="kategori_obat" class="form-label small fw-bold text-secondary">Kategori Regulasi
                                    Obat</label>
                                <select class="form-select" id="kategori_obat" name="kategori_obat" required>
                                    <option value="Bebas">Obat Bebas (Hijau)</option>
                                    <option value="Bebas Terbatas">Obat Bebas Terbatas (Biru)</option>
                                    <option value="Keras">Obat Keras (Merah / K)</option>
                                    <option value="Psikotropika">Psikotropika</option>
                                    <option value="Narkotika">Narkotika</option>
                                    <option value="Non-Obat">Non-Obat / Alkes</option>
                                </select>
                            </div>

                            <hr class="my-2 text-muted">

                            <div class="col-md-4">
                                <label for="satuan_besar" class="form-label small fw-bold text-secondary">Satuan Besar
                                    (Pembelian)</label>
                                <input type="text" class="form-control" id="satuan_besar" name="satuan_besar"
                                    placeholder="Contoh: Box / Karton" required>
                            </div>

                            <div class="col-md-4">
                                <label for="satuan_sedang" class="form-label small fw-bold text-secondary">Satuan Sedang
                                    (Opsional)</label>
                                <input type="text" class="form-control" id="satuan_sedang" name="satuan_sedang"
                                    placeholder="Contoh: Strip / Botol">
                            </div>

                            <div class="col-md-4">
                                <label for="satuan_kecil" class="form-label small fw-bold text-secondary">Satuan Kecil
                                    (Eceran/Resep)</label>
                                <input type="text" class="form-control" id="satuan_kecil" name="satuan_kecil"
                                    placeholder="Contoh: Tablet / Pcs" required>
                            </div>

                            <div class="col-6">
                                <label for="isi_konversi" class="form-label small fw-bold text-secondary">Bentuk Sediaan
                                    Satuan</label>
                                <input type="text" class="form-control" id="bentuk_sediaan" name="bentuk_sediaan"
                                    placeholder="Contoh: inject atau tablet" required>
                            </div>
                            <div class="col-6">
                                <label for="isi_konversi" class="form-label small fw-bold text-secondary">Isi Konversi
                                    Satuan</label>
                                <input type="text" class="form-control" id="isi_konversi" name="isi_konversi"
                                    placeholder="Contoh: 1 box berisi 100 tablet, maka isi dengan angka 100" required>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" id="btnSimpanBarang" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Barang
                        </button>
                    </div>>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modaleditbarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Master Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                    <div class="v_edit">

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btnSimpanEditBarang" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Edit Barang
                    </button>
                </div>>
            </div>
        </div>
    </div>
    <style>
        .ui-autocomplete {
            z-index: 215000000 !important;
            /* Pastikan lebih tinggi dari z-index Modal */
        }
    </style>
    <script>
        $(document).ready(function() {
            // Ketika tombol simpan di dalam modal diklik
            $('#btnSimpanBarang').on('click', function(e) {
                e.preventDefault();

                // 1. Bersihkan error validasi yang lama (jika ada)
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                // 2. Ambil semua data input dari form
                let formData = $('#formTambahBarang').serialize();

                // 3. Ambil elemen tombol untuk efek loading
                let btn = $(this);
                btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...'
                );

                // 4. Jalankan AJAX Post ke Laravel
                $.ajax({
                    url: "{{ url('barang/store') }}", // Arahkan ke route store controller Anda
                    type: "POST",
                    data: formData,
                    dataType: "JSON",
                    success: function(response) {
                        // Kembalikan status tombol
                        btn.prop('disabled', false).html(
                            '<i class="bi bi-save me-1"></i> Simpan Barang');

                        if (response.status) {
                            // Tampilkan notifikasi sukses pakai SweetAlert2
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // Tutup modal dan reset isi form
                            $('#modaltambahbarang').modal('hide');
                            $('#formTambahBarang')[0].reset();

                            // RELOAD DATATABLES (Jika Anda menggunakan Server-Side DataTables)
                            // $('#tabelnamagenerik').DataTable().ajax.reload(null, false);

                            // Jika Anda menggunakan table HTML biasa tanpa datatables, 
                            // Anda bisa memicu reload halaman otomatis khusus saat BERHASIL saja:
                            setTimeout(function() {
                                location.reload();
                            }, 1200);
                        }
                    },
                    error: function(xhr) {
                        // Kembalikan status tombol jika gagal
                        btn.prop('disabled', false).html(
                            '<i class="bi bi-save me-1"></i> Simpan Barang');

                        // Jika error 422 (Gagal Validasi dari $request->validate di Laravel)
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            // Loop semua pesan error yang dikirim oleh Controller
                            $.each(errors, function(key, value) {
                                // Cari element input berdasarkan atribut 'name'
                                let inputElement = $('[name="' + key + '"]');

                                // Tambahkan kelas border merah khas Bootstrap (.is-invalid)
                                inputElement.addClass('is-invalid');

                                // Selipkan teks pesan error tepat di bawah inputnya
                                inputElement.after('<div class="invalid-feedback">' +
                                    value[0] + '</div>');
                            });

                            // Beri notifikasi peringatan atas bahwa form belum valid
                            Swal.fire({
                                icon: 'warning',
                                title: 'Validasi Gagal',
                                text: 'Silakan periksa kembali isian form yang berwarna merah.',
                                confirmButtonColor: '#3085d6'
                            });

                        } else {
                            // Jika error sistem lainnya (Error 500 dll)
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan pada server. Coba beberapa saat lagi.'
                            });
                        }
                    }
                });
            });
            $('#btnSimpanEditBarang').on('click', function(e) {
                var data = $('.formeditmasterbarang').serializeArray();
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
                    url: '<?= route('simpaneditmasterbarang') ?>',
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
        });
        $(".hapusbarang").on('click', function(event) {
            idbarang = $(this).attr('idbarang')
            namabarang = $(this).attr('namabarang')
            Swal.fire({
                title: "Data " + namabarang + " akan dihapus, anda yakin ?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Ya Hapus",
                denyButtonText: `Batal`
            }).then((result) => {
                if (result.isConfirmed) {
                    hapusbarang(idbarang)
                }
            });
        })
        $(".editmasterbarang").on('click', function(event) {
            idbarang = $(this).attr('idbarang')
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    idbarang
                },
                url: '<?= route('ambilformeditbarang') ?>',
                success: function(response) {
                    $('.v_edit').html(response);
                }
            });
        })

        function hapusbarang(idbarang) {
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    idbarang
                },
                url: '<?= route('hapusmasterbarang') ?>',
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
        }
    </script>
@endsection
