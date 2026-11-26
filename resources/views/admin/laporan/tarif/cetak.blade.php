<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Laporan Tarif Parkir - SAPA JUKIR Sinjai
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #111827;
            background: #ffffff;
            font-size: 12px;
        }

        .container {
            width: 100%;
            padding: 20px 25px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            text-align: left;
            margin-bottom: 18px;
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
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 4px 0 0;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 10px;
            color: #4b5563;
        }

        .line {
            border-top: 2px solid #111827;
            margin-top: 12px;
            margin-bottom: 3px;
        }

        .line-thin {
            border-top: 1px solid #111827;
            margin-bottom: 15px;
        }

        .filter-info {
            margin-bottom: 15px;
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

        .filter-info td:first-child {
            font-weight: 600;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #374151;
            padding: 7px 6px;
            vertical-align: middle;
            text-align: center;
        }

        .report-table th {
            background: #f3f4f6;
            text-align: center;
            font-weight: 700;
            font-size: 10px;
        }

        .report-table td {
            font-size: 10.5px;
        }

        .report-table .no {
            width: 5%;
            text-align: center;
        }

        .report-table .jenis-parkir {
            width: 18%;
        }

        .report-table .kendaraan {
            width: 17%;
        }

        .report-table .nominal {
            width: 16%;
            text-align: center;
        }

        .report-table .mulai {
            width: 14%;
            text-align: center;
        }

        .report-table .sampai {
            width: 14%;
            text-align: center;
        }

        .report-table .status {
            width: 16%;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: center;
        }

        .status-aktif {
            color: #166534;
            font-weight: 700;
        }

        .status-tidak-aktif {
            color: #991b1b;
            font-weight: 700;
        }

        .summary {
            margin-top: 15px;
            width: 100%;
        }

        .summary-box {
            border: 1px solid #374151;
            padding: 8px 10px;
            display: inline-block;
            min-width: 180px;
            margin-right: 8px;
        }

        .summary-label {
            font-size: 9px;
            color: #4b5563;
        }

        .summary-value {
            margin-top: 3px;
            font-size: 13px;
            font-weight: 700;
        }

        .footer {
            margin-top: 30px;
            width: 100%;
        }

        .footer-date {
            text-align: right;
            margin-bottom: 35px;
            font-size: 11px;
        }

        .footer-signature {
            width: 250px;
            margin-left: auto;
            text-align: center;
            font-size: 11px;
        }

        .footer-signature .space {
            height: 55px;
        }

        .footer-signature .name {
            font-weight: 700;
            text-decoration: underline;
        }

        .empty {
            text-align: center;
            padding: 20px !important;
            color: #6b7280;
        }

        @page {
            size: A4 portrait;
            margin: 12mm;
        }

        @media print {

            body {
                background: white;
            }

            .container {
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .report-table {
                page-break-inside: auto;
            }

            .report-table tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            .report-table thead {
                display: table-header-group;
            }

        }

    </style>

</head>


<body>

<div class="container">


    {{-- =========================================================
        HEADER LAPORAN
    ========================================================== --}}

    @include('admin.laporan.partials.header-kop')

    <div class="report-title" style="text-align:center; margin: -8px 0 12px; font-weight:700; font-size:14px; text-transform:uppercase;">
        LAPORAN TARIF RETRIBUSI
    </div>

    <div class="line"></div>

    <div class="line-thin"></div>


    {{-- =========================================================
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
                        : {{ $search }}
                    </td>

                </tr>

            @endif


            @if($jenisParkirId)

                <tr>

                    <td>
                        Jenis Parkir
                    </td>

                    <td>
                        :
                        {{ optional(
                            \App\Models\JenisParkir::find($jenisParkirId)
                        )->nama ?? '-' }}
                    </td>

                </tr>

            @endif


            @if($status !== null && $status !== '')

                <tr>

                    <td>
                        Status
                    </td>

                    <td>
                        :
                        {{ $status === '1' ? 'Aktif' : 'Tidak Aktif' }}
                    </td>

                </tr>

            @endif

            @if(!$search && !$jenisParkirId && ($status === null || $status === ''))

                <tr>

                    <td>
                        Filter
                    </td>

                    <td>
                        : Semua Data
                    </td>

                </tr>

            @endif

            <tr>

                <td>
                    Tanggal Cetak
                </td>

                <td>
                    :
                    {{ now()->translatedFormat('d F Y') }}
                </td>

            </tr>

        </table>

    </div>


    {{-- =========================================================
        TABEL
    ========================================================== --}}

    <table class="report-table">

        <thead>

            <tr>

                <th class="no">
                    No
                </th>

                <th class="jenis-parkir">
                    Jenis Parkir
                </th>

                <th class="kendaraan">
                    Jenis Kendaraan
                </th>

                <th class="nominal">
                    Nominal
                </th>

                <th class="mulai">
                    Berlaku Mulai
                </th>

                <th class="sampai">
                    Berlaku Sampai
                </th>

                <th class="status">
                    Status
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($tarifs as $tarif)

                <tr>

                    {{-- NO --}}

                    <td class="no">
                        {{ $loop->iteration }}
                    </td>


                    {{-- JENIS PARKIR --}}

                    <td>
                        {{ $tarif->jenisParkir->nama ?? '-' }}
                    </td>


                    {{-- JENIS KENDARAAN --}}

                    <td>

                        {{ $tarif->jenis_kendaraan ?? '-' }}

                        @if($tarif->keterangan)

                            <br>

                            <small style="color:#6b7280;">
                                {{ $tarif->keterangan }}
                            </small>

                        @endif

                    </td>


                    {{-- NOMINAL --}}

                    <td class="nominal">

                        Rp
                        {{ number_format(
                            (float) $tarif->nominal,
                            0,
                            ',',
                            '.'
                        ) }}

                    </td>


                    {{-- BERLAKU MULAI --}}

                    <td class="mulai">

                        {{ $tarif->berlaku_mulai
                            ? $tarif->berlaku_mulai->translatedFormat('d M Y')
                            : '-' }}

                    </td>


                    {{-- BERLAKU SAMPAI --}}

                    <td class="sampai">

                        {{ $tarif->berlaku_sampai
                            ? $tarif->berlaku_sampai->translatedFormat('d M Y')
                            : '-' }}

                    </td>


                    {{-- STATUS --}}

                    <td class="status">

                        @if($tarif->status)

                            <span class="status-aktif">
                                AKTIF
                            </span>

                        @else

                            <span class="status-tidak-aktif">
                                TIDAK AKTIF
                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" class="empty">

                        Tidak terdapat data tarif berdasarkan filter yang dipilih.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- =========================================================
        RINGKASAN
    ========================================================== --}}

    <div class="summary">

        <div class="summary-box">

            <div class="summary-label">
                TOTAL DATA TARIF
            </div>

            <div class="summary-value">
                {{ $tarifs->count() }}
            </div>

        </div>

    </div>


    {{-- =========================================================
        FOOTER / TANDA TANGAN
    ========================================================== --}}

    <div class="footer">

        <div class="footer-date">

            Sinjai,
            {{ now()->translatedFormat('d F Y') }}

        </div>


        <div class="footer-signature">

            <div>
                Mengetahui,
            </div>

            <div>
                Administrator SAPA JUKIR
            </div>

            <div class="space"></div>

            <div class="name">
                __________________________
            </div>

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