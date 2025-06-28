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
        Schema::table('hasils', function (Blueprint $table) {
            // Hapus dulu foreign key constraint-nya
            $table->dropForeign(['jurusan_id']);

            // Setelah itu baru hapus kolomnya
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
        Schema::table('hasils', function (Blueprint $table) {
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusans')->onDelete('set null');
        });
    }
};
