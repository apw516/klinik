<table id="tabelpasien" class="table table-sm table-bordered table-hover text-center">
    <thead>
        <th>Tanggal kunjungan</th>
        {{-- <th>Kode Layanan Header</th> --}}
        <th>Nomor RM</th>
        <th>Nama Pasien</th>
        <th>Jenis Kunjungan</th>
        <th>Unit</th>
        <th>Dokter</th>
        <th>Status</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($data as $d)
            <tr class="text-center">
                <td class="text-right">{{ $d->tgl_masuk }}</td>
                {{-- <td class="text-right">{{ $d->kode_layanan_header }}</td> --}}
                <td class="text-right">{{ $d->nomor_rm }}</td>
                <td class="text-right">{{ $d->nama_pasien }}</td>
                <td class="text-right">
                    @if ($d->jenis_kunjungan == 1)
                        Rawat Jalan
                    @else
                        Rawat Inap
                    @endif
                </td>
                <td class="text-right">{{ $d->nama_unit }}</td>
                <td class="text-right">{{ $d->nama_dokter }}</td>
                <td class="text-center">
                    @if ($d->jumlah_belum_bayar > 0)
                        <span class="badge bg-danger">
                            {{ $d->jumlah_belum_bayar }} Item Belum Bayar
                        </span>
                    @else
                        <span class="badge bg-success">Lunas</span>
                    @endif
                </td>
                <td class="text-right">
                    <button class="btn btn-info pilihheader" idlayanan="{{ $d->id_kunjungan }}"
                        idkunjungan="{{ $d->id_kunjungan }}">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function() {
        $("#tabelpasien").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 12,
            "searching": true,
            "ordering": false,
        })
    });
    $(".pilihheader").on('click', function(event) {
        idlayanan = $(this).attr('idlayanan')
        idkunjungan = $(this).attr('idkunjungan')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idlayanan,
                idkunjungan
            },
            url: '<?= route('ambilformpembayarankasir') ?>',
            success: function(response) {
                spinner.hide();
                $('.v_2').removeAttr('hidden', true)
                $('.v_1').attr('hidden', true)
                $('.v_kasirfarmasi').html(response);
            }
        });
    });
