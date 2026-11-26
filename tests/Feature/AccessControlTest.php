<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_pimpinan_sidebar_matches_admin_menu(): void
    {
        $user = User::factory()->create([
            'role' => 'pimpinan',
            'status' => 'aktif',
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Data Petugas')
            ->assertSee('Penempatan Petugas')
            ->assertSee('SEO')
            ->assertSee('Publik');
    }

    public function test_pimpinan_dashboard_uses_pimpinan_labels(): void
    {
        $user = User::factory()->create([
            'role' => 'pimpinan',
            'status' => 'aktif',
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Pimpinan SAPA JUKIR')
            ->assertSee('Ringkasan data dan kondisi pengelolaan pendapatan dan operasional Kabupaten Sinjai.')
            ->assertSee('Dashboard Pimpinan')
            ->assertSee('SAPA JUKIR Sinjai');
    }

    public function test_pimpinan_can_open_reports_but_not_master_data(): void
    {
        $user = User::factory()->create([
            'role' => 'pimpinan',
            'status' => 'aktif',
        ]);

        $this->actingAs($user)
            ->get(route('admin.laporan.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('admin.sumber-pemasukan.index'))
            ->assertForbidden();
    }

    public function test_admin_can_open_master_revenue_objects(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.objek-pendapatan.index'))
            ->assertOk()
            ->assertSee('Objek Pendapatan');

        $this->actingAs($admin)
            ->get(route('admin.objek-pendapatan.create'))
            ->assertOk()
            ->assertSee('Tambah Objek Pendapatan');
    }

    public function test_user_changes_are_audited_without_password_values(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

        $operator = User::factory()->create(['role' => 'operator', 'status' => 'aktif']);

        $this->actingAs($admin)
            ->put(route('admin.users.update', $operator), [
                'name' => 'Operator Audit',
                'username' => 'operator-audit',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'role' => 'operator',
                'status' => 'aktif',
            ])
            ->assertRedirect(route('admin.users.index'));

        $user = User::where('username', 'operator-audit')->firstOrFail();
        $audit = \App\Models\AuditLog::where('auditable_type', User::class)
            ->where('auditable_id', $user->id)
            ->latest('id')
            ->firstOrFail();

        $this->assertArrayNotHasKey('password', $audit->new_values);
        $this->assertArrayNotHasKey('remember_token', $audit->new_values);
    }

    public function test_admin_can_update_own_account_without_role_and_status_fields(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

        $this->actingAs($admin)
            ->put(route('admin.users.update', $admin), [
                'name' => 'Admin Diperbarui',
                'username' => $admin->username,
            ])
            ->assertRedirect(route('admin.users.index'));

        $admin->refresh();
        $this->assertSame('Admin Diperbarui', $admin->name);
        $this->assertSame('admin', $admin->role);
        $this->assertSame('aktif', $admin->status);
    }

    public function test_operator_can_open_dashboard_but_not_target_master(): void
    {
        $user = User::factory()->create([
            'role' => 'operator',
            'status' => 'aktif',
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('admin.target-pendapatan.index'))
            ->assertForbidden();
    }

    public function test_pimpinan_can_export_revenue_analysis_as_csv(): void
    {
        $user = User::factory()->create([
            'role' => 'pimpinan',
            'status' => 'aktif',
        ]);

        $this->actingAs($user)
            ->get(route('admin.laporan.analisis-pendapatan.export', ['tahun' => 2026, 'bulan' => 8]))
            ->assertOk()
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    public function test_pimpinan_can_export_revenue_analysis_as_pdf_and_excel(): void
    {
        $user = User::factory()->create(['role' => 'pimpinan', 'status' => 'aktif']);

        $this->actingAs($user)
            ->get(route('admin.laporan.analisis-pendapatan.pdf', ['tahun' => 2026, 'bulan' => 8, 'pdf' => 1]))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');

        $this->actingAs($user)
            ->get(route('admin.laporan.analisis-pendapatan.excel', ['tahun' => 2026, 'bulan' => 8, 'excel' => 1]))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/vnd.ms-excel; charset=UTF-8');

            $this->actingAs($user)
                ->get(route('admin.laporan.analisis-pendapatan.xlsx', ['tahun' => 2026, 'bulan' => 8, 'xlsx' => 1]))
                ->assertOk()
                ->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_pimpinan_can_open_arrears_report(): void
    {
        $user = User::factory()->create(['role' => 'pimpinan', 'status' => 'aktif']);

        $this->actingAs($user)
            ->get(route('admin.laporan.tunggakan'))
            ->assertOk();
    }

    public function test_revenue_analysis_supports_quarter_period(): void
    {
        $user = User::factory()->create(['role' => 'pimpinan', 'status' => 'aktif']);

        $this->actingAs($user)
            ->get(route('admin.laporan.analisis-pendapatan', ['tahun' => 2026, 'bulan' => 8, 'periode' => 'triwulan']))
            ->assertOk()
            ->assertViewHas('periodeLabel', 'T3');
    }

    public function test_pimpinan_can_open_report_for_one_revenue_type(): void
    {
        $user = User::factory()->create(['role' => 'pimpinan', 'status' => 'aktif']);
        $sourceId = \Illuminate\Support\Facades\DB::table('sumber_pemasukans')->value('id');

        $this->actingAs($user)
            ->get(route('admin.laporan.jenis', ['sumberPemasukan' => $sourceId, 'tahun' => 2026, 'bulan' => 8]))
            ->assertOk()
            ->assertViewHas('sourceId', $sourceId);
    }

    public function test_only_admin_can_manage_users(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);
        $operator = User::factory()->create([
            'role' => 'operator',
            'status' => 'aktif',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk();

        $this->actingAs($operator)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public function test_admin_can_create_multiple_users_per_role_and_cannot_delete_self(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $payload = fn (string $username) => [
            'name' => 'Operator '.$username,
            'username' => $username,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'operator',
            'status' => 'aktif',
        ];

        $this->actingAs($admin)->post(route('admin.users.store'), $payload('operator-a'))->assertRedirect(route('admin.users.index'));
        $this->actingAs($admin)->post(route('admin.users.store'), $payload('operator-b'))->assertRedirect(route('admin.users.index'));
        $this->assertSame(2, User::where('role', 'operator')->count());

        $this->actingAs($admin)->delete(route('admin.users.destroy', User::where('username', 'operator-a')->first()))
            ->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['username' => 'operator-a']);

        $this->actingAs($admin)->delete(route('admin.users.destroy', $admin))->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $admin->id]);

        $this->actingAs($admin)->put(route('admin.users.update', $admin), [
            'name' => $admin->name,
            'username' => $admin->username,
            'role' => 'operator',
            'status' => 'nonaktif',
        ])->assertRedirect();
        $this->assertSame('admin', $admin->fresh()->role);
        $this->assertSame('aktif', $admin->fresh()->status);
    }

    public function test_pimpinan_can_review_warnings_but_operator_cannot(): void
    {
        $pimpinan = User::factory()->create(['role' => 'pimpinan', 'status' => 'aktif']);
        $operator = User::factory()->create(['role' => 'operator', 'status' => 'aktif']);

        $this->actingAs($pimpinan)
            ->get(route('admin.peringatan-capaian.index'))
            ->assertOk();

        $this->actingAs($operator)
            ->get(route('admin.peringatan-capaian.index'))
            ->assertForbidden();
    }

    public function test_only_admin_can_view_audit_logs(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $operator = User::factory()->create(['role' => 'operator', 'status' => 'aktif']);

        $this->actingAs($admin)
            ->get(route('admin.audit-logs.index'))
            ->assertOk();

        $this->actingAs($operator)
            ->get(route('admin.audit-logs.index'))
            ->assertForbidden();
    }

    public function test_pimpinan_has_read_only_access_to_operational_modules(): void
    {
        $pimpinan = User::factory()->create(['role' => 'pimpinan', 'status' => 'aktif']);

        $this->actingAs($pimpinan)->get(route('admin.setoran.index'))->assertOk()->assertDontSee(route('admin.setoran.create'));
        $this->actingAs($pimpinan)->get(route('admin.penempatan-jukir.index'))->assertOk()->assertDontSee(route('admin.penempatan-jukir.create'));
        $this->actingAs($pimpinan)->get(route('admin.tagihan.index'))->assertOk()->assertDontSee(route('admin.tagihan.create'));

        $this->actingAs($pimpinan)->get(route('admin.setoran.create'))->assertForbidden();
        $this->actingAs($pimpinan)->get(route('admin.penempatan-jukir.create'))->assertForbidden();
        $this->actingAs($pimpinan)->get(route('admin.tagihan.create'))->assertForbidden();
    }
}
