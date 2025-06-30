<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        @auth
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-x-3">
                <a href="{{ route('hasil.export') }}"
                    class="btn bg-red-500 hover:bg-red-600 text-white {{ $status == 0 ? 'opacity-50 pointer-events-none cursor-not-allowed' : '' }}">
                    <i class="fa-solid fa-file-pdf"></i>
                    <span class="hidden xs:block ml-2">Export PDF</span>
                </a>
                @if (auth()->user()->id == '2' && $status == 0)
                <form action="{{ route('hasil.approve') }}" method="POST" onsubmit="return confirm('Yakin setujui hasil?')" class="m-0">
                    @csrf
                    <input type="hidden" name="tahun_ajaran" value="{{ $tahun_ajaran }}">
                    <button type="submit" class="btn bg-slate-500 hover:bg-slate-600 text-white">Setujui Hasil</button>
                </form>
                @endif
            </div>

            <form method="GET" action="{{ url()->current() }}" class="m-0">
                <div class="flex items-center gap-2">
                    <label for="tahun_ajaran" class="font-medium">Tahun Ajaran:</label>
                    <select id="tahun_ajaran" name="tahun_ajaran" onchange="this.form.submit()" class="border rounded px-2 py-1">
                        @foreach ($tahunAjarans as $ta)
                        <option value="{{ $ta }}" {{ $tahun_ajaran == $ta ? 'selected' : '' }}>
                            {{ $ta }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        @endauth

        <div class="relative overflow-x-auto">
            @auth
            <div class="bg-white rounded-t-lg p-4">
                <h5 class="mr-3 font-semibold dark:text-white">Hasil Perankingan</h5>
                @if ($status == 1)
                <span class="text-green-600 font-semibold">Sudah disetujui</span>
                @endif
            </div>
            @endauth

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Ranking</th>
                        <th scope="col" class="px-6 py-3">No Reg</th>
                        <th scope="col" class="px-6 py-3">Nama Siswa</th>
                        <th scope="col" class="px-6 py-3">Jenis Kelamin</th>
                        <th scope="col" class="px-6 py-3">Hasil Qi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $row->rank }}
                        </th>
                        <td class="px-6 py-4">{{ $row->mahasiswa->no_reg }}</td>
                        <td class="px-6 py-4">{{ $row->mahasiswa->nama }}</td>
                        <td class="px-6 py-4">{{ $row->mahasiswa->jenis_kelamin }}</td>
                        <td class="px-6 py-4">{{ number_format($row->qi, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-2">
                {{ $data->links() }}
            </div>
        </div>
    </div>

    <style>
        .dataTables_length select {
            width: 100px;
            padding: 5px;
            font-size: 14px;
        }
    </style>
</x-app-layout>