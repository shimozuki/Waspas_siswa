<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\NilaiSiswa;
use App\Models\SubAttribute;
use App\Models\Attribute;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    // Tambahkan properti ini di atas dalam class
    public $berhasil = 0;
    public $gagal = 0;
    public $log_gagal = [];

    public function collection(Collection $collection)
    {
        try {
            // Validasi kolom wajib
            $requiredColumns = ['nisn', 'nama', 'jenis_kelamin', 'asal_kelas', 'tahun_ajaran', 'jurusan'];
            $headers = array_keys($collection->first()?->toArray() ?? []);
            $missing = array_diff($requiredColumns, $headers);

            if (!empty($missing)) {
                throw new \Exception('❌ Kolom berikut tidak ditemukan di file Excel: ' . implode(', ', $missing));
            }

            $attributes = Attribute::all();

            foreach ($collection as $row) {
                try {
                    // Validasi data dasar
                    $validator = Validator::make($row->toArray(), [
                        'nisn' => 'required|numeric|unique:mahasiswas,no_reg',
                        'nama' => 'required|string',
                        'jenis_kelamin' => 'required|in:L,P',
                        'asal_kelas' => 'nullable|string',
                        'tahun_ajaran' => 'required|digits:4',
                        'jurusan' => 'nullable|string',
                    ]);

                    if ($validator->fails()) {
                        $msg = "❌ Data tidak valid untuk NISN: {$row['nisn']} | " . implode(', ', $validator->errors()->all());
                        \Log::warning($msg);
                        $this->gagal++;
                        $this->log_gagal[] = $msg;
                        continue;
                    }

                    // Cek duplikasi berdasarkan NISN
                    if (Mahasiswa::where('no_reg', $row['nisn'])->exists()) {
                        $msg = "⚠️ Duplikat data ditemukan. Siswa dengan NISN {$row['nisn']} sudah ada.";
                        \Log::info($msg);
                        $this->gagal++;
                        $this->log_gagal[] = $msg;
                        continue;
                    }

                    // Simpan Mahasiswa
                    $siswa = Mahasiswa::create([
                        'no_reg' => $row['nisn'],
                        'nama' => $row['nama'],
                        'jenis_kelamin' => $row['jenis_kelamin'],
                        'asal_kelas' => $row['asal_kelas'] ?? '-',
                        'tahun_ajaran' => $row['tahun_ajaran'],
                        'jurusan' => $row['jurusan'],
                    ]);

                    // Normalisasi nama kolom agar aman
                    $normalize = function ($name) {
                        return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $name), '_'));
                    };

                    foreach ($attributes as $attribute) {
                        $column_name = $normalize($attribute->nama);

                        if (!isset($row[$column_name])) {
                            \Log::warning("⚠️ Kolom tidak ditemukan: $column_name (attribute: {$attribute->nama})");
                            continue;
                        }

                        $poin = $row[$column_name];

                        // Cari sub attribute sesuai poin
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
                    }
                } catch (\Exception $e) {
                    \Log::error("❌ Gagal proses baris: " . json_encode($row->toArray()) . ' | Error: ' . $e->getMessage());
                    continue;
                }
            }
        } catch (\Exception $e) {
            \Log::error("❌ Gagal proses file Excel: " . $e->getMessage());
            report($e);
            throw $e;
        }
    }

    public function getHasil()
    {
        return [
            'berhasil' => $this->berhasil,
            'gagal' => $this->gagal,
            'log' => $this->log_gagal,
        ];
    }
}
