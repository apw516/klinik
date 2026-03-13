<table class="table table-sm table-hover table-bordered">
    <thead>
        <th>Nomor Antrian</th>
        <th>Tanggal masuk</th>
        <th>Nomor RM</th>
        <th>Nama Pasien</th>
        <th>Unit</th>
        <th>Dokter</th>
        <th>Keluhan</th>
        <th>Status</th>
        <th class="text-center">Action</th>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $item->nomor_antrian }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tgl_masuk)->locale('id')->translatedFormat('d F Y') }}</td>
                <td>{{ $item->nomor_rm }}</td>
                <td>{{ $item->nama_pasien }}</td>
                <td>{{ $item->nama_unit }}</td>
                <td>{{ $item->nama_dokter }}</td>
                <td>{{ $item->keluhan_utama }}</td>
                <td>
                    @if ($item->status_periksa == 1)
                        <i class="bi bi-clipboard-check-fill text-danger"></i> Belum diperiksa
                    @else
                        <i class="bi bi-clipboard-check-fill text-success"></i> Sudah diperiksa
                    @endif
                </td>
                <td class="text-center">
                    <button class="btn btn-success pilihpasien" idkunjungan="{{ $item->id }}"><i
                            class="bi bi-file-earmark-plus"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(".pilihpasien").on('click', function(event) {
        idkunjungan = $(this).attr('idkunjungan')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idkunjungan
            },
            url: '<?= route('ambilformerm') ?>',
            error: function(response) {
                spinner.hide();
                alert('error')
            },
            success: function(response) {
                spinner.hide();
                $('.v_1').attr('hidden', true)
                $('.v_2').removeAttr('hidden', true)
                $('.v_erm').html(response);
            }
        });
    });
</script>
