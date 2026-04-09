<div class="card">
    <div class="card-header">Detail Kunjungan Pasien</div>
    <div class="card-body">
        <table class="table table-sm">
            <tr>
                <td>
                    <p><strong>Tanggal Masuk:</strong>
                        {{ \Carbon\Carbon::parse($data->tgl_masuk)->translatedFormat('d F Y') }}</p>
                </td>
                <td>
                    <p><strong>Kunjungan ke :</strong> {{ $data->counter }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p><strong>Nomor RM:</strong> {{ $data->nomor_rm }}</p>
                </td>
                <td>
                    <p><strong>Nama Dokter:</strong> {{ $data->nama_dokter }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <p><strong>Unit/Poli:</strong> {{ $data->nama_unit }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p><strong>Tekanan darah :</strong> {{ $data->tekanan_darah }} mmHg</p>
                </td>
                <td>
                    <p><strong>Suhu Tubuh:</strong> {{ $data->suhu_tubuh }} (°C)</p>
                </td>
                <td>
                    <p><strong>Keluhan utama :</strong> {{ $data->keluhan_utama }}</p>
                </td>
            </tr>
            <tr>
                <td class="fw-bold" colspan="3">SUBJECT :  {{ $data->SUBJECT }}</td>
            </tr>
            <tr>
                <td class="fw-bold" colspan="3">OBJECT : {{ $data->OBJECT }}</td>
            </tr>
            <tr>
                <td class="fw-bold" colspan="3">ASSESMEN : {{ $data->ASSESMENT }}</td>
            </tr>
            <tr>
                <td class="fw-bold" colspan="3">PLANNING : {{ $data->PLANNING }}</td>
            </tr>
            <tr>
                <td class="fw-bold" colspan="3">Hasil Laboratorium : {{ $data->pemeriksaan_penunjang }}</td>
            </tr>
        </table>
        {{-- <div hidden class="card">
            <div class="card-header">Billing Pelayanan</div>
            <div class="card-body">
                <table class="table table-sm table-hover">
                    <thead>
                        <th>Kode Ly header</th>
                        <th>Tgl entry</th>
                        <th>Tgl Layanan</th>
                        <th>Nama Tarif </th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @foreach ($ly as $l)
                            <tr>
                                <td>{{ $l->kode_layanan_header }}</td>
                                <td>{{ \Carbon\Carbon::parse($l->tgl_entry)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($l->tgl_layanan)->format('d-m-Y') }}</td>
                                <td>{{ $l->nama_tarif }}</td>
                                <td>{{ $l->jumlah }}</td>
                                <td>{{ number_format($l->subtotal, 0, 0) }}</td>
                                <td>
                                    @if ($l->status_bayar == 1)
                                        Sudah dibayar
                                    @else
                                        Belum dibayar
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button @if ($l->status_bayar == 1)
                                        disabled
                                    @endif class="btn btn-danger btn-sm returlayanan" id="returlayanan"
                                        iddetail="{{ $l->iddetail }}" nama="{{ $l->nama_tarif }}"><i
                                            class="bi bi-arrow-clockwise"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> --}}
    </div>
</div>
<script>
    $(".returlayanan").on('click', function(event) {
        nama = $(this).attr('nama')
        iddetail = $(this).attr('iddetail')
        Swal.fire({
            title: "Anda yakin ?",
            text: "Layanan " + nama + " Akan dibatalkan ...",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, batalkan !"
        }).then((result) => {
            if (result.isConfirmed) {
                spinner = $('#loader')
                spinner.show();
                $.ajax({
                    async: true,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        iddetail
                    },
                    url: '<?= route('returlayanan') ?>',
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
                            $('#modaldetail').modal('hide');
                            tampilkandatapasien()
                        }
                    }
                });
            }
        });
    })
</script>
