<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Lab - {{ $hasillab->kode_kunjungan }}</title>
    <style>
        /* Gaya Dasar Kertas Cetak */
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
            padding: 20px;
            margin: 0;
        }

        /* Kontainer Kop Surat Flexbox (Logo + Teks) */
        .kop-container {
            display: flex;
            align-items: center;
            border-bottom: 3px double #000; /* Menggunakan double line agar lebih formal */
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .kop-logo {
            width: 80px; /* Ukuran proporsional untuk logo klinik */
            height: auto;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .kop-teks {
            flex-grow: 1;
            text-align: left; /* Rata kiri agar rapi di sebelah logo */
        }

        .kop-teks h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
            font-weight: bold;
            line-height: 1.2;
        }

        .kop-teks p {
            margin: 5px 0 0 0;
            font-size: 11px;
            color: #444;
            line-height: 1.3;
        }

        .info-pasien {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-pasien td {
            padding: 3px 0;
            vertical-align: top;
        }

        /* Gaya Tabel Hasil Laboratorium */
        .table-nota {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-nota th {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 6px;
            font-weight: bold;
            font-size: 11px;
            background-color: #f5f5f5;
        }

        .table-nota td {
            border-bottom: 1px solid #eee;
            padding: 6px;
            font-size: 11px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        /* Bagian Kesan / Catatan Dokter */
        .section-kesan {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 4px;
            background-color: #fafafa;
        }

        .section-kesan title {
            font-weight: bold;
            font-size: 11px;
            display: block;
            margin-bottom: 5px;
        }

        /* Tanda Tangan & Titi Mangsa */
        .ttd-wrapper {
            width: 100%;
            margin-top: 30px;
            display: flex;
            justify-content: flex-end; /* Memastikan area ttd berada di kanan bawah */
        }

        .ttd-area {
            text-align: center;
            width: 230px;
        }

        .titi-mangsa {
            margin-bottom: 5px;
            font-size: 11px;
        }

        .ttd-space {
            height: 65px; /* Ruang untuk tanda tangan fisik atau stempel QR-Code */
        }

        /* Proteksi CSS saat dicetak ke Printer Fisik */
        @media print {
            body {
                padding: 0;
                background: #fff;
            }

            .section-kesan {
                background: #fff;
                border: 1px solid #000;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="kop-container">
        <img src="{{ asset('public/img/NP_MEDIKA_LOGO2.png')}}" class="kop-logo" alt="Logo Klinik">
        <div class="kop-teks">
            <h2>KLINIK NP MEDIKA <br> dr. NURIA & dr. PINOKO</h2>
            <p>Desa Gebang, Kecamatan Gebang, Kabupaten Cirebon, Jawa Barat 45191</p>
        </div>
    </div>

    <table class="info-pasien">
        <tr>
            <td style="width: 18%;">Nama Pasien</td>
            <td style="width: 2%;">:</td>
            <td style="width: 30%;" class="fw-bold">{{ $pasien->nama_pasien ?? '-' }}</td>
            <td style="width: 18%;">Tgl Pemeriksaan</td>
            <td style="width: 2%;">:</td>
            <td style="width: 30%;">{{ \Carbon\Carbon::parse($hasillab->updated_at)->format('d-m-Y H:i') }} WIB</td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td class="fw-bold">{{ isset($pasien->tanggal_lahir) ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
            <td>Dokter Pengirim</td>
            <td>:</td>
            <td>@if(count($dokter) > 0) {{ $dokter[0]->nama_lengkap ?? '-' }} @else - @endif</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td colspan="4">{{ $pasien->alamat_domisili ?? '-' }}</td>
        </tr>
    </table>

    <table class="table-nota">
        <thead>
            <tr>
                <th style="width: 40%; text-align: left;">JENIS PEMERIKSAAN</th>
                <th style="width: 20%; text-align: right;">HASIL</th>
                <th style="width: 20%; text-align: center;">RUJUKAN (P)</th>
                <th style="width: 20%; text-align: center;">RUJUKAN (L)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="fw-bold">Hemoglobin Rutin</td>
                <td class="text-right fw-bold">{{ $hasillab->hb_hasil ?? '-' }} gr/dl</td>
                <td class="text-center">12 – 15,5 gr/dl</td>
                <td class="text-center">13,5 – 17,5 gr/dl</td>
            </tr>
            <tr>
                <td class="fw-bold">Hematokrit</td>
                <td class="text-right fw-bold">{{ $hasillab->ht_hasil ?? '-' }} %</td>
                <td class="text-center">34,9 – 44,5%</td>
                <td class="text-center">38,8 – 50%</td>
            </tr>
            <tr>
                <td class="fw-bold">Eritrosit</td>
                <td class="text-right fw-bold">{{ $hasillab->eritrosit_hasil ?? '-' }} juta/mm³</td>
                <td class="text-center">4 – 5 Juta/mm³</td>
                <td class="text-center">4,5 – 5,5 juta/mm³</td>
            </tr>
            <tr>
                <td class="fw-bold">Leukosit</td>
                <td class="text-right fw-bold">{{ $hasillab->leukosit_hasil ?? '-' }} /µL</td>
                <td class="text-center">4.500 – 10.000 /µL</td>
                <td class="text-center">4.500 – 10.000 /µL</td>
            </tr>
            <tr>
                <td class="fw-bold">Trombosit</td>
                <td class="text-right fw-bold">{{ $hasillab->trombosit_hasil ?? '-' }} /µL</td>
                <td class="text-center">150.000 – 450.000 /µL</td>
                <td class="text-center">150.000 – 450.000 /µL</td>
            </tr>
        </tbody>
    </table>

    <div class="section-kesan">
        <div class="fw-bold" style="font-size: 11px; margin-bottom: 5px;">KESAN / INTERPRETASI:</div>
        <p style="margin: 0; white-space: pre-line;">{{ $hasillab->kesan_lab ?? 'Tidak ada kesan tertulis.' }}</p>
    </div>

    <div class="ttd-wrapper">
        <div class="ttd-area">
            <div class="titi-mangsa">
                Cirebon, {{ \Carbon\Carbon::parse($hasillab->updated_at)->translatedFormat('d F Y') }}
            </div>
            <p style="margin: 0;">Petugas Laboratorium,</p>
            <div class="ttd-space"></div>
            <p style="margin: 0; border-bottom: 1px solid #000;" class="fw-bold">
                {{ strtoupper($user->nama ?? 'Validator Lab') }}
            </p>
            <p style="margin: 2px 0 0 0; font-size: 10px; color: #777;">Dokumen Rekam Medis Elektronik</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>