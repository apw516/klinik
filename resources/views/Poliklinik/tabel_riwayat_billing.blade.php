<table class="table table-sm table-bordered table-hover">
    <thead>
        <tr>
            <th>Nama Tarif</th>
            <th>Jumlah</th>
            <th>Tarif</th>
            <th>Aturan pakai</th>
            <th>Status Layanan</th>
            <th>Status Pembayaran</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @php $grandTotal = 0; @endphp
        @foreach ($layanan as $l)
            @php 
                $subtotal = $l->jumlah * $l->harga_satuan;
                $grandTotal += $subtotal;
            @endphp
            <tr>
                <td>@if($l->id_tarif != ''){{ $l->nama_tarif }} @else {{ $l->nama_display}} @endif </td>
                <td>{{ $l->jumlah }}</td>
                <td>Rp {{ number_format($l->harga_satuan, 0, ',', '.') }}</td>
                <td>{{ $l->aturan_pakai }} @if($l->signa != '') ( {{ $l->signa }} ) @endif</td>
                <td>
                    @if ($l->status_layanan == 1)
                        <span class="badge bg-warning text-dark">OK</span>
                    @elseif($l->status_layanan == 2)
                        <span class="badge bg-success">Selesai</span>
                    @else
                        <span class="badge bg-danger">Retur</span>
                    @endif
                </td>
                <td>
                    @if ($l->status_bayar == 0)
                        <span class="badge bg-secondary">Belum bayar</span>
                    @else
                        <span class="badge bg-primary">Sudah dibayar</span>
                    @endif
                </td>
                <td class="text-center">
                    <button @if ($l->status_bayar == 1) disabled @endif class="btn btn-danger btn-sm returlayanan" iddetail="{{ $l->iddetail }}" nama="{{ $l->nama_tarif }}">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="fw-bold table-light">
            <td colspan="2" class="text-end">Total Keseluruhan:</td>
            <td colspan="5">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
        </tr>
    </tfoot>
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
