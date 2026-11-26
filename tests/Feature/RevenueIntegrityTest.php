<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Tagihan;
use App\Models\Gallery;
use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class RevenueIntegrityTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_save_manual_monthly_achievement_and_audit_it(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.capaian-bulanan.store'), [
                'tahun' => 2026,
                'bulan' => 8,
                'target' => 900000,
                'realisasi' => 800000,
                'catatan' => 'Override capaian bulan berjalan',
            ])
            ->assertRedirect(route('admin.capaian-bulanan.index', ['tahun' => 2026]));

        $this->assertDatabaseHas('capaian_bulanans', [
            'tahun' => 2026,
            'bulan' => 8,
            'target' => 900000,
            'realisasi' => 800000,
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => 'App\\Models\\CapaianBulanan',
            'action' => 'created',
        ]);
    }

    public function test_revenue_index_shows_all_categories_by_default_and_filters_selected_category(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.titik-parkir.index'))
            ->assertOk()
            ->assertSee('Retribusi Pelayanan Parkir Tepi Jalan Umum')
            ->assertSee('Retribusi Penyediaan Tempat Kegiatan Usaha')
            ->assertSee('Retribusi Tempat Khusus Parkir')
            ->assertSee('Retribusi Sewa Pelataran Area Terminal untuk Kegiatan Tertentu');

        $this->actingAs($admin)
            ->get(route('admin.titik-parkir.index', ['kategori_retribusi' => 'R-PJTU']))
            ->assertOk()
            ->assertSee('R-PJTU')
            ->assertSee('Retribusi Pelayanan Parkir Tepi Jalan Umum');
    }

    public function test_terminal_retribution_code_alias_is_grouped_in_titik_parkir_index(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.titik-parkir.index'));

        $response->assertOk();
        $html = $response->getContent();

        $this->assertSame(1, substr_count($html, 'value="R-SPATKT"'));
        $this->assertStringNotContainsString('value="R-JASA-USAHA"', $html);
        $this->assertStringContainsString('Retribusi Sewa Pelataran Area Terminal untuk Kegiatan Tertentu', $html);

        $this->actingAs($admin)
            ->get(route('admin.titik-parkir.index', ['kategori_retribusi' => 'R-SPATKT']))
            ->assertOk()
            ->assertSee('Retribusi Sewa Pelataran Area Terminal untuk Kegiatan Tertentu');
    }

    public function test_add_setoran_form_does_not_show_revenue_object_field(): void
    {
        $operator = User::factory()->create([
            'role' => 'operator',
            'status' => 'aktif',
        ]);

        $this->actingAs($operator)
            ->get(route('admin.setoran.create'))
            ->assertOk()
            ->assertDontSee('Objek Usaha')
            ->assertDontSee('objek_pendapatan_id');
    }

    public function test_edit_setoran_form_does_not_show_revenue_object_field(): void
    {
        $operator = User::factory()->create([
            'role' => 'operator',
            'status' => 'aktif',
        ]);
        $setoranId = DB::table('setorans')->insertGetId([
            'sumber_pemasukan_id' => DB::table('sumber_pemasukans')->where('kode', 'R-TKU')->value('id'),
            'tanggal' => '2026-08-21',
            'pendapatan_bruto' => 100000,
            'jumlah_setoran' => 100000,
            'selisih' => 0,
            'status' => 'belum_verifikasi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($operator)
            ->get(route('admin.setoran.edit', $setoranId))
            ->assertOk()
            ->assertDontSee('Objek Usaha')
            ->assertDontSee('objek_pendapatan_id');
    }

    public function test_add_target_form_does_not_show_revenue_object_field(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.target-pendapatan.create'))
            ->assertOk()
            ->assertSee('Lokasi Sumber Pendapatan')
            ->assertSee('Pilih lokasi sumber pendapatan')
            ->assertDontSee('Lokasi Parkir')
            ->assertDontSee('Objek Usaha / Aset / Pajak')
            ->assertDontSee('objek_pendapatan_id');
    }

    public function test_public_home_counts_only_official_revenue_sources(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSeeInOrder(['Jenis Sumber Pendapatan', '4'])
            ->assertSee('href="' . route('skm') . '">SKM</a>', false);
    }

    public function test_public_skm_page_links_to_official_survey(): void
    {
        $this->get(route('skm'))
            ->assertOk()
            ->assertSee('Survei Kepuasan Masyarakat')
            ->assertSee('Isi Survei SKM')
            ->assertSee('href="https://skm.go.id/share/instansi/7cc2fe0e-ca0b-445f-a0cd-8003ee53ad83/1" target="_blank" rel="noopener noreferrer"', false);
    }

    public function test_public_news_page_lists_published_news_and_opens_details(): void
    {
        $news = News::create([
            'judul' => 'Kegiatan Pelayanan Terminal',
            'slug' => 'kegiatan-pelayanan-terminal',
            'kategori' => 'Sosialisasi',
            'ringkasan' => 'Petugas memberikan informasi pelayanan kepada masyarakat.',
            'konten' => 'Petugas memberikan informasi pelayanan kepada masyarakat.',
            'gambar' => 'news/berita-terminal.jpg',
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);
        News::create([
            'judul' => 'Berita yang tidak dipublikasikan',
            'slug' => 'berita-yang-tidak-dipublikasikan',
            'konten' => 'Konten internal.',
            'gambar' => 'news/rahasia.jpg',
            'is_published' => false,
        ]);

        $this->get(route('news.index'))
            ->assertOk()
            ->assertSee('Berita Terkini')
            ->assertSee('Kegiatan Pelayanan Terminal')
            ->assertSee(now()->subDay()->format('d'))
            ->assertDontSee('Berita yang tidak dipublikasikan')
            ->assertSee(route('news.show', $news));

        $this->get(route('news.show', $news))
            ->assertOk()
            ->assertSee('Kegiatan Pelayanan Terminal')
            ->assertSee('Petugas memberikan informasi pelayanan kepada masyarakat.')
            ->assertSee('news/berita-terminal.jpg')
            ->assertSee('Berita Terbaru');

        $this->get(route('news.show', 'berita-yang-tidak-dipublikasikan'))
            ->assertNotFound();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('href="' . route('news.index') . '">Berita</a>', false);
    }

    public function test_admin_can_create_news_and_manage_it_from_the_sidebar(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

        $this->actingAs($admin)
            ->get(route('admin.news.index'))
            ->assertOk()
            ->assertSee('Pengaturan Berita')
            ->assertSee(route('admin.news.create'));

        $this->actingAs($admin)
            ->post(route('admin.news.store'), [
                'judul' => 'Berita Baru Sinjai',
                'kategori' => 'Kegiatan',
                'ringkasan' => 'Ringkasan berita terbaru.',
                'konten' => 'Isi berita terbaru.',
                'is_published' => '1',
                'gambar' => UploadedFile::fake()->image('berita.jpg'),
            ])
            ->assertRedirect(route('admin.news.index'));

        $this->assertDatabaseHas('news', [
            'judul' => 'Berita Baru Sinjai',
            'slug' => 'berita-baru-sinjai',
            'is_published' => true,
        ]);
        Storage::disk('public')->assertExists(News::where('slug', 'berita-baru-sinjai')->value('gambar'));
    }

    public function test_non_operational_revenue_can_be_recorded_without_parkir_context(): void
    {
        $operator = User::factory()->create([
            'role' => 'operator',
            'status' => 'aktif',
        ]);
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-TKU')->value('id');
        $allocationId = DB::table('karcis_allocations')->insertGetId([
            'sumber_pemasukan_id' => $sourceId,
            'penerima' => 'Petugas UPTD',
            'jenis_karcis' => 'Retribusi tempat kegiatan usaha',
            'seri_prefix' => 'TKU-',
            'nomor_awal' => 1,
            'nomor_akhir' => 1,
            'lebar_nomor' => 1,
            'nilai_per_karcis' => 100000,
            'tanggal_penyerahan' => '2026-08-21',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($operator)
            ->post(route('admin.setoran.store'), [
                'sumber_pemasukan_id' => $sourceId,
                'tanggal' => '2026-08-21',
                'karcis_lines' => [
                    ['allocation_id' => $allocationId, 'nomor' => '1'],
                ],
                'pendapatan_bruto' => 100000,
                'jumlah_setoran' => 100000,
                'keterangan' => 'Setoran tempat kegiatan usaha',
            ])
            ->assertRedirect(route('admin.setoran.index'));

        $this->assertDatabaseHas('setorans', [
            'sumber_pemasukan_id' => $sourceId,
            'jukir_id' => null,
            'titik_parkir_id' => null,
            'status' => 'belum_verifikasi',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => 'App\\Models\\Setoran',
            'action' => 'created',
        ]);
    }

    public function test_setoran_calculates_gross_revenue_from_multiple_ticket_series(): void
    {
        $operator = User::factory()->create([
            'role' => 'operator',
            'status' => 'aktif',
        ]);
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-TKU')->value('id');
        $firstAllocationId = DB::table('karcis_allocations')->insertGetId([
            'sumber_pemasukan_id' => $sourceId,
            'penerima' => 'Petugas UPTD',
            'jenis_karcis' => 'Karcis kegiatan usaha',
            'seri_prefix' => 'TKU-A-',
            'nomor_awal' => 1,
            'nomor_akhir' => 5,
            'lebar_nomor' => 3,
            'nilai_per_karcis' => 10000,
            'tanggal_penyerahan' => '2026-08-21',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $secondAllocationId = DB::table('karcis_allocations')->insertGetId([
            'sumber_pemasukan_id' => $sourceId,
            'penerima' => 'Petugas UPTD',
            'jenis_karcis' => 'Karcis pelataran',
            'seri_prefix' => 'TKU-B-',
            'nomor_awal' => 1,
            'nomor_akhir' => 5,
            'lebar_nomor' => 3,
            'nilai_per_karcis' => 15000,
            'tanggal_penyerahan' => '2026-08-21',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($operator)
            ->post(route('admin.setoran.store'), [
                'sumber_pemasukan_id' => $sourceId,
                'tanggal' => '2026-08-21',
                'karcis_lines' => [
                    ['allocation_id' => $firstAllocationId, 'nomor' => '001-002'],
                    ['allocation_id' => $secondAllocationId, 'nomor' => '003'],
                ],
                'pendapatan_bruto' => 1,
                'jumlah_setoran' => 35000,
            ])
            ->assertRedirect(route('admin.setoran.index'));

        $setoran = DB::table('setorans')->latest('id')->first();
        $this->assertSame(35000, (int) $setoran->pendapatan_bruto);
        $this->assertSame(3, (int) $setoran->jumlah_karcis);
        $this->assertSame(3, DB::table('karcis_usages')->where('setoran_id', $setoran->id)->count());

        $this->actingAs($operator)
            ->get(route('admin.setoran.show', $setoran->id))
            ->assertOk()
            ->assertSee('TKU-A-001')
            ->assertSee('TKU-B-003');
    }

    public function test_overlapping_active_assignment_is_rejected(): void
    {
        $operator = User::factory()->create([
            'role' => 'operator',
            'status' => 'aktif',
        ]);
        $now = now();
        $kecamatanId = DB::table('kecamatans')->insertGetId([
            'kode' => 'KEC-TEST', 'nama' => 'Kecamatan Test', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $kelurahanId = DB::table('kelurahans')->insertGetId([
            'kecamatan_id' => $kecamatanId, 'kode' => 'KEL-TEST', 'nama' => 'Kelurahan Test', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $jenisJukirId = DB::table('jenis_jukirs')->insertGetId([
            'kode' => 'JJ-TEST', 'nama' => 'Jenis Test', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $jenisParkirId = DB::table('jenis_parkirs')->value('id');
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-PJTU')->value('id');
        $jukirId = DB::table('jukirs')->insertGetId([
            'kode_jukir' => 'JK-TEST', 'jenis_jukir_id' => $jenisJukirId, 'nik' => '1234567890123456',
            'nama' => 'Jukir Test', 'status' => 'aktif', 'created_at' => $now, 'updated_at' => $now,
        ]);
        $titikId = DB::table('titik_parkirs')->insertGetId([
            'kode_titik' => 'TP-TEST', 'nama' => 'Titik Test', 'alamat' => 'Alamat Test',
            'kecamatan_id' => $kecamatanId, 'kelurahan_id' => $kelurahanId, 'jenis_parkir_id' => $jenisParkirId,
            'sumber_pemasukan_id' => $sourceId, 'status' => 'aktif', 'created_at' => $now, 'updated_at' => $now,
        ]);

        $payload = [
            'jukir_id' => $jukirId,
            'titik_parkir_id' => $titikId,
            'role' => 'koordinator',
            'tanggal_mulai' => '2026-08-01',
            'tanggal_selesai' => '2026-08-31',
            'status' => 'aktif',
        ];

        $this->actingAs($operator)
            ->post(route('admin.penempatan-jukir.store'), $payload)
            ->assertRedirect(route('admin.penempatan-jukir.index'));

        $this->actingAs($operator)
            ->post(route('admin.penempatan-jukir.store'), $payload)
            ->assertSessionHasErrors('jukir_id');

        $this->assertDatabaseCount('penempatan_jukirs', 1);
        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => 'App\\Models\\PenempatanJukir',
            'action' => 'created',
        ]);
    }

    public function test_one_active_coordinator_per_location_and_multiple_members_are_allowed(): void
    {
        $operator = User::factory()->create([
            'role' => 'operator',
            'status' => 'aktif',
        ]);
        $now = now();
        $kecamatanId = DB::table('kecamatans')->insertGetId([
            'kode' => 'KEC-TEST-2', 'nama' => 'Kecamatan Test 2', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $kelurahanId = DB::table('kelurahans')->insertGetId([
            'kecamatan_id' => $kecamatanId, 'kode' => 'KEL-TEST-2', 'nama' => 'Kelurahan Test 2', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $jenisJukirId = DB::table('jenis_jukirs')->insertGetId([
            'kode' => 'JJ-TEST-2', 'nama' => 'Jenis Test 2', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $jenisParkirId = DB::table('jenis_parkirs')->value('id');
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-PJTU')->value('id');
        $coordinatorId = DB::table('jukirs')->insertGetId([
            'kode_jukir' => 'JK-COORD', 'jenis_jukir_id' => $jenisJukirId, 'nik' => '1234567890123457',
            'nama' => 'Koordinator Test', 'status' => 'aktif', 'created_at' => $now, 'updated_at' => $now,
        ]);
        $memberId = DB::table('jukirs')->insertGetId([
            'kode_jukir' => 'JK-ANGGOTA', 'jenis_jukir_id' => $jenisJukirId, 'nik' => '1234567890123458',
            'nama' => 'Anggota Test', 'status' => 'aktif', 'created_at' => $now, 'updated_at' => $now,
        ]);
        $titikId = DB::table('titik_parkirs')->insertGetId([
            'kode_titik' => 'TP-TEST-2', 'nama' => 'Titik Test 2', 'alamat' => 'Alamat Test 2',
            'kecamatan_id' => $kecamatanId, 'kelurahan_id' => $kelurahanId, 'jenis_parkir_id' => $jenisParkirId,
            'sumber_pemasukan_id' => $sourceId, 'status' => 'aktif', 'created_at' => $now, 'updated_at' => $now,
        ]);

        $this->actingAs($operator)
            ->post(route('admin.penempatan-jukir.store'), [
                'jukir_id' => $coordinatorId,
                'titik_parkir_id' => $titikId,
                'tanggal_mulai' => '2026-08-01',
                'status' => 'aktif',
                'role' => 'koordinator',
            ])
            ->assertRedirect(route('admin.penempatan-jukir.index'));

        $this->actingAs($operator)
            ->post(route('admin.penempatan-jukir.store'), [
                'jukir_id' => $memberId,
                'titik_parkir_id' => $titikId,
                'tanggal_mulai' => '2026-08-01',
                'status' => 'aktif',
                'role' => 'anggota',
            ])
            ->assertRedirect(route('admin.penempatan-jukir.index'));

        $this->actingAs($operator)
            ->from(route('admin.penempatan-jukir.create'))
            ->post(route('admin.penempatan-jukir.store'), [
                'jukir_id' => $memberId,
                'titik_parkir_id' => $titikId,
                'tanggal_mulai' => '2026-08-02',
                'status' => 'aktif',
                'role' => 'koordinator',
            ])
            ->assertSessionHasErrors('role');

        $this->assertDatabaseCount('penempatan_jukirs', 2);
    }

    public function test_titik_parkir_detail_shows_assignment_roster_with_role_target_and_schedule(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $now = now();
        $kecamatanId = DB::table('kecamatans')->insertGetId([
            'kode' => 'KEC-DETAIL', 'nama' => 'Kecamatan Detail', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $kelurahanId = DB::table('kelurahans')->insertGetId([
            'kecamatan_id' => $kecamatanId, 'kode' => 'KEL-DETAIL', 'nama' => 'Kelurahan Detail', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $jenisParkirId = DB::table('jenis_parkirs')->value('id');
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-PJTU')->value('id');
        $titikParkirId = DB::table('titik_parkirs')->insertGetId([
            'kode_titik' => 'TP-DETAIL', 'nama' => 'Titik Detail', 'alamat' => 'Alamat Detail',
            'kecamatan_id' => $kecamatanId, 'kelurahan_id' => $kelurahanId, 'jenis_parkir_id' => $jenisParkirId,
            'sumber_pemasukan_id' => $sourceId, 'status' => 'aktif', 'created_at' => $now, 'updated_at' => $now,
        ]);

        $koordinatorId = DB::table('jukirs')->insertGetId([
            'kode_jukir' => 'JK-KOOR', 'jenis_jukir_id' => DB::table('jenis_jukirs')->insertGetId([
                'kode' => 'JJ-DETAIL', 'nama' => 'Jenis Detail', 'status' => true,
                'created_at' => $now, 'updated_at' => $now,
            ]), 'nik' => '1234567890123459', 'nama' => 'Koordinator Detail', 'status' => 'aktif',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $memberId = DB::table('jukirs')->insertGetId([
            'kode_jukir' => 'JK-ANG', 'jenis_jukir_id' => DB::table('jenis_jukirs')->insertGetId([
                'kode' => 'JJ-DETAIL-2', 'nama' => 'Jenis Detail 2', 'status' => true,
                'created_at' => $now, 'updated_at' => $now,
            ]), 'nik' => '1234567890123460', 'nama' => 'Anggota Detail', 'status' => 'aktif',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        DB::table('penempatan_jukirs')->insert([
            [
                'jukir_id' => $koordinatorId,
                'titik_parkir_id' => $titikParkirId,
                'role' => 'koordinator',
                'target_per_hari' => 370000,
                'waktu_kerja' => '06.30 - 16.00 Wita',
                'tanggal_mulai' => '2026-08-01',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'jukir_id' => $memberId,
                'titik_parkir_id' => $titikParkirId,
                'role' => 'anggota',
                'target_per_hari' => 300000,
                'waktu_kerja' => '07.00 - 15.00 Wita',
                'tanggal_mulai' => '2026-08-01',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $this->actingAs($admin)
            ->get(route('admin.titik-parkir.show', $titikParkirId))
            ->assertOk()
            ->assertSee('Koordinator')
            ->assertSee('Anggota')
            ->assertSee('Target Per Hari')
            ->assertSee('Waktu Kerja')
            ->assertSee('Rp 370.000')
            ->assertSee('06.30 - 16.00 Wita');
    }

    public function test_target_is_taken_from_coordinator_for_all_staff_on_location(): void
    {
        $now = now();
        $kecamatanId = DB::table('kecamatans')->insertGetId([
            'kode' => 'KEC-TARGET-COORD', 'nama' => 'Kecamatan Target Coordinator', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $kelurahanId = DB::table('kelurahans')->insertGetId([
            'kecamatan_id' => $kecamatanId, 'kode' => 'KEL-TARGET-COORD', 'nama' => 'Kelurahan Target Coordinator', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $jenisParkirId = DB::table('jenis_parkirs')->value('id');
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-PJTU')->value('id');
        $titikParkirId = DB::table('titik_parkirs')->insertGetId([
            'kode_titik' => 'TP-TARGET-COORD', 'nama' => 'Titik Target Coordinator', 'alamat' => 'Alamat Target Coordinator',
            'kecamatan_id' => $kecamatanId, 'kelurahan_id' => $kelurahanId, 'jenis_parkir_id' => $jenisParkirId,
            'sumber_pemasukan_id' => $sourceId, 'status' => 'aktif', 'created_at' => $now, 'updated_at' => $now,
        ]);

        $koordinatorId = DB::table('jukirs')->insertGetId([
            'kode_jukir' => 'JK-TARGET-K', 'jenis_jukir_id' => DB::table('jenis_jukirs')->insertGetId([
                'kode' => 'JJ-TARGET-K', 'nama' => 'Jenis Target K', 'status' => true,
                'created_at' => $now, 'updated_at' => $now,
            ]), 'nik' => '1234567890123469', 'nama' => 'Koordinator Target', 'status' => 'aktif',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $memberId = DB::table('jukirs')->insertGetId([
            'kode_jukir' => 'JK-TARGET-A', 'jenis_jukir_id' => DB::table('jenis_jukirs')->insertGetId([
                'kode' => 'JJ-TARGET-A', 'nama' => 'Jenis Target A', 'status' => true,
                'created_at' => $now, 'updated_at' => $now,
            ]), 'nik' => '1234567890123470', 'nama' => 'Anggota Target', 'status' => 'aktif',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        DB::table('penempatan_jukirs')->insert([
            [
                'jukir_id' => $koordinatorId,
                'titik_parkir_id' => $titikParkirId,
                'role' => 'koordinator',
                'target_per_hari' => 370000,
                'waktu_kerja' => '06.30 - 16.00 Wita',
                'tanggal_mulai' => '2026-08-01',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'jukir_id' => $memberId,
                'titik_parkir_id' => $titikParkirId,
                'role' => 'anggota',
                'target_per_hari' => 150000,
                'waktu_kerja' => '07.00 - 15.00 Wita',
                'tanggal_mulai' => '2026-08-01',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $this->get(route('guest.titik-parkir.show', $titikParkirId))
            ->assertOk()
            ->assertSee('Rp 370.000')
            ->assertDontSee('Rp 150.000');
    }

    public function test_guest_titik_detail_shows_all_active_staff_with_role_target_and_schedule(): void
    {
        $now = now();
        $kecamatanId = DB::table('kecamatans')->insertGetId([
            'kode' => 'KEC-PUBLIC', 'nama' => 'Kecamatan Public', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $kelurahanId = DB::table('kelurahans')->insertGetId([
            'kecamatan_id' => $kecamatanId, 'kode' => 'KEL-PUBLIC', 'nama' => 'Kelurahan Public', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $jenisParkirId = DB::table('jenis_parkirs')->value('id');
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-PJTU')->value('id');
        $titikParkirId = DB::table('titik_parkirs')->insertGetId([
            'kode_titik' => 'TP-PUBLIC', 'nama' => 'Titik Public', 'alamat' => 'Alamat Public',
            'kecamatan_id' => $kecamatanId, 'kelurahan_id' => $kelurahanId, 'jenis_parkir_id' => $jenisParkirId,
            'sumber_pemasukan_id' => $sourceId, 'status' => 'aktif', 'created_at' => $now, 'updated_at' => $now,
        ]);

        $memberId = DB::table('jukirs')->insertGetId([
            'kode_jukir' => 'JK-PUB-A', 'jenis_jukir_id' => DB::table('jenis_jukirs')->insertGetId([
                'kode' => 'JJ-PUB-A', 'nama' => 'Jenis Public A', 'status' => true,
                'created_at' => $now, 'updated_at' => $now,
            ]), 'nik' => '1234567890123462', 'nama' => 'Anggota Public', 'status' => 'aktif',
            'foto' => 'jukir/foto/anggota-public.png',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $koordinatorId = DB::table('jukirs')->insertGetId([
            'kode_jukir' => 'JK-PUB-K', 'jenis_jukir_id' => DB::table('jenis_jukirs')->insertGetId([
                'kode' => 'JJ-PUB-K', 'nama' => 'Jenis Public K', 'status' => true,
                'created_at' => $now, 'updated_at' => $now,
            ]), 'nik' => '1234567890123461', 'nama' => 'Koordinator Public', 'status' => 'aktif',
            'foto' => 'jukir/foto/koordinator-public.png',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        DB::table('penempatan_jukirs')->insert([
            [
                'jukir_id' => $memberId,
                'titik_parkir_id' => $titikParkirId,
                'role' => 'anggota',
                'target_per_hari' => 300000,
                'waktu_kerja' => '07.00 - 15.00 Wita',
                'tanggal_mulai' => '2026-08-01',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'jukir_id' => $koordinatorId,
                'titik_parkir_id' => $titikParkirId,
                'role' => 'koordinator',
                'target_per_hari' => 370000,
                'waktu_kerja' => '06.30 - 16.00 Wita',
                'tanggal_mulai' => '2026-08-01',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $this->get(route('guest.titik-parkir.show', $titikParkirId))
            ->assertOk()
            ->assertSeeInOrder(['Koordinator Public', 'Anggota Public'])
            ->assertSee('Koordinator')
            ->assertSee('Anggota')
            ->assertSee('storage/jukir/foto/koordinator-public.png')
            ->assertSee('storage/jukir/foto/anggota-public.png')
            ->assertSee('Rp 370.000')
            ->assertSee('06.30 - 16.00 Wita');
    }

    public function test_target_rejects_object_from_another_revenue_source(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);
        $sourceObject = DB::table('sumber_pemasukans')->where('kode', 'R-TKU')->value('id');
        $sourceTarget = DB::table('sumber_pemasukans')->where('kode', 'R-PJTU')->value('id');
        $objekId = DB::table('objek_pendapatans')->insertGetId([
            'sumber_pemasukan_id' => $sourceObject,
            'kode' => 'OBJ-TEST',
            'nama' => 'Objek Test',
            'tipe' => 'tempat_usaha',
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($admin)
            ->post(route('admin.target-pendapatan.store'), [
                'sumber_pemasukan_id' => $sourceTarget,
                'objek_pendapatan_id' => $objekId,
                'tahun' => 2026,
                'bulan' => 8,
                'target' => 100000,
            ])
            ->assertSessionHasErrors('objek_pendapatan_id');

        $this->assertDatabaseMissing('target_pendapatans', [
            'objek_pendapatan_id' => $objekId,
            'tahun' => 2026,
            'bulan' => 8,
        ]);
    }

    public function test_object_requires_valid_source_and_tipe(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.objek-pendapatan.store'), [
                'kode' => 'OBJ-TEST',
                'nama' => 'Objek Test',
                'tipe' => 'objek_pajak',
                'status' => 'aktif',
            ])
            ->assertSessionHasErrors(['sumber_pemasukan_id', 'tipe']);

        $this->assertDatabaseMissing('objek_pendapatans', ['kode' => 'OBJ-TEST']);
    }

    public function test_duplicate_aggregate_target_period_is_rejected(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-PJTU')->value('id');

        $this->actingAs($admin)
            ->post(route('admin.target-pendapatan.store'), [
                'sumber_pemasukan_id' => $sourceId,
                'tahun' => 2026,
                'bulan' => 1,
                'target' => 100000,
            ])
            ->assertSessionHasErrors('bulan');

        $this->assertDatabaseCount('target_pendapatans', 48);
    }

    public function test_non_parking_revenue_points_use_unit_and_area_fields(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $kecamatanId = DB::table('kecamatans')->insertGetId([
            'kode' => 'KEC-TEST-2', 'nama' => 'Kecamatan Test 2', 'status' => true,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $kelurahanId = DB::table('kelurahans')->insertGetId([
            'kecamatan_id' => $kecamatanId, 'kode' => 'KEL-TEST-2', 'nama' => 'Kelurahan Test 2', 'status' => true,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-TKU')->value('id');
        $jenisParkirId = DB::table('jenis_parkirs')->value('id');

        DB::table('titik_parkirs')->insert([
            'kode_titik' => 'TP-USAHA-01',
            'nama' => 'Kios Terminal Test',
            'alamat' => 'Jl. Terminal Test',
            'kecamatan_id' => $kecamatanId,
            'kelurahan_id' => $kelurahanId,
            'jenis_parkir_id' => $jenisParkirId,
            'sumber_pemasukan_id' => $sourceId,
            'latitude' => -5.1333,
            'longitude' => 120.2500,
            'status' => 'aktif',
            'jumlah_unit' => 12,
            'luas_m2' => 240,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.titik-parkir.index'))
            ->assertOk()
            ->assertSee('Unit')
            ->assertSee('Luas')
            ->assertSee('12')
            ->assertSee('240');
    }

    public function test_non_parking_revenue_ignores_stale_parking_fields(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $kecamatanId = DB::table('kecamatans')->insertGetId([
            'kode' => 'KEC-BUSINESS', 'nama' => 'Kecamatan Bisnis', 'status' => true,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $kelurahanId = DB::table('kelurahans')->insertGetId([
            'kecamatan_id' => $kecamatanId, 'kode' => 'KEL-BUSINESS', 'nama' => 'Kelurahan Bisnis', 'status' => true,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-TKU')->value('id');
        $jenisParkirId = DB::table('jenis_parkirs')->value('id');

        $this->actingAs($admin)
            ->post(route('admin.titik-parkir.store'), [
                'kode_titik' => 'TP-USAHA-STALE',
                'nama' => 'Kios Terminal Stale',
                'alamat' => 'Jl. Terminal Bisnis',
                'kecamatan_id' => $kecamatanId,
                'kelurahan_id' => $kelurahanId,
                'jenis_parkir_id' => $jenisParkirId,
                'sumber_pemasukan_id' => $sourceId,
                'status' => 'aktif',
                'jumlah_unit' => 12,
                'luas_m2' => 240,
                'kapasitas_motor' => 15,
                'kapasitas_mobil_kecil' => 5,
                'kapasitas_total' => 25,
                'nama_pengelola' => 'Pengelola Kios',
            ])
            ->assertRedirect(route('admin.titik-parkir.index'));

        $this->assertDatabaseHas('titik_parkirs', [
            'kode_titik' => 'TP-USAHA-STALE',
            'sumber_pemasukan_id' => $sourceId,
            'jumlah_unit' => 12,
            'luas_m2' => 240,
        ]);
        $this->assertDatabaseHas('titik_parkirs', [
            'kode_titik' => 'TP-USAHA-STALE',
            'kapasitas_total' => null,
        ]);
    }

    public function test_business_source_form_does_not_show_parkir_specific_hint(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.titik-parkir.create'))
            ->assertOk()
            ->assertSee('Sumber Pendapatan')
            ->assertSee('Wajib diisi hanya untuk sumber pendapatan berbasis parkir.')
            ->assertDontSee('khusus sumber parkir');
    }

    public function test_dashboard_nominal_only_uses_verified_setoran(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        DB::table('setorans')->insert([
            'tanggal' => '2026-08-21',
            'pendapatan_bruto' => 900000,
            'jumlah_setoran' => 800000,
            'selisih' => 100000,
            'status' => 'belum_verifikasi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('setorans')->insert([
            'tanggal' => '2026-08-21',
            'pendapatan_bruto' => 400000,
            'jumlah_setoran' => 350000,
            'selisih' => 50000,
            'status' => 'terverifikasi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewHas('totalPendapatanBruto', 400000.0)
            ->assertViewHas('totalJumlahSetoran', 350000.0)
            ->assertViewHas('totalSelisih', 50000.0);
    }

    public function test_tagihan_supports_partial_payment_and_tracks_remaining_balance(): void
    {
        $operator = User::factory()->create(['role' => 'operator', 'status' => 'aktif']);
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-TKU')->value('id');

        $this->actingAs($operator)
            ->post(route('admin.tagihan.store'), [
                'sumber_pemasukan_id' => $sourceId,
                'nomor_tagihan' => 'TAG-TEST-001',
                'uraian' => 'Sewa unit usaha',
                'tanggal_terbit' => '2026-08-01',
                'tanggal_jatuh_tempo' => '2026-08-31',
                'nilai_tagihan' => 1000000,
            ])
            ->assertRedirect(route('admin.tagihan.index'));

        $tagihan = Tagihan::where('nomor_tagihan', 'TAG-TEST-001')->firstOrFail();
        $this->actingAs($operator)
            ->post(route('admin.tagihan.bayar', $tagihan), [
                'tanggal_bayar' => '2026-08-21',
                'jumlah_bayar' => 400000,
                'metode' => 'transfer',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('tagihans', ['id' => $tagihan->id, 'status' => 'sebagian']);
        $this->assertDatabaseHas('pembayarans', ['tagihan_id' => $tagihan->id, 'jumlah_bayar' => 400000]);
    }

    public function test_unit_usaha_can_be_registered_under_business_object(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-TKU')->value('id');
        $objectId = DB::table('objek_pendapatans')->insertGetId([
            'sumber_pemasukan_id' => $sourceId,
            'kode' => 'OBJ-UNIT-TEST',
            'nama' => 'Objek Usaha Test',
            'tipe' => 'tempat_usaha',
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($admin)
            ->post(route('admin.unit-usaha.store'), [
                'objek_pendapatan_id' => $objectId,
                'kode_unit' => 'UNIT-TEST-01',
                'nama_unit' => 'Kios Test',
                'penyewa_nama' => 'Penyewa Test',
                'luas_m2' => 12.5,
                'tarif_sewa' => 250000,
                'status' => 'aktif',
            ])
            ->assertRedirect(route('admin.unit-usaha.index'));

        $this->assertDatabaseHas('unit_usahas', [
            'objek_pendapatan_id' => $objectId,
            'kode_unit' => 'UNIT-TEST-01',
            'status' => 'aktif',
        ]);
    }

    public function test_business_object_can_be_created_for_valid_revenue_source(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-TKU')->value('id');

        $this->actingAs($admin)
            ->post(route('admin.objek-pendapatan.store'), [
                'sumber_pemasukan_id' => $sourceId,
                'kode' => 'OBJ-BUSINESS-TEST',
                'nama' => 'Objek Usaha Test',
                'tipe' => 'tempat_usaha',
                'status' => 'aktif',
                'nama_pengelola' => 'Pengelola Test',
                'tarif_sewa' => 250000,
            ])
            ->assertRedirect(route('admin.objek-pendapatan.index'));

        $this->assertDatabaseHas('objek_pendapatans', ['kode' => 'OBJ-BUSINESS-TEST', 'tipe' => 'tempat_usaha']);
    }

    public function test_asset_utilization_can_be_recorded_for_active_usage(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $asetId = DB::table('aset_daerahs')->insertGetId([
            'kode_aset' => 'ASET-TEST-001',
            'nama_aset' => 'Pelataran Terminal Test',
            'jenis_aset' => 'Tanah',
            'lokasi' => 'Terminal Sinjai',
            'luas_total_m2' => 1000,
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $areaId = DB::table('area_asets')->insertGetId([
            'aset_daerah_id' => $asetId,
            'kode_area' => 'AREA-TEST-001',
            'nama_area' => 'Pelataran A',
            'luas_m2' => 200,
            'tarif_sewa' => 500000,
            'status' => 'tersedia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($admin)
            ->post(route('admin.pemanfaatan-aset.store'), [
                'area_aset_id' => $areaId,
                'pihak_pemanfaat' => 'Kegiatan Test',
                'jenis_kegiatan' => 'Sewa Pelataran',
                'tanggal_mulai' => '2026-08-01',
                'tanggal_selesai' => '2026-08-31',
                'nilai_sewa' => 500000,
                'status' => 'aktif',
            ])
            ->assertRedirect(route('admin.pemanfaatan-aset.index'));

        $this->assertDatabaseHas('area_asets', ['id' => $areaId, 'status' => 'dimanfaatkan']);
    }

    public function test_special_parking_requires_capacity_and_manager(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $now = now();
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-TKP')->value('id');
        if (! $sourceId) {
            $sourceId = DB::table('sumber_pemasukans')->insertGetId([
                'kode' => 'R-TKP', 'nama' => 'Retribusi Parkir Khusus', 'status' => true,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }
        $kecamatanId = DB::table('kecamatans')->insertGetId([
            'kode' => 'KEC-PK', 'nama' => 'Kecamatan Parkir Khusus', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $kelurahanId = DB::table('kelurahans')->insertGetId([
            'kecamatan_id' => $kecamatanId, 'kode' => 'KEL-PK', 'nama' => 'Kelurahan Parkir Khusus', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $jenisParkirId = DB::table('jenis_parkirs')->insertGetId([
            'kode' => 'JP-PK', 'nama' => 'Parkir Khusus Test', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.titik-parkir.store'), [
                'kode_titik' => 'PK-TEST-001',
                'nama' => 'Parkir Khusus Test',
                'alamat' => 'Alamat Test',
                'kecamatan_id' => $kecamatanId,
                'kelurahan_id' => $kelurahanId,
                'jenis_parkir_id' => $jenisParkirId,
                'sumber_pemasukan_id' => $sourceId,
                'status' => 'aktif',
            ])
            ->assertSessionHasErrors(['kapasitas_total', 'nama_pengelola']);

        $this->assertDatabaseMissing('titik_parkirs', ['kode_titik' => 'PK-TEST-001']);
    }

    public function test_active_asset_utilization_marks_area_as_utilized(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $assetId = DB::table('aset_daerahs')->insertGetId([
            'kode_aset' => 'ASET-UTIL-001', 'nama_aset' => 'Aset Utilisasi Test', 'status' => 'aktif',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $areaId = DB::table('area_asets')->insertGetId([
            'aset_daerah_id' => $assetId, 'kode_area' => 'AREA-UTIL-001', 'nama_area' => 'Area Utilisasi Test',
            'status' => 'tersedia', 'created_at' => now(), 'updated_at' => now(),
        ]);

        $this->actingAs($admin)
            ->post(route('admin.pemanfaatan-aset.store'), [
                'area_aset_id' => $areaId,
                'pihak_pemanfaat' => 'Pemanfaat Test',
                'jenis_kegiatan' => 'Kegiatan Test',
                'tanggal_mulai' => '2026-08-21',
                'tanggal_selesai' => '2026-08-22',
                'nilai_sewa' => 750000,
                'status' => 'aktif',
            ])
            ->assertRedirect(route('admin.pemanfaatan-aset.index'));

        $this->assertDatabaseHas('area_asets', ['id' => $areaId, 'status' => 'dimanfaatkan', 'pemanfaat_terakhir' => 'Pemanfaat Test']);
        $this->assertDatabaseHas('tagihans', [
            'pihak_tertagih' => 'Pemanfaat Test',
            'nilai_tagihan' => 750000,
            'status' => 'terbit',
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => 'App\\Models\\Tagihan',
            'action' => 'created',
        ]);
    }

    public function test_potential_refresh_calculates_active_unit_rent(): void
    {
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-TKU')->value('id');
        $objectId = DB::table('objek_pendapatans')->insertGetId([
            'sumber_pemasukan_id' => $sourceId,
            'kode' => 'OBJ-POT-TEST',
            'nama' => 'Objek Potensi Test',
            'tipe' => 'tempat_usaha',
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('unit_usahas')->insert([
            'objek_pendapatan_id' => $objectId,
            'kode_unit' => 'UNIT-POT-TEST',
            'nama_unit' => 'Unit Potensi Test',
            'tarif_sewa' => 450000,
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->artisan('potensi:refresh')->assertExitCode(0);

        $this->assertDatabaseHas('objek_pendapatans', [
            'id' => $objectId,
            'potensi_bulanan' => 450000,
        ]);
    }

    public function test_special_parking_occupancy_cannot_exceed_capacity(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $now = now();
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-TKP')->value('id');
        $kecamatanId = DB::table('kecamatans')->insertGetId([
            'kode' => 'KEC-OCC', 'nama' => 'Kecamatan Occupancy', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $kelurahanId = DB::table('kelurahans')->insertGetId([
            'kecamatan_id' => $kecamatanId, 'kode' => 'KEL-OCC', 'nama' => 'Kelurahan Occupancy', 'status' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $pointId = DB::table('titik_parkirs')->insertGetId([
            'kode_titik' => 'PK-OCC-001', 'nama' => 'Parkir Occupancy Test', 'alamat' => 'Alamat',
            'kecamatan_id' => $kecamatanId, 'kelurahan_id' => $kelurahanId,
            'jenis_parkir_id' => DB::table('jenis_parkirs')->value('id'), 'sumber_pemasukan_id' => $sourceId,
            'status' => 'aktif', 'kapasitas_total' => 10, 'created_at' => now(), 'updated_at' => now(),
        ]);

        $this->actingAs($admin)
            ->post(route('admin.okupansi-parkir.store'), [
                'titik_parkir_id' => $pointId,
                'tanggal' => '2026-08-21',
                'jumlah_motor' => 8,
                'jumlah_mobil' => 3,
            ])
            ->assertSessionHasErrors('jumlah_motor');

        $this->assertDatabaseMissing('okupansi_parkirs', ['titik_parkir_id' => $pointId]);
    }

    public function test_potential_refresh_uses_motor_small_car_and_large_car_tariffs(): void
    {
        $jenisParkirId = DB::table('jenis_parkirs')->insertGetId([
            'kode' => 'JP-TARIF-TEST', 'nama' => 'Jenis Tarif Test', 'status' => true,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        foreach ([['motor', 1000], ['mobil_kecil', 3000], ['mobil_besar', 5000]] as [$vehicle, $nominal]) {
            DB::table('tarifs')->insert([
                'jenis_parkir_id' => $jenisParkirId, 'jenis_kendaraan' => $vehicle, 'nominal' => $nominal,
                'berlaku_mulai' => '2026-01-01', 'status' => true, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }
        $now = now();
        $kecamatanId = DB::table('kecamatans')->insertGetId(['kode' => 'KEC-TARIF', 'nama' => 'Kecamatan Tarif', 'status' => true, 'created_at' => $now, 'updated_at' => $now]);
        $kelurahanId = DB::table('kelurahans')->insertGetId(['kecamatan_id' => $kecamatanId, 'kode' => 'KEL-TARIF', 'nama' => 'Kelurahan Tarif', 'status' => true, 'created_at' => $now, 'updated_at' => $now]);
        $sourceId = DB::table('sumber_pemasukans')->where('kode', 'R-TKP')->value('id');
        DB::table('titik_parkirs')->insert([
            'kode_titik' => 'TP-TARIF-TEST', 'nama' => 'Titik Tarif Test', 'alamat' => 'Alamat', 'kecamatan_id' => $kecamatanId,
            'kelurahan_id' => $kelurahanId, 'jenis_parkir_id' => $jenisParkirId, 'sumber_pemasukan_id' => $sourceId,
            'status' => 'aktif', 'kapasitas_motor' => 10, 'kapasitas_mobil_kecil' => 5, 'kapasitas_mobil_besar' => 2,
            'created_at' => $now, 'updated_at' => $now,
        ]);

        $this->artisan('potensi:refresh')->assertExitCode(0);

        $this->assertDatabaseHas('titik_parkirs', ['kode_titik' => 'TP-TARIF-TEST', 'potensi_harian' => 35000]);
    }

    public function test_unit_tenant_change_creates_contract_history(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $objectId = DB::table('objek_pendapatans')->insertGetId([
            'sumber_pemasukan_id' => DB::table('sumber_pemasukans')->where('kode', 'R-TKU')->value('id'),
            'kode' => 'OBJ-HIST-TEST', 'nama' => 'Objek Histori Test', 'tipe' => 'tempat_usaha', 'status' => 'aktif',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $unitId = DB::table('unit_usahas')->insertGetId([
            'objek_pendapatan_id' => $objectId, 'kode_unit' => 'UNIT-HIST-TEST', 'nama_unit' => 'Unit Histori Test',
            'penyewa_nama' => 'Penyewa Lama', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now(),
        ]);

        $this->actingAs($admin)
            ->put(route('admin.unit-usaha.update', $unitId), [
                'objek_pendapatan_id' => $objectId,
                'kode_unit' => 'UNIT-HIST-TEST',
                'nama_unit' => 'Unit Histori Test',
                'penyewa_nama' => 'Penyewa Baru',
                'status' => 'aktif',
            ])
            ->assertRedirect(route('admin.unit-usaha.index'));

        $this->assertDatabaseHas('unit_usaha_histories', ['unit_usaha_id' => $unitId, 'aksi' => 'perubahan_penyewa_kontrak']);
    }
}
