# Ringkasan PR Sijukir

## 1. PR title
Sijukir Dishub Blueprint Alignment: parking-first scope, tax-domain cleanup, and access/reporting consistency

## 2. PR description final

### Summary
This PR aligns the Sijukir project with the Dishub blueprint by narrowing the scope to parking operations and related revenue management, while removing legacy tax-domain logic that is outside the authority of Dishub.

### What changed
- removed legacy Pajak Parkir and Wajib Pajak references from routes, controllers, views, and validation
- cleaned revenue object rules to support only Dishub-appropriate object types
- restricted master-data access to admin while keeping dashboard and operational flows open to admin, operator, and pimpinan
- kept support modules such as asset utilization and unit business management separated from the core parking flow
- aligned dashboard and reporting logic with verified operational data
- preserved audit logging and operational integrity checks

### Scope definition
In scope:
- parking master data
- parking operational flow
- revenue source and object management relevant to Dishub
- target, achievement, and reporting for parking operations
- asset utilization and support structures related to public service operations

Out of scope:
- Wajib Pajak
- Pajak Parkir
- tax object management
- tax identity / NOP / NPWP workflows
- any business logic outside Dishub authority

### Verification
- validated with relevant feature tests covering access control and revenue integrity
- passing result: 30 passed, 100 assertions

---

## 3. Checklist pengerjaan tim per modul

### A. Core: Master Parkir
- [ ] jenis parkir terdefinisi dengan benar
- [ ] titik parkir terhubung ke sumber pemasukan yang valid
- [ ] tarif parkir siap dipakai pada proses operasional
- [ ] jukir dan jenis jukir terkelola dengan benar
- [ ] penempatan jukir memiliki validasi overlap dan status aktif

### B. Core: Operasional Parkir
- [ ] okupansi parkir dapat dicatat dengan validasi kapasitas
- [ ] setoran dibuat tanpa konteks pajak
- [ ] verifikasi setoran berjalan dengan status yang konsisten
- [ ] tagihan dibuat untuk pendapatan yang relevan
- [ ] pembayaran dan sisa tagihan tercatat dengan benar

### C. Core: Pendapatan & Target
- [ ] sumber pemasukan terbatas pada kode yang sesuai blueprint
- [ ] objek pendapatan hanya menggunakan tipe yang diperbolehkan
- [ ] target pendapatan terhubung ke objek yang valid
- [ ] capaian bulanan dapat disimpan dan diaudit

### D. Core: Laporan & Dashboard
- [ ] dashboard memakai data operasional yang terverifikasi
- [ ] laporan pendapatan relevan dengan kondisi Dishub
- [ ] laporan setoran dan titik parkir konsisten
- [ ] peringatan capaian dan pengaduan terdokumentasi

### E. Support: Aset & Pemanfaatan
- [ ] aset daerah terdefinisi dengan status operasional jelas
- [ ] area aset terhubung ke aset daerah dengan benar
- [ ] pemanfaatan aset dapat dikonfirmasi dan didukung tagihan bila perlu

### F. Support: Unit Usaha
- [ ] unit usaha terkait dengan objek pendapatan yang valid
- [ ] data historis unit usaha tercatat dengan benar

### G. Governance & Audit
- [ ] akses admin, operator, pimpinan sesuai kebijakan
- [ ] master data terbatas admin
- [ ] semua entitas penting tercatat di audit log
- [ ] tidak ada route, view, atau controller yang merujuk ke pajak parkir / wajib pajak

---

## 4. Daftar commit breakdown yang rapi untuk merge

### Commit 1 — Scope cleanup and blueprint alignment
- remove legacy Pajak Parkir references
- remove Wajib Pajak-related fields and routes
- update object validation to Dishub-appropriate scope

### Commit 2 — Route and access alignment
- fix admin vs operational role grouping
- keep dashboard and operations accessible to intended roles
- restrict master-data access to admin only

### Commit 3 — Dashboard and reporting cleanup
- align reporting metrics with verified setoran data
- remove tax-based indicators and labels
- update public and admin views to reflect valid domain

### Commit 4 — Support module separation
- keep asset utilization and unit business support modules separate from core parking flow
- ensure support data remains non-tax and operationally relevant

### Commit 5 — Verification and documentation
- add final blueprint documentation
- update PR summary and module checklist
- finalize validation and release notes

---

## 5. Suggested merge order
1. Scope cleanup
2. Access alignment
3. Dashboard/reporting cleanup
4. Support module adjustments
5. Documentation and final verification

This order keeps the project stable while preserving the intended blueprint semantics and minimizing risky regressions.
