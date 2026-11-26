# Fitur Filter Tanggal - Capaian Target Harian Petugas

## 📋 Deskripsi Fitur
Menambahkan kemampuan filter tanggal pada card "Capaian Target Harian Petugas" di halaman dashboard admin, sehingga admin dapat melihat capaian petugas dari hari-hari sebelumnya, bukan hanya hari ini.

## ✨ Fitur Yang Ditambahkan

### 1. **Kontrol Filter Tanggal**
- Input date picker untuk memilih tanggal
- Tombol "Filter" untuk menerapkan filter
- Tombol "Reset" untuk kembali ke hari ini
- Validasi: tanggal tidak boleh melebihi hari ini

### 2. **Perubahan Data Dinamis**
- Data capaian, target, dan realisasi petugas akan berubah sesuai tanggal yang dipilih
- Grafik dan tabel akan otomatis update dengan data dari tanggal pilihan
- Statistik "Tercapai", "Belum tercapai", dan "Tanpa target" akan dihitung ulang

### 3. **UI/UX Improvements**
- Filter form ditempatkan di bawah header card untuk kemudahan akses
- Tampilan responsive untuk berbagai ukuran layar
- Indikasi tanggal yang sedang ditampilkan di subtitle

## 🔧 Perubahan Teknis

### File yang Dimodifikasi:
1. **`app/Http/Controllers/Admin/DashboardController.php`**
   - Import `Illuminate\Http\Request`
   - Tambah parameter `Request $request` pada method `index()`
   - Tambah logic untuk parse tanggal dari query parameter
   - Query setoran menggunakan `$tanggalFilter` bukan hardcoded `today()`
   - Pass `$tanggalFilter` ke view

2. **`resources/views/admin/dashboard.blade.php`**
   - Update subtitle untuk menampilkan tanggal filter yang aktif
   - Tambah form filter dengan date input
   - Form submit ke `route('admin.dashboard')` dengan parameter `tanggal`
   - Styling menggunakan Bootstrap classes yang konsisten dengan tema

## 📐 Implementasi Detail

### DashboardController.php
```php
// Get date from request, default to today
$tanggalFilter = $request->query('tanggal') 
    ? \Carbon\Carbon::parse($request->query('tanggal'))->toDateString() 
    : today()->toDateString();

// Query menggunakan tanggal yang difilter
$setoranHariIniPerPetugas = Setoran::query()
    ->where('status', 'terverifikasi')
    ->whereDate('tanggal', $tanggalFilter)  // ← Menggunakan filter
    ->whereNotNull('jukir_id')
    ->selectRaw('jukir_id, SUM(jumlah_setoran) AS total')
    ->groupBy('jukir_id')
    ->pluck('total', 'jukir_id');
```

### dashboard.blade.php
```blade
{{-- Subtitle menampilkan tanggal yang sedang ditampilkan --}}
<small class="text-muted">
    Perbandingan target titik/objek pendapatan dan penerimaan 
    untuk tanggal {{ \Carbon\Carbon::parse($tanggalFilter)->format('d/m/Y') }}.
</small>

{{-- Form Filter Tanggal --}}
<form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex gap-2 align-items-end flex-wrap">
    <div class="flex-grow-1" style="min-width: 250px;">
        <label for="tanggalFilter" class="form-label fw-semibold mb-2">Filter Tanggal</label>
        <input 
            type="date" 
            id="tanggalFilter" 
            name="tanggal" 
            class="form-control" 
            value="{{ $tanggalFilter }}"
            max="{{ now()->toDateString() }}"
        >
    </div>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-search me-1"></i>Filter
    </button>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-clockwise me-1"></i>Reset
    </a>
</form>
```

## 🎯 Cara Penggunaan

1. **Akses Dashboard Admin**
   - Login sebagai admin atau pimpinan
   - Navigasi ke halaman Dashboard

2. **Gunakan Filter Tanggal**
   - Scroll ke section "Capaian Target Harian Petugas"
   - Klik field "Filter Tanggal"
   - Pilih tanggal yang ingin dilihat (hanya tanggal sebelumnya atau hari ini)
   - Klik tombol "Filter"

3. **Lihat Hasil**
   - Card akan menampilkan data untuk tanggal yang dipilih
   - Grafik bar chart akan update dengan data baru
   - Tabel "Petugas Belum Mencapai Target" akan update

4. **Reset ke Hari Ini**
   - Klik tombol "Reset" untuk kembali ke data hari ini

## 💾 Catatan Database

- Data yang ditampilkan adalah dari setoran dengan status "terverifikasi"
- Sistem menggunakan `whereDate()` untuk perbandingan tanggal yang akurat
- Target harian dihitung dari `potensi_harian` di lokasi parkir
- Realisasi dihitung dari `jumlah_setoran` per petugas

## ✅ Testing Checklist

- ✅ Filter tanggal dapat diklik dan memilih tanggal
- ✅ Data berubah sesuai tanggal yang dipilih
- ✅ Tombol Reset kembali ke hari ini
- ✅ Grafik update dengan data baru
- ✅ Tabel update dengan data baru
- ✅ Subtitle menampilkan tanggal yang benar
- ✅ Tidak ada error di console
- ✅ Responsive di berbagai ukuran layar

## 🚀 Future Enhancements

Fitur tambahan yang bisa dikembangkan ke depan:
- [ ] Filter range tanggal (dari - sampai)
- [ ] Export data ke PDF/Excel
- [ ] Perbandingan data antar tanggal
- [ ] Menyimpan preferensi filter terakhir
- [ ] Notifikasi untuk capaian di atas/di bawah target

---

**Dibuat untuk**: Sistem Informasi Jukir Kabupaten Sinjai (SIJUKIR)  
**Tanggal**: 2026-09-01  
**Status**: ✅ Selesai dan siap implementasi
