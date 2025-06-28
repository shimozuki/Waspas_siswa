<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        {{-- Tombol Simpan Qi --}}
        @if (!$hasHasil)
        <div class="px-5 pb-4">
            <form action="{{ route('perhitungan.save') }}" method="POST">
                @csrf
                <input type="hidden" name="tahun_ajaran" value="{{ request('tahun_ajaran') }}">
                <button class="mt-3 btn bg-indigo-500 hover:bg-indigo-600 text-white">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span class="ml-2">Simpan Nilai Qi ke Tabel Hasil</span>
                </button>
            </form>
        </div>
        @endif
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div
                class="w-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <div class="flex flex-wrap justify-between">
                    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Normalisasi Kriteria</h2>
                    </header>
                    <form method="GET" action="{{ route('perhitungan.index') }}">
                        <select name="tahun_ajaran" onchange="this.form.submit()">
                            @if(request('tahun_ajaran') == null)
                            <option value="" selected disabled>-- pilih tahun --</option>
                            @endif
                            @foreach($tahunAjarans as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun_ajaran') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                {{-- Tabel Kriteria dan Bobot --}}
                <div class="p-3">
                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table id="tableIndex" class="table-auto w-full dark:text-slate-300">
                            <!-- Table header -->
                            <thead
                                class="text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Nama Kriteria</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Kode Kriteria</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Bobot</div>
                                    </th>
                                </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="text-sm font-medium divide-y divide-slate-100 dark:divide-slate-700">
                                <!-- Row -->
                                @foreach ($data['attributes'] as $attribute)
                                <tr>
                                    <td class="p-2">
                                        <div class="text-left">{{ $attribute->nama }}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left">{{ $attribute->kode }}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left">{{ $attribute->bobot }}</div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{--Tabel Nilai Asli--}}
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="w-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <div class="flex flex-wrap justify-between bg-slate-200">
                    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Data Awal</h2>
                    </header>
                </div>
                <div class="p-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full dark:text-slate-300 mb-4">
                            <!-- Header -->
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-left border p-2">Nama Siswa</th>
                                    <th class="text-center border p-2" colspan="{{ $data['attributes']->count() }}">Nilai Bobot Kriteria</th>
                                </tr>
                                <tr>
                                    @foreach ($data['attributes'] as $attribute)
                                    <th class="border text-center p-2">{{ $attribute->kode }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data['mahasiswas'] as $mahasiswa)
                                <tr>
                                    <td class="p-2"><Strong>{{ $mahasiswa->nama }}</Strong></td>
                                    @foreach ($data['attributes'] as $attribute)
                                    @php
                                    $nilai = $mahasiswa->nilaiSiswa
                                    ->filter(fn($ns) => \App\Models\SubAttribute::where('nilai_id', $ns->nilai_id)
                                    ->where('attribute_id', $attribute->id)->exists())
                                    ->first();
                                    @endphp
                                    <td class="text-center p-2">
                                        {{ $nilai?->poin ?? '-' }}
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $data['mahasiswas']->links() }}
                    </div>
                </div>
            </div>
        </div>

        {{--Matriks Normalisasi--}}
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="w-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <div class="flex flex-wrap justify-between bg-green-200">
                    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Normalisasi Matriks</h2>
                    </header>
                </div>
                <div class="p-3">
                    <div class="overflow-x-auto">
                        <table id="tableIndex" class="table-auto w-full dark:text-slate-300 mb-4">
                            <!-- Table header -->
                            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm">
                                <tr>
                                    <th rowspan="2" class="text-left border p-2">Nama Siswa</th>
                                    <th class="text-center border p-2" colspan="{{ $data['attributes']->count() }}">Attribute</th>
                                </tr>
                                <tr>
                                    @foreach ($data['attributes'] as $attribute)
                                    <th class="border text-center p-2">{{ $attribute->kode }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="text-sm font-medium divide-y divide-slate-100 dark:divide-slate-700">
                                @foreach ($data['mahasiswas'] as $mahasiswa)
                                <tr>
                                    <th scope="row" class="p-2 text-left">{{ $mahasiswa->nama }}</th>
                                    @foreach ($data['attributes'] as $attribute)
                                    <td class="p-2 text-center">
                                        @php
                                        $nilaiNorm = $normalisasi[$mahasiswa->id][$attribute->id] ?? 0;
                                        @endphp
                                        {{ number_format($nilaiNorm, 2) }}
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                        {{ $data['mahasiswas']->links() }}
                    </div>
                </div>
            </div>
        </div>
        {{-- Perhitungan Nilai Qi Detail --}}
        <div class="w-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 mt-6">
            <div class="flex flex-wrap justify-between bg-blue-200">
                <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100">Detail Perhitungan Nilai Qi</h2>
                </header>
            </div>
            <div class="p-3 overflow-x-auto">
                <table class="table-auto w-full dark:text-slate-300 text-sm">
                    <thead class="bg-slate-100 text-slate-600">
                        <tr>
                            <th class="p-2 border">Nama Siswa</th>
                            @foreach ($data['attributes'] as $attribute)
                            <th class="p-2 border">{{ $attribute->kode }}</th>
                            @endforeach
                            <th class="p-2 border bg-yellow-200">∑ (Wi * Rij)</th>
                            <th class="p-2 border bg-yellow-100">0.5 * ∑</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['mahasiswas'] as $mahasiswa)
                        <tr>
                            <td class="p-2 border font-semibold">{{ $mahasiswa->nama }}</td>
                            @php
                            $sum = 0;
                            @endphp
                            @foreach ($data['attributes'] as $attribute)
                            @php
                            $norm = $normalisasi[$mahasiswa->id][$attribute->id] ?? 0;
                            $bobot = $attribute->bobot;
                            $hasil = $norm * $bobot;
                            $sum += $hasil;
                            @endphp
                            <td class="p-2 border text-center">{{ number_format($hasil, 2) }}</td>
                            @endforeach
                            <td class="p-2 border text-center bg-yellow-200">{{ number_format($sum, 2) }}</td>
                            <td class="p-2 border text-center bg-yellow-100">{{ number_format($sum * 0.5, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Perhitungan Rij^Wi --}}
        <div class="w-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 mt-6">
            <div class="flex flex-wrap justify-between bg-blue-200">
                <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100">Perhitungan (Rij ^ Wi)</h2>
                </header>
            </div>
            <div class="p-3 overflow-x-auto">
                <table class="table-auto w-full dark:text-slate-300 text-sm">
                    <thead class="bg-slate-100 text-slate-600">
                        <tr>
                            <th class="p-2 border">Nama Siswa</th>
                            @foreach ($data['attributes'] as $attribute)
                            <th class="p-2 border">{{ $attribute->kode }}</th>
                            @endforeach
                            <th class="p-2 border bg-yellow-200">∏ (Rij ^ Wi)</th>
                            <th class="p-2 border bg-yellow-100">0.5 * ∏</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['mahasiswas'] as $mahasiswa)
                        <tr>
                            <td class="p-2 border font-semibold">{{ $mahasiswa->nama }}</td>
                            @php
                            $product = 1;
                            @endphp
                            @foreach ($data['attributes'] as $attribute)
                            @php
                            $norm = $normalisasi[$mahasiswa->id][$attribute->id] ?? 0;
                            $bobot = $attribute->bobot;
                            $pangkat = $norm > 0 ? pow($norm, $bobot) : 0;
                            $product *= $pangkat;
                            @endphp
                            <td class="p-2 border text-center">{{ number_format($pangkat, 2) }}</td>
                            @endforeach
                            <td class="p-2 border text-center bg-yellow-200">{{ number_format($product, 2) }}</td>
                            <td class="p-2 border text-center bg-yellow-100">{{ number_format($product * 0.5, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    </div>
</x-app-layout>