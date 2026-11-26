# Blueprint Final Proyek Sijukir Dishub

## 1. Tujuan proyek

Proyek Sijukir difokuskan pada pengelolaan pendapatan dan operasional parkir di lingkungan Dishub. Fokus utama adalah pengelolaan parkir, penerimaan, verifikasi, dan laporan operasional, dengan dukungan modul pendukung yang tidak mengganggu inti parkir.

## 2. Prinsip ruang lingkup

### A. Core / inti
- Parkir sebagai domain utama
- Pendapatan parkir sebagai sumber penerimaan utama
- Pengelolaan titik parkir, jenis parkir, penempatan jukir, okupansi, tarif, setoran, verifikasi, dan laporan
- Audit trail dan kontrol akses yang jelas

### B. Support / pendukung
- Pengelolaan aset daerah dan pemanfaatan area
- Unit usaha / kawasan usaha yang berkaitan dengan pendapatan non-parkir terikat pada objek pendapatan
- Capaian bulanan, target pendapatan, tagihan, dan laporan pendukung

### C. Out of scope
- Wajib Pajak
- Pajak Parkir
- objek_pajak
- NPWP, NOP, tarif pajak, dan logika pajak parkir
- aturan bisnis yang tidak sesuai dengan wewenang Dishub

## 3. Modul final: Core vs Support

### Core modules
1. Master parkir
   - JenisParkir
   - TitikParkir
   - Tarif
   - Jukir
   - JenisJukir
   - PenempatanJukir

2. Operasional parkir
   - OkupansiParkir
   - Setoran
   - Verifikasi setoran
   - Tagihan
   - Pembayaran

3. Pendapatan dan target
   - SumberPemasukan
   - ObjekPendapatan
   - TargetPendapatan
   - CapaianBulanan

4. Laporan dan monitoring
   - Dashboard
   - Laporan pendapatan
   - Laporan setoran
   - Laporan titik parkir
   - Laporan penempatan jukir
   - PeringatanCapaian
   - Pengaduan

5. Administrasi dan keamanan
   - User management
   - AuditLog
   - Role-based access control
   - Sambutan / informasi publik
   - Gallery / dokumentasi publik

### Support modules
1. Aset daerah dan pemanfaatan area
   - AsetDaerah
   - AreaAset
   - PemanfaatanAset

2. Unit usaha pendukung
   - UnitUsaha
   - UnitUsahaHistory

3. Modul pendapatan non-parkir berbasis objek usaha
   - ObjekPendapatan tipe: tempat_usaha, aset_daerah, parkir_khusus

## 4. Aturan final tiap modul

### A. Parkir (core)
- Harus menjadi fokus utama halaman admin dan dashboard
- Semua indikator utama menggunakan data parkir dan setoran yang terverifikasi
- Sumber pendapatan parkir dibatasi pada kode yang relevan dengan parkir dan bukan pajak

### B. Objek pendapatan
- Hanya menerima tipe yang sesuai dengan kebutuhan Dishub
- Tipe valid: tempat_usaha, aset_daerah, parkir_khusus
- Tidak mengizinkan field pajak dan wajib pajak

### C. Aset daerah
- Diperbolehkan sebagai pendukung operasional dan pemanfaatan area
- Harus terpisah jelas dari domain parkir utama
- Pemanfaatan area dipetakan melalui PemanfaatanAset, bukan melalui logika pajak

### D. Laporan
- Menampilkan data yang relevan untuk parkir dan penerimaan Dishub
- Tidak memuat indikator fiskal di luar kewenangan Dishub

### E. Audit & akses
- Semua entitas penting harus tercatat di AuditLog
- Dashboard dan operasional diperuntukkan untuk admin, operator, dan pimpinan
- Master data hanya untuk admin

## 5. Checklist implementasi per modul

### Core module checklist
- [ ] Master jenis parkir lengkap dan valid
- [ ] Master titik parkir lengkap dan terhubung ke sumber pendapatan yang sah
- [ ] Master jukir dan penempatan jukir sesuai jadwal dan overlap guard
- [ ] Tarif parkir berhasil dipakai dalam perhitungan dan laporan
- [ ] Okupansi parkir menyimpan data harian dan validasi kapasitas
- [ ] Setoran dapat dibuat dari sumber yang relevan tanpa konteks pajak
- [ ] Verifikasi setoran hanya dilakukan pada data yang masuk akal
- [ ] Tagihan dan pembayaran berjalan untuk pendapatan yang relevan
- [ ] Dashboard hanya menampilkan realisasi terverifikasi
- [ ] Laporan pendapatan, setoran, dan titik parkir sesuai data operasional
- [ ] Peringatan capaian dan pengaduan terdokumentasi dengan baik

### Support module checklist
- [ ] Aset daerah dan area aset dapat dibuat dengan status utilitas yang jelas
- [ ] Pemanfaatan aset terhubung ke area aset dan tagihan yang relevan
- [ ] Unit usaha berelasi dengan objek pendapatan yang benar
- [ ] Data unit usaha tidak mencampurkan domain fiskal pajak
- [ ] Target pendapatan tetap terkait objek pendapatan yang benar

### Governance checklist
- [ ] Semua entitas penting menggunakan audit logging
- [ ] Role access sesuai blueprint
- [ ] Tidak ada route, blade, atau controller yang mengarah ke pajak parkir / wajib pajak
- [ ] Semua label dan copywriting menggunakan istilah Dishub yang benar
- [ ] Data migration dan seed tidak lagi berisi kode P-PARKIR atau entitas wajib pajak

## 6. Blueprint final untuk commit / PR

### A. Scope statement
Project Sijukir focuses on Dishub-managed parking revenue operations and related reporting. It excludes tax collection and taxpayer management as these are outside the authority of Dishub.

### B. In-scope summary
- Parking management
- Revenue source and object management for relevant Dishub activities
- Operational reporting and verification
- Support modules for assets and utilization

### C. Out-of-scope summary
- Wajib Pajak
- Pajak Parkir
- Taxpayer registration and tax object management
- Tax calculation flows and tax identity validation

### D. PR title suggestion
Sijukir Dishub Blueprint Alignment: Scope parking-first, remove tax domain, align access and reporting

### E. PR description suggestion
- align project scope to Dishub parking domain
- remove legacy tax and taxpayer logic
- keep support modules separated from core parking flow
- enforce role-based access for admin, operator, and pimpinan
- verify revenue integrity and reporting against blueprint

## 7. Status akhir

Blueprint ini merupakan versi final acuan untuk commit/PR saat ini. Semua pembersihan yang diperlukan untuk scope Dishub telah diterapkan dan diverifikasi melalui pengujian relevan.
