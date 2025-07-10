<x-guest-layout>
    <div class="p-8 bg-gray-100 min-h-screen">
        <div class="mb-4">
            <h1 class="font-semibold text-center text-2xl uppercase">Pengumuman Hasil Seleksi SNBP</h1>
            <p class="text-lg text-gray-500 text-center">
                Berikut adalah hasil dari seleksi SNBP dengan menggunakan metode WASPAS
            </p>
        </div>

        {{-- Filter Tahun Ajaran --}}
        <form method="GET" class="mb-6 max-w-xs mx-auto">
            <label for="tahun_ajaran" class="block mb-1 text-sm font-medium text-gray-700">Pilih Tahun Ajaran</label>
            <select name="tahun_ajaran" id="tahun_ajaran" onchange="this.form.submit()"
                class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2">
                @foreach ($tahunAjarans as $tahun)
                <option value="{{ $tahun }}" {{ $tahun == $tahun_ajaran ? 'selected' : '' }}>
                    {{ $tahun }}
                </option>
                @endforeach
            </select>
        </form>

        <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto">
            @auth
            <div class="mb-6 text-right">
                <a href="{{ route('hasil.export', ['tahun_ajaran' => $tahun_ajaran]) }}"
                    class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded shadow">
                    <i class="fa-solid fa-file-pdf mr-2"></i>
                    Export PDF
                </a>
            </div>
            @endauth

            {{-- CARD START --}}
            <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b">
                    <h5 class="text-lg font-semibold text-gray-800">Hasil Perankingan</h5>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs  uppercase">
                            <tr>
                                <th scope="col" class="px-6 py-3">Ranking</th>
                                <th scope="col" class="px-6 py-3">No Reg</th>
                                <th scope="col" class="px-6 py-3">Nama Siswa</th>
                                <th scope="col" class="px-6 py-3">Jenis Kelamin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $row->rank }}</td>
                                <td class="px-6 py-4">{{ $row->mahasiswa->no_reg ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $row->mahasiswa->nama ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $row->mahasiswa->jenis_kelamin ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="p-4">
                    {{ $data->links() }}
                </div>
            </div>
            {{-- CARD END --}}
        </div>
    </div>
</x-guest-layout>