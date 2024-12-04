<x-guest-layout>
    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-7">
                <h1
                    class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">
                    Sistem Pendukung Keputusan Pemilihan Jurusan MAN 3 Langkat</h1>
                <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
                    Sistem Pendukung Keputusan penentuan Jurusan Siswa menggunakan Metode WASPAS</p>
                @if ($data['hasil'] != 0)
                    <a href="{{ route('guest.result.index') }}"
                        class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        Lihat Hasil Penjurusan
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                @endif
            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                <img src="{{ asset('images/illustration.svg') }}" alt="mockup">
            </div>
        </div>
    </section>
    <section class="bg-gray-50 dark:bg-gray-900" id="search">
        <div class="feature-1 py-8 md:py-12 px-4">
            <div class="container px-4 mx-auto">
                <div class="flex -mx-4">
                    <div class="px-4 text-center md:w-10/12 xl:w-8/12 mx-auto">
                        <h1 class="mb-4 text-4xl font-medium uppercase">Cari data siswa</h1>
                        <form class="max-w-md mx-auto" action="{{ route('guest.siswa.index') }}">
                            <label for="default-search"
                                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="search" id="default-search" name="siswa"
                                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Cari Nama Siswa..." required />
                                <button type="submit"
                                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cari</button>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="md:flex md:-mx-4 mt-12 md:pt-4">
                    <div class="px-4 md:w-1/3 mt-6 md:mt-0">
                        <div
                            class="feature-box text-center p-4 md:p-6 max-w-sm mx-auto border-2 border-solid border-gray-300 rounded md:h-full">
                            <div class="text-xl p-4 w-16 h-16 mx-auto">
                                <i class="fab fa-searchengin text-indigo-600 text-2xl"></i>
                            </div>
                            <h5 class="text-xl font-medium mb-4">Informasi Siswa</h5>
                            <p class="text-gray-600 mb-3">Temukan data siswa dengan mengetikkan nama siswa yang terdata
                                pada kolom pencarian</p>
                        </div>
                    </div>
                    <div class="px-4 md:w-1/3 mt-6 md:mt-0">
                        <div
                            class="feature-box text-center p-4 md:p-6 max-w-sm mx-auto border-2 border-solid border-gray-300 rounded md:h-full">
                            <div class="text-xl p-4 w-16 h-16 mx-auto">
                                <i class="fas fa-gears text-indigo-600 text-2xl"></i>
                            </div>
                            <h5 class="text-xl font-medium mb-4">Klasifikasi Siswa</h5>
                            <p class="text-gray-600 mb-3">Pengklasifikasian Jurusan siswa ditentukan oleh
                                kriteria-kriteria berdasarkan nilai siswa.</p>
                        </div>
                    </div>
                    <div class="px-4 md:w-1/3 mt-6 md:mt-0">
                        <div
                            class="feature-box text-center p-4 md:p-6 max-w-sm mx-auto border-2 border-solid border-gray-300 rounded md:h-full">
                            <div class="text-xl p-4 w-16 h-16 mx-auto">
                                <i class="fas fa-wrench text-indigo-600 text-2xl"></i>
                            </div>
                            <h5 class="text-xl font-medium mb-4">Mudah digunakan</h5>
                            <p class="text-gray-600 mb-3">Mudah digunakan oleh wali siswa dalam melihat perkembangan
                                siswa.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-white dark:bg-gray-900" id="demografi">
        <div class="feature-1 py-8 md:py-12 px-4">
            <div class="container px-4 mx-auto">
                <div class="flex -mx-4">
                    <div class="px-4 text-center md:w-10/12 xl:w-8/12 mx-auto">
                        <h1 class="mb-4 text-4xl font-medium uppercase">Demografi Siswa</h1>
                    </div>
                </div>

                <div class="md:flex md:-mx-4 mt-12 md:pt-4">
                    <div class="px-4 md:w-1/3 mt-6 md:mt-0">
                        <div
                            class="feature-box text-center p-4 md:p-6 max-w-sm mx-auto border-solid bg-indigo-300 hover:shadow-indigo-400 rounded md:h-full hover:shadow-xl transition ease-in-out duration-300">
                            <div class="text-xl p-4 w-16 h-16 mx-auto">
                                <i class="fas fa-mars text-white text-2xl"></i>
                            </div>
                            <h5 class="text-xl font-medium mb-4">Laki-Laki</h5>
                            <p class="text-gray-600 mb-3">
                                Jumlah laki-laki yang berada di MAN 3 Langkat adalah <span
                                    class="font-bold">{{ $data['male'] }}</span> Jiwa
                            </p>
                        </div>
                    </div>
                    <div class="px-4 md:w-1/3 mt-6 md:mt-0">
                        <div
                            class="feature-box text-center p-4 md:p-6 max-w-sm mx-auto border-solid bg-indigo-300 hover:shadow-indigo-400 rounded md:h-full hover:shadow-xl transition ease-in-out duration-300">
                            <div class="text-xl p-4 w-16 h-16 mx-auto">
                                <i class="fas fa-venus text-white text-2xl"></i>
                            </div>
                            <h5 class="text-xl font-medium mb-4">Perempuan</h5>
                            <p class="text-gray-600 mb-3">
                                Jumlah Perempuan yang berada di MAN 3 Langkat adalah <span
                                    class="font-bold">{{ $data['female'] }}</span> Jiwa
                            </p>
                        </div>
                    </div>
                    <div class="px-4 md:w-1/3 mt-6 md:mt-0">
                        <div
                            class="feature-box text-center p-4 md:p-6 max-w-sm mx-auto border-solid bg-indigo-300 hover:shadow-indigo-400 rounded md:h-full hover:shadow-xl transition ease-in-out duration-300">
                            <div class="text-xl p-4 w-16 h-16 mx-auto">
                                <i class="fas fa-children text-white text-2xl"></i>
                            </div>
                            <h5 class="text-xl font-medium mb-4">Total</h5>
                            <p class="text-gray-600 mb-3">
                                Jumlah Total Laki-Laki dan Perempuan yang berada di MAN 3 Langkat adalah
                                <span class="font-bold">{{ $data['total'] }}</span> Jiwa
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-gray-50 dark:bg-gray-900" id="penjurusan">
        <div class="feature-1 py-8 md:py-12 px-4">
            <div class="container px-4 mx-auto">
                <div class="flex -mx-4">
                    <div class="px-4 text-center md:w-10/12 xl:w-8/12 mx-auto">
                        <h1 class="mb-4 text-4xl font-medium uppercase">Penjurusan</h1>
                    </div>
                </div>
                <div class="md:flex md:-mx-4 mt-12 md:pt-4">
                    @foreach ($data['jurusan'] as $jurusan)
                        <div class="px-4 md:w-1/3 mt-6 md:mt-0">
                            <div
                                class="feature-box text-center p-4 md:p-6 max-w-sm mx-auto border-2 border-solid border-gray-300 rounded md:h-full">
                                <div class="text-xl p-4 w-16 h-16 mx-auto">
                                    <i class="fas fa-building-columns text-indigo-600 text-2xl"></i>
                                </div>
                                <h5 class="text-xl font-medium mb-4">{{ $jurusan->nama }}</h5>
                                <p class="text-gray-600 mb-3">
                                    Jurusan <span class="font-bold">{{ $jurusan->nama }}</span> Memiliki Quota Sebanyak
                                    <span class="font-bold">{{ $jurusan->quota }}</span> Siswa
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="bg-white dark:bg-gray-900" id="kontak">
        <div class="feature-1 py-8 md:py-12 px-4">
            <div class="container px-4 mx-auto">
                <div class="flex -mx-4">
                    <div class="px-4 text-center md:w-10/12 xl:w-8/12 mx-auto">
                        <h1 class="mb-4 text-4xl font-medium uppercase">Hubungi Kami</h1>
                    </div>
                </div>
                <div class="w-full flex flex-wrap justify-between">
                    <div class="p-4">
                        <div class="mb-4">
                            <h1 class="font-bold text-2xl">
                                <i class="fa-solid fa-location-dot"></i>
                                Alamat
                            </h1>
                            <p class="font-semibolg text-gray-500 text-lg">
                                Jl. Proklamasi No.54, Kwala Bingai, Kec. Stabat,
                                Kabupaten Langkat, Sumatera Utara 20811
                            </p>
                        </div>
                        <div class="mb-4">
                            <h1 class="font-bold text-2xl">
                                <i class="fa-solid fa-envelope"></i>
                                Email
                            </h1>
                            <p class="font-semibolg text-gray-500 text-lg">
                                admin@gmail.com
                            </p>
                        </div>
                    </div>
                    <div class="p-2">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3981.427256183279!2d98.42258327584386!3d3.716599249400661!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30372b3bc8c7eb9d%3A0xeb6ade8b7c33c6a2!2sMAN%203%20LANGKAT!5e0!3m2!1sid!2sid!4v1721038538271!5m2!1sid!2sid"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
