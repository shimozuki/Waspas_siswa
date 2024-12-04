<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jurusan::create([
            'nama' => 'IPA',
            'priority' => 1,
            'quota' => 168
        ]);

        Jurusan::create([
            'nama' => 'IPS',
            'priority' => 2,
            'quota' => 84,
        ]);

        Jurusan::create([
            'nama' => 'Agama',
            'priority' => 3,
            'quota' => 84
        ]);
    }
}
