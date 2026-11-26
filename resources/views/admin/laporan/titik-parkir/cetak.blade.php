<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Laporan Titik/Objek Pendapatan - SAPA JUKIR Sinjai
    </title>

    <style>

        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
            font-size: 11px;
        }

        .kop {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            text-align: left;
            border-bottom: 3px solid #000;
            padding: 0 0 10px;
            margin-bottom: 12px;
        }

        .kop-badge {
            width: 46px;
            height: 46px;
            border: 2px solid #000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
            color: #000;
            flex-shrink: 0;
        }

        .kop-text {
            text-align: center;
        }

        .kop-title {
            margin: 0;
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .kop-subtitle {
            margin: 2px 0 0;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-small {
            margin-top: 2px;
            font-size: 10px;
            font-weight: normal;
            text-transform: none;
        }

        .judul {
            text-align: center;
            margin-bottom: 15px;
        }

        .judul h4 {
            margin: 0 0 5px;
            font-size: 15px;
            text-transform: uppercase;
        }

        .judul p {
            margin: 0;
            font-size: 10px;
        }

        .filter {
            margin-bottom: 12px;
            font-size: 10px;
        }

        .filter table {
            width: auto;
            border-collapse: collapse;
        }

        .filter td {
            padding: 2px 8px 2px 0;
            vertical-align: top;
        }

        .table-data {
            width: 100%;
            border-collapse: collapse;
        }

        .table-data th,
        .table-data td {
            border: 1px solid #000;
            padding: 6px 5px;
            vertical-align: middle;
            text-align: center;
        }

        .table-data th {
            text-align: center;
            font-weight: bold;
            background: #f0f0f0;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: center;
        }

        .footer {
            margin-top: 25px;
            width: 100%;
        }

        .tanggal {
            width: 250px;
            margin-left: auto;
            text-align: left;
            line-height: 1.5;
        }

        .tempat {
            margin-bottom: 3px;
        }

        .signature-space {
            height: 65px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .signature-title {
            font-size: 10px;
        }

        .no-data {
            text-align: center;
            padding: 15px;
        }

        @media print {

            .no-print {
                display: none !important;
            }

        }

    </style>

</head>


<body>


{{-- ==========================================================
    KOP LAPORAN RESMI
========================================================== --}}

@include('admin.laporan.partials.header-kop')

<div class="judul">
    <h4>LAPORAN DATA TITIK/OBJEK PENDAPATAN</h4>
    <p>Kabupaten Sinjai</p>
</div>


{{-- ==========================================================
    FILTER
========================================================== --}}

<div class="filter">

    <table>

        @if($search)

            <tr>

                <td>
                    Pencarian
                </td>

                <td>
                    :
                </td>

                <td>
                    {{ $search }}
                </td>

            </tr>

        @endif


        @if($jenisParkirId)

            <tr>

                <td>
                    Jenis Retribusi
                </td>

                <td>
                    :
                </td>

                <td>
                    {{ $titikParkirs->first()?->jenisParkir?->nama ?? '-' }}
                </td>

            </tr>

        @endif


        @if($status)

            <tr>

                <td>
                    Status
                </td>

                <td>
                    :
                </td>

                <td>
                    {{ ucfirst($status) }}
                </td>

            </tr>

        @endif

    </table>

</div>


{{-- ==========================================================
    TABEL
========================================================== --}}

<table class="table-data">

    <thead>

        <tr>

            <th style="width: 35px;">
                No.
            </th>

            <th style="width: 90px;">
                Kode Titik
            </th>

            <th>
                Nama Titik/Objek
            </th>

            <th>
                Jenis Retribusi
            </th>

            <th>
                Alamat
            </th>

            <th style="width: 70px;">
                Kapasitas Motor
            </th>

            <th style="width: 70px;">
                Kapasitas Mobil
            </th>

            <th style="width: 100px;">
                Target Harian
            </th>

            <th style="width: 100px;">
                Target Bulanan
            </th>

            <th style="width: 65px;">
                Status
            </th>

        </tr>

    </thead>


    <tbody>

        @forelse($titikParkirs as $titik)

            <tr>

                <td class="text-center">
                    {{ $loop->iteration }}
                </td>


                <td class="text-center">
                    {{ $titik->kode_titik }}
                </td>


                <td>
                    {{ $titik->nama }}
                </td>


                <td>
                    {{ $titik->jenisParkir?->nama ?? '-' }}
                </td>


                <td>
                    {{ $titik->alamat ?? '-' }}
                </td>


                <td class="text-center">
                    {{ $titik->kapasitas_motor ?? 0 }}
                </td>


                <td class="text-center">
                    {{ $titik->kapasitas_mobil ?? 0 }}
                </td>


                <td class="text-right">

                    Rp
                    {{ number_format((float) $titik->targetPendapatans->sum('target') / 30, 0, ',', '.') }}

                </td>


                <td class="text-right">

                    Rp
                    {{ number_format((float) $titik->targetPendapatans->sum('target'), 0, ',', '.') }}

                </td>


                <td class="text-center">

                    {{ ucfirst($titik->status) }}

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="10"
                    class="no-data"
                >

                    Tidak ada data titik/objek pendapatan.

                </td>

            </tr>

        @endforelse

    </tbody>

</table>


{{-- ==========================================================
    TANDA TANGAN
========================================================== --}}

<div class="footer">

    <div class="tanggal">

        <div class="tempat">

            Sinjai,
            {{ now()->locale('id')->translatedFormat('d F Y') }}

        </div>


        <div>
            Mengetahui,
        </div>


        <div class="signature-space"></div>


        <div class="signature-name">
            Administrator SAPA JUKIR
        </div>

        <div class="signature-title">
            Sistem Informasi Petugas Kabupaten Sinjai
        </div>

    </div>

</div>


<script>

    window.onload = function () {
        window.print();
    };

</script>


</body>

</html>