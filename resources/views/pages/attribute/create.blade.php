<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div
                class="w-full lg:w-1/2 mx-auto xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100">Form Tambah Kriteria</h2>
                </header>
                <div class="p-3">
                    <form action="{{ route('attribute.save') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <x-jet-label for="nama" value="{{ __('Nama Kriteria') }}" />
                            <x-jet-input id="nama" type="text" name="nama" :value="old('nama')" required autofocus />
                        </div>

                        <div class="mb-4">
                            <x-jet-label for="kode" value="{{ __('Kode Kriteria') }}" />
                            <x-jet-input id="kode" type="text" name="kode" :value="old('kode')" required />
                        </div>

                        <div class="mb-4">
                            <x-jet-label for="bobot" value="{{ __('Bobot Kriteria') }}" />
                            <x-jet-input id="bobot" type="number" name="bobot" :value="old('bobot')" step="0.01" min="0" placeholder="Contoh: 0.75" />
                        </div>

                        {{-- ⬇️ Tambahkan pilihan Cost / Benefit --}}
                        <div class="mb-4">
                            <x-jet-label for="tipe" value="{{ __('Tipe Kriteria') }}" />
                            <select id="tipe" name="tipe" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="benefit" {{ old('tipe') == 'benefit' ? 'selected' : '' }}>Benefit</option>
                                <option value="cost" {{ old('tipe') == 'cost' ? 'selected' : '' }}>Cost</option>
                            </select>
                        </div>

                        <x-jet-validation-errors class="mb-4" />

                        <div class="flex flex-wrap justify-between">
                            <a href="{{ route('attribute.index') }}"
                                class="btn bg-slate-500 hover:bg-slate-600 text-white">
                                <i class="fa-solid fa-chevron-left"></i>
                                <span class="hidden xs:block ml-2">Kembali</span>
                            </a>
                            <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span class="hidden xs:block ml-2">Simpan</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
</x-app-layout>