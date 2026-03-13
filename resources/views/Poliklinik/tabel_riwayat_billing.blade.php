<table class="table table-sm table-bordered table-hover">
    <thead>
        <th>Nama Tarif</th>
        <th>Jumlah</th>
        <th>Tarif</th>
        <th>Status Layanan</th>
        <th>Status Pembayaran</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($layanan as $l)
            <tr>
                <td>{{ $l->nama_tarif }}</td>
                <td>{{ $l->jumlah }}</td>
                <td>Rp {{ number_format($l->harga_satuan, 0, ',', '.') }}</td>
                <td>
                    @if ($l->status_layanan == 1)
                        OK
                    @elseif($l->status_layanan == 2)
                        Selesai
                    @else
                        Retur
                    @endif
                </td>
                <td>
                    @if ($l->status_bayar == 0)
                        Belum bayar
                    @else
                        Sudah dibayar
                    @endif
                </td>
                <td>
                    <button @if ($l->status_bayar == 1) disabled @endif class="btn btn-danger btn-sm returlayanan" iddetail="{{ $l->iddetail}}" nama="{{ $l->nama_tarif}}"><i
                            class="bi bi-arrow-clockwise"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
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
                            ambilriwayatbilling()
                        }
                    }
                });
            }
        });
    })
</script>
