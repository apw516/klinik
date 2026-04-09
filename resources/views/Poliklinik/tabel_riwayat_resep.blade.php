<table class="table table-sm table-bordered table-hover">
    <thead>
        <th>No Resep</th>
        <th>Nama Obat</th>
        <th>Satuan</th>
        <th>Jumlah</th>
        <th>Aturan Pakai</th>
        <th>Status Resep</th>
        <th>Status Obat</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($data as $l)
            <tr>
                <td>{{ $l->no_resep }}</td>
                <td>{{ $l->nama_barang }}</td>
                <td>{{ $l->satuan_kecil }}</td>
                <td>{{ $l->qty }}</td>
                <td>{{ $l->aturan_pakai }}</td>
                <td>
                    @if ($l->status_resep == 1)
                        Terkirim
                    @elseif($l->status_resep == 2)
                        Sudah diterima
                    @else
                        Retur
                    @endif
                </td>
                <td>
                    @if ($l->status_obat == 1)
                        OK
                    @else
                        Retur
                    @endif
                </td>
                <td>
                    <button class="btn btn-danger btn-sm batalresep" @if ($l->status_resep == 2) disabled @endif iddetail="{{ $l->iddetail }}" nama="{{ $l->nama_barang }}" @if ($l->status_obat != 1) disabled @endif ><i
                            class="bi bi-arrow-clockwise"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(".batalresep").on('click', function(event) {
        nama = $(this).attr('nama')
        iddetail = $(this).attr('iddetail')
        Swal.fire({
            title: "Anda yakin ?",
            text: "Order Obat " + nama + " Akan dibatalkan ...",
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
                    url: '<?= route('returorderobat') ?>',
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
                            ambilriwayatresep()
                        }
                    }
                });
            }
        });
    })
</script>
