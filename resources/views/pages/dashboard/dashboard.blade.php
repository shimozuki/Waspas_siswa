<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Welcome banner -->
        <x-dashboard.welcome-banner />

        <!-- Cards dan Form -->
        <div class="grid grid-cols-12 gap-6">

            {{-- Kartu Jumlah --}}
            <x-dashboard.dashboard-card-users :mahasiswa="$data['mahasiswa']" />
            <x-dashboard.dashboard-card-jurusan :jurusan="$data['jurusan']" />
            <x-dashboard.dashboard-card-kriteria :kriteria="$data['kriteria']" />
            @if (auth()->user()->id == '1')
            {{-- Form Penentuan Kuota --}}
            <div class="col-span-12 lg:col-span-12 xl:col-span-8 bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Penentuan Kuota Penerimaan</h2>

                <form action="{{ route('kuota.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" id="tahun_ajaran" required
                                placeholder="Contoh: 2025/2026"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('tahun_ajaran')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Kuota</label>
                            <input type="number" name="jumlah" id="jumlah" required min="1"
                                placeholder="Contoh: 10"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('jumlah')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                            Simpan Kuota
                        </button>
                    </div>
                </form>
            </div>
            @endif


            {{-- Tabel Kuota Tersimpan --}}
            <div class="col-span-12 xl:col-span-8 bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Kuota Tersimpan</h2>

                @if($kuotaList->isEmpty())
                <p class="text-sm text-gray-500">Belum ada data kuota yang tersimpan.</p>
                @else
                <div class="col-span-12 xl:col-span-8 overflow-x-auto">
                    <table class="min-w-full w-full border border-gray-200 rounded-lg table-auto">
                        <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Tahun Ajaran</th>
                                <th class="px-4 py-2">Jumlah Kuota</th>
                                @if (auth()->user()->id == '1')
                                <th class="px-4 py-2">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-200">
                            @foreach($kuotaList as $index => $kuota)
                            <tr>
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $kuota->tahun_ajaran }}</td>
                                <td class="px-4 py-2">{{ $kuota->jumlah }}</td>
                                @if (auth()->user()->id == '1')
                                <td class="px-4 py-2 flex items-center gap-2">
                                    <!-- Tombol Edit -->
                                    <button
                                        type="button"
                                        onclick="openEditModal({{ $kuota->id }}, '{{ $kuota->tahun_ajaran }}', {{ $kuota->jumlah }})"
                                        class="text-blue-600 hover:text-blue-800 text-sm">
                                        Edit
                                    </button>

                                    <!-- Form Hapus -->
                                    <form action="{{ route('kuota.destroy', $kuota->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            <div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-40">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Edit Kuota</h2>
                    <form id="editKuotaForm" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" id="edit_id">

                        <div class="mb-4">
                            <label for="edit_tahun_ajaran" class="block text-sm font-medium text-gray-700">Tahun Ajaran</label>
                            <input type="text" id="edit_tahun_ajaran" name="tahun_ajaran" class="mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label for="edit_jumlah" class="block text-sm font-medium text-gray-700">Jumlah Kuota</label>
                            <input type="number" id="edit_jumlah" name="jumlah" class="mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded-md">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div> <!-- end grid-cols-12 -->

    </div>
    <!-- Modal Edit Kuota -->
    <script>
        function openEditModal(id, tahunAjaran, jumlah) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_tahun_ajaran').value = tahunAjaran;
            document.getElementById('edit_jumlah').value = jumlah;

            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('flex');
            document.getElementById('editModal').classList.add('hidden');
        }

        function openEditModal(id, tahunAjaran, jumlah) {
            const form = document.getElementById('editKuotaForm');

            // GANTI INI:
            form.action = `/admin/kuota/${id}`; // ← ini yang benar sesuai route

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_tahun_ajaran').value = tahunAjaran;
            document.getElementById('edit_jumlah').value = jumlah;

            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }
    </script>

</x-app-layout>