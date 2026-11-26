# Analisis Referensi Target Harian & Target Bulanan di SIJUKIR

## 📊 Arsitektur Target Sistem

Ada **2 layer target** yang berbeda dalam sistem SIJUKIR:

```
┌─────────────────────────────────────────────────────────────┐
│                        LAYER TARGET                          │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  1. TARGET HARIAN (Daily Target)                             │
│     ├─ Sumber: potensi_harian dari TitikParkir/ObjekPendapatan
│     ├─ Digunakan untuk: Monitoring capaian harian petugas     │
│     ├─ Level: Per lokasi/objek                               │
│     ├─ Diatur di: Admin → Titik Parkir / Objek Pendapatan    │
│     └─ Ditampilkan: Dashboard Capaian Target Harian Petugas  │
│                                                               │
│  2. TARGET BULANAN (Monthly Target)                          │
│     ├─ Sumber: Table TargetPendapatan                        │
│     ├─ Digunakan untuk: Monitoring capaian bulanan           │
│     ├─ Level: Global/Per Sumber/Per Titik/Per Objek         │
│     ├─ Diatur di: Admin → Target Pendapatan                  │
│     └─ Ditampilkan: Dashboard Bulanan, Laporan              │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

## 🎯 TARGET HARIAN (Potensi Harian)

### Sumber Data

```
TitikParkir (titik_parkirs)
├── potensi_harian    [decimal:15,2] ← TARGET HARIAN PER LOKASI
└── potensi_bulanan   [decimal:15,2]

ObjekPendapatan (objek_pendapatans)
├── potensi_harian    [decimal:15,2] ← TARGET HARIAN PER OBJEK
└── potensi_bulanan   [decimal:15,2]
```

### Bagaimana Target Harian Digunakan

**1. Di Dashboard (Capaian Target Harian Petugas)**

```php
// File: app/Http/Controllers/Admin/DashboardController.php (line 188-189)

$target = $petugas->penempatanJukirs
    ->sum(fn ($penempatan) => 
        (float) ($penempatan->titikParkir?->potensi_harian ?? 0)
    );

// Artinya:
// Target = SUM(potensi_harian) dari semua lokasi yang ditugaskan
```

**Contoh:**
```
Petugas A ditugaskan di:
  - Lokasi 1: potensi_harian = Rp 150.000
  - Lokasi 2: potensi_harian = Rp 200.000
  ─────────────────────────────
  Target Harian Petugas A = Rp 350.000

Realisasi Petugas A hari ini = Rp 325.000
Capaian = (325.000 / 350.000) × 100 = 92.86% ✅ Tercapai
```

**2. Di Penempatan Jukir**

```php
// Field: target_per_hari di table penempatan_jukirs (nullable)
// Ini adalah override manual untuk target per penempatan
// Jika ada nilai, bisa digunakan sebagai target alternatif
```

**3. Di Laporan Titik Parkir**

```blade
// Menampilkan potensi_harian untuk setiap lokasi
@foreach($titikParkirs as $titikParkir)
    {{ $titikParkir->potensi_harian }}
@endforeach
```

### Flow Kalkulasi Target Harian

```
Admin Input
    ↓
Titik Parkir / Objek Pendapatan
    ├── potensi_harian = Rp 500.000
    └── potensi_bulanan = Rp 15.000.000 (500.000 × 30 hari)
    ↓
Penempatan Jukir (assignment petugas ke lokasi)
    ├── Petugas A → Lokasi 1 (potensi_harian = 500.000)
    └── Petugas B → Lokasi 2 (potensi_harian = 300.000)
    ↓
Dashboard Capaian Harian
    └── Target = 500.000 (untuk Petugas A) / 300.000 (untuk Petugas B)
```

## 📅 TARGET BULANAN

### Sumber Data

```
TargetPendapatan (target_pendapatans) - Table Master
├── sumber_pemasukan_id   [nullable] → Target global per sumber
├── titik_parkir_id       [nullable] → Target per lokasi
├── objek_pendapatan_id   [nullable] → Target per objek
├── tahun                 [integer]
├── bulan                 [integer]
├── target                [decimal:15,2] ← NILAI TARGET BULANAN
└── catatan               [text]

Struktur:
┌─────────────────────────────────────────────────┐
│ Target Bulanan Bisa di Level:                   │
├─────────────────────────────────────────────────┤
│ 1. GLOBAL (per Sumber Pemasukan)                │
│    sumber_pemasukan_id = 1 (Parkir Mobil)       │
│    titik_parkir_id = NULL                       │
│    objek_pendapatan_id = NULL                   │
│    Target = Rp 15.000.000 (total semua lokasi)  │
│                                                  │
│ 2. PER LOKASI (titik parkir)                    │
│    sumber_pemasukan_id = 1                      │
│    titik_parkir_id = 5 (Lokasi ABC)             │
│    objek_pendapatan_id = NULL                   │
│    Target = Rp 500.000 (spesifik lokasi)        │
│                                                  │
│ 3. PER OBJEK (tempat usaha)                     │
│    sumber_pemasukan_id = 2 (Pajak Usaha)        │
│    titik_parkir_id = NULL                       │
│    objek_pendapatan_id = 3 (Toko ABC)           │
│    Target = Rp 2.000.000 (spesifik objek)       │
└─────────────────────────────────────────────────┘
```

### Bagaimana Target Bulanan Digunakan

**1. Di Dashboard (Bulanan)**

```php
// File: app/Http/Controllers/Admin/DashboardController.php (line 221-242)

