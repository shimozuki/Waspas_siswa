<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Jurusan;
use App\Models\Nilai;
use App\Models\SubAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Seeder for Jurusan IPA */
        SubAttribute::create([
            'jurusan_id' => 1,
            'attribute_id' => 1,
            'nilai_id' => 4
        ]);
        SubAttribute::create([
            'jurusan_id' => 1,
            'attribute_id' => 2,
            'nilai_id' => 1
        ]);
        SubAttribute::create([
            'jurusan_id' => 1,
            'attribute_id' => 3,
            'nilai_id' => 7
        ]);
        SubAttribute::create([
            'jurusan_id' => 1,
            'attribute_id' => 3,
            'nilai_id' => 8
        ]);

        /* Seeder Jurusan IPS */
        SubAttribute::create([
            'jurusan_id' => 2,
            'attribute_id' => 1,
            'nilai_id' => 5
        ]);
        SubAttribute::create([
            'jurusan_id' => 2,
            'attribute_id' => 2,
            'nilai_id' => 2
        ]);
        SubAttribute::create([
            'jurusan_id' => 2,
            'attribute_id' => 3,
            'nilai_id' => 7
        ]);
        SubAttribute::create([
            'jurusan_id' => 2,
            'attribute_id' => 3,
            'nilai_id' => 8
        ]);

        /* Seeder Jurusan Agama */
        SubAttribute::create([
            'jurusan_id' => 3,
            'attribute_id' => 1,
            'nilai_id' => 6
        ]);
        SubAttribute::create([
            'jurusan_id' => 3,
            'attribute_id' => 2,
            'nilai_id' => 3
        ]);
        SubAttribute::create([
            'jurusan_id' => 3,
            'attribute_id' => 2,
            'nilai_id' => 3
        ]);
        SubAttribute::create([
            'jurusan_id' => 3,
            'attribute_id' => 3,
            'nilai_id' => 9
        ]);
        SubAttribute::create([
            'jurusan_id' => 3,
            'attribute_id' => 3,
            'nilai_id' => 10
        ]);
        SubAttribute::create([
            'jurusan_id' => 3,
            'attribute_id' => 3,
            'nilai_id' => 11
        ]);

    }
}
