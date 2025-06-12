<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Nilai;
use App\Models\NilaiSiswa;
use App\Models\SubAttribute;
use App\Models\Attribute;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        try {
            $attributes = Attribute::all();

            foreach ($collection as $row) {
                if (!empty($row['nama'])) {
                    $siswa = Mahasiswa::create([
                        'no_reg' => $row['nisn'],
                        'nama' => $row['nama'],
                        'jenis_kelamin' => $row['jenis_kelamin'],
                        'asal_kelas' => $row['jurusan'],
                        'tahun_ajaran' => $row['tahun_ajaran'],
                    ]);

                    foreach ($attributes as $attribute) {
                        $column_name = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $attribute->nama), '_'));


                        if (isset($row[$column_name])) {
                            \Log::info("✅ Kolom ditemukan: $column_name = " . $row[$column_name]);
                        } else {
                            \Log::warning("❌ Kolom TIDAK ditemukan di Excel: $column_name");
                        }

                        if (isset($row[$column_name]) && $row[$column_name] !== null) {
                            $poin = $row[$column_name];

                            // Cari sub_attribute yang cocok dengan nilai
                            $sub = SubAttribute::where('attribute_id', $attribute->id)
                                ->where('nilai_min', '<=', $poin)
                                ->where('nilai_max', '>=', $poin)
                                ->first();

                            // Kalau ditemukan, ambil nilai_id dari sub kriteria
                            if ($sub) {
                                NilaiSiswa::create([
                                    'mahasiswa_id' => $siswa->id,
                                    'nilai_id' => $sub->nilai_id, // ini yang wajib dipakai
                                    'poin' => $poin,
                                ]);
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            report($e); // Gunakan logging daripada redirect
            throw $e;
        }
    }
}