$targetBulanDashboard = TargetPendapatan::query()
    ->where('tahun', $tahunDashboard)
    ->where('bulan', $bulanDashboard)  // FILTER BULAN BERJALAN
    ->get(['sumber_pemasukan_id', 'titik_parkir_id', 
           'objek_pendapatan_id', 'target']);

$targetPerSumber = $targetBulanDashboard
    ->groupBy('sumber_pemasukan_id')
    ->map(function ($targets) {
        // Prioritas: jika ada target spesifik (per titik/objek), gunakan itu
        // Jika tidak ada, gunakan target global
        $memilikiTargetObjek = $targets->contains(
            fn ($target) => $target->titik_parkir_id !== null 
                         || $target->objek_pendapatan_id !== null
        );

        return (float) $targets
            ->filter(fn ($target) => 
                $memilikiTargetObjek
                    ? $target->titik_parkir_id !== null 
                      || $target->objek_pendapatan_id !== null
                    : $target->titik_parkir_id === null 
                      && $target->objek_pendapatan_id === null
            )
            ->sum('target');
    });

// Hasil: Target per Sumber Pemasukan untuk bulan ini
// Contoh: Parkir Mobil = Rp 15.000.000, Pajak Usaha = Rp 5.000.000
```

**2. Di Laporan**

```php
// File: app/Http/Controllers/Admin/LaporanController.php
// Menggunakan TargetPendapatan untuk filter bulan/tahun tertentu
```

**3. Di Grafik Tren Pendapatan**

```php
// File: app/Http/Controllers/Admin/DashboardController.php (line 126-137)
// Menampilkan target bulanan dalam grafik tren tahunan

$targetTrenDashboard = collect(range(1, 12))->map(function ($bulan) {
    $targets = $targetTrenDashboard->get($bulan, collect());
    // ... logic untuk aggregate target per bulan
});
```

### Flow Kalkulasi Target Bulanan

```
Admin Input (Target Pendapatan)
    ↓
[Tahun] [Bulan] [Sumber/Titik/Objek] [Nilai Target]
  2026     09      Parkir Mobil      Rp 15.000.000
  2026     09      Lokasi A          Rp 500.000
  2026     09      Lokasi B          Rp 300.000
    ↓
Dashboard Bulanan
├── Tampilkan: Target bulan berjalan (September)
├── Ambil: TargetPendapatan WHERE tahun=2026 AND bulan=9
├── Group: Per sumber pemasukan
└── Hitung: Target vs Realisasi (dari Setoran terverifikasi)
    ↓
Persentase Capaian Bulanan
└── % = (Realisasi / Target) × 100
```

## 🔗 Relasi Target Harian vs Target Bulanan

### Relationship Diagram

```
                         ┌─────────────────────┐
                         │  TitikParkir        │
                         ├─────────────────────┤
                         │ potensi_harian  ←── TARGET HARIAN
                         │ potensi_bulanan     │
                         └─────────────────────┘
                                 │
                                 │ hasMany
                                 ↓
                         ┌─────────────────────┐
                         │ PenempatanJukir     │
                         ├─────────────────────┤
                         │ jukir_id            │
                         │ titik_parkir_id     │ (reference)
                         │ target_per_hari     │
                         │ status = 'aktif'    │
                         └─────────────────────┘
                                 │
                    ╔════════════╩═════════════╗
                    ↓                         ↓
            ┌──────────────────┐    ┌──────────────────┐
            │ Dashboard Harian │    │ Setoran (daily)  │
            │ (capaian per     │    │ (realisasi)      │
            │  petugas hari    │    └──────────────────┘
            │  ini)            │
            └──────────────────┘

        ─────────────────────────────────────────────────

            ┌─────────────────────┐
            │ TargetPendapatan    │
            ├─────────────────────┤
            │ tahun = 2026        │
            │ bulan = 1-12        │
            │ target (bulanan) ←──── TARGET BULANAN
            │ sumber_id           │
            │ titik_id (opt)      │
            │ objek_id (opt)      │
            └─────────────────────┘
                     │
        ╔════════════╩═════════════╗
        ↓                         ↓
