<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div
                class="w-full lg:w-1/2 mx-auto xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100">Form Tambah Sub Kriteria</h2>
                </header>
                <div class="p-3">
                    <form action="{{ route('sub-attribute.save') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <x-jet-label for="jurusan" value="{{ __('Jurusan') }}" />
                            <select id="jurusan" name="jurusan_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Pilih Jurusan</option>
                                @foreach ($jurusan as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <x-jet-label for="kriteria" value="{{ __('Kriteria') }}" />
                            <select id="kriteria" name="attribute_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Pilih Kriteria</option>
                                @foreach ($attributes as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <x-jet-label for="nilai" value="{{ __('Nilai') }}" />
                            <select id="nilai" name="nilai_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Pilih Nilai yg digunakan</option>
                                @foreach ($nilai as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <x-jet-validation-errors class="mb-4" />
                        <div class="flex flex-wrap justify-between">
                            <a href="{{ route('sub-attribute.index') }}"
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
