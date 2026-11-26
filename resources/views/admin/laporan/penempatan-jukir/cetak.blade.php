<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Laporan Penempatan Petugas - SAPA JUKIR Sinjai
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {

            margin: 0;

            padding: 30px;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            color: #000;

            font-size: 12px;

        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            text-align: left;
            margin-bottom: 25px;
        }

        .kop-badge {
            width: 62px;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 50%;
            box-shadow: 0 0 0 2px #000;
            background: #fff;
            flex-shrink: 0;
        }

        .kop-badge img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .header-text {
            text-align: center;
        }

        .header h2 {

            margin: 0;

            font-size: 15px;

            font-weight: bold;

            text-transform: uppercase;

        }

        .header h3 {

            margin: 5px 0 0;

            font-size: 12px;

            font-weight: bold;

            text-transform: uppercase;

        }

        .header p {

            margin: 5px 0 0;

            font-size: 10px;

        }

        .line {

            border-top: 2px solid #000;

            margin-top: 12px;

        }

        .info {

            margin-bottom: 15px;

        }

        .info table {

            width: 100%;

            border-collapse: collapse;

        }

        .info td {

            padding: 3px 0;

            vertical-align: top;

        }

        .info td:first-child {

            width: 120px;

            font-weight: bold;

        }

        .filter {

            margin-bottom: 15px;

        }

        .filter span {

            display: inline-block;

            margin-right: 20px;

        }

        table.data {

            width: 100%;

            border-collapse: collapse;

        }

        table.data th,
        table.data td {

            border: 1px solid #000;

            padding: 7px 6px;

            vertical-align: middle;

            text-align: center;

        }

        table.data th {

            text-align: center;

            background: #f0f0f0;

            font-weight: bold;

        }

        .text-center {

            text-align: center;
        }

        .text-right {

            text-align: center;
        }

        .nowrap {

            white-space: nowrap;
        }

        .footer {

            margin-top: 25px;

            font-size: 10px;

        }

        .empty {

            text-align: center;

            padding: 20px;

        }

        @media print {

            body {

                padding: 10mm;

            }

            .no-print {

                display: none !important;

            }

        }

    </style>

</head>


<body>


{{-- ==========================================================
    HEADER
========================================================== --}}

@include('admin.laporan.partials.header-kop')

<div class="report-title" style="text-align:center; margin: -10px 0 12px; font-weight:700; font-size:14px; text-transform:uppercase;">
    LAPORAN PENEMPATAN PETUGAS
</div>

<div class="line"></div>


{{-- ==========================================================
    INFORMASI FILTER
========================================================== --}}

<div class="info">

    <table>

        <tr>

            <td>
                Tanggal Cetak
            </td>

            <td>
                : {{ now()->format('d-m-Y H:i') }}
            </td>

        </tr>

        <tr>

            <td>
                Pencarian
            </td>

            <td>
                :
                {{ $search ?: 'Semua Data' }}
            </td>

        </tr>

        <tr>

            <td>
                Titik Parkir
            </td>

            <td>
                :

                @if($titikParkirId)

                    @php

                        $titikParkir =
                            \App\Models\TitikParkir::find($titikParkirId);

                    @endphp

                    {{ $titikParkir?->kode_titik }}
                    -
                    {{ $titikParkir?->nama }}

                @else

                    Semua Titik Parkir

                @endif

            </td>

        </tr>

        <tr>

            <td>
                Status
            </td>

            <td>
                :
                {{ $status ? ucfirst($status) : 'Semua Status' }}
            </td>

        </tr>

    </table>

</div>


{{-- ==========================================================
    DATA
========================================================== --}}

<table class="data">

    <thead>

        <tr>

            <th style="width:35px;">
                No.
            </th>

            <th>
                Petugas
            </th>

            <th>
                Kode Petugas
            </th>

            <th>
                Titik Parkir
            </th>

            <th>
                Kode Titik
            </th>

            <th>
                Tanggal Mulai
            </th>

            <th>
                Tanggal Selesai
            </th>

            <th>
                Surat Penugasan
            </th>

            <th>
                Status
            </th>

            <th>
                Keterangan
            </th>

        </tr>

    </thead>


    <tbody>

        @forelse($penempatans as $index => $penempatan)

            <tr>

                <td class="text-center">
                    {{ $index + 1 }}
                </td>


                {{-- Petugas --}}

                <td>

                    {{ $penempatan->jukir?->nama ?? '-' }}

                </td>


                {{-- KODE Petugas --}}

                <td class="nowrap">

                    {{ $penempatan->jukir?->kode_jukir ?? '-' }}

                </td>


                {{-- TITIK PARKIR --}}

                <td>

                    {{ $penempatan->titikParkir?->nama ?? '-' }}

                </td>


                {{-- KODE TITIK --}}

                <td class="nowrap">

                    {{ $penempatan->titikParkir?->kode_titik ?? '-' }}

                </td>


                {{-- TANGGAL MULAI --}}

                <td class="text-center nowrap">

                    {{ $penempatan->tanggal_mulai?->format('d-m-Y') ?? '-' }}

                </td>


                {{-- TANGGAL SELESAI --}}

                <td class="text-center nowrap">

                    {{ $penempatan->tanggal_selesai?->format('d-m-Y') ?? '-' }}

                </td>


                {{-- SURAT --}}

                <td>

                    {{ $penempatan->surat_penugasan ?? '-' }}

                </td>


                {{-- STATUS --}}

                <td class="text-center">

                    {{ ucfirst($penempatan->status ?? '-') }}

                </td>


                {{-- KETERANGAN --}}

                <td>

                    {{ $penempatan->keterangan ?? '-' }}

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="10"
                    class="empty"
                >

                    Tidak ada data penempatan Petugas.

                </td>

            </tr>

        @endforelse

    </tbody>

</table>


{{-- ==========================================================
    FOOTER
========================================================== --}}

<div class="footer">

    <strong>
        Total Data:
    </strong>

    {{ $penempatans->count() }}

    data

</div>


{{-- ==========================================================
    PRINT BUTTON
========================================================== --}}

<div
    class="no-print"
    style="margin-top:25px;text-align:center;"
>

    <button
        onclick="window.print()"
        style="
            padding:8px 18px;
            cursor:pointer;
        "
    >

        Cetak / Print

    </button>

    <button
        onclick="window.close()"
        style="
            padding:8px 18px;
            margin-left:5px;
            cursor:pointer;
        "
    >

        Tutup

    </button>

</div>


<script>

    window.addEventListener('load', function () {

        window.print();

    });

</script>

</body>

</html>