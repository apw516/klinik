<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-light fw-bold">Detail Pasien</div>
                    <div class="card-body">
                        <table class="table table-sm table-boredered">
                            <tr>
                                <td>Nomor Identitas</td>
                                <td>: {{ $mt_pasien[0]->nomor_identitas }}</td>
                            </tr>
                            <tr>
                                <td>ID Satu Sehat</td>
                                <td>{{ $mt_pasien[0]->id_satu_sehat }}</td>
                            </tr>
                            <tr>
                                <td>Nomor RM</td>
                                <td>{{ $mt_pasien[0]->nomor_rm }}</td>
                            </tr>
                            <tr>
                                <td>Nama Pasien</td>
                                <td>{{ $mt_pasien[0]->nama_pasien }}</td>
                            </tr>
                            <tr>
                                <td>Tempat, Tanggal lahir</td>
                                <td>{{ $mt_pasien[0]->tempat_lahir }},
                                    {{ \Carbon\Carbon::parse($mt_pasien[0]->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>{{ $mt_pasien[0]->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>{{ $mt_pasien[0]->alamat_domisili }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card mt-2">
                    <div class="card-header bg-light fw-bold">Riwayat Kunjungan</div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered text-center">
                            <thead>
                                <th>Tanggal masuk</th>
                                <th>Unit</th>
                                <th>Dokter</th>
                                <th>Keluhan Utama</th>
                                <th>Status Kunjungan</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($data_kunjungan as $t)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($t->tgl_masuk)->locale('id')->translatedFormat('d F Y') }} | {{ $t->counter}}</td>
                                        <td>{{ $t->nama_unit }}</td>
                                        <td>{{ $t->nama_dokter }}</td>
                                        <td>{{ $t->keluhan_utama }}</td>
                                        <td class="text-center">
                                            @if ($t->status_kunjungan == 1)
                                                aktif
                                            @elseif ($t->status_kunjungan == 2)
                                                Selesai
                                            @elseif ($t->status_kunjungan == 3)
                                                Batal
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning editstatus" data-bs-toggle="tooltip"
                                                data-bs-title="edit status kunjungan ..."
                                                idkunjungan="{{ $t->id }}"><i
                                                    class="bi bi-pencil-square"></i></button>
                                            <button class="btn btn-sm btn-info detailkunjungan" data-bs-toggle="tooltip"
                                                data-bs-title="lihat detail kunjungan ... "
                                                idkunjungan="{{ $t->id }}"><i class="bi bi-eye"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card" style="min-height: 650px;">
            <div class="card-header bg-light fw-bold">Form Pendaftaran</div>
            <div class="card-body">
                <form class="formpendaftaran">
                    <label for="exampleFormControlInput1" class="form-label">Tanggal Kunjungan</label>
                    <input type="date" class="form-control" id="tanggalkunjungan" name="tanggalkunjungan"
                        placeholder="name@example.com" value="{{ $datenow }}">
                    <input hidden type="text" class="form-control" id="no_rm" name="no_rm"
                        placeholder="name@example.com" value="{{ $rm }}">
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Jenis Kunjungan</label>
                                <select class="form-select" aria-label="Default select example" name="jeniskunjungan"
                                    id="jeniskunjungan">
                                    <option value="0">Silahkan Pilih</option>
                                    <option value="1" selected>Rawat Jalan</option>
                                    <option value="2">Rawat Inap</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Tujuan Kunjungan</label>
                                <select class="form-select" aria-label="Default select example" name="tujuankunjungan"
                                    id="tujuankunjungan">
                                    <option value="0">Silahkan Pilih</option>
                                    @foreach ($mt_unit as $m)
                                        <option value="{{ $m->id }}"
                                            @if ($m->id == 1) selected @endif>{{ $m->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Pilih Dokter</label>
                        <select class="form-select" aria-label="Default select example" name="dokter" id="dokter">
                            <option value="0">Silahkan Pilih</option>
                            @foreach ($dokter as $m)
                                <option value="{{ $m->id }}">{{ $m->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="exampleFormControlInput1" class="form-label">Tekanan Darah</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="masukan tekanan darah ..."
                                    aria-label="Recipient’s username" aria-describedby="basic-addon2"
                                    name="tekanandarah" id="tekanandarah">
                                <span class="input-group-text" id="basic-addon2">mmHg </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="exampleFormControlInput1" class="form-label">Suhu Tubuh</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="masukan suhu tubuh ..."
                                    aria-label="Recipient’s username" aria-describedby="basic-addon2" name="suhutubuh"
                                    id="suhutubuh">
                                <span class="input-group-text" id="basic-addon2">°C </span>
                            </div>
                        </div>
                    </div>
                    <label for="exampleFormControlInput1" class="form-label">Keluhan Utama</label>
                    <div class="input-group mb-3">
                        <textarea rows="5" type="text" class="form-control" placeholder="masukan keluhan pasien ..."
                            aria-label="Recipient’s username" aria-describedby="basic-addon2" name="keluhanutama" name="keluhanutama"></textarea>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="simpanpendaftaran()"><i
                            class="bi bi-floppy" style="margin-right: 12px"></i> Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modaleditkunjungan" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Status Kunjungan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="v_edit_kunjungan">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="simpaneditstatus()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modaldetailkunjungan" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Kunjungan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="v_detail_kunjungan">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    function simpanpendaftaran() {
        Swal.fire({
            title: "Anda yakin ?",
            text: "Data Pendaftaran akan disimpan !",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya Simpan ..."
        }).then((result) => {
            if (result.isConfirmed) {
                simpanpendaftaran2()
            }
        });
    }

    function simpanpendaftaran2() {
        var data = $('.formpendaftaran').serializeArray();
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
            url: '<?= route('simpanpendaftaranpasien') ?>',
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
                    const myForm = document.getElementById('formpendaftaran');
                    myForm.reset();
                }
            }
        });
    }
    $(".editstatus").on('click', function(event) {
        idkunjungan = $(this).attr('idkunjungan')
        $('#modaleditkunjungan').modal('show');
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idkunjungan
            },
            url: '<?= route('formeditkunjungan') ?>',
            success: function(response) {
                spinner.hide();
                $('.v_edit_kunjungan').html(response);
            }
        });
    });
    $(".detailkunjungan").on('click', function(event) {
        idkunjungan = $(this).attr('idkunjungan')
        $('#modaldetailkunjungan').modal('show');
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idkunjungan
            },
            url: '<?= route('ambildetailkunjungan') ?>',
            success: function(response) {
                spinner.hide();
                $('.v_detail_kunjungan').html(response);
            }
        });
    });

    function simpaneditstatus() {
        Swal.fire({
            title: "Anda yakin ?",
            text: "status kunjungan akan diedit !",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, edit !"
        }).then((result) => {
            if (result.isConfirmed) {
                status = $('#status_kunjungan').val()
                id = $('#idkunjungan').val()
                spinner = $('#loader')
                spinner.show();
                $.ajax({
                    async: true,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id,
                        status
                    },
                    url: '<?= route('simpaneditstatus') ?>',
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
    }
</script>
