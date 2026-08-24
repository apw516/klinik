<div class="card">
    <div class="card-body">
        <div class="mb-4">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
        </div>
        <h2 class="fw-bold text-success">Pembayaran Berhasil!</h2>
        <p class="text-muted">Transaksi telah berhasil diproses ke dalam sistem.</p>

        <div class="card bg-light border-0 mb-4">
            <div class="card-body">
                <small class="text-uppercase fw-bold text-muted">Uang Kembalian</small>
                <h1 class="display-4 fw-bold text-primary mb-0" id="displayKembalian">Rp
                    {{ number_format($kembalian, 0, ',', '.') }}</h1>
            </div>
        </div>
        <input hidden type="text" value="{{ $id_header }}" id="idheader">
        <div class="d-grid gap-2">
            <button type="button" class="btn btn-primary btn-lg" onclick="cetakStruk()">
                <i class="bi bi-printer"></i> Cetak Struk
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
<script>
    function cetakStruk() {
        idHeader = $('#idheader').val()
        var urlPrint = "{{ url('/kasir/cetak-struk') }}/" + idHeader;

        // 2. Buka URL di tab/jendela baru
        var win = window.open(urlPrint, '_blank');

        // 3. Fokuskan kursor ke tab baru tersebut (jika browser tidak memblokir)
        if (win) {
            win.focus();
        } else {
            alert('Gagal membuka tab baru. Mohon izinkan Pop-up pada browser Anda.');
        }
    }
</script>
