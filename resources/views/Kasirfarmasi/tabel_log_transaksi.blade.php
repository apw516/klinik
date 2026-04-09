<table class="table table-hover table-bordered align-middle" id="tabelTransaksi">
    <thead class="table-light">
        <tr>
            <th class="text-center">No.</th>
            <th>ID Transaksi</th>
            <th>Tanggal</th>
            <th>No. RM / Nama Pasien</th>
            {{-- <th>Unit Tujuan</th> --}}
            <th class="text-end">Sub Total Tagihan</th>
            <th class="text-end">Bayar</th>
            <th class="text-end">Diskon</th>
            <th class="text-end">Kembalian</th>
            <th class="text-end">Total Tagihan</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $grandTotal = 0; @endphp
        @forelse($data as $key => $d)
            @php $grandTotal += $d->total_neto; @endphp
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td><span class="fw-bold text-primary">{{ $d->id_transaksi }}</span></td>
                <td>{{ \Carbon\Carbon::parse($d->tgl_transaksi)->format('d/m/Y H:i') }}</td>
                <td>
                    <div class="fw-bold">{{ $d->nomor_rm }}</div>
                    <small class="text-muted">{{ $d->nama_pasien }}</small>
                </td>
                {{-- <td><span class="badge bg-info text-dark">{{ $d->nama_unit }}</span></td> --}}
                <td class="text-end fw-bold text-dark">
                    Rp {{ number_format($d->total_bruto, 0, ',', '.') }}
                </td>
                <td class="text-end text-success">
                    Rp {{ number_format($d->bayar, 0, ',', '.') }}
                </td>
                <td class="text-end text-success">
                    Rp {{ number_format($d->total_diskon, 0, ',', '.') }}
                </td>
                <td class="text-end text-danger">
                    Rp {{ number_format($d->kembalian, 0, ',', '.') }}
                </td>
                <td class="text-end text-danger">
                    Rp {{ number_format($d->total_neto, 0, ',', '.') }}
                </td>
                <td class="text-center">
                    {{-- <button class="btn btn-sm btn-outline-secondary" onclick="printStruk('{{ $d->id_transaksi }}')">
                        <i class="bi bi-printer"></i>
                    </button> --}}
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-danger returpembayaran" idheader="{{ $d->idtx }}"
                            idtrans="{{ $d->id_transaksi }}"><i class="bi bi-x-square"></i></button>
                        <button type="button" class="btn btn-info detailpembayaran" idheader="{{ $d->idtx }}"
                            idtrans="{{ $d->id_transaksi }}" data-bs-toggle="modal" data-bs-target="#modaldt"><i
                                class="bi bi-eye"></i></button>
                        <button type="button" class="btn btn-success cetaknota"> <i class="bi bi-printer"></i></button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center py-4 text-muted italic">Data tidak ditemukan untuk periode ini.
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot class="table-secondary">
        <tr>
            <th colspan="5" class="text-end">TOTAL PENDAPATAN :</th>
            <th class="text-end">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
            <th colspan="3"></th>
        </tr>
    </tfoot>
</table>
<!-- Modal -->
<div class="modal fade" id="modaldt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Pembayaran</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="v_d">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(".detailpembayaran").on('click', function(event) {
        idheader = $(this).attr('idheader')
        idtrans = $(this).attr('idtrans')
        // Swal.fire({
        //     title: "Anda yakin ?",
        //     text: "Pembayaran Dengan ID " + idtrans + " Akan dibatalkan ...",
        //     icon: "warning",
        //     showCancelButton: true,
        //     confirmButtonColor: "#3085d6",
        //     cancelButtonColor: "#d33",
        //     confirmButtonText: "Ya, batalkan !"
        // }).then((result) => {
        // if (result.isConfirmed) {
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                idheader,idtrans
            },
            url: '<?= route('detailpembayaran') ?>',
            error: function(data) {
                spinner.hide()
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops....',
                    text: 'Sepertinya ada masalah......',
                    footer: ''
                })
            },
            success: function(response) {
                spinner.hide()
                if (response.kode == 500) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopss...',
                        text: response.message,
                        footer: ''
                    })
                } else {
                    $('.v_d').html(response.view);
                }
            }
        });
        //     }
        // });
    })
    $(".returpembayaran").on('click', function(event) {
        idheader = $(this).attr('idheader')
        idtrans = $(this).attr('idtrans')
        Swal.fire({
            title: "Anda yakin ?",
            text: "Pembayaran Dengan ID " + idtrans + " Akan dibatalkan ...",
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
                        idheader
                    },
                    url: '<?= route('returpembayaran') ?>',
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
                            tampilkandatapasien()
                        }
                    }
                });
            }
        });
    })
</script>
