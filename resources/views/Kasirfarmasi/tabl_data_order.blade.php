<table class="table table-sm table-bordered table-hover">
    <thead>
        <th>Nama Barang</th>
        <th>Qty</th>
        <th>Aturan Pakai</th>
        <th>Stok</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{ $d->nama_barang }}</td>
                <td>{{ $d->qty }}</td>
                <td>{{ $d->aturan_pakai }}</td>
                <td>{{ $d->stok_tersedia }}</td>
                <td class="text-center">
                    <button iddetail="{{ $d->iddetail }}" nama="{{ $d->nama_barang }}"
                        class="btn btn-danger btn-sm batalresep"><i class="bi bi-arrow-clockwise"></i></button>
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
                            tampilkanorderresep()
                        }
                    }
                });
            }
        });
    })
</script>
