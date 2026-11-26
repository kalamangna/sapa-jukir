<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Laporan Setoran Petugas
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 25px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #111827;
            background: #ffffff;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            text-align: left;
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
            box-shadow: 0 0 0 2px #111827;
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

        .header h1 {
            margin: 0 0 5px;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 0 0 5px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .header p {
            margin: 3px 0;
            color: #4b5563;
            font-size: 11px;
        }

        .line {
            border-top: 2px solid #111827;
            margin: 15px 0 20px;
        }

        .filter {
            margin-bottom: 15px;
        }

        .filter table {
            width: 100%;
            border-collapse: collapse;
        }

        .filter td {
            padding: 3px 8px 3px 0;
            vertical-align: top;
        }

        .filter .label {
            width: 130px;
            font-weight: 700;
        }

        .summary {
            margin-bottom: 20px;
        }

        .summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary td {
            width: 25%;
            border: 1px solid #d1d5db;
            padding: 8px;
            vertical-align: top;
        }

        .summary-label {
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .summary-value {
            font-size: 14px;
            font-weight: 700;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: visible;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #9ca3af;
            padding: 6px 5px;
            vertical-align: middle;
            text-align: center;
        }

        .data-table th {
            background: #f3f4f6;
            font-weight: 700;
            text-align: center;
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

        .status {
            font-weight: 700;
        }

        .status-terverifikasi {
            color: #15803d;
        }

        .status-ditolak {
            color: #b91c1c;
        }

        .status-belum {
            color: #a16207;
        }

        .footer {
            margin-top: 25px;
        }

        .footer table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer td {
            width: 50%;
            vertical-align: top;
        }

        .signature {
            text-align: center;
            margin-top: 10px;
        }

        .signature-space {
            height: 70px;
        }

        .print-button {
            margin-bottom: 20px;
            text-align: right;
        }

        .print-button button {
            border: 0;
            background: #2563eb;
            color: white;
            padding: 9px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }

        @media print {

            @page {
                size: A4 landscape;
                margin: 12mm;
            }

            body {
                padding: 0;
                font-size: 10px;
            }

            .print-button {
                display: none;
            }

            .container {
                max-width: none;
            }

            .header h1 {
                font-size: 18px;
            }

            .header h2 {
                font-size: 14px;
            }

            .summary-value {
                font-size: 12px;
            }

            .data-table th,
            .data-table td {
                padding: 4px;
            }

        }

    </style>

</head>


<body>

<div class="container">


    {{-- ======================================================
        BUTTON CETAK
    ======================================================= --}}

    <div class="print-button">

        <button onclick="window.print()">

            🖨 Cetak Laporan

        </button>

    </div>


    {{-- ======================================================
        HEADER
    ======================================================= --}}

    @include('admin.laporan.partials.header-kop')

    <div class="report-title" style="text-align:center; margin: 0 0 12px; font-weight:700; font-size:14px; text-transform:uppercase;">
        LAPORAN SETORAN PETUGAS
    </div>


    <div class="line"></div>


    {{-- ======================================================
        FILTER YANG DIGUNAKAN
    ======================================================= --}}

    @if(
        $search ||
        $jukirId ||
        $titikParkirId ||
        $status ||
        $tanggalMulai ||
        $tanggalSelesai
    )

        <div class="filter">

            <table>

                @if($search)

                    <tr>

                        <td class="label">
                            Pencarian
                        </td>

                        <td>
                            {{ $search }}
                        </td>

                    </tr>

                @endif


                @if($jukirId)

                    @php
                        $jukirFilter = \App\Models\Jukir::find($jukirId);
                    @endphp

                    <tr>

                        <td class="label">
                            Petugas
                        </td>

                        <td>

                            @if($jukirFilter)

                                {{ $jukirFilter->kode_jukir }}
                                -
                                {{ $jukirFilter->nama }}

                            @else

                                -

                            @endif

                        </td>

                    </tr>

                @endif


                @if($titikParkirId)

                    @php
                        $titikFilter = \App\Models\TitikParkir::find($titikParkirId);
                    @endphp

                    <tr>

                        <td class="label">
                            Titik Parkir
                        </td>

                        <td>

                            @if($titikFilter)

                                {{ $titikFilter->kode_titik }}
                                -
                                {{ $titikFilter->nama }}

                            @else

                                -

                            @endif

                        </td>

                    </tr>

                @endif


                @if($status)

                    <tr>

                        <td class="label">
                            Status
                        </td>

                        <td>

                            @if($status === 'terverifikasi')

                                Terverifikasi

                            @elseif($status === 'ditolak')

                                Ditolak

                            @elseif($status === 'belum_verifikasi')

                                Belum Verifikasi

                            @else

                                {{ ucfirst(str_replace('_', ' ', $status)) }}

                            @endif

                        </td>

                    </tr>

                @endif


                @if($tanggalMulai)

                    <tr>

                        <td class="label">
                            Tanggal Mulai
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($tanggalMulai)->locale('id')->translatedFormat('d F Y') }}
                        </td>

                    </tr>

                @endif


                @if($tanggalSelesai)

                    <tr>

                        <td class="label">
                            Tanggal Selesai
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($tanggalSelesai)->locale('id')->translatedFormat('d F Y') }}
                        </td>

                    </tr>

                @endif

            </table>

        </div>

    @endif


    {{-- ======================================================
        RINGKASAN
    ======================================================= --}}

    <div class="summary">

        <table>

            <tr>

                <td>

                    <div class="summary-label">
                        TOTAL DATA SETORAN
                    </div>

                    <div class="summary-value">
                        {{ number_format($setorans->count(), 0, ',', '.') }}
                    </div>

                </td>


                <td>

                    <div class="summary-label">
                        PENDAPATAN BRUTO
                    </div>

                    <div class="summary-value">
                        Rp {{ number_format($setorans->sum('pendapatan_bruto'), 0, ',', '.') }}
                    </div>

                </td>


                <td>

                    <div class="summary-label">
                        JUMLAH SETORAN
                    </div>

                    <div class="summary-value">
                        Rp {{ number_format($setorans->sum('jumlah_setoran'), 0, ',', '.') }}
                    </div>

                </td>


                <td>

                    <div class="summary-label">
                        TOTAL SELISIH
                    </div>

                    <div class="summary-value">
                        Rp {{ number_format($setorans->sum('selisih'), 0, ',', '.') }}
                    </div>

                </td>

            </tr>

        </table>

    </div>


    {{-- ======================================================
        TABEL DATA
    ======================================================= --}}

    <div class="table-wrapper">

        <table class="data-table">

            <thead>

                <tr>

                    <th style="width:4%;">
                        No
                    </th>

                    <th style="width:9%;">
                        Tanggal
                    </th>

                    <th style="width:17%;">
                        Petugas
                    </th>

                    <th style="width:17%;">
                        Titik Parkir
                    </th>

                    <th style="width:13%;">
                        Pendapatan Bruto
                    </th>

                    <th style="width:13%;">
                        Jumlah Setoran
                    </th>

                    <th style="width:11%;">
                        Selisih
                    </th>

                    <th style="width:10%;">
                        Status
                    </th>

                    <th style="width:6%;">
                        Verifikator
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($setorans as $index => $setoran)

                    <tr>

                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>


                        <td class="text-center nowrap">

                            {{ \Carbon\Carbon::parse($setoran->tanggal)->format('d/m/Y') }}

                        </td>


                        <td>

                            @if($setoran->jukir)

                                <strong>
                                    {{ $setoran->jukir->nama }}
                                </strong>

                                <br>

                                <small>
                                    {{ $setoran->jukir->kode_jukir }}
                                </small>

                            @else

                                -

                            @endif

                        </td>


                        <td>

                            @if($setoran->titikParkir)

                                <strong>
                                    {{ $setoran->titikParkir->nama }}
                                </strong>

                                <br>

                                <small>
                                    {{ $setoran->titikParkir->kode_titik }}
                                </small>

                            @else

                                -

                            @endif

                        </td>


                        <td class="text-right nowrap">

                            Rp
                            {{ number_format($setoran->pendapatan_bruto, 0, ',', '.') }}

                        </td>


                        <td class="text-right nowrap">

                            Rp
                            {{ number_format($setoran->jumlah_setoran, 0, ',', '.') }}

                        </td>


                        <td class="text-right nowrap">

                            Rp
                            {{ number_format($setoran->selisih, 0, ',', '.') }}

                        </td>


                        <td class="text-center status">

                            @if($setoran->status === 'terverifikasi')

                                <span class="status-terverifikasi">
                                    Terverifikasi
                                </span>

                            @elseif($setoran->status === 'ditolak')

                                <span class="status-ditolak">
                                    Ditolak
                                </span>

                            @else

                                <span class="status-belum">
                                    Belum Verifikasi
                                </span>

                            @endif

                        </td>


                        <td class="text-center">

                            @if($setoran->diverifikasiOleh)

                                {{ $setoran->diverifikasiOleh->name }}

                            @else

                                -

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="9"
                            class="text-center"
                        >

                            Tidak ada data setoran.

                        </td>

                    </tr>

                @endforelse

            </tbody>


            @if($setorans->count() > 0)

                <tfoot>

                    <tr>

                        <th colspan="4" class="text-right">
                            TOTAL
                        </th>

                        <th class="text-right">

                            Rp
                            {{ number_format($setorans->sum('pendapatan_bruto'), 0, ',', '.') }}

                        </th>

                        <th class="text-right">

                            Rp
                            {{ number_format($setorans->sum('jumlah_setoran'), 0, ',', '.') }}

                        </th>

                        <th class="text-right">

                            Rp
                            {{ number_format($setorans->sum('selisih'), 0, ',', '.') }}

                        </th>

                        <th colspan="2"></th>

                    </tr>

                </tfoot>

            @endif

        </table>

    </div>


    {{-- ======================================================
        FOOTER / TANDA TANGAN
    ======================================================= --}}

    <div class="footer">

        <table>

            <tr>

                <td>

                    <div class="signature">

                        <p>
                            Mengetahui,
                        </p>

                        <p>
                            Kepala/Penanggung Jawab
                        </p>

                        <div class="signature-space"></div>

                        <strong>
                            __________________________
                        </strong>

                    </div>

                </td>


                <td>

                    <div class="signature">

                        <p>
                            Sinjai,
                            {{ now()->translatedFormat('d F Y') }}
                        </p>

                        <p>
                            Petugas/Pengelola
                        </p>

                        <div class="signature-space"></div>

                        <strong>
                            __________________________
                        </strong>

                    </div>

                </td>

            </tr>

        </table>

    </div>


</div>


</body>

</html>