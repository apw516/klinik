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
                        <button @if ($d->status_kunjungan == 3 || $d->status_kunjungan == 2) disabled @endif type="button"
                            class="btn btn-outline-success" title="Input Layanan"
                            onclick="inputLayanan('{{ $d->id_kunjungan }}')" data-bs-toggle="modal"
                            data-bs-target="#modalinputlayanan">
                            <i class="bi bi-plus-circle"></i>
                        </button>
                        <button @if ($d->status_kunjungan == 3 || $d->status_kunjungan == 2) disabled @endif type="button"
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
