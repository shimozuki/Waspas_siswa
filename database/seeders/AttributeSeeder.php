<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attribute;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Kriteria Utama',
            'Kriteria Pendukung',
            'Kriteria Tambahan'
        ];

        $bobot = [
           4,
           3,
           3
        ];
        $count = 0;
        foreach($data as $row){
            Attribute::create([
                'nama' => $row,
                'kode' => 'C'.$count+1,
                'bobot' => $bobot[$count],
            ]);
            $count++;
        }
    }
}
