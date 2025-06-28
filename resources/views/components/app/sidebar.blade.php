<div>
    <!-- Sidebar backdrop (mobile only) -->
    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-slate-800 p-4 transition-all duration-200 ease-in-out"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false" x-cloak="lg">

        <!-- Sidebar header -->
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen"
                aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="block lg:mx-auto" href="{{ route('dashboard') }}">
                <span class="font-semibold text-white text-lg mx-auto">
                    {{ config('app.name') }}
                </span>
            </a>
        </div>

        <!-- Links -->
        <div class="space-y-8">
            <!-- Pages group -->
            <div>
                <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Pages</span>
                </h3>

                <ul class="mt-3">
                    @if (auth()->user()->id == '1')
                    <!-- Dashboard -->
                    <li
                        class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Request::segment(2), ['dashboard'])) {{ 'bg-slate-900' }} @endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Request::segment(2), ['dashboard'])) {{ 'hover:text-slate-200' }} @endif"
                            href="{{ route('dashboard') }}">
                            <div class="flex items-center">
                                <i
                                    class="fa-solid fa-house text-xl {{ in_array(Request::segment(2), ['dashboard']) ? 'text-indigo-500' : 'text-slate-600' }}"></i>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                            </div>
                        </a>
                    </li>

                    <!-- Attribute -->
                    <li
                        class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Request::segment(2), ['kriteria'])) {{ 'bg-slate-900' }} @endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Request::segment(2), ['kriteria'])) {{ 'hover:text-slate-200' }} @endif"
                            href="{{ route('attribute.index') }}">
                            <div class="flex items-center">
                                <i
                                    class="fa-solid fa-dollar-sign text-xl {{ in_array(Request::segment(2), ['kriteria']) ? 'text-indigo-500' : 'text-slate-600' }}"></i>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Kriteria</span>
                            </div>
                        </a>
                    </li>
                    <!-- Nilai -->
                    <li
                        class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Request::segment(2), ['nilai'])) {{ 'bg-slate-900' }} @endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Request::segment(2), ['nilai'])) {{ 'hover:text-slate-200' }} @endif"
                            href="{{ route('nilai.index') }}">
                            <div class="flex items-center">
                                <i
                                    class="fa-solid fa-rectangle-list text-xl {{ in_array(Request::segment(2), ['nilai']) ? 'text-indigo-500' : 'text-slate-600' }}"></i>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Nilai</span>
                            </div>
                        </a>
                    </li>
                    <!-- SubAttribute -->
                    <li
                        class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Request::segment(2), ['sub-kriteria'])) {{ 'bg-slate-900' }} @endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Request::segment(2), ['sub-kriteria'])) {{ 'hover:text-slate-200' }} @endif"
                            href="{{ route('sub-attribute.index') }}">
                            <div class="flex items-center">
                                <i
                                    class="fa-solid fa-list-ol text-xl {{ in_array(Request::segment(2), ['sub-kriteria']) ? 'text-indigo-500' : 'text-slate-600' }}"></i>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Sub
                                    Kriteria</span>
                            </div>
                        </a>
                    </li>
                    <li
                        class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Request::segment(2), ['siswa'])) {{ 'bg-slate-900' }} @endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Request::segment(2), ['siswa'])) {{ 'hover:text-slate-200' }} @endif"
                            href="{{ route('mahasiswa.index') }}">
                            <div class="flex items-center">
                                <i
                                    class="fa-solid fa-users text-xl {{ in_array(Request::segment(2), ['siswa']) ? 'text-indigo-500' : 'text-slate-600' }}"></i>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Data
                                    Siswa</span>
                            </div>
                        </a>
                    </li>
                    <!-- Perhitungan -->
                    <li
                        class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Request::segment(2), ['perhitungan'])) {{ 'bg-slate-900' }} @endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Request::segment(2), ['perhitungan'])) {{ 'hover:text-slate-200' }} @endif"
                            href="{{ route('perhitungan.index') }}">
                            <div class="flex items-center">
                                <i
                                    class="fa-solid fa-calculator text-xl {{ in_array(Request::segment(2), ['perhitungan']) ? 'text-indigo-500' : 'text-slate-600' }}"></i>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Perhitungan
                                    WASPAS</span>
                            </div>
                        </a>
                    </li>
                    @endif
                    <!-- Hasil Perangkingan -->
                    <li
                        class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if (in_array(Request::segment(2), ['hasil'])) {{ 'bg-slate-900' }} @endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if (in_array(Request::segment(2), ['hasil'])) {{ 'hover:text-slate-200' }} @endif"
                            href="{{ route('hasil.index') }}">
                            <div class="flex items-center">
                                <i
                                    class="fa-solid fa-square-poll-vertical text-xl {{ in_array(Request::segment(2), ['hasil']) ? 'text-indigo-500' : 'text-slate-600' }}"></i>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Hasil
                                    Perangkingan</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- More group -->
        </div>

        <!-- Expand / collapse button -->
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="px-3 py-2">
                <button @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                        <path class="text-slate-400"
                            d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                        <path class="text-slate-600" d="M3 23H1V1h2z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>