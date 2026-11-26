<?php

namespace Tests\Feature;

use App\Models\JenisJukir;
use App\Models\JenisParkir;
use App\Models\Jukir;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Pengaduan;
use App\Models\Sambutan;
use App\Models\Setoran;
use App\Models\SumberPemasukan;
use App\Models\Tagihan;
use App\Models\TargetPendapatan;
use App\Models\TitikParkir;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    public function test_jukir_sensitive_documents_are_stored_privately_and_restricted_to_admin(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $operator = User::factory()->create(['role' => 'operator', 'status' => 'aktif']);
        $pimpinan = User::factory()->create(['role' => 'pimpinan', 'status' => 'aktif']);
        $jenisJukir = JenisJukir::create([
            'kode' => 'JJ-01',
            'nama' => 'Jukir Resmi',
            'status' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.jukir.store'), [
            'jenis_jukir_id' => $jenisJukir->id,
            'nik' => '7307010101900001',
            'nama' => 'Budi Santoso',
            'status' => 'aktif',
            'foto_ktp' => UploadedFile::fake()->image('ktp.jpg'),
            'dokumen_pendukung' => UploadedFile::fake()->create('sk.pdf', 100, 'application/pdf'),
        ]);

        $response->assertRedirect(route('admin.jukir.index'));

        $jukir = Jukir::firstOrFail();
        Storage::disk('local')->assertExists($jukir->foto_ktp);
        Storage::disk('local')->assertExists($jukir->dokumen_pendukung);
        Storage::disk('public')->assertMissing($jukir->foto_ktp);
        Storage::disk('public')->assertMissing($jukir->dokumen_pendukung);

        $ktpUrl = route('admin.jukir.document', [$jukir, 'ktp']);
        $docUrl = route('admin.jukir.document', [$jukir, 'dokumen-pendukung']);

        Auth::logout();
        $this->get($ktpUrl)->assertRedirect(route('login'));
        $this->actingAs($operator)->get($ktpUrl)->assertForbidden();
        $this->actingAs($pimpinan)->get($ktpUrl)->assertForbidden();
        $this->actingAs($admin)->get($ktpUrl)->assertOk();
        $this->actingAs($admin)->get($docUrl)->assertOk();
    }

    public function test_pengaduan_photo_is_stored_privately_and_restricted_to_admin(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $operator = User::factory()->create(['role' => 'operator', 'status' => 'aktif']);
        $pimpinan = User::factory()->create(['role' => 'pimpinan', 'status' => 'aktif']);

        $response = $this->post(route('pengaduan.store'), [
            'nama' => 'Warga Sinjai',
            'nik' => '7307010101900002',
            'telepon' => '081234567890',
            'lokasi_parkir' => 'Pasar Sentral',
            'jenis' => 'tarif_parkir_tidak_sesuai',
            'detail' => 'Tarif tidak sesuai karcis resmi.',
            'foto' => UploadedFile::fake()->image('bukti.jpg'),
        ]);

        $response->assertRedirect(route('pengaduan.create'));

        $pengaduan = Pengaduan::firstOrFail();
        Storage::disk('local')->assertExists($pengaduan->foto);
        Storage::disk('public')->assertMissing($pengaduan->foto);

        $photoUrl = route('admin.pengaduan.photo', $pengaduan);

        $this->get($photoUrl)->assertRedirect(route('login'));
        $this->actingAs($operator)->get($photoUrl)->assertForbidden();
        $this->actingAs($pimpinan)->get($photoUrl)->assertForbidden();
        $this->actingAs($admin)->get($photoUrl)->assertOk();
    }

    public function test_public_pages_escape_map_popup_content_without_unsafe_html_injection(): void
    {
        $kecamatan = Kecamatan::create(['kode' => 'KEC-01', 'nama' => 'Sinjai Utara']);
        $kelurahan = Kelurahan::create(['kecamatan_id' => $kecamatan->id, 'kode' => 'KEL-01', 'nama' => 'Bongki']);
        $jenisParkir = JenisParkir::create(['kode' => 'JP-01', 'nama' => 'Tepi Jalan Umum', 'status' => true]);

        $titikParkir = TitikParkir::create([
            'kode_titik' => 'TP-001',
            'nama' => 'Lokasi <script>alert(1)</script>',
            'alamat' => 'Jl. Persatuan <img src=x onerror=alert(1)>',
            'kecamatan_id' => $kecamatan->id,
            'kelurahan_id' => $kelurahan->id,
            'jenis_parkir_id' => $jenisParkir->id,
            'status' => 'aktif',
            'latitude' => -5.12345,
            'longitude' => 120.25432,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('escapeHtml(point.nama)', false);

        $this->get(route('guest.titik-parkir.show', $titikParkir))
            ->assertOk()
            ->assertSee('titleEl.textContent = locationName', false);
    }

    public function test_security_headers_are_present_on_responses(): void
    {
        $response = $this->get(route('home'))->assertOk();

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=(self)');
        $response->assertHeader('Content-Security-Policy', "frame-ancestors 'self'; base-uri 'self'; form-action 'self'");
    }

    public function test_csv_export_neutralizes_formula_injection(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $source = SumberPemasukan::create([
            'kode' => 'R-TEST',
            'nama' => "=CMD|' /C calc'!A0",
            'status' => true,
        ]);

        TargetPendapatan::create([
            'sumber_pemasukan_id' => $source->id,
            'tahun' => 2026,
            'bulan' => 11,
            'target' => 1000000,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.laporan.analisis-pendapatan.export', [
            'tahun' => 2026,
            'bulan' => 11,
            'periode' => 'bulanan',
        ]));

        $response->assertOk();
        $csvContent = $response->streamedContent();
        $this->assertStringContainsString("'=CMD|' /C calc'!A0", $csvContent);
        $this->assertStringNotContainsString(',=CMD', $csvContent);
    }

    public function test_sambutan_rejects_non_hex_background_color(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $sambutan = Sambutan::create([
            'nama_kepala_dinas' => 'Kepala Dinas',
            'jabatan' => 'Kepala Dinas Perhubungan Kabupaten Sinjai',
            'deskripsi' => 'Sambutan resmi.',
            'is_active' => true,
        ]);

        $this->actingAs($admin)
            ->put(route('admin.sambutan.update', $sambutan), [
                'background_color' => '#ffffff; background-image: url(https://evil.test)',
                'is_active' => '1',
            ])
            ->assertSessionHasErrors('background_color');

        $this->actingAs($admin)
            ->put(route('admin.sambutan.update', $sambutan), [
                'background_color' => '#3d2df5',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.sambutan.index'))
            ->assertSessionHasNoErrors();

        $this->assertSame('#3d2df5', $sambutan->fresh()->background_color);
    }

    public function test_tagihan_bayar_rejects_overpayment_and_updates_status_atomically(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $source = SumberPemasukan::create([
            'kode' => 'R-TAG',
            'nama' => 'Retribusi Jasa Usaha',
            'status' => true,
        ]);

        $tagihan = Tagihan::create([
            'sumber_pemasukan_id' => $source->id,
            'nomor_tagihan' => 'TAG-SEC-001',
            'uraian' => 'Sewa Kios Bulan Ini',
            'tanggal_terbit' => '2026-11-01',
            'tanggal_jatuh_tempo' => '2026-11-30',
            'nilai_tagihan' => 500000,
            'status' => 'terbit',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.tagihan.bayar', $tagihan), [
                'tanggal_bayar' => '2026-11-10',
                'jumlah_bayar' => 600000,
            ])
            ->assertSessionHasErrors('jumlah_bayar');

        $this->actingAs($admin)
            ->post(route('admin.tagihan.bayar', $tagihan), [
                'tanggal_bayar' => '2026-11-10',
                'jumlah_bayar' => 500000,
            ])
            ->assertRedirect();

        $this->assertSame('lunas', $tagihan->fresh()->status);
    }

    public function test_site_settings_rejects_non_http_urls(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

        $this->actingAs($admin)
            ->post(route('admin.site-settings.update'), [
                'location_url' => 'javascript:alert(1)',
                'whatsapp_url' => 'ftp://example.com',
            ])
            ->assertSessionHasErrors(['location_url', 'whatsapp_url']);

        $this->actingAs($admin)
            ->post(route('admin.site-settings.update'), [
                'location_url' => 'https://maps.google.com/?q=Sinjai',
                'whatsapp_url' => 'https://wa.me/628123456789',
            ])
            ->assertRedirect(route('admin.site-settings.index'))
            ->assertSessionHasNoErrors();
    }

    public function test_user_password_requires_letters_and_numbers(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

        $this->actingAs($admin)
            ->post(route('admin.users.store'), [
                'name' => 'Petugas Baru',
                'username' => 'petugas_baru_1',
                'password' => 'passwordonly',
                'password_confirmation' => 'passwordonly',
                'role' => 'operator',
                'status' => 'aktif',
            ])
            ->assertSessionHasErrors('password');

        $this->actingAs($admin)
            ->post(route('admin.users.store'), [
                'name' => 'Petugas Baru',
                'username' => 'petugas_baru_2',
                'password' => '12345678',
                'password_confirmation' => '12345678',
                'role' => 'operator',
                'status' => 'aktif',
            ])
            ->assertSessionHasErrors('password');

        $this->actingAs($admin)
            ->post(route('admin.users.store'), [
                'name' => 'Petugas Baru',
                'username' => 'petugas_baru_3',
                'password' => 'Password123',
                'password_confirmation' => 'Password123',
                'role' => 'operator',
                'status' => 'aktif',
            ])
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHasNoErrors();
    }

    public function test_only_admin_can_verify_setoran(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $operator = User::factory()->create(['role' => 'operator', 'status' => 'aktif']);
        $source = SumberPemasukan::create([
            'kode' => 'R-SET',
            'nama' => 'Retribusi Parkir',
            'status' => true,
        ]);

        $setoran = Setoran::create([
            'sumber_pemasukan_id' => $source->id,
            'tanggal' => '2026-11-26',
            'pendapatan_bruto' => 100000,
            'jumlah_setoran' => 100000,
            'selisih' => 0,
            'status' => 'belum_verifikasi',
        ]);

        $this->actingAs($operator)
            ->put(route('admin.setoran.verifikasi', $setoran), [
                'status' => 'terverifikasi',
            ])
            ->assertForbidden();

        $this->actingAs($admin)
            ->put(route('admin.setoran.verifikasi', $setoran), [
                'status' => 'terverifikasi',
            ])
            ->assertRedirect(route('admin.setoran.show', $setoran->id));

        $this->assertSame('terverifikasi', $setoran->fresh()->status);
    }
}
