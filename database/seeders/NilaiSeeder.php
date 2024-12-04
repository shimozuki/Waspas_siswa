<?php

namespace Database\Seeders;

use App\Models\Nilai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Nilai Raport IPA',
            'Nilai Raport IPS',
            'Nilai Raport Agama',
            'Nilai Tes IPA',
            'Nilai Tes IPS',
            'Nilai Tes Agama',
            'Nilai Tes Bahasa Indonesia',
            'Nilai Tes Bahasa Inggris',
            'Nilai Praktek Solat',
            'Nilai Praktek Baca Quran',
            'Nilai Praktek Hafalan Surat Pendek'
        ];

        foreach($data as $row){
            Nilai::create([
                'nama' => $row,
            ]);
        }
    }
}
