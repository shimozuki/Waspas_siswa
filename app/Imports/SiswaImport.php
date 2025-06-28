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
                    // Simpan data mahasiswa langsung, tanpa referensi tabel jurusan
                    $siswa = Mahasiswa::create([
                        'no_reg' => $row['nisn'],
                        'nama' => $row['nama'],
                        'jenis_kelamin' => $row['jenis_kelamin'],
                        'asal_kelas' => $row['asal_kelas'] ?? '-', // opsional fallback
                        'tahun_ajaran' => $row['tahun_ajaran'],
                        'jurusan' => $row['jurusan'], // ⬅️ langsung dari excel ke kolom jurusan
                    ]);

                    foreach ($attributes as $attribute) {
                        $column_name = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $attribute->nama), '_'));

                        if (isset($row[$column_name])) {
                            $poin = $row[$column_name];

                            $sub = SubAttribute::where('attribute_id', $attribute->id)
                                ->where('nilai_min', '<=', $poin)
                                ->where('nilai_max', '>=', $poin)
                                ->first();

                            if ($sub) {
                                NilaiSiswa::create([
                                    'mahasiswa_id' => $siswa->id,
                                    'nilai_id' => $sub->nilai_id,
                                    'poin' => $poin,
                                ]);
                            } else {
                                \Log::warning("❌ SubAttribute tidak ditemukan: attribute_id {$attribute->id}, poin: $poin");
                            }
                        } else {
                            \Log::warning("❌ Kolom tidak ditemukan di Excel: $column_name");
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            report($e);
            throw $e;
        }
    }
}
