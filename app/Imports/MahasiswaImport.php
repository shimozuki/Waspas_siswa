<?php

namespace App\Imports;

use App\Models\Attribute;
use App\Models\Finansial;
use App\Models\Mahasiswa;
use App\Models\NilaiAttribute;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MahasiswaImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $col)
        {
            $attributes = Attribute::all();
            if($col[5] != null || 0){
                $mhs = Mahasiswa::create([
                    'nim' => $col[24],
                    'nama' => $col[0],
                    'jenis_kelamin' => $col[6],
                    'tempat_lahir' => $col[4],
                    'tanggal_lahir' => DateTime::createFromFormat('d/m/Y', $col[5]),
                    'alamat' => $col[7],
                    'asal_sekolah' => $col[1],
                    'program_studi' => $col[23],
                ]);

            $nilaiC1 = NilaiAttribute::query()->where('attribute_id', $attributes[0]->id)->where('value', 'like', '%'. $col[10] . '%')->first();
            $finansialC1 = Finansial::create([
                'mahasiswa_id' => $mhs->id,
                'nilai_attribute_id' => $nilaiC1->id,
                'nilai' => $nilaiC1->nilai
            ]);

            $nilaiC2 = NilaiAttribute::query()->where('attribute_id', $attributes[1]->id)->where('value', 'like', '%'. $col[14] . '%')->first();
            $finansialC2 = Finansial::create([
                'mahasiswa_id' => $mhs->id,
                'nilai_attribute_id' => $nilaiC2->id,
                'nilai' => $nilaiC2->nilai
            ]);

            $nilaiC3 = NilaiAttribute::query()->where('attribute_id', $attributes[2]->id)->where('value', 'like', '%'. $col[8] . '%')->first();
            $finansialC3 = Finansial::create([
                'mahasiswa_id' => $mhs->id,
                'nilai_attribute_id' => $nilaiC3->id,
                'nilai' => $nilaiC3->nilai
            ]);

            $nilaiC4 = NilaiAttribute::query()->where('attribute_id', $attributes[3]->id)->where('value', 'like', '%'. $col[12] . '%')->first();
            $finansialC4 = Finansial::create([
                'mahasiswa_id' => $mhs->id,
                'nilai_attribute_id' => $nilaiC4->id,
                'nilai' => $nilaiC4->nilai
            ]);

            $nilaiC5 = NilaiAttribute::query()->where('attribute_id', $attributes[4]->id)->where('value', 'like', '%'. $col[9] . '%')->first();
            $finansialC5 = Finansial::create([
                'mahasiswa_id' => $mhs->id,
                'nilai_attribute_id' => $nilaiC5->id,
                'nilai' => $nilaiC5->nilai
            ]);

            $nilaiC6 = NilaiAttribute::query()->where('attribute_id', $attributes[5]->id)->where('value', 'like', '%'. $col[13] . '%')->first();
            $finansialC6 = Finansial::create([
                'mahasiswa_id' => $mhs->id,
                'nilai_attribute_id' => $nilaiC6->id,
                'nilai' => $nilaiC6->nilai
            ]);

            $nilaiC7 = NilaiAttribute::query()->where('attribute_id', $attributes[6]->id)->where('value', 'like', '%'. $col[15] . '%')->first();
            $finansialC7 = Finansial::create([
                'mahasiswa_id' => $mhs->id,
                'nilai_attribute_id' => $nilaiC7->id,
                'nilai' => $nilaiC7->nilai
            ]);

            if($col[16] == "-"){
                $col[16] = "Tidak Memiliki";
            }
            $nilaiC8 = NilaiAttribute::query()->where('attribute_id', $attributes[7]->id)->where('value', 'like', '%'. $col[16] . '%')->first();
            $finansialC8 = Finansial::create([
                'mahasiswa_id' => $mhs->id,
                'nilai_attribute_id' => $nilaiC8->id,
                'nilai' => $nilaiC8->nilai
            ]);
        }
        }
    }
}
