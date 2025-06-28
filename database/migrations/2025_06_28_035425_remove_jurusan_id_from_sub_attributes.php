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
        Schema::table('sub_attributes', function (Blueprint $table) {
            // 1. Drop foreign key constraint dulu
            $table->dropForeign(['jurusan_id']);

            // 2. Baru hapus kolomnya
            $table->dropColumn('jurusan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('jurusan_id')->nullable();
        });
    }
};
