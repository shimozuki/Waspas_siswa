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
        Schema::table('hasil_qis', function (Blueprint $table) {
            $table->renameColumn('siswa_id', 'mahasiswa_id');
        });
    }

    public function down()
    {
        Schema::table('hasil_qis', function (Blueprint $table) {
            $table->renameColumn('mahasiswa_id', 'siswa_id');
        });
    }
};
