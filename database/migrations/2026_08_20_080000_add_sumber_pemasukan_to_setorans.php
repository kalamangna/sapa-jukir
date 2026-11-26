<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sumber_pemasukans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        $sources = [
            ['kode' => 'R-TKP', 'nama' => 'Retribusi Tempat Khusus Parkir', 'deskripsi' => 'Pemasukan retribusi dari tempat khusus parkir.'],
            ['kode' => 'R-PJTU', 'nama' => 'Retribusi Pelayanan Parkir Tepi Jalan Umum', 'deskripsi' => 'Pemasukan retribusi pelayanan parkir di tepi jalan umum.'],
            ['kode' => 'R-JASA-USAHA', 'nama' => 'Retribusi Sewa Pelataran Area Terminal untuk Kegiatan Tertentu', 'deskripsi' => 'Sewa pelataran area terminal untuk kegiatan tertentu.'],
        ];

        foreach ($sources as $source) {
            DB::table('sumber_pemasukans')->insert(array_merge($source, [
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        Schema::table('setorans', function (Blueprint $table) {
            $table->foreignId('sumber_pemasukan_id')
                ->nullable()
                ->after('id')
                ->constrained('sumber_pemasukans')
                ->restrictOnDelete();
            $table->foreignId('jukir_id')->nullable()->change();
            $table->foreignId('titik_parkir_id')->nullable()->change();
        });

        $sourceIds = DB::table('sumber_pemasukans')->pluck('id', 'kode');
        $setorans = DB::table('setorans')
            ->join('titik_parkirs', 'titik_parkirs.id', '=', 'setorans.titik_parkir_id')
            ->join('jenis_parkirs', 'jenis_parkirs.id', '=', 'titik_parkirs.jenis_parkir_id')
            ->select('setorans.id', 'jenis_parkirs.kode')
            ->get();

        foreach ($setorans as $setoran) {
            $sourceId = $sourceIds[$setoran->kode] ?? null;
            if ($sourceId) {
                DB::table('setorans')->where('id', $setoran->id)->update(['sumber_pemasukan_id' => $sourceId]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('setorans', function (Blueprint $table) {
            $table->dropForeign(['sumber_pemasukan_id']);
            $table->dropColumn('sumber_pemasukan_id');
            $table->foreignId('jukir_id')->nullable(false)->change();
            $table->foreignId('titik_parkir_id')->nullable(false)->change();
        });

        Schema::dropIfExists('sumber_pemasukans');
    }
};
