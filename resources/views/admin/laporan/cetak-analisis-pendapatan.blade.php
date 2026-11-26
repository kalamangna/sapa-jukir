<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Pendapatan {{ sprintf('%02d/%d', $bulan, $tahun) }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 24px; color: #111827; font: 12px Arial, sans-serif; }
        .container { max-width: 1100px; margin: 0 auto; }
        header { display: flex; align-items: center; justify-content: center; gap: 14px; border-bottom: 2px solid #111827; margin-bottom: 18px; padding-bottom: 12px; text-align: left; }
        .kop-badge {
            width: 62px;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            border-radius: 50%;
            box-shadow: 0 0 0 2px #111827;
            background: #fff;
        }
        .kop-badge img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .header-text { text-align: center; }
        h1 { margin: 0 0 6px; font-size: 15px; text-transform: uppercase; }
        h2 { margin: 0; font-size: 12px; font-weight: 700; text-transform: uppercase; }
        .report-subhead { margin: 4px 0 0; font-size: 10px; }
        h3 { border-bottom: 1px solid #9ca3af; margin: 22px 0 8px; padding-bottom: 5px; font-size: 14px; }
        .meta { margin: 0 0 16px; text-align: center; }
        .summary, table { width: 100%; border-collapse: collapse; }
        .summary td { border: 1px solid #9ca3af; padding: 8px; width: 25%; }
        .label { color: #4b5563; display: block; font-size: 10px; margin-bottom: 4px; }
        .value { font-size: 14px; font-weight: 700; }
        th, td { border: 1px solid #9ca3af; padding: 6px; }
        th { background: #f3f4f6; text-align: center; }
        .right { text-align: center; }
        .footer { margin-top: 28px; text-align: right; }
        @media print { body { padding: 0; } .no-print { display: none; } h3 { break-after: avoid; } table { break-inside: avoid; } }
    </style>
</head>
<body>
<main class="container">
    @include('admin.laporan.partials.header-kop')
    <div style="text-align:center; margin: 0 0 12px; font-weight:700; font-size:14px; text-transform:uppercase;">LAPORAN REALISASI PENDAPATAN</div>
    <div style="text-align:center; margin: 0 0 18px; font-size:12px;">Periode {{ sprintf('%02d/%d', $bulan, $tahun) }}</div>
    <p class="meta">Realisasi dihitung dari setoran dengan status terverifikasi.</p>
    <table class="summary">
        <tr>
            <td><span class="label">TOTAL TARGET</span><span class="value">Rp {{ number_format($totalTarget, 0, ',', '.') }}</span></td>
            <td><span class="label">TOTAL REALISASI</span><span class="value">Rp {{ number_format($totalRealisasi, 0, ',', '.') }}</span></td>
            <td><span class="label">SELISIH</span><span class="value">Rp {{ number_format($totalSelisih, 0, ',', '.') }}</span></td>
            <td><span class="label">CAPAIAN</span><span class="value">{{ number_format($persentase, 2, ',', '.') }}%</span></td>
        </tr>
    </table>
    @foreach ([['judul' => 'Sumber Pendapatan', 'items' => $analisisSumber], ['judul' => 'Lokasi', 'items' => $analisisLokasi], ['judul' => 'Objek Pendapatan', 'items' => $analisisObjek]] as $bagian)
        <h3>Analisis per {{ $bagian['judul'] }}</h3>
        <table>
            <thead><tr><th>Nama</th><th class="right">Target</th><th class="right">Realisasi</th><th class="right">Selisih</th><th class="right">Capaian</th></tr></thead>
            <tbody>
            @forelse ($bagian['items'] as $item)
                <tr><td>{{ $item['nama'] }}</td><td class="right">Rp {{ number_format($item['target'], 0, ',', '.') }}</td><td class="right">Rp {{ number_format($item['realisasi'], 0, ',', '.') }}</td><td class="right">Rp {{ number_format($item['selisih'], 0, ',', '.') }}</td><td class="right">{{ number_format($item['persentase'], 2, ',', '.') }}%</td></tr>
            @empty
                <tr><td colspan="5">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    @endforeach
    <div class="footer">Dicetak pada {{ now()->format('d/m/Y H:i') }}</div>
</main>
</body>
</html>