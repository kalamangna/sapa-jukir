# Fitur Multiple Regu/Koordinator per Lokasi

## 📋 Deskripsi Fitur
Mengubah sistem penempatan petugas untuk memungkinkan lokasi dengan target tinggi memiliki **2 koordinator/regu**, namun tetap dengan **1 target harian yang sama** (target tidak dihitung 2x).

## ✨ Perubahan Yang Dilakukan

### 1. Database Migration
**File**: `database/migrations/2026_09_01_234028_add_jumlah_koordinator_to_titik_parkir.php`

Menambahkan field ke table `titik_parkirs`:
```sql
jumlah_koordinator tinyInteger (default: 1)
```

- Default: 1 (backward compatible dengan sistem lama)
- Max: 2 koordinator per lokasi
- Min: 1 koordinator per lokasi

### 2. Model Updates

**File**: `app/Models/TitikParkir.php`
- Tambah `jumlah_koordinator` ke `fillable` array

### 3. Validasi Permintaan (Form Request)

**File**: `app/Http/Requests/StorePenempatanJukirRequest.php`
- Ubah logika validasi dari `exists()` menjadi `count()`
- Bandingkan jumlah koordinator aktif terhadap `$titikParkir->jumlah_koordinator`
- Izinkan multiple koordinator sesuai dengan konfigurasi
- Error message menampilkan jumlah koordinator saat ini dan max yang diperbolehkan

**File**: `app/Http/Requests/UpdatePenempatanJukirRequest.php`
- Update dengan logika yang sama, mengecualikan record yang sedang di-edit

### 4. Validasi Data Titik Parkir

**File**: `app/Http/Requests/StoreTitikParkirRequest.php`
- Tambah rule: `'jumlah_koordinator' => ['required', 'integer', 'in:1,2']`

**File**: `app/Http/Requests/UpdateTitikParkirRequest.php`
- Inherit dari StoreTitikParkirRequest (otomatis mendapat validasi)

### 5. Interface Pengguna

**File**: `resources/views/admin/titik-parkir/create.blade.php`
- Tambah field select untuk `jumlah_koordinator`
- Options: 1 Regu atau 2 Regu
- Deskripsi: "Untuk lokasi dengan target tinggi, pilih 2 regu. Target harian tetap sama."
- Badge "Baru" untuk menunjukkan ini field baru

**File**: `resources/views/admin/titik-parkir/edit.blade.php`
- Tambah field yang sama dengan nilai dari database

## 🔧 Implementasi Detail

### Alur Kerja

1. **Admin membuat/edit Titik Parkir**
   ```
   - Pilih "1 Regu (1 Koordinator)" → max 1 koordinator aktif per periode
   - Pilih "2 Regu (2 Koordinator)" → max 2 koordinator aktif per periode
   - Target harian tetap SAMA (tidak dihitung 2x)
   ```

2. **Admin melakukan penempatan petugas dengan role "koordinator"**
   ```
   - Sistem cek: sudah ada berapa koordinator aktif di lokasi ini?
   - Jika sudah = jumlah_koordinator → TOLAK penempatan baru
   - Jika < jumlah_koordinator → TERIMA penempatan baru
   ```

3. **Perhitungan Capaian Harian**
   ```
   - Target masih dihitung sekali per lokasi
   - Realisasi = SUM(jumlah_setoran) dari semua koordinator di lokasi
   - Status capaian tetap 1 per lokasi (bukan per regu)
   ```

### Kode Validasi Sebelum (Lama)

```php
if ($this->input('role') === 'koordinator') {
    $coordinatorExists = PenempatanJukir::query()
        ->where('status', 'aktif')
        ->where('titik_parkir_id', $this->integer('titik_parkir_id'))
        ->where('role', 'koordinator')
        ->whereDate('tanggal_mulai', '<=', $end?->toDateString() ?? '9999-12-31')
        ->where(function ($query) use ($start) {
            $query->whereNull('tanggal_selesai')
                ->orWhereDate('tanggal_selesai', '>=', $start->toDateString());
        })
        ->exists(); // ← HANYA CEK EXISTS (0 atau 1+)

    if ($coordinatorExists) {
        $validator->errors()->add('role', '...');
    }
}
```

### Kode Validasi Setelah (Baru)

