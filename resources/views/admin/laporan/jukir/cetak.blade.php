<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Laporan Data Petugas - SAPA JUKIR Sinjai
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {

            margin: 0;

            padding: 25px;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            color: #000;

            font-size: 12px;

            background: #fff;

        }


        .kop {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            text-align: left;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
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

        .kop .instansi {
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop .nama {
            font-size: 18px;
            font-weight: bold;
            margin-top: 2px;
        }

        .kop .alamat {
            font-size: 11px;
            margin-top: 4px;
        }

        .judul {

            text-align: center;

            margin-bottom: 5px;

        }


        .judul h2 {

            margin: 0;

            font-size: 17px;

            text-transform: uppercase;

        }


        .judul p {

            margin: 5px 0 15px;

            font-size: 11px;

        }


        .filter-info {

            margin-bottom: 12px;

            font-size: 11px;

        }


        .filter-info table {

            width: auto;

            border-collapse: collapse;

        }


        .filter-info td {

            padding: 2px 8px 2px 0;

            vertical-align: top;

        }


        table.data {

            width: 100%;

            border-collapse: collapse;

        }


        table.data th,

        table.data td {

            border: 1px solid #000;

            padding: 6px 7px;

        }


        table.data th {

            background: #f2f2f2;

            text-align: center;

            font-weight: bold;

        }


        table.data td {

            vertical-align: middle;

            text-align: center;

        }


        .text-center {

            text-align: center;

        }


        .text-right {

            text-align: center;

        }


        .footer {

            margin-top: 25px;

            display: flex;

            justify-content: flex-end;

        }


        .tanggal {

            width: 250px;

            text-align: center;

        }


        .tanggal .tempat {

            margin-bottom: 50px;

        }


        .total {

            margin-top: 10px;

            font-weight: bold;

        }


        .no-print {

            margin-bottom: 20px;

        }


        .btn {

            display: inline-block;

            padding: 8px 14px;

            border: 1px solid #6c757d;

            border-radius: 4px;

            text-decoration: none;

            color: #000;

            background: #fff;

            cursor: pointer;

            font-size: 12px;

        }


        @media print {

            body {

                padding: 0;

            }


            .no-print {

                display: none !important;

            }


            @page {

                size: A4 portrait;

                margin: 15mm;

            }

        }

    </style>

</head>


<body>


{{-- ==========================================================
    TOMBOL
========================================================== --}}

<div class="no-print">

    <button
        type="button"
        class="btn"
        onclick="window.print()"
    >

        Cetak Laporan

    </button>


    <button
        type="button"
        class="btn"
        onclick="window.close()"
    >

        Tutup

    </button>

</div>


{{-- ==========================================================
    KOP LAPORAN RESMI
========================================================== --}}

@include('admin.laporan.partials.header-kop')

<div class="judul">
    <h2>LAPORAN DATA PETUGAS</h2>
    <p>Kabupaten Sinjai</p>
</div>


{{-- ==========================================================
    INFORMASI FILTER
========================================================== --}}

<div class="filter-info">

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


        @if($jenisJukirId)

            <tr>

                <td>
                    Jenis Petugas
                </td>

                <td>
                    :
                </td>

                <td>

                    @php

                        $jenis = \App\Models\JenisJukir::find($jenisJukirId);

                    @endphp

                    {{ $jenis?->kode }}
                    -
                    {{ $jenis?->nama }}

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

<table class="data">

    <thead>

        <tr>

            <th style="width:40px;">
                No.
            </th>

            <th style="width:110px;">
                Kode Petugas
            </th>

            <th>
                Nama
            </th>

            <th>
                Jenis Petugas
            </th>

            <th style="width:130px;">
                NIK
            </th>

            <th style="width:110px;">
                No. HP
            </th>

            <th style="width:70px;">
                Status
            </th>

        </tr>

    </thead>


    <tbody>

        @forelse($jukirs as $index => $jukir)

            <tr>

                <td class="text-center">
                    {{ $index + 1 }}
                </td>


                <td class="text-center">
                    {{ $jukir->kode_jukir }}
                </td>


                <td>
                    {{ $jukir->nama }}
                </td>


                <td>

                    @if($jukir->jenisJukir)

                        {{ $jukir->jenisJukir->kode }}
                        -
                        {{ $jukir->jenisJukir->nama }}

                    @else

                        -

                    @endif

                </td>


                <td class="text-center">

                    {{ $jukir->nik ?: '-' }}

                </td>


                <td class="text-center">

                    {{ $jukir->no_hp ?: '-' }}

                </td>


                <td class="text-center">

                    {{ ucfirst($jukir->status) }}

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="7"
                    class="text-center"
                >

                    Tidak ada data Petugas.

                </td>

            </tr>

        @endforelse

    </tbody>

</table>


{{-- ==========================================================
    TOTAL
========================================================== --}}

<div class="total">

    Total Data Petugas :
    {{ $jukirs->count() }}

</div>


{{-- ==========================================================
    TANDA TANGAN
========================================================== --}}

@php

    $bulanIndonesia = [
        1  => 'Januari',
        2  => 'Februari',
        3  => 'Maret',
        4  => 'April',
        5  => 'Mei',
        6  => 'Juni',
        7  => 'Juli',
        8  => 'Agustus',
        9  => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $tanggalSekarang = now();

@endphp


<div class="footer">

    <div class="tanggal">

        <div class="tempat">

            Sinjai,
            {{ $tanggalSekarang->day }}
            {{ $bulanIndonesia[$tanggalSekarang->month] }}
            {{ $tanggalSekarang->year }}

        </div>


        <div>
            Mengetahui,
        </div>


        <br><br><br><br>


        <strong>
            Administrator SAPA JUKIR
        </strong>

    </div>

</div>


</body>

</html>