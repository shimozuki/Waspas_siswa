<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ubah nama tabel
        Schema::rename('hasil_qis', 'hasil_snbp');

        Schema::table('hasil_snbp', function (Blueprint $table) {
            $table->renameColumn('mahasiswa_id', 'siswa_id');
            $table->renameColumn('jurusan_id', 'kelas_id');

            $table->integer('peringkat')->nullable()->after('qi');
            $table->boolean('lolos')->default(false)->after('peringkat');
        });
    }

    public function down()
    {
        Schema::table('hasil_snbp', function (Blueprint $table) {
            $table->dropColumn(['peringkat', 'lolos']);
            $table->renameColumn('siswa_id', 'mahasiswa_id');
            $table->renameColumn('kelas_id', 'jurusan_id');
        });

        Schema::rename('hasil_snbp', 'hasil_qis');
    }
};
