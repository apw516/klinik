<table class="table table-hover table-bordered align-middle" id="tabelKunjungan">
    <thead class="table-light text-center text-nowrap">
        <tr>
            <th width="5%">No</th>
            <th>Tgl. Masuk</th>
            <th>No. Antrian</th>
            <th>Data Pasien</th>
            <th>Unit/Poli</th>
            <th>Dokter Pemeriksa</th>
            <th>Status</th>
            <th width="10%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $key => $d)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td class="text-center">
                    {{ \Carbon\Carbon::parse($d->tgl_masuk)->format('d-m-Y') }}<br>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($d->tgl_masuk)->format('H:i') }} WIB</small>
                </td>
                <td class="text-center fw-bold text-primary">{{ $d->nomor_antrian }}</td>
                <td>
                    <div class="fw-bold">{{ $d->nomor_rm }}</div>
                    <div class="text-uppercase small text-secondary">{{ $d->nama_pasien }}</div>
                </td>
                <td>
                    <span class="badge bg-info text-dark font-monospace">{{ $d->nama_unit }}</span>
                </td>
                <td>
                    @if ($d->nama_dokter)
                        <i class="bi bi-person-badge me-1"></i> {{ $d->nama_dokter }}
                    @else
                        <span class="text-muted italic small">Belum ditentukan</span>
                    @endif
                </td>
                <td class="text-center">
                    @if ($d->status_kunjungan == 1)
                        <span class="badge rounded-pill bg-success">Aktif</span>
                    @elseif($d->status_kunjungan == 2)
                        <span class="badge rounded-pill bg-secondary">Selesai</span>
                    @else
                        <span class="badge rounded-pill bg-danger">Batal</span>
                    @endif
                </td>
                <td class="text-center bg-light">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-primary" title="Lihat Detail"
                            onclick="viewDetail('{{ $d->id_kunjungan }}')" data-bs-toggle="modal"
                            data-bs-target="#modaldetail">
                            <i class="bi bi-search"></i>
                        </button>
                        <button type="button" class="btn btn-outline-vla" title="Input Hasil Laboratorium"
                            onclick="inputLaboratorium('{{ $d->id_kunjungan }}')" data-bs-toggle="modal"
                            data-bs-target="#modalinputlab">
                            <i class="bi bi-flask"></i> </button>

                        <button HIDDEN @if ($d->status_kunjungan == 3 || $d->status_kunjungan == 2) disabled @endif type="button"
                            class="btn btn-outline-success" title="Input Layanan"
                            onclick="inputLayanan('{{ $d->id_kunjungan }}')" data-bs-toggle="modal"
                            data-bs-target="#modalinputlayanan">
                            <i class="bi bi-plus-circle"></i>
                        </button>
                        <button HIDDEN @if ($d->status_kunjungan == 3 || $d->status_kunjungan == 2) disabled @endif type="button"
                            class="btn btn-outline-danger" title="batal kunjungan"
                            onclick="batalkunjungan('{{ $d->id_kunjungan }}')">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center py-5">
                    <img src="https://illustrations.popsy.co/amber/no-data-found.svg" alt="No data"
                        style="width: 150px;"><br>
                    <span class="text-muted">Tidak ada data kunjungan pada periode ini.</span>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modaldetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Kunjungan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="v_detail"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalinputlayanan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 90%; width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Silahkan Input Layanan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="v_form_input"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="simpanlayanan()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalinputlab" tabindex="-1" aria-labelledby="modalinputlabLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalinputlabLabel">
                    <i class="bi bi-flask me-2"></i>Input Hasil Pemeriksaan Laboratorium
                </h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="formhasillab">
                <style>
                    /* CSS Kustom agar Input Menyatu Sempurna dengan Tabel */
                    .table-input-seamless {
                        vertical-align: middle !important;
                    }

                    .table-input-seamless td {
                        padding: 4px 8px !important;
                        /* Memperkecil padding agar tabel lebih ringkas */
                        vertical-align: middle !important;
                    }

                    .table-input-seamless .input-group {
                        margin-bottom: 0 !important;
                        /* Menghilangkan margin bawaan bootstrap */
                        border: 1px solid #dee2e6;
                        /* Membuat border luar membungkus input + satuan */
                        border-radius: 4px;
                        background-color: #fff;
                        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                    }

                    /* Efek Fokus saat User Mengklik Kolom Hasil */
                    .table-input-seamless .input-group:focus-within {
                        border-color: #80bdff;
                        outline: 0;
                        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                    }

                    .table-input-seamless .form-control-minimal {
                        border: none !important;
                        /* Menghapus border internal input */
                        background-color: transparent !important;
                        padding: 4px 8px;
                        height: auto;
                        text-align: right;
                        /* Angka hasil lab umumnya rata kanan */
                        font-weight: 600;
                        color: #495057;
                    }

                    .table-input-seamless .form-control-minimal:focus {
                        box-shadow: none !important;
                        outline: none !important;
                    }

                    .table-input-seamless .unit-text {
                        border: none !important;
                        /* Menghapus border internal addon */
                        background-color: transparent !important;
                        color: #6c757d;
                        font-size: 0.85rem;
                        padding-left: 4px;
                        padding-right: 8px;
                    }
                </style>
                <table class="table table-sm table-bordered table-input-seamless">
                    <thead class="bg-light text-center">
                        <tr>
                            <th class="align-middle">JENIS PEMERIKSAAN</th>
                            <th class="align-middle" rowspan="2" style="width: 25%;">HASIL</th>
                            <th class="align-middle" rowspan="2" colspan="2">NILAI RUJUKAN</th>
                        </tr>
                        <tr>
                            <th class="text-left text-primary fw-bold">HEMATOLOGI RUTIN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-semibold">Hemoglobin Rutin</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="hb_hasil" class="form-control form-control-minimal"
                                        placeholder="0.0">
                                    <span class="input-group-text unit-text">gr/dl</span>
                                </div>
                            </td>
                            <td>P : 12 – 15,5 gr/dl</td>
                            <td>L : 13,5 – 17,5 gr/dl</td>
                        </tr>

                        <tr>
                            <td class="fw-semibold">Hematokrit</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="ht_hasil" class="form-control form-control-minimal"
                                        placeholder="0">
                                    <span class="input-group-text unit-text">%</span>
                                </div>
                            </td>
                            <td>P : 34,9 – 44,5%</td>
                            <td>L : 38,8 – 50%</td>
                        </tr>

                        <tr>
                            <td class="fw-semibold">Eritrosit</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="eritrosit_hasil"
                                        class="form-control form-control-minimal" placeholder="0.0">
                                    <span class="input-group-text unit-text">juta/mm³</span>
                                </div>
                            </td>
                            <td>P : 4 – 5 Juta/mm³</td>
                            <td>L : 4,5 – 5,5 juta/mm³</td>
                        </tr>

                        <tr>
                            <td class="fw-semibold">Leukosit</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="leukosit_hasil"
                                        class="form-control form-control-minimal" placeholder="0">
                                    <span class="input-group-text unit-text">/µL</span>
                                </div>
                            </td>
                            <td>P : 4.500 – 10.000 /µL</td>
                            <td>L : 4.500 – 10.000 /µL</td>
                        </tr>

                        <tr>
                            <td class="fw-semibold">Trombosit</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="trombosit_hasil"
                                        class="form-control form-control-minimal" placeholder="0">
                                    <span class="input-group-text unit-text">/µL</span>
                                </div>
                            </td>
                            <td>P : 150.000 – 450.000 /µL</td>
                            <td>L : 150.000 – 450.000 /µL</td>
                        </tr>
                        <tr class="bg-light">
                            <td colspan="4" class="p-3">
                                <div class="form-group mb-0">
                                    <label for="hasillab"
                                        class="fw-bold text-secondary small mb-1.5 d-flex align-items-center">
                                        <i class="fas fa-comment-medical text-primary mr-2"
                                            style="font-size: 1.1rem;"></i>
                                        KESAN / INTERPRETASI LABORATORIUM
                                    </label>
                                    <textarea class="form-control border-secondary-subtle rounded-2 p-2.5" rows="4" id="hasillab"
                                        name="kesan_lab" placeholder="Tuliskan kesan atau catatan keahlian dokter/petugas laboratorium di sini..."
                                        style="font-size: 0.95rem; line-height: 1.5; resize: vertical; background-color: #fff;"></textarea>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input hidden type="text" id="idkunjungannya" name="idkunjungannya" value="">
                </form>
            </div>
            <div class="modal-footer footer-lab">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" onclick="simpanHasilLab()">
                    <i class="bi bi-save me-1"></i>Simpan Hasil Lab
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function viewDetail(idkunjungan) {
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idkunjungan
            },
            url: '<?= route('ambildetailkunjungan_billing') ?>',
            success: function(response) {
                spinner.hide();
                $('.v_detail').html(response);
            }
        });
    }

    function inputLayanan(idkunjungan) {
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idkunjungan
            },
            url: '<?= route('ambilforminputlayanan') ?>',
            success: function(response) {
                spinner.hide();
                $('.v_form_input').html(response);
            }
        });
    }

    function inputLaboratorium(idkunjungan) {
        $('#idkunjungannya').val(idkunjungan)
    }

    function simpanHasilLab() {
        Swal.fire({
            title: "Anda yakin ?",
            text: "Pastikan data sudah terisi dengan benar!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, simpan"
        }).then((result) => {
            Swal.fire({
                title: "Data akan disimpan sebagai catatan hasil laboratorium ?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Simpan",
                denyButtonText: `Batal`
            }).then((result) => {
                if (result.isConfirmed) {
                    simpanhasillabfinx()
                }
            });
        });
    }

    function simpanlayanan() {
        Swal.fire({
            title: "Anda yakin ?",
            text: "Pastikan data sudah terisi dengan benar!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, simpan"
        }).then((result) => {
            Swal.fire({
                title: "Data akan disimpan sebagai tagihan pasien ?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Simpan",
                denyButtonText: `Batal`
            }).then((result) => {
                if (result.isConfirmed) {
                    simpanbilling()
                }
            });
        });
    }

    function simpanhasillabfinx() {
        hasillab = $('#hasillab').val()
        idkunjungan = $('#idkunjungannya').val()
        var data = $('.formhasillab').serializeArray();
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                hasillab,
                idkunjungan,
                data: JSON.stringify(data),

            },
            url: '<?= route('simpanHasilLab') ?>',
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

    function simpanbilling() {
        var data2 = $('.formbilling').serializeArray();
        var data3 = $('.formbillingobat').serializeArray();
        idkunjungan = $('#idkunjungan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data2: JSON.stringify(data2),
                data3: JSON.stringify(data3),
                idkunjungan
            },
            url: '<?= route('simpanbilling') ?>',
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
                    const myForm = document.getElementById('formassesmen');
                    myForm.reset();
                }
            }
        });
    }

    function batalkunjungan(idkunjungan) {
        Swal.fire({
            title: "Anda yakin ?",
            text: "Data kunjungan pasien akan dibatalkan !",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, batal"
        }).then((result) => {
            Swal.fire({
                title: "Status kunjungan pasien akan dibatalkan ?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Ya, Simpan",
                denyButtonText: `cancel`
            }).then((result) => {
                if (result.isConfirmed) {
                    idkunjungan = $('#idkunjungan').val()
                    spinner = $('#loader')
                    spinner.show();
                    $.ajax({
                        async: true,
                        type: 'post',
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            idkunjungan
                        },
                        url: '<?= route('simpanbatalkunjungan') ?>',
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
            });
        });
    }
</script>
