@extends('layouts.coordinator')

@section('content')
    <div class="px-2 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold">Batch Management</h1>
            <p class="text-[#737373] mt-2 font-medium">Kelola batch pelatihan</p>
        </div>
        <button @click="openAddBatch = true"
            class="flex items-center bg-[#0059FF] text-white rounded-lg px-3 gap-3 py-2 w-fit cursor-pointer hover:bg-blue-700 transition font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            <span>Buat Batch Baru</span>
        </button>
    </div>

    <!-- Modal Buat Batch -->
    <div x-show="openAddBatch" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white w-full max-w-2xl rounded-2xl p-6 relative max-h-[89vh] overflow-y-auto">
            <button @click="openAddBatch = false" class="absolute top-6 right-6 text-[#737373] hover:text-black">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M18 6l-12 12" />
                    <path d="M6 6l12 12" />
                </svg>
            </button>
            <div class="flex justify-between items-center mb-4 p-2">
                <div>
                    <h2 class="text-xl font-semibold">Buat Batch Baru</h2>
                    <p class="text-[#737373]">Buat batch pelatihan baru dengan jadwal, trainer, dan tugas</p>
                </div>
            </div>
            <form method="POST" action="{{ route('batch-management.store') }}">
                @csrf
                <div class="space-y-4 bg-gray-50 rounded-xl px-6 py-1 mx-2 mb-2 pb-7">
                    <h1 class="text-black text-md font-medium pt-2">Informasi Dasar</h1>
                    <div>
                        <label class="text-md font-semibold text-gray-700">
                            Judul Batch <span class="text-[#ff0000] text-lg">*</span>
                        </label>
                        <input type="text" name="title"
                            class="w-full mt-1 px-3 py-2
                            border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                            dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm text-md"
                            placeholder="Contoh: Python Game Developer Batch 1" required>
                    </div>
                    <div>
                        <label class="text-md font-semibold text-gray-700">
                            Deskripsi <span class="text-[#ff0000] text-lg">*</span>
                        </label>
                        <textarea name="description" required
                            class="bg-gray-200 focus:ring-[#10AF13] focus:border-[#10AF13] border-none text-md rounded-xl w-full resize-none focus:border-double"
                            rows="4" placeholder="Berikan deskripsi..."></textarea>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                Kategori Pelatihan <span class="text-[#ff0000] text-lg">*</span>
                            </label>

                            <!-- Dropdown Kategori -->
                            <div x-data="{ open: false, value: '', label: 'Pilih Kategori' }" class="relative w-full">
                                <button @click="open = !open"
                                    :class="open
                                        ?
                                        'border-[#10AF13] ring-1 ring-[#10AF13]' :
                                        'border-gray-300'"
                                    class="mt-1 w-full px-3 py-2 rounded-md border cursor-pointer
                                    flex justify-between items-center bg-white transition text-md"
                                    type="button">
                                    <span x-text="label"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="#374151" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M6 9l6 6l6 -6" />
                                    </svg>
                                </button>

                                <!-- Dropdown Content -->
                                <div x-show="open" @click.outside="open = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute z-20 mt-2 w-full bg-white border rounded-lg shadow-md overflow-hidden max-h-52 overflow-y-auto">
                                    <!-- Default -->
                                    <div @click="
                                                value='';
                                                label='Pilih Kategori';
                                                open=false
                                            "
                                        class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">
                                        <span>Pilih Kategori</span>
                                        <!-- Check Icon -->
                                        <svg x-show="value === ''" width="16" height="16" viewBox="0 0 24 24"
                                            fill="none" stroke="#10AF13" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l5 5l10 -10" />
                                        </svg>
                                    </div>
                                    @foreach ($categories as $category)
                                        <!-- Data Kategori -->
                                        <div @click="
                                                value='{{ $category->id }}';
                                                label='{{ $category->name }}';
                                                open=false
                                            "
                                            class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">
                                            <span>{{ $category->name }}</span>
                                            <!-- Check Icon -->
                                            <svg x-show="value === '{{ $category->id }}'" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="#10AF13" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 12l5 5l10 -10" />
                                            </svg>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Hidden input untuk backend -->
                                <input type="hidden" name="category_id" :value="value" required>
                            </div>
                        </div>
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                Trainer <span class="text-[#ff0000] text-lg">*</span>
                            </label>

                            <!-- Dropdown Trainer -->
                            <div x-data="{ open: false, value: '', label: 'Pilih Trainer' }" class="relative w-full">
                                <button @click="open = !open"
                                    :class="open
                                        ?
                                        'border-[#10AF13] ring-1 ring-[#10AF13]' :
                                        'border-gray-300'"
                                    class="mt-1 w-full px-3 py-2 rounded-md border cursor-pointer
                                    flex justify-between items-center bg-white transition text-md"
                                    type="button">
                                    <span x-text="label"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="#374151" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M6 9l6 6l6 -6" />
                                    </svg>
                                </button>

                                <!-- Dropdown Content -->
                                <div x-show="open" @click.outside="open = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute z-20 mt-2 w-full bg-white border rounded-lg shadow-md overflow-hidden max-h-52 overflow-y-auto">
                                    <!-- Default -->
                                    <div @click="
                                                value='';
                                                label='Pilih Trainer';
                                                open=false
                                            "
                                        class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">
                                        <span>Pilih Trainer</span>
                                        <!-- Check Icon -->
                                        <svg x-show="value === ''" width="16" height="16" viewBox="0 0 24 24"
                                            fill="none" stroke="#10AF13" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l5 5l10 -10" />
                                        </svg>
                                    </div>
                                    @foreach ($trainers as $trainer)
                                        <!-- Data Kategori -->
                                        <div @click="
                                                value='{{ $trainer->id }}';
                                                label='{{ $trainer->name }}';
                                                open=false
                                            "
                                            class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">
                                            <span>{{ $trainer->name }}</span>
                                            <!-- Check Icon -->
                                            <svg x-show="value === '{{ $trainer->id }}'" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="#10AF13" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 12l5 5l10 -10" />
                                            </svg>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Hidden input untuk backend -->
                                <input type="hidden" name="trainer_id" :value="value" required>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <hr>
                    </div>

                    <h1 class="text-black text-md font-medium">Jadwal</h1>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                Tanggal Mulai <span class="text-[#ff0000] text-lg">*</span>
                            </label>
                            <input type="date" name="start_date"
                                class="w-full mt-1 px-3 py-2
                                border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm text-md">
                        </div>
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                Tanggal Selesai <span class="text-[#ff0000] text-lg">*</span>
                            </label>
                            <input type="date" name="end_date"
                                class="w-full mt-1 px-3 py-2
                                border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm text-md">
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                Waktu Mulai <span class="text-[#ff0000] text-lg">*</span>
                            </label>
                            <input type="time" name="start_time"
                                class="w-full mt-1 px-3 py-2
                                border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm text-md">
                        </div>
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                Waktu Selesai <span class="text-[#ff0000] text-lg">*</span>
                            </label>
                            <input type="time" name="end_time"
                                class="w-full mt-1 px-3 py-2
                                border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm text-md">
                        </div>
                    </div>

                    <div class="pt-4">
                        <hr>
                    </div>

                    <h1 class="text-black text-md font-medium">Jumlah Peserta dan Link Zoom</h1>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                Min Peserta <span class="text-[#ff0000] text-lg">*</span>
                            </label>
                            <input type="number" name="min_quota"
                                class="w-full mt-1 px-3 py-2
                                border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm text-md">
                        </div>
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                Max Peserta <span class="text-[#ff0000] text-lg">*</span>
                            </label>
                            <input type="number" name="max_quota"
                                class="w-full mt-1 px-3 py-2
                                border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm text-md">
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-1 gap-4">
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                Zoom Link <span class="text-[#ff0000] text-lg">*</span>
                            </label>
                            <input type="text" name="zoom_link"
                                class="w-full mt-1 px-3 py-2
                                border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm text-md"
                                placeholder="https://zoom.us/j/i">
                        </div>
                    </div>
                </div>

                <hr class="mt-4 ms-2 me-2">

                <div class="flex justify-end gap-3 pt-4 me-2">
                    <button type="button" @click="openAddBatch = false"
                        class="px-4 py-2 border rounded-lg hover:bg-gray-50 font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-[#10AF13] text-white rounded-lg hover:bg-[#0e8e0f] font-medium">
                        Buat Batch
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-8 px-2">
        @include('dashboard.card', [
            'title' => 'Total Batch',
            'value' => $batchCounts['totalBatches'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="none" stroke="#5EABD6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2zm20 0h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>',
            'color' => 'text-[#5EABD6]',
        ])
        @include('dashboard.card', [
            'title' => 'Scheduled',
            'value' => $batchCounts['scheduled'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="24" height="24" viewBox="0 0 24 24" 
                                        stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" />
                                        <path d="M8 3v4" /><path d="M4 11h16" /></svg>',
            'color' => 'text-[#0059FF]',
        ])
        @include('dashboard.card', [
            'title' => 'Ongoing',
            'value' => $batchCounts['ongoing'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-loader-2" width="24" height="24" 
                                        viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2"><path d="M12 3 a9 9 0 1 0 9 9" /></svg>',
            'color' => 'text-[#10AF13]',
        ])
        @include('dashboard.card', [
            'title' => 'Completed',
            'value' => $batchCounts['completed'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-progress-check"><path stroke="none" d="M0 0h24v24H0z" 
                                        fill="none"/><path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" /><path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" />
                                        <path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" /><path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" />
                                        <path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" /><path d="M9 12l2 2l4 -4" /></svg>',
            'color' => 'text-[#FF4D00]',
        ])
    </div>

    {{-- Search and Filter --}}
    <form method="GET" action="{{ route('batch-management') }}">
        <div class="grid grid-cols-1 border lg:grid-cols-2 gap-4 px-5 bg-white py-6 rounded-2xl mt-8 mx-2">
            <!-- Search -->
            <div class="flex items-center bg-[#F1F1F1] rounded-lg px-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="text-[#737373]">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                    <path d="M21 21l-6 -6" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    @input.debounce.500ms="$el.closest('form').submit()"
                    class="w-full border-0 focus:ring-0 text-sm bg-[#F1F1F1] placeholder-[#737373]"
                    placeholder="Cari batch, kategori, atau trainer..." />
            </div>

            <!-- Dropdown Status -->
            <div x-data="{ 
                    open: false, 
                    value: '{{ request('statusBatch') }}', 
                    label: '{{ request('statusBatch') ? ucfirst(request('statusBatch')) : 'Semua Status' }}'
                }" 
                class="relative w-full">
                <button type="button" @click="open = !open"
                    :class="open
                        ?
                        'border-[#10AF13] ring-1 ring-[#10AF13]' :
                        'border-gray-300'"
                    class="w-full px-3 py-2 rounded-lg border cursor-pointer
                    flex justify-between items-center text-sm bg-white transition">
                    <span x-text="label"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="#374151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M6 9l6 6l6 -6" />
                    </svg>
                </button>

                <!-- Dropdown Content -->
                <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute z-20 mt-2 w-full bg-white border rounded-lg shadow-md overflow-hidden">

                    <!-- Item -->
                    <template
                        x-for="item in [
                        { value: '', label: 'Semua Status' },
                        { value: 'scheduled', label: 'Scheduled' },
                        { value: 'ongoing', label: 'Ongoing' },
                        { value: 'completed', label: 'Completed' }
                    ]"
                        :key="item.value">

                        <div 
                            @click="
                                value = item.value; 
                                label = item.label; 
                                open = false;
                                $nextTick(() => $el.closest('form').submit())
                            "
                            class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">

                            <span x-text="item.label"></span>

                            <!-- Check Icon -->
                            <svg x-show="value === item.value" xmlns="http://www.w3.org/2000/svg" width="16"
                                height="16" viewBox="0 0 24 24" fill="none" stroke="#10AF13" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l5 5l10 -10" />
                            </svg>
                        </div>
                    </template>
                </div>

                <!-- Hidden input untuk backend -->
                <input type="hidden" name="statusBatch" :value="value">
            </div>
        </div>
    </form>

    {{-- Jika tidak ada batch --}}
    @if ($batches->isEmpty())
        @php
            $status = request('statusBatch');
            $search = request('search');

            $statusLabel = match ($status) {
                'scheduled' => 'Scheduled',
                'ongoing'   => 'Ongoing',
                'completed' => 'Completed',
                default     => null,
            };
        @endphp

        <div class="p-11 border border-dashed rounded-2xl bg-gray-50 transition mt-8 mx-2 text-center">
            <div class="flex justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                    stroke-width="2"
                    d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2zm20 0h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"
                    class="text-gray-300"/>
                </svg>
            </div>

            <p class="text-md font-medium text-gray-700">
                @if ($statusLabel && $search)
                    Tidak ada batch yang memiliki status
                    <strong>{{ $statusLabel }}</strong>
                    dengan kata kunci
                    <strong>"{{ $search }}"</strong>.
                @elseif ($statusLabel)
                    Tidak ada batch dengan status
                    <strong>{{ $statusLabel }}</strong>.
                @elseif ($search)
                    Tidak ada batch dengan kata kunci
                    <strong>"{{ $search }}"</strong>.
                @else
                    Tidak ada batch yang tersedia.
                @endif
            </p>
        </div>
    @endif

    {{-- Batch List --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-8 px-2">
        @foreach ($batches as $batch)
            <div x-data="{ openEditBatch: false, openDeleteBatch: false }"
                class="bg-white border rounded-2xl p-6 flex flex-col h-33 hover:shadow-md transition">
                <!-- TOP: Title + Status -->
                <div class="flex justify-between items-start">
                    <h1 class="text-black font-bold text-xl">
                        {{ $batch->title }}
                    </h1>

                    @php
                        $statusBatch = match ($batch->status) {
                            'Scheduled' => 'bg-blue-100 text-[#0059FF]',
                            'Ongoing' => 'bg-green-100 text-[#10AF13]',
                            'Completed' => 'bg-orange-100 text-[#FF4D00]',
                        };
                    @endphp

                    <div class="px-3 py-1 font-medium rounded-full uppercase {{ $statusBatch }}">
                        <p class="text-xs">{{ $batch->status }}</p>
                    </div>
                </div>

                <!-- Sub Title -->
                <div class="flex items-start mt-1">
                    <h2 class="text-gray-600 font-medium text-base">
                        {{ $batch->display_code ?? '-' }}
                    </h2>
                </div>

                <div class="px-3 py-1 w-fit mt-4 font-bold rounded-lg border">
                    <p class="text-xs">{{ $batch->category->name ?? '-' }}</p>
                </div>

                <!-- BOTTOM: VALUE -->
                <div class="mt-5 flex gap-2 text-gray-600 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="20"
                        height="20" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                        <path d="M16 3v4" />
                        <path d="M8 3v4" />
                        <path d="M4 11h16" />
                    </svg>
                    <p class="text-md font-medium">
                        {{ \Carbon\Carbon::parse($batch->start_date)->format('d/m/Y') }}
                    </p>
                </div>
                <div class="mt-2 flex gap-2 text-gray-600 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-9">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M12 12h-3.5" />
                        <path d="M12 7v5" />
                    </svg>
                    <p class="text-md font-medium">
                        {{ \Carbon\Carbon::parse($batch->start_date)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($batch->end_date)->format('H:i') }}
                    </p>
                </div>
                <div class="mt-2 flex gap-2 text-gray-600 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                    </svg>
                    <p class="text-md font-medium">
                        {{ $batch->active_participants_count ?? 0 }} / {{ $batch->max_quota }} peserta
                    </p>
                </div>

                <hr class="border-gray-200 mt-3">

                <div class="flex items-start gap-20">
                    <div class="mt-2">
                        <h2 class="text-md font-medium text-gray-600">
                            Trainer
                        </h2>
                        <p class="text-md font-medium text-black">
                            {{ $batch->trainer->name ?? '-' }}
                        </p>
                    </div>
                </div>

                <hr class="border-gray-200 mt-3">

                <div class="mt-2 flex gap-2 items-center justify-between">
                    <button @click="openEditBatch = true"
                        class="border py-2 rounded-lg w-full text-sm font-semibold text-black hover:bg-gray-100">
                        Edit
                    </button>
                    <button @click="openDeleteBatch = true"
                        class="border py-2 rounded-lg px-4 text-sm font-semibold text-[#ff0000] hover:bg-gray-100">
                        Hapus
                    </button>
                </div>

                <!-- Modal Edit Batch -->
                <div x-show="openEditBatch" x-cloak x-transition
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                    <div class="bg-white w-full max-w-2xl rounded-2xl p-6 relative max-h-[89vh] overflow-y-auto">
                        <button @click="openEditBatch = false"
                            class="absolute top-6 right-6 text-[#737373] hover:text-black">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M18 6l-12 12" />
                                <path d="M6 6l12 12" />
                            </svg>
                        </button>
                        <div class="flex justify-between items-center mb-4 p-2">
                            <div>
                                <h2 class="text-xl font-semibold">Edit Batch</h2>
                                <p class="text-[#737373]">Ubah informasi batch pelatihan</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('batch-management.update', $batch->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="space-y-4 bg-gray-50 rounded-xl px-6 py-1 mx-2 mb-2 pb-7">
                                <h1 class="text-black text-md font-medium pt-2">Informasi Dasar</h1>
                                <div>
                                    <label class="text-md font-semibold text-gray-700">
                                        Judul Batch <span class="text-[#ff0000] text-lg">*</span>
                                    </label>
                                    <input type="text" name="title" value="{{ old('title', $batch->title) }}"
                                        class="w-full mt-1 px-3 py-2
                                        border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                        dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm font-medium"
                                        placeholder="Contoh: Python Game Developer Batch 1" required>
                                </div>
                                <div>
                                    <label class="text-md font-semibold text-gray-700">
                                        Deskripsi <span class="text-[#ff0000] text-lg">*</span>
                                    </label>
                                    <textarea name="description" required
                                        class="bg-gray-200 focus:ring-[#10AF13] focus:border-[#10AF13] border-none font-medium rounded-xl w-full resize-none focus:border-double"
                                        rows="4" placeholder="Berikan deskripsi...">{{ old('description', $batch->description) }}</textarea>
                                </div>
                                <div class="grid sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-md font-semibold text-gray-700">
                                            Kategori Pelatihan <span class="text-[#ff0000] text-lg">*</span>
                                        </label>

                                        <!-- Dropdown Kategori -->
                                        <div x-data="{
                                                open: false,
                                                value: '{{ old('category_id', $batch->category_id) }}',
                                                label: '{{ old('category_id')
                                                    ? optional($categories->firstWhere('id', old('category_id')))->name
                                                    : optional($categories->firstWhere('id', $batch->category_id))->name 
                                                }}'
                                            }" 
                                            class="relative w-full">
                                            <button @click="open = !open"
                                                :class="open
                                                    ?
                                                    'border-[#10AF13] ring-1 ring-[#10AF13]' :
                                                    'border-gray-300'"
                                                class="mt-1 w-full px-3 py-2 rounded-md border cursor-pointer
                                                flex justify-between items-center bg-white transition text-md"
                                                type="button">
                                                <span x-text="label"></span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="#374151" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M6 9l6 6l6 -6" />
                                                </svg>
                                            </button>

                                            <!-- Dropdown Content -->
                                            <div x-show="open" @click.outside="open = false"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-150"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95"
                                                class="absolute z-20 mt-2 w-full bg-white border rounded-lg shadow-md overflow-hidden max-h-52 overflow-y-auto">
                                                <!-- Default -->
                                                <div @click="
                                                        value='';
                                                        label='Pilih Kategori';
                                                        open=false
                                                    "
                                                    class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">
                                                    <span>Pilih Kategori</span>
                                                    <!-- Check Icon -->
                                                    <svg x-show="value === ''" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="#10AF13"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M5 12l5 5l10 -10" />
                                                    </svg>
                                                </div>
                                                @foreach ($categories as $category)
                                                    <!-- Data Kategori -->
                                                    <div @click="
                                                            value='{{ $category->id }}';
                                                            label='{{ $category->name }}';
                                                            open=false
                                                        "
                                                        class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">
                                                        <span>{{ $category->name }}</span>
                                                        <!-- Check Icon -->
                                                        <svg x-show="value === '{{ $category->id }}'" width="16"
                                                            height="16" viewBox="0 0 24 24" fill="none"
                                                            stroke="#10AF13" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M5 12l5 5l10 -10" />
                                                        </svg>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Hidden input untuk backend -->
                                            <input type="hidden" name="category_id" :value="value" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-md font-semibold text-gray-700">
                                            Trainer <span class="text-[#ff0000] text-lg">*</span>
                                        </label>
                                        <!-- Dropdown Trainer -->
                                        <div x-data="{
                                            open: false,
                                            value: '{{ old('trainer_id', $batch->trainer_id) }}',
                                            label: '{{ old('trainer_id')
                                                ? optional($trainers->firstWhere('id', old('trainer_id')))->name
                                                : optional($trainers->firstWhere('id', $batch->trainer_id))->name }}'
                                        }" class="relative w-full">
                                            <button @click="open = !open"
                                                :class="open
                                                    ?
                                                    'border-[#10AF13] ring-1 ring-[#10AF13]' :
                                                    'border-gray-300'"
                                                class="mt-1 w-full px-3 py-2 rounded-md border cursor-pointer
                                                flex justify-between items-center bg-white transition text-md"
                                                type="button">
                                                <span x-text="label"></span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="#374151" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M6 9l6 6l6 -6" />
                                                </svg>
                                            </button>

                                            <!-- Dropdown Content -->
                                            <div x-show="open" @click.outside="open = false"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-150"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95"
                                                class="absolute z-20 mt-2 w-full bg-white border rounded-lg shadow-md overflow-hidden max-h-52 overflow-y-auto">
                                                <!-- Default -->
                                                <div @click="
                                                value='';
                                                label='Pilih Trainer';
                                                open=false
                                            "
                                                    class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">
                                                    <span>Pilih Trainer</span>
                                                    <!-- Check Icon -->
                                                    <svg x-show="value === ''" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="#10AF13"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M5 12l5 5l10 -10" />
                                                    </svg>
                                                </div>
                                                @foreach ($trainers as $trainer)
                                                    <!-- Data Kategori -->
                                                    <div @click="
                                                value='{{ $trainer->id }}';
                                                label='{{ $trainer->name }}';
                                                open=false
                                            "
                                                        class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">
                                                        <span>{{ $trainer->name }}</span>
                                                        <!-- Check Icon -->
                                                        <svg x-show="value === '{{ $trainer->id }}'" width="16"
                                                            height="16" viewBox="0 0 24 24" fill="none"
                                                            stroke="#10AF13" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M5 12l5 5l10 -10" />
                                                        </svg>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Hidden input untuk backend -->
                                            <input type="hidden" name="trainer_id" :value="value" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <hr>
                                </div>

                                <h1 class="text-black text-md font-medium">Jadwal</h1>
                                <div class="grid sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-md font-semibold text-gray-700">
                                            Tanggal Mulai <span class="text-[#ff0000] text-lg">*</span>
                                        </label>
                                        <input type="date" name="start_date"
                                            value="{{ old('start_date', \Carbon\Carbon::parse($batch->start_date)->format('Y-m-d')) }}"
                                            class="w-full mt-1 px-3 py-2
                                            border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                            dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm font-medium">
                                    </div>
                                    <div>
                                        <label class="text-md font-semibold text-gray-700">
                                            Tanggal Selesai <span class="text-[#ff0000] text-lg">*</span>
                                        </label>
                                        <input type="date" name="end_date"
                                            value="{{ old('end_date', \Carbon\Carbon::parse($batch->end_date)->format('Y-m-d')) }}"
                                            class="w-full mt-1 px-3 py-2
                                            border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                            dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm font-medium">
                                    </div>
                                </div>
                                <div class="grid sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-md font-semibold text-gray-700">
                                            Waktu Mulai <span class="text-[#ff0000] text-lg">*</span>
                                        </label>
                                        <input type="time" name="start_time"
                                            value="{{ old('start_time', \Carbon\Carbon::parse($batch->start_date)->format('H:i')) }}"
                                            class="w-full mt-1 px-3 py-2
                                            border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                            dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm font-medium">
                                    </div>
                                    <div>
                                        <label class="text-md font-semibold text-gray-700">
                                            Waktu Selesai <span class="text-[#ff0000] text-lg">*</span>
                                        </label>
                                        <input type="time" name="end_time"
                                            value="{{ old('end_time', \Carbon\Carbon::parse($batch->end_date)->format('H:i')) }}"
                                            class="w-full mt-1 px-3 py-2
                                            border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                            dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm font-medium">
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <hr>
                                </div>

                                <h1 class="text-black text-md font-medium">Jumlah Peserta dan Link Zoom</h1>
                                <div class="grid sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-md font-semibold text-gray-700">
                                            Min Peserta <span class="text-[#ff0000] text-lg">*</span>
                                        </label>
                                        <input type="number" name="min_quota"
                                            value="{{ old('min_quota', $batch->min_quota) }}"
                                            class="w-full mt-1 px-3 py-2
                                            border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                            dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm font-medium">
                                    </div>
                                    <div>
                                        <label class="text-md font-semibold text-gray-700">
                                            Max Peserta <span class="text-[#ff0000] text-lg">*</span>
                                        </label>
                                        <input type="number" name="max_quota"
                                            value="{{ old('max_quota', $batch->max_quota) }}"
                                            class="w-full mt-1 px-3 py-2
                                            border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                            dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm font-medium">
                                    </div>
                                </div>
                                <div class="grid sm:grid-cols-1 gap-4">
                                    <div>
                                        <label class="text-md font-semibold text-gray-700">
                                            Zoom Link <span class="text-[#ff0000] text-lg">*</span>
                                        </label>
                                        <input type="text" name="zoom_link"
                                            value="{{ old('zoom_link', $batch->zoom_link) }}"
                                            class="w-full mt-1 px-3 py-2
                                            border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                            dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm font-medium"
                                            placeholder="https://zoom.us/j/i">
                                    </div>
                                </div>
                            </div>

                            <hr class="mt-4 ms-2 me-2">

                            <div class="flex justify-end gap-3 pt-4 me-2">
                                <button type="button" @click="openEditBatch = false"
                                    class="px-4 py-2 border rounded-lg hover:bg-gray-50 font-medium">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-[#10AF13] text-white rounded-lg hover:bg-[#0e8e0f] font-medium">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Delete Batch -->
                <div x-show="openDeleteBatch" x-cloak x-transition
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                    <div class="bg-white w-full max-w-md rounded-2xl p-6 space-y-4">

                        <!-- Icon -->
                        <div class="flex justify-center text-[#ff0000]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentcolor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                                <path d="M9 9l6 6" />
                                <path d="M15 9l-6 6" />
                            </svg>

                        </div>

                        <!-- Text -->
                        <div class="text-center">
                            <h2 class="text-2xl font-semibold">Hapus Batch</h2>
                            <p class="text-gray-600 mt-2">
                                Apakah Anda yakin ingin menghapus
                                <span class="font-semibold">
                                    {{ $batch->title }}
                                </span>
                                dari daftar batch pelatihan?
                            </p>
                        </div>

                        <!-- Aksi -->
                        <div class="flex justify-end gap-3 pt-4">
                            <button @click="openDeleteBatch = false"
                                class="px-4 py-2 border rounded-lg hover:bg-gray-50 font-medium">
                                Batal
                            </button>
                            <form action="{{ route('batch-management.destroy', $batch->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 bg-[#ff0000] text-white rounded-lg hover:bg-[#E81B1B] font-medium">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
