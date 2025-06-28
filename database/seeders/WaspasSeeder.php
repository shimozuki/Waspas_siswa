<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WaspasSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // ===== 1. Attributes (Kriteria)
        $attributes = [
            ['id' => 6, 'nama' => 'Ketidakhadiran', 'kode' => 'KTH', 'bobot' => 0.1, 'tipe' => 'cost'],
            ['id' => 7, 'nama' => 'Prestasi Akademik', 'kode' => 'PA', 'bobot' => 0.2, 'tipe' => 'benefit'],
            ['id' => 8, 'nama' => 'Prestasi Non-Akademik', 'kode' => 'PNA', 'bobot' => 0.2, 'tipe' => 'benefit'],
            ['id' => 9, 'nama' => 'Keterlambatan', 'kode' => 'KD', 'bobot' => 0.1, 'tipe' => 'cost'],
            ['id' => 10, 'nama' => 'Nilai Rata Rata Rapot', 'kode' => 'N3R', 'bobot' => 0.4, 'tipe' => 'benefit'],
        ];
        DB::table('attributes')->insert($attributes);

        // ===== 2. Nilais & 3. SubAttributes
        $levels = [
            ['nama' => 'Sangat Baik', 'poin' => 4],
            ['nama' => 'Baik', 'poin' => 3],
            ['nama' => 'Cukup', 'poin' => 2],
            ['nama' => 'Kurang', 'poin' => 1],
        ];

        $nilaiId = 1;
        $subId = 1;
        foreach ($attributes as $attr) {
            $attribute_id = $attr['id'];
            $min = 0;

            foreach (array_reverse($levels) as $level) {
                $max = $level['poin'] != 4 ? $min + 24 : 100;

                DB::table('nilais')->insert([
                    'id' => $nilaiId,
                    'attribute_id' => $attribute_id,
                    'nama' => $level['nama'],
                    'poin' => $level['poin'],
                    'created_at' => $now,
                    'updated_at' => $now
                ]);

                DB::table('sub_attributes')->insert([
                    'id' => $subId,
                    'attribute_id' => $attribute_id,
                    'nilai_id' => $nilaiId,
                    'nilai_min' => $min,
                    'nilai_max' => $max,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);

                $nilaiId++;
                $subId++;
                $min = $max + 1;
            }
        }
    }
}
