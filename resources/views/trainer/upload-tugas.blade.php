@extends('layouts.trainer')

@section('content')
    <div class="px-2 flex justify-between items-center" x-data="{ openUploadTugas: false }">
        <div>
            <h1 class="text-2xl font-semibold">Upload Tugas</h1>
            <p class="text-[#737373] mt-2 font-medium">Kelola tugas dan assignment untuk peserta pelatihan</p>
        </div>
        <button @click="openUploadTugas = true"
            class="flex items-center bg-[#0059FF] text-white rounded-lg px-3 gap-3 py-2 w-fit cursor-pointer hover:bg-blue-700 transitionn font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            <span>Buat Tugas Baru</span>
        </button>

        <!-- Modal Upload Tugas -->
        <div x-show="openUploadTugas" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div class="bg-white w-full max-w-2xl rounded-2xl p-6 relative max-h-[89vh] overflow-y-auto">
                <button @click="openUploadTugas = false" class="absolute top-6 right-6 text-[#737373] hover:text-black">
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
                        <h2 class="text-xl font-semibold">Buat Tugas Baru</h2>
                        <p class="text-[#737373]">Buat tugas baru untuk peserta pelatihan</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('upload-tugas.store') }}">
                    @csrf
                    <div class="space-y-4 bg-gray-50 rounded-xl px-6 py-4 mx-2 mb-2 pb-7">
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                Batch <span class="text-[#ff0000] text-lg">*</span>
                            </label>

                            <!-- Dropdown Batch -->
                            <div x-data="{ open: false, value: '', label: 'Pilih Batch' }" class="relative w-full">
                                <button @click="open = !open"
                                    :class="open
                                        ?
                                        'border-[#10AF13] ring-1 ring-[#10AF13]' :
                                        'border-gray-300'"
                                    class="w-full px-3 py-2 rounded-md border cursor-pointer
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

                                    <div @click="
                                            value = ''; 
                                            label = 'Pilih Batch';
                                            open = false
                                        "
                                        class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">
                                        <span>Pilih Batch</span>
                                        <!-- Check Icon -->
                                        <svg x-show="value === ''" xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" viewBox="0 0 24 24" fill="none" stroke="#10AF13"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l5 5l10 -10" />
                                        </svg>
                                    </div>
                                    @foreach ($batches as $batch)
                                        {{-- Data Batch --}}
                                        <div @click="
                                                value = '{{ $batch->id }}'; 
                                                label = '{{ $batch->title }}';
                                                open = false
                                            "
                                            class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">
                                            <span>{{ $batch->title }}</span>
                                            <!-- Check Icon -->
                                            <svg x-show="value === '{{ $batch->id }}'" xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="16" viewBox="0 0 24 24" fill="none"
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
                                <input type="hidden" name="batch_id" :value="value" required>
                            </div>
                        </div>
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                Judul Tugas <span class="text-[#ff0000] text-lg">*</span>
                            </label>
                            <input type="text" name="title"
                                class="w-full mt-1 px-3 py-2 text-md
                                border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm"
                                placeholder="Contoh: Project Akhir - Membuat Game Sederhana" required>
                        </div>
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                Deskripsi <span class="text-[#ff0000] text-lg">*</span>
                            </label>
                            <textarea
                                class="bg-gray-200 focus:ring-[#10AF13] focus:border-[#10AF13] border-none rounded-xl w-full resize-none focus:border-double"
                                rows="4" placeholder="Jelaskan detail tugas, kriteria penilaian, dan format pengumpulan tugas..."
                                name="description" required></textarea>
                            <p class="text-md font-medium text-gray-500">
                                Berikan instruksi yang jelas dan lengkap untuk peserta
                            </p>
                        </div>
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                Deadline <span class="text-[#ff0000] text-lg">*</span>
                            </label>
                            <input type="date" name="deadline"
                                class="w-full mt-1 px-3 py-2
                                border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm font-medium">
                            <p class="text-md font-medium text-gray-500 pt-2">
                                Tentukan batas waktu pengumpulan tugas
                            </p>
                        </div>
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                Link Lampiran <span class="text-[#ff0000] text-lg">*</span>
                            </label>
                            <input type="url" name="link_lampiran"
                                class="w-full mt-1px-3 py-2
                                border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm"
                                placeholder="https://drive.google.com/..." required>
                            <p class="text-md font-medium text-gray-500 pt-2">
                                Link ke file template, panduan, atau resource tambahan
                            </p>
                        </div>
                    </div>

                    <hr class="mt-4 ms-2 me-2">

                    <!-- Button -->
                    <div class="mt-3 flex justify-end gap-3 me-2">
                        <button @click="openUploadTugas = false"
                            class="gap-3 px-4 py-2 border rounded-lg hover:bg-gray-50 font-medium">
                            Batal
                        </button>
                        <button
                            class="justify-center gap-3 px-4 py-2 rounded-lg text-white bg-[#10AF13] hover:bg-[#0e8e0f] font-medium">
                            Buat Tugas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-8 px-2">
        @include('dashboard.card', [
            'title' => 'Total Tugas',
            'value' => $taskCounts['totalTasks'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                                                                                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                                                                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-file-text"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                                                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                                                                                                                <path d="M9 9l1 0" /><path d="M9 13l6 0" /><path d="M9 17l6 0" /></svg>',
            'color' => 'text-[#0059FF]',
        ])
        @include('dashboard.card', [
            'title' => 'Aktif',
            'value' => $taskCounts['totalAktif'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                                                                                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-4">
                                                                                                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 12l3 2" /><path d="M12 7v5" /></svg>',
            'color' => 'text-[#10AF13]',
        ])
        @include('dashboard.card', [
            'title' => 'Terlambat',
            'value' => $taskCounts['totalTerlambat'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="24"
                                                                                                                                                height="24" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"
                                                                                                                                                stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                                                                                <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                                                                                                                <path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /></svg>',
            'color' => 'text-[#ff0000]',
        ])
        @include('dashboard.card', [
            'title' => 'Batch Aktif',
            'value' => $batchCounts['totalBatches'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="#5EABD6" stroke-linecap="round" stroke-linejoin="round" 
                                                                                                                                                stroke-width="2" d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2zm20 0h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7zM6 8h2m-2 4h2m8-4h2m-2 4h2"/></svg>',
            'color' => 'text-[#5EABD6]',
        ])
    </div>

    <!-- List Batch -->
    @foreach ($batches as $batch)
        <div class="bg-white border rounded-2xl p-6 mt-8 mx-2">
            <div class="flex justify-between items-center">
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="text-lg font-semibold">
                            {{ $batch->title }}
                        </h2>
                        <div class="px-2 border rounded-lg bg-blue-50">
                            <p class="text-sm font-medium text-[#0059FF]">
                                {{ $batch->display_code ?? '-' }}
                            </p>
                        </div>
                    </div>
                    <p class="text-md font-medium text-gray-600">
                        {{ \Carbon\Carbon::parse($batch->start_date)->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::parse($batch->end_date)->format('d/m/Y') }}
                    </p>
                </div>
                <div class="flex border px-2 rounded-lg items-center gap-1 font-medium text-sm">
                    <p>{{ $batch->tasks->count() }}</p>
                    <p>tugas</p>
                </div>
            </div>

            {{-- List Tugas --}}
            <div class="mt-5 space-y-4 max-h-[450px] overflow-y-auto pr-1">
                @forelse ($batch->tasks as $task)
                    @php
                        $isLate = \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($task->deadline));
                    @endphp
                    <div class="p-4 border rounded-xl hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 flex-1 pr-8">
                                <div class="{{ $isLate ? 'bg-red-100' : 'bg-green-100' }} p-2 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-file-text {{ $isLate ? 'text-[#ff0000]' : 'text-[#10AF13]' }}">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                        <path d="M9 9l1 0" />
                                        <path d="M9 13l6 0" />
                                        <path d="M9 17l6 0" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3">
                                        <h3 class="text-md font-medium text-gray-800">
                                            {{ $task->title }}
                                        </h3>
                                        @if ($isLate)
                                            <div class="px-2 rounded-lg bg-red-100">
                                                <p class="text-sm font-medium text-[#ff0000]">
                                                    Terlambat
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                    <p class="text-md text-[#737373] font-medium">
                                        {{ $task->description }}
                                    </p>
                                </div>
                            </div>

                            <div x-data="{
                                openEditTugas: false,
                                openDeleteTugas: false,
                                editTugas: {
                                    id: null,
                                    batch_id: null,
                                    title: '',
                                    description: '',
                                    deadline: '',
                                    link_lampiran: '',
                                }
                            }" class="flex items-center gap-4 shrink-0">

                                {{-- Button Edit --}}
                                <button
                                    @click="
                                            openEditTugas = true;
                                            editTugas = {
                                                id: {{ $task->id }},
                                                batch_id: {{ $task->batch_id }},
                                                title: @js($task->title),
                                                description: @js($task->description),
                                                deadline: '{{ \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') }}',
                                                link_lampiran: @js($task->link_lampiran),
                                            }
                                    "
                                    class="px-3 py-1 text-sm font-medium rounded-lg border flex justify-center items-center gap-3 hover:bg-gray-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>
                                    <p>Edit</p>
                                </button>

                                <!-- Modal Edit Tugas -->
                                <div x-show="openEditTugas" x-cloak x-transition
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                                    <div class="bg-white w-full max-w-2xl rounded-2xl p-6 relative max-h-[89vh] overflow-y-auto">
                                        <button @click="openEditTugas = false"
                                            class="absolute top-6 right-6 text-[#737373] hover:text-black">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M18 6l-12 12" />
                                                <path d="M6 6l12 12" />
                                            </svg>
                                        </button>
                                        <div class="flex justify-between items-center mb-4 p-2">
                                            <div>
                                                <h2 class="text-xl font-semibold">Edit Tugas</h2>
                                                <p class="text-[#737373]">Update informasi tugas untuk peserta</p>
                                            </div>
                                        </div>
                                        <form method="POST" action="{{ route('upload-tugas.update', $task->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="space-y-4 bg-gray-50 rounded-xl px-6 py-4 mx-2 mb-2 pb-7">
                                                <div>
                                                    <label class="text-md font-semibold text-gray-700">
                                                        Batch <span class="text-[#ff0000] text-lg">*</span>
                                                    </label>

                                                    <!-- Dropdown Batch -->
                                                    <div x-data="{
                                                        open: false,
                                                        value: null,
                                                        label: 'Pilih Batch',
                                                    }" x-init="$watch('editTugas.batch_id', newBatchId => {
                                                        value = String(newBatchId)
                                                        label = daftarBatch[newBatchId] ?? 'Pilih Batch'
                                                    });"
                                                        class="relative w-full">
                                                        <button @click="open = !open"
                                                            :class="open
                                                                ?
                                                                'border-[#10AF13] ring-1 ring-[#10AF13]' :
                                                                'border-gray-300'"
                                                            class="w-full px-3 py-2 rounded-md border cursor-pointer
                                                            flex justify-between items-center bg-white transition text-md"
                                                            type="button">
                                                            <span x-text="label"></span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" viewBox="0 0 24 24" fill="none"
                                                                stroke="#374151" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
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

                                                            <div @click="
                                                                    value = ''; 
                                                                    label = 'Pilih Batch';
                                                                    open = false
                                                                "
                                                                class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">
                                                                <span>Pilih Batch</span>
                                                                <!-- Check Icon -->
                                                                <svg x-show="value === ''"
                                                                    xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" viewBox="0 0 24 24" fill="none"
                                                                    stroke="#10AF13" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M5 12l5 5l10 -10" />
                                                                </svg>
                                                            </div>
                                                            @foreach ($batches as $batch)
                                                                {{-- Data Batch --}}
                                                                <div @click="
                                                                        value = '{{ $batch->id }}'; 
                                                                        label = '{{ $batch->title }}';
                                                                        open = false
                                                                    "
                                                                    class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">
                                                                    <span>{{ $batch->title }}</span>
                                                                    <!-- Check Icon -->
                                                                    <svg x-show="value === '{{ $batch->id }}'"
                                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                                        height="16" viewBox="0 0 24 24" fill="none"
                                                                        stroke="#10AF13" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path d="M5 12l5 5l10 -10" />
                                                                    </svg>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <!-- Hidden input untuk backend -->
                                                        <input type="hidden" name="batch_id" :value="value"
                                                            required>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="text-md font-semibold text-gray-700">
                                                        Judul Tugas <span class="text-[#ff0000] text-lg">*</span>
                                                    </label>
                                                    <input type="text" name="title" x-model="editTugas.title"
                                                        class="w-full mt-1 px-3 py-2 text-md
                                                        border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                                        dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm"
                                                        placeholder="Contoh: Project Akhir - Membuat Game Sederhana"
                                                        required>
                                                </div>
                                                <div>
                                                    <label class="text-md font-semibold text-gray-700">
                                                        Deskripsi <span class="text-[#ff0000] text-lg">*</span>
                                                    </label>
                                                    <textarea
                                                        class="bg-gray-200 focus:ring-[#10AF13] focus:border-[#10AF13] border-none rounded-xl w-full resize-none focus:border-double"
                                                        rows="4" placeholder="Jelaskan detail tugas, kriteria penilaian, dan format pengumpulan tugas..."
                                                        name="description" x-model="editTugas.description" required></textarea>
                                                    <p class="text-md font-medium text-gray-500">
                                                        Berikan instruksi yang jelas dan lengkap untuk peserta
                                                    </p>
                                                </div>
                                                <div>
                                                    <label class="text-md font-semibold text-gray-700">
                                                        Deadline <span class="text-[#ff0000] text-lg">*</span>
                                                    </label>
                                                    <input type="date" name="deadline" x-model="editTugas.deadline"
                                                        class="w-full mt-1 px-3 py-2
                                                        border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                                        dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm font-medium">
                                                    <p class="text-md font-medium text-gray-500 pt-2">
                                                        Tentukan batas waktu pengumpulan tugas
                                                    </p>
                                                </div>
                                                <div>
                                                    <label class="text-md font-semibold text-gray-700">
                                                        Link Lampiran <span class="text-[#ff0000] text-lg">*</span>
                                                    </label>
                                                    <input type="url" name="link_lampiran"
                                                        x-model="editTugas.link_lampiran"
                                                        class="w-full mt-1px-3 py-2
                                                        border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                                        dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm"
                                                        placeholder="https://drive.google.com/..." required>
                                                    <p class="text-md font-medium text-gray-500 pt-2">
                                                        Link ke file template, panduan, atau resource tambahan
                                                    </p>
                                                </div>
                                            </div>

                                            <hr class="mt-4 ms-2 me-2">

                                            <!-- Button -->
                                            <div class="mt-3 flex justify-end gap-3 me-2">
                                                <button @click="openEditTugas = false" type="button"
                                                    class="gap-3 px-4 py-2 border rounded-lg hover:bg-gray-50 font-medium">
                                                    Batal
                                                </button>
                                                <button
                                                    class="justify-center gap-3 px-4 py-2 rounded-lg text-white bg-[#10AF13] hover:bg-[#0e8e0f] font-medium">
                                                    Simpan Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                {{-- Button Hapus --}}
                                <button class="text-[#ff0000] hover:text-[#E81B1B]" @click="openDeleteTugas = true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>

                                <!-- Modal Delete Tugas -->
                                <div x-show="openDeleteTugas" x-cloak x-transition
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                                    <div class="bg-white w-full max-w-md rounded-2xl p-6 space-y-4">

                                        <!-- Icon -->
                                        <div class="flex justify-center text-[#ff0000]">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-file-x">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                <path
                                                    d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                                                <path d="M10 12l4 4m0 -4l-4 4" />
                                            </svg>
                                        </div>

                                        <!-- Text -->
                                        <div class="text-center">
                                            <h2 class="text-2xl font-semibold">Hapus Tugas</h2>
                                            <p class="text-gray-600 mt-2">
                                                Apakah Anda yakin ingin menghapus tugas
                                                <span class="font-semibold">
                                                    {{ $task->title }}
                                                </span>
                                                dari batch <strong>{{ $task->batch->title }}</strong>?
                                            </p>
                                        </div>

                                        <!-- Aksi -->
                                        <div class="flex justify-end gap-3 pt-4">
                                            <button @click="openDeleteTugas = false"
                                                class="px-4 py-2 border rounded-lg hover:bg-gray-50 font-medium">
                                                Batal
                                            </button>
                                            <form action="{{ route('upload-tugas.destroy', $task->id) }}" method="POST">
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
                        </div>
                        <div class="flex gap-4 ml-12">
                            <div class="flex items-center gap-1 mt-1 text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-due">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                    <path d="M16 3v4" />
                                    <path d="M8 3v4" />
                                    <path d="M4 11h16" />
                                    <path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                </svg>
                                <p class="text-md font-medium text-gray-700">
                                    Deadline: {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('l, j F Y') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-1 mt-1 text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12.5 21h-6.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v5" />
                                    <path d="M16 3v4" />
                                    <path d="M8 3v4" />
                                    <path d="M4 11h16" />
                                    <path d="M16 19h6" />
                                    <path d="M19 16v6" />
                                </svg>
                                <p class="text-md font-medium text-gray-700">
                                    Created: {{ \Carbon\Carbon::parse($task->created_at)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <script>
                        const daftarBatch = @json($batches->pluck('title', 'id'));
                    </script>
                @empty
                    <div class="mt-5 max-h-[360px] overflow-y-auto pr-1" x-data="{ openUploadTugasPertama: false }">
                        <div class="p-11 border border-dashed rounded-xl bg-gray-50 transition">
                            <div class="flex justify-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-text text-gray-300">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                    <path d="M9 9l1 0" />
                                    <path d="M9 13l6 0" />
                                    <path d="M9 17l6 0" />
                                </svg>
                            </div>
                            <div class="flex justify-center mb-2">
                                <p class="text-md font-medium text-gray-700">
                                    Belum ada tugas untuk batch ini.
                                </p>
                            </div>
                            <div class="flex justify-center">
                                <button @click="openUploadTugasPertama = true"
                                    class="flex items-center bg-[#10AF13] text-white rounded-lg px-3 gap-3 py-1 w-fit cursor-pointer hover:bg-[#0e8e0f] transitionn font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    <span>Buat Tugas Pertama</span>
                                </button>

                                <!-- Modal Upload Tugas Pertama -->
                                <div x-show="openUploadTugasPertama" x-cloak x-transition
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                                    <div class="bg-white w-full max-w-2xl rounded-2xl p-6 relative max-h-[89vh] overflow-y-auto">
                                        <button @click="openUploadTugasPertama = false"
                                            class="absolute top-6 right-6 text-[#737373] hover:text-black">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M18 6l-12 12" />
                                                <path d="M6 6l12 12" />
                                            </svg>
                                        </button>
                                        <div class="flex justify-between items-center mb-4 p-2">
                                            <div>
                                                <h2 class="text-xl font-semibold">Buat Tugas Baru</h2>
                                                <p class="text-[#737373]">Buat tugas baru untuk peserta pelatihan</p>
                                            </div>
                                        </div>
                                        <form method="POST" action="{{ route('upload-tugas.store') }}">
                                            @csrf
                                            <div class="space-y-4 bg-gray-50 rounded-xl px-6 py-4 mx-2 mb-2 pb-7">
                                                <div>
                                                    <label class="text-md font-semibold text-gray-700">
                                                        Batch <span class="text-[#ff0000] text-lg">*</span>
                                                    </label>

                                                    <!-- Dropdown Batch -->
                                                    <div x-data="{
                                                            open: false,
                                                            value: '{{ $batch->id }}',
                                                            label: '{{ $batch->title ?? 'Tidak ada batch tersedia' }}'
                                                        }"
                                                        class="relative w-full">
                                                        <button @click="open = !open"
                                                            :class="open
                                                                ?
                                                                'border-[#10AF13] ring-1 ring-[#10AF13]' :
                                                                'border-gray-300'"
                                                            class="w-full px-3 py-2 rounded-md border cursor-pointer
                                                                flex justify-between items-center bg-white transition text-md"
                                                            type="button">
                                                            <span x-text="label"></span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" viewBox="0 0 24 24" fill="none"
                                                                stroke="#374151" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
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

                                                            <div @click="
                                                                        value = ''; 
                                                                        label = 'Pilih Batch';
                                                                        open = false
                                                                    "
                                                                class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">
                                                                <span>Pilih Batch</span>
                                                                <!-- Check Icon -->
                                                                <svg x-show="value === ''"
                                                                    xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" viewBox="0 0 24 24" fill="none"
                                                                    stroke="#10AF13" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M5 12l5 5l10 -10" />
                                                                </svg>
                                                            </div>
                                                            @foreach ($batchesWithoutTasks as $batch)
                                                                {{-- Data Batch --}}
                                                                <div @click="
                                                                            value = '{{ $batch->id }}'; 
                                                                            label = '{{ $batch->title }}';
                                                                            open = false
                                                                        "
                                                                    class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">
                                                                    <span>{{ $batch->title }}</span>
                                                                    <!-- Check Icon -->
                                                                    <svg x-show="value === '{{ $batch->id }}'"
                                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                                        height="16" viewBox="0 0 24 24" fill="none"
                                                                        stroke="#10AF13" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path d="M5 12l5 5l10 -10" />
                                                                    </svg>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <!-- Hidden input untuk backend -->
                                                        <input type="hidden" name="batch_id" :value="value"
                                                            required>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="text-md font-semibold text-gray-700">
                                                        Judul Tugas <span class="text-[#ff0000] text-lg">*</span>
                                                    </label>
                                                    <input type="text" name="title"
                                                        class="w-full mt-1 px-3 py-2 text-md
                                                            border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                                            dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm"
                                                        placeholder="Contoh: Project Akhir - Membuat Game Sederhana"
                                                        required>
                                                </div>
                                                <div>
                                                    <label class="text-md font-semibold text-gray-700">
                                                        Deskripsi <span class="text-[#ff0000] text-lg">*</span>
                                                    </label>
                                                    <textarea
                                                        class="bg-gray-200 focus:ring-[#10AF13] focus:border-[#10AF13] border-none rounded-xl w-full resize-none focus:border-double"
                                                        rows="4" placeholder="Jelaskan detail tugas, kriteria penilaian, dan format pengumpulan tugas..."
                                                        name="description" required></textarea>
                                                    <p class="text-md font-medium text-gray-500">
                                                        Berikan instruksi yang jelas dan lengkap untuk peserta
                                                    </p>
                                                </div>
                                                <div>
                                                    <label class="text-md font-semibold text-gray-700">
                                                        Deadline <span class="text-[#ff0000] text-lg">*</span>
                                                    </label>
                                                    <input type="date" name="deadline"
                                                        class="w-full mt-1 px-3 py-2
                                                            border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                                            dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm font-medium">
                                                    <p class="text-md font-medium text-gray-500 pt-2">
                                                        Tentukan batas waktu pengumpulan tugas
                                                    </p>
                                                </div>
                                                <div>
                                                    <label class="text-md font-semibold text-gray-700">
                                                        Link Lampiran <span class="text-[#ff0000] text-lg">*</span>
                                                    </label>
                                                    <input type="text" name="link_lampiran"
                                                        class="w-full mt-1px-3 py-2
                                                            border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                                            dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm"
                                                        placeholder="https://drive.google.com/..." required>
                                                    <p class="text-md font-medium text-gray-500 pt-2">
                                                        Link ke file template, panduan, atau resource tambahan
                                                    </p>
                                                </div>
                                            </div>

                                            <hr class="mt-4 ms-2 me-2">

                                            <!-- Button -->
                                            <div class="mt-3 flex justify-end gap-3 me-2">
                                                <button @click="openUploadTugasPertama = false"
                                                    class="gap-3 px-4 py-2 border rounded-lg hover:bg-gray-50 font-medium">
                                                    Batal
                                                </button>
                                                <button
                                                    class="justify-center gap-3 px-4 py-2 rounded-lg text-white bg-[#10AF13] hover:bg-[#0e8e0f] font-medium">
                                                    Buat Tugas
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    @endforeach
@endsection
