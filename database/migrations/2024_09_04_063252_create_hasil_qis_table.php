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
        Schema::create('hasil_qis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained();
            $table->foreignId('jurusan_id')->constrained();
            $table->float('qi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasil_qis');
    }
};
