<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->nullable()->after('name');
        });

        // Username awal diambil dari bagian depan email. Jika bentrok, ditambah id agar tetap unik.
        $used = [];
        foreach (DB::table('users')->orderBy('id')->get(['id', 'email']) as $user) {
            $base = Str::slug(Str::before((string) $user->email, '@'), '') ?: 'user';
            $username = isset($used[$base]) ? $base.$user->id : $base;
            $used[$username] = true;

            DB::table('users')->where('id', $user->id)->update(['username' => $username]);
        }

        // Satu akun per role: akun dengan id terkecil dipertahankan, sisanya dihapus.
        $keep = DB::table('users')->selectRaw('MIN(id) as id')->groupBy('role')->pluck('id');
        DB::table('users')->whereNotIn('id', $keep)->delete();

        Schema::table('users', function (Blueprint $table) {
            $table->unique('username');
            $table->unique('role');
            $table->dropUnique(['email']);
            $table->dropColumn(['email', 'email_verified_at']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->after('username');
            $table->timestamp('email_verified_at')->nullable();
            $table->dropUnique(['role']);
            $table->dropUnique(['username']);
        });

        DB::table('users')->update(['email' => DB::raw("CONCAT(username, '@sijukir.local')")]);

        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable(false)->unique()->change();
            $table->dropColumn('username');
        });
    }
};
