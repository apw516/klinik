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
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modaltambah"> <i
                    class="bi bi-plus" style="margin-right:8px"></i>
                Master ICD 10</button>
            <div class="card mt-3">
                <div class="card-header"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Tabel Data ICD 10</div>
                <div class="card-body">
                    <table id="tabelunit" class="table table-sm table-bordered table-hover w-100">
                        <thead>
                            <tr>
                                <th style="width: 15%;">DIAG</th>
                                <th>Nama Panjang</th>
                                <th style="width: 15%;">DTD</th>
                                <th style="width: 10%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data diisi oleh DataTables Server-Side -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modaltambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Diagnosa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahDiagnosa" action="{{ route('icd10.store') }}" method="POST"> @csrf
                    <div class="modal-body">
                        <!-- Kode Diagnosa (DIAG) -->
                        <div class="mb-3">
                            <label for="diag" class="form-label font-weight-bold">
                                Kode Diagnosa (DIAG) <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control text-uppercase" id="diag" name="diag"
                                placeholder="Contoh: A00.0" maxlength="10" required>
                            <small class="text-muted">Masukkan kode resmi ICD-10.</small>
                        </div>

                        <!-- Nama Panjang Diagnosa -->
                        <div class="mb-3">
                            <label for="nama" class="form-label font-weight-bold">
                                Nama Diagnosa / Keterangan <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="nama" name="nama" rows="3"
                                placeholder="Masukkan nama lengkap deskripsi penyakit..." required></textarea>
                        </div>

                        <!-- DTD (Daftar Tabulasi Daerah) -->
                        <div class="mb-3">
                            <label for="dtd" class="form-label font-weight-bold">DTD (Daftar Tabulasi Daerah)</label>
                            <input type="text" class="form-control" id="dtd" name="dtd"
                                placeholder="Contoh: 001">
                            <small class="text-muted">Opsional (boleh dikosongkan jika tidak ada).</small>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnSimpanDiagnosa">
                            <i class="bi bi-save me-1"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modaledit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fs-5" id="modalEditLabel">
                        <i class="bi bi-pencil-square me-1"></i> Edit Diagnosa ICD 10
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditDiagnosa" action="{{ route('icd10.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_diag_old" name="diag_old">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_diag" class="form-label font-weight-bold">Kode Diagnosa (DIAG)</label>
                            <input type="text" class="form-control text-uppercase" id="edit_diag" name="diag"
                                required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label font-weight-bold">Nama Diagnosa</label>
                            <textarea class="form-control" id="edit_nama" name="nama" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_dtd" class="form-label font-weight-bold">DTD</label>
                            <input type="text" class="form-control" id="edit_dtd" name="dtd">
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning" id="btnUpdateDiagnosa">
                            <i class="bi bi-save me-1"></i> Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            var table = $("#tabelunit").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('icd10.data') }}",
                    "type": "GET"
                },
                "columns": [{
                        "data": "diag",
                        "name": "diag"
                    },
                    {
                        "data": "nama",
                        "name": "nama"
                    },
                    {
                        "data": "dtd",
                        "name": "dtd",
                        "defaultContent": "-"
                    },
                    {
                        "data": null,
                        "name": "aksi",
                        "orderable": false,
                        "searchable": false,
                        "className": "text-center",
                        "render": function(data, type, row) {
                            return `
                        <button type="button" class="btn btn-sm btn-warning btn-edit" 
                            data-diag="${row.diag}" 
                            data-nama="${row.nama}" 
                            data-dtd="${row.dtd ?? ''}">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                    `;
                        }
                    }
                ],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                "searching": true,
                "ordering": true,
                "language": {
                    "processing": "Memuat data...",
                    "search": "Cari ICD 10:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "infoFiltered": "(disaring dari _MAX_ total data)",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": ">>",
                        "previous": "<<"
                    }
                }
            });

            // Event Klik Tombol Edit
            $('#tabelunit').on('click', '.btn-edit', function() {
                let diag = $(this).data('diag');
                let nama = $(this).data('nama');
                let dtd = $(this).data('dtd');

                // Isi data ke modal edit
                $('#edit_diag_old').val(diag);
                $('#edit_diag').val(diag);
                $('#edit_nama').val(nama);
                $('#edit_dtd').val(dtd);

                // Tampilkan modal edit
                $('#modaledit').modal('show');
            });

            // Event Submit Form Edit
            $('#formEditDiagnosa').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let actionUrl = form.attr('action');

                $('#btnUpdateDiagnosa').prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

                $.ajax({
                    url: actionUrl,
                    type: "POST",
                    data: form.serialize(),
                    success: function(response) {
                        $('#modaledit').modal('hide');
                        table.ajax.reload(null, false);
                        alert('Diagnosa berhasil diperbarui!');
                    },
                    error: function(xhr) {
                        let res = xhr.responseJSON;
                        alert('Gagal memperbarui data: ' + (res?.message ||
                            'Terjadi kesalahan.'));
                    },
                    complete: function() {
                        $('#btnUpdateDiagnosa').prop('disabled', false).html(
                            '<i class="bi bi-save me-1"></i> Update Data');
                    }
                });
            });
        });
        $(document).ready(function() {
            $('#formTambahDiagnosa').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let actionUrl = form.attr('action');
                let formData = form.serialize();
                $('#btnSimpanDiagnosa').prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');
                $.ajax({
                    url: actionUrl,
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        // Tutup Modal
                        $('#modaltambah').modal('hide');

                        // Reset Input Form
                        form[0].reset();

                        // Reload DataTables Server-Side
                        if ($.fn.DataTable.isDataTable('#tabelunit')) {
                            $('#tabelunit').DataTable().ajax.reload(null, false);
                        }
                        alert('Diagnosa baru berhasil ditambahkan!');
                    },
                    error: function(xhr) {
                        let res = xhr.responseJSON;
                        if (res && res.message) {
                            alert('Gagal menyimpan: ' + res.message);
                        } else {
                            alert('Terjadi kesalahan saat menyimpan data.');
                        }
                    },
                    complete: function() {
                        $('#btnSimpanDiagnosa').prop('disabled', false).html(
                            '<i class="bi bi-save me-1"></i> Simpan Data');
                    }
                });
            });
        });
    </script>
@endsection