```php
if ($this->input('role') === 'koordinator') {
    $titikParkir = \App\Models\TitikParkir::find($this->integer('titik_parkir_id'));
    $maxKoordinator = $titikParkir ? $titikParkir->jumlah_koordinator : 1;

    // Count active coordinators
    $activeCoordinators = PenempatanJukir::query()
        ->where('status', 'aktif')
        ->where('titik_parkir_id', $this->integer('titik_parkir_id'))
        ->where('role', 'koordinator')
        ->whereDate('tanggal_mulai', '<=', $end?->toDateString() ?? '9999-12-31')
        ->where(function ($query) use ($start) {
            $query->whereNull('tanggal_selesai')
                ->orWhereDate('tanggal_selesai', '>=', $start->toDateString());
        })
        ->count(); // ← COUNT jumlah pasti

    if ($activeCoordinators >= $maxKoordinator) {
        $validator->errors()->add(
            'role',
            "Sudah ada {$activeCoordinators} koordinator aktif... (max: {$maxKoordinator})."
        );
    }
}
```

## 📊 Contoh Skenario

### Lokasi A: Pasar Sentral (Target Tinggi = Rp 500.000)
```
Konfigurasi: jumlah_koordinator = 2
Target harian: Rp 500.000 (TETAP SATU)

Penempatan:
1. Koordinator A - 01/09/2026 s/d 30/09/2026 ✅ (1 dari 2 slot)
2. Koordinator B - 15/09/2026 s/d 30/09/2026 ✅ (2 dari 2 slot)
3. Koordinator C - 20/09/2026 s/d 30/09/2026 ❌ (sudah penuh 2 slot)

Perhitungan Capaian:
- Target: Rp 500.000
- Realisasi: Rp 150.000 (dari A) + Rp 180.000 (dari B) = Rp 330.000
- Capaian: 66%
- Status Lokasi: Belum Tercapai (SATU status untuk satu lokasi, bukan per regu)
```

### Lokasi B: Tepi Pantai (Target Rendah = Rp 100.000)
```
Konfigurasi: jumlah_koordinator = 1
Target harian: Rp 100.000

Penempatan:
1. Koordinator X - 01/09/2026 s/d 30/09/2026 ✅ (1 dari 1 slot)
2. Koordinator Y - 15/09/2026 s/d 30/09/2026 ❌ (sudah penuh 1 slot)

Perhitungan Capaian:
- Target: Rp 100.000
- Realisasi: Rp 150.000 (dari X)
- Capaian: 150%
- Status Lokasi: Tercapai
```

## ✅ Fitur Terkait Yang TETAP SAMA

- ✅ Target per lokasi: TIDAK BERUBAH (tetap 1 target)
- ✅ Perhitungan capaian bulanan: TIDAK BERUBAH
- ✅ Sistem ranking pendapatan: TIDAK BERUBAH
- ✅ Reporting dan laporan: TIDAK BERUBAH (hanya agregasi per lokasi)
- ✅ Dashboard capaian harian: OTOMATIS UPDATE (menghitung seluruh koordinator)

## 🧪 Testing Checklist

- [ ] Buat lokasi parkir baru dengan jumlah_koordinator = 1
- [ ] Edit lokasi parkir existing, ubah jumlah_koordinator = 2
- [ ] Coba assign 1 koordinator ke lokasi → BERHASIL
- [ ] Coba assign koordinator ke-2 (jika max=2) → BERHASIL
- [ ] Coba assign koordinator ke-3 → GAGAL dengan pesan error tepat
- [ ] Lihat dashboard capaian harian → data terkombinasi semua koordinator
- [ ] Edit penempatan koordinator → validasi tetap jalan
- [ ] Batalkan penempatan koordinator 1 dari 2 → slot menjadi tersedia
- [ ] Cek database field: semua lokasi punya nilai jumlah_koordinator

## 📝 Catatan Penting

1. **Backward Compatibility**: Semua lokasi existing otomatis punya `jumlah_koordinator = 1` (default), jadi tidak ada perubahan behavior
2. **Target Tidak Dihitung 2x**: Target harian di dashboard/laporan tetap per lokasi, bukan per regu
3. **Data Setorans**: Tetap terikat ke individual petugas (jukir_id), bukan ke regu
4. **Validation**: Dilakukan saat CREATE/UPDATE penempatan, bukan di dashboard

## 🚀 Future Enhancement

Fitur tambahan yang bisa dikembangkan:
- [ ] Assign target per regu/koordinator (jika diperlukan)
- [ ] Rotating schedule untuk 2 regu (shift A pagi, shift B sore)
- [ ] Performance analytics per regu
- [ ] Bonus/insentif berdasarkan kinerja regu

---

**Dibuat untuk**: Sistem Informasi Jukir Kabupaten Sinjai (SIJUKIR)  
**Tanggal**: 2026-09-01  
**Status**: ✅ Selesai dan siap testing
