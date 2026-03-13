<table class="table table-sm table-bordered table-hover">
    <thead>
        <th>Kode layanan</th>
        <th>tgl layanan</th>
        <th>Nama tarif</th>
        <th>Jumlah</th>
        <th>Harga</th>
        <th>Subtotal</th>
        <th></th>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @foreach ($data as $d)
            <tr>
                <td>{{ $d->kode_layanan_header }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tgl_layanan)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y') }}
                </td>
                <td>{{ $d->nama_tarif }}</td>
                <td>{{ $d->jumlah }}</td>
                <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm returlayanan" id="returlayanan" iddetail="{{ $d->iddetail }}"
                        nama="{{ $d->nama_tarif }}"><i class="bi bi-arrow-clockwise"></i></button>
                </td>
            </tr>
            @php
                $total = $d->subtotal + $total;
            @endphp
        @endforeach
    </tbody>
</table>
<input hidden type="text" value="{{ number_format($total, 0, ',', '.') }}" id="test">
<input hidden type="text" value="{{ $total }}" id="test2">
<script>
    $(document).ready(function() {
        hitung()
    })

    function hitung() {
        total = $('#test').val()
        total2 = $('#test2').val()
        $('#totaltagihan').val(total)
        $('#totaltagihanasli').val(total2)
    }
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
                            tampilkantagihanpasien()
                        }
                    }
                });
            }
        });
    })
</script>