┌──────────────────┐    ┌──────────────────┐
│ Dashboard Bulanan│    │ Setoran(monthly) │
│ (capaian per     │    │ (realisasi)      │
│  sumber/bulan)   │    └──────────────────┘
└──────────────────┘
```

### Perbedaan Utama

| Aspek | Target Harian | Target Bulanan |
|-------|---------------|----------------|
| **Sumber Data** | `potensi_harian` dari TitikParkir/ObjekPendapatan | Table `TargetPendapatan` |
| **Level Detail** | Per lokasi/objek | Global/Per sumber/Per titik/Per objek |
| **Waktu** | Setiap hari | Per bulan (Januari-Desember) |
| **Diatur Di** | Edit Titik Parkir/Objek | Menu Target Pendapatan |
| **Digunakan Untuk** | Monitor capaian harian petugas | Monitor capaian bulanan sumber |
| **Realisasi Dari** | Setoran dengan jukir_id | Setoran dengan sumber_pemasukan_id |
| **Update Otomatis?** | Tidak (manual input potensi) | Tidak (manual input target) |
| **Bisa Berbeda?** | Ya, per lokasi bisa berbeda | Ya, sesuai konfigurasi |
| **Prioritas** | Semua level dipakai | Jika ada yang spesifik, gunakan itu |

## 📍 Di Mana Target Digunakan

### Target Harian - Digunakan Di:

```
1. Dashboard → Capaian Target Harian Petugas
   Lokasi: resources/views/admin/dashboard.blade.php (line 574+)
   
2. Laporan → Titik Parkir
   Lokasi: resources/views/admin/laporan/titik-parkir/
   
3. Penempatan Jukir (optional override)
   Lokasi: app/Models/PenempatanJukir.php (field target_per_hari)
   
4. Halaman Publik - Show Titik Parkir
   Lokasi: resources/views/public/titik-parkir/show.blade.php
```

### Target Bulanan - Digunakan Di:

```
1. Dashboard → Target & Capaian Bulanan (cards)
   Lokasi: resources/views/admin/dashboard.blade.php (line ~230)
   
2. Dashboard → Grafik Tren Pendapatan (monthly)
   Lokasi: resources/views/admin/dashboard.blade.php
   
3. Menu Target Pendapatan (CRUD)
   Lokasi: app/Http/Controllers/Admin/TargetPendapatanController.php
   
4. Laporan Komprehensif
   Lokasi: app/Http/Controllers/Admin/LaporanController.php
   
5. Peringatan Capaian (warning jika < 80%)
   Lokasi: resources/views/admin/dashboard.blade.php (line ~625)
```

## 🔍 Contoh Query References

### Mengambil Target Harian

```php
// Method 1: Via Penempatan Petugas
$petugas = Jukir::with('penempatanJukirs.titikParkir')->find($id);
$targetHarian = $petugas->penempatanJukirs
    ->sum(fn ($p) => $p->titikParkir?->potensi_harian ?? 0);

// Method 2: Via Lokasi Langsung
$lokasi = TitikParkir::find($id);
$targetHarian = $lokasi->potensi_harian;

// Method 3: Via ObjekPendapatan
$objek = ObjekPendapatan::find($id);
$targetHarian = $objek->potensi_harian;
```

### Mengambil Target Bulanan

```php
// Method 1: Per Sumber Pemasukan
$targets = TargetPendapatan::where('tahun', 2026)
    ->where('bulan', 9)
    ->where('sumber_pemasukan_id', $id)
    ->get();

// Method 2: Per Lokasi
$targets = TargetPendapatan::where('tahun', 2026)
    ->where('bulan', 9)
    ->where('titik_parkir_id', $id)
    ->get();

// Method 3: Global (aggregate)
$targetGlobal = TargetPendapatan::where('tahun', 2026)
    ->where('bulan', 9)
    ->whereNull('titik_parkir_id')
    ->whereNull('objek_pendapatan_id')
    ->sum('target');
```

## 📋 Summary Struktur

### Database Tables

| Table | Kolom Target | Tipe Target | Catatan |
|-------|--------------|------------|---------|
| `titik_parkirs` | potensi_harian | Daily | Per lokasi parkir |
| `titik_parkirs` | potensi_bulanan | Monthly | Kalkulasi otomatis |
| `objek_pendapatans` | potensi_harian | Daily | Per objek/tempat usaha |
| `objek_pendapatans` | potensi_bulanan | Monthly | Kalkulasi otomatis |
| `penempatan_jukirs` | target_per_hari | Daily (optional) | Override manual |
| `target_pendapatans` | target | Monthly | Master data |

### Kalkulasi Otomatis

```php
// Dari: app/Services/PotentialCalculationService.php (line 32)
// Potensi bulanan biasanya = potensi_harian × 30
$monthly = $daily * 30;
$daily = $monthly / 30;
```

---

**Kesimpulan**: Sistem SIJUKIR menggunakan 2 jenis target yang terpisah:
- **Target Harian** = Potensi dari lokasi/objek (untuk monitor petugas setiap hari)
- **Target Bulanan** = Data master di TargetPendapatan (untuk monitor capaian bulanan)
