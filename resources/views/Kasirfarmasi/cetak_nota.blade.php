<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - {{ $header->kode_transaksi ?? $header->id }}</title>
    <style>
        @page {
            size: 80mm auto;
            /* Sesuaikan dengan printer thermal 58mm / 80mm */
            margin: 0;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            width: 72mm;
            margin: auto;
            padding: 8px 0;
            color: #000;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 2px 0;
            vertical-align: top;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <!-- Tombol manual jika dialog print tertutup -->
    <div class="no-print" style="margin-bottom: 10px; text-align: center;">
        <button onclick="window.print()" style="padding: 5px 15px; cursor: pointer;">Cetak Nota</button>
        <button onclick="window.close()" style="padding: 5px 15px; cursor: pointer;">Tutup</button>
    </div>

    <!-- Header Klinik / Rumah Sakit -->
    <div class="text-center">
        <h3 style="margin: 0; text-transform: uppercase;">NP MEDIKA</h3>
        <p style="margin: 2px 0;">Jl. Kesehatan No. 123, Jakarta</p>
        <p style="margin: 2px 0;">Telp: (021) 12345678</p>
    </div>

    <div class="line"></div>

    <!-- Informasi Transaksi -->
    <table>
        <tr>
            <td>No. Nota</td>
            <td>: {{ $header->kode_transaksi ?? $header->id }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: {{ date('d/m/Y H:i', strtotime($header->created_at ?? now())) }}</td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td>: {{ $header->created_by ?? 'Kasir' }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <!-- Detail Item (Semua digabung jadi 1 item sesuai rules) -->
    <table>
        <thead>
            <tr style="text-align: left;">
                <th style="width: 60%;">Item</th>
                <th style="width: 10%; text-align: center;">Qty</th>
                <th style="width: 30%; text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Paket Pemeriksaan</td>
                <td class="text-center">1</td>
                <td class="text-end">Rp {{ number_format($totalPaket, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="line"></div>

    <!-- Rincian Pembayaran -->
    <table>
        <tr>
            <td class="fw-bold">Total Tagihan</td>
            <td class="text-end fw-bold">Rp {{ number_format($totalPaket, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Bayar</td>
            <td class="text-end">Rp {{ number_format($header->bayar ?? $totalPaket, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="text-end">Rp
                {{ number_format(($header->kembalian), 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <!-- Footer Struk -->
    <div class="text-center" style="margin-top: 10px;">
        <p style="margin: 2px 0;">-- Terima Kasih --</p>
        <p style="margin: 2px 0;">Semoga Lekas Sembuh</p>
    </div>

    <!-- Script Auto Print -->
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
