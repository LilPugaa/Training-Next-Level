@extends('layouts.trainer')

@section('content')
    <div class="px-2 flex justify-between items-center" x-data="{ openUploadMateri: false }">
        <div>
            <h1 class="text-2xl font-semibold">Upload Materi</h1>
            <p class="text-[#737373] mt-2 font-medium">Kelola materi pelatihan untuk peserta</p>
        </div>
        <button @click="openUploadMateri = true"
            class="flex items-center bg-[#0059FF] text-white rounded-lg px-3 gap-3 py-2 w-fit cursor-pointer hover:bg-blue-700 transitionn font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-upload">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                <path d="M7 9l5 -5l5 5" />
                <path d="M12 4l0 12" />
            </svg>
            <span>Upload Materi</span>
        </button>

        <!-- Modal Upload Materi -->
        <div x-show="openUploadMateri" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div class="bg-white w-full max-w-xl rounded-2xl p-6 relative">
                <button @click="openUploadMateri = false" class="absolute top-6 right-6 text-[#737373] hover:text-black">
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
                        <h2 class="text-xl font-semibold">Upload Materi Baru</h2>
                        <p class="text-[#737373]">Upload materi pembelajaran untuk peserta</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('upload-materi.store') }}">
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
                                Judul Materi <span class="text-[#ff0000] text-lg">*</span>
                            </label>
                            <input type="text" name="judul_materi"
                                class="w-full mt-1 px-3 py-2
                                border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm text-md"
                                placeholder="Contoh: Modul Python Game Development" required>
                        </div>
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                Tipe materi <span class="text-[#ff0000] text-lg">*</span>
                            </label>

                            <!-- Dropdown Tipe Materi -->
                            <div x-data="{
                                open: false,
                                value: '',
                                label: 'Pilih tipe materi'
                            }" class="relative w-full">
                                <button type="button" @click="open = !open"
                                    :class="open
                                        ?
                                        'border-[#10AF13] ring-1 ring-[#10AF13]' :
                                        'border-gray-300'"
                                    class="w-full px-3 py-2 rounded-md border cursor-pointer
                                    flex justify-between items-center text-md bg-white transition"
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
                                    class="absolute z-20 mt-2 w-full bg-white border rounded-lg shadow-md overflow-hidden">

                                    <!-- Item -->
                                    <template
                                        x-for="item in [
                                            { value: '', label: 'Pilih tipe materi' },
                                            { value: 'pdf', label: 'PDF' },
                                            { value: 'video', label: 'Video' },
                                            { value: 'recording', label: 'Recording' },
                                            { value: 'link', label: 'Link' }
                                        ]"
                                        :key="item.value">

                                        <div @click="
                                                value = item.value; 
                                                label = item.label; 
                                                open = false;
                                            "
                                            class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">

                                            <span x-text="item.label"></span>

                                            <!-- Check Icon -->
                                            <svg x-show="value === item.value" xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="#10AF13" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 12l5 5l10 -10" />
                                            </svg>
                                        </div>
                                    </template>
                                </div>

                                <!-- Hidden input untuk backend -->
                                <input type="hidden" name="tipe_materi" :value="value">
                            </div>
                        </div>
                        <div>
                            <label class="text-md font-semibold text-gray-700">
                                URL/Link <span class="text-[#ff0000] text-lg">*</span>
                            </label>
                            <input type="url" name="link_materi"
                                class="w-full mt-1 px-3 py-2
                                border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm text-md"
                                placeholder="https://..." required>
                            <p class="text-md font-medium text-gray-500 pt-2">
                                Link ke file materi (Google Drive, Dropbox, dll)
                            </p>
                        </div>
                    </div>

                    <hr class="mt-4 ms-2 me-2">

                    <!-- Button -->
                    <div class="mt-3 flex justify-end gap-3 me-2">
                        <button type="button" @click="openUploadMateri = false"
                            class="gap-3 px-4 py-2 border rounded-lg hover:bg-gray-50 font-medium">
                            Batal
                        </button>
                        <button
                            class="justify-center gap-3 px-4 py-2 rounded-lg text-white bg-[#10AF13] hover:bg-[#0e8e0f] font-medium">
                            Upload Materi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mt-8 px-2">
        @include('dashboard.card', [
            'title' => 'Total Materi',
            'value' => $materialCounts['totalMaterials'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" 
                                                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-upload"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 9l5 -5l5 5" /><path d="M12 4l0 12" /></svg>',
            'color' => 'text-[#10AF13]',
        ])
        @include('dashboard.card', [
            'title' => 'PDF',
            'value' => $materialCounts['totalPdf'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
                                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                                                        <path d="M9 9l1 0" /><path d="M9 13l6 0" /><path d="M9 17l6 0" /></svg>',
            'color' => 'text-[#FF4D00]',
        ])
        @include('dashboard.card', [
            'title' => 'Video',
            'value' => $materialCounts['totalVideos'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                                                                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-video"><path stroke="none" d="M0 0h24v24H0z" 
                                                                                        fill="none"/><path d="M15 10l4.553 -2.276a1 1 0 0 1 1.447 .894v6.764a1 1 0 0 1 -1.447 .894l-4.553 -2.276v-4z" />
                                                                                        <path d="M3 6m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /></svg>',
            'color' => 'text-[#AE00FF]',
        ])
        @include('dashboard.card', [
            'title' => 'Recording',
            'value' => $materialCounts['totalRecords'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-microphone">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M12 14a3.5 3.5 0 0 0 3.5 -3.5v-6a3.5 3.5 0 0 0 -7 0v6a3.5 3.5 0 0 0 3.5 3.5z" />
                                                                    <path d="M5 10a7 7 0 0 0 14 0" />
                                                                    <path d="M8 21h8" />
                                                                    <path d="M12 17v4" />
                                                                </svg>',
            'color' => 'text-[#5EABD6]',
        ])
        @include('dashboard.card', [
            'title' => 'Link',
            'value' => $materialCounts['totalLinks'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="#0059FF" 
                                                                                        d="m10 17.55l-1.77 1.72a2.47 2.47 0 0 1-3.5-3.5l4.54-4.55a2.46 2.46 0 0 1 3.39-.09l.12.1a1 1 0 0 0 1.4-1.43a2.75 
                                                                                        2.75 0 0 0-.18-.21a4.46 4.46 0 0 0-6.09.22l-4.6 4.55a4.48 4.48 0 0 0 6.33 6.33L11.37 19A1 1 0 0 0 10 17.55ZM20.69 
                                                                                        3.31a4.49 4.49 0 0 0-6.33 0L12.63 5A1 1 0 0 0 14 6.45l1.73-1.72a2.47 2.47 0 0 1 3.5 3.5l-4.54 4.55a2.46 2.46 0 0 
                                                                                        1-3.39.09l-.12-.1a1 1 0 0 0-1.4 1.43a2.75 2.75 0 0 0 .23.21a4.47 4.47 0 0 0 6.09-.22l4.55-4.55a4.49 4.49 0 0 0 .04-6.33Z"/></svg>',
            'color' => 'text-[#0059FF]',
        ])
    </div>

    <!-- List Batch -->
    @foreach ($batches as $batch)
        <div class="bg-white border rounded-2xl p-6 mt-8 mx-2">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold">
                        {{ $batch->title }}
                    </h2>
                    <p class="text-md font-medium text-gray-600">
                        {{ $batch->display_code ?? '-' }}
                    </p>
                </div>
                <div class="flex border px-2 rounded-lg items-center gap-1 font-medium text-sm">
                    <p>{{ $batch->materials->count() }}</p>
                    <p>materi</p>
                </div>
            </div>

            {{-- List Material --}}
            <div class="mt-5 space-y-4 max-h-[350px] overflow-y-auto pr-1">
                @forelse ($batch->materials as $material)
                    <div class="flex items-center justify-between p-4 border rounded-xl hover:bg-gray-50 transition"
                        x-data="{
                            openEditMateri: false,
                            openDeleteMateri: false,
                            editMateri: {
                                id: null,
                                batch_id: '',
                                judul_materi: '',
                                tipe_materi: '',
                                link_materi: ''
                            }
                        }">
                        <div class="flex items-center gap-3">

                            {{-- Icon material berdasarkan tipe --}}
                            @if ($material->tipe_materi === 'pdf')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-text text-[#FF4D00]">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                    <path d="M9 9l1 0" />
                                    <path d="M9 13l6 0" />
                                    <path d="M9 17l6 0" />
                                </svg>
                            @elseif ($material->tipe_materi === 'video')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-video text-[#AE00FF]">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M15 10l4.553 -2.276a1 1 0 0 1 1.447 .894v6.764a1 1 0 0 1 -1.447 .894l-4.553 -2.276v-4z" />
                                    <path
                                        d="M3 6m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" />
                                </svg>
                            @elseif ($material->tipe_materi === 'recording')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-microphone text-[#5EABD6]">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M12 14a3.5 3.5 0 0 0 3.5 -3.5v-6a3.5 3.5 0 0 0 -7 0v6a3.5 3.5 0 0 0 3.5 3.5z" />
                                    <path d="M5 10a7 7 0 0 0 14 0" />
                                    <path d="M8 21h8" />
                                    <path d="M12 17v4" />
                                </svg>
                            @elseif ($material->tipe_materi === 'link')
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                    viewBox="0 0 24 24">
                                    <path fill="#0059FF"
                                        d="m10 17.55l-1.77 1.72a2.47 2.47 0 0 1-3.5-3.5l4.54-4.55a2.46 2.46 0 0 1 3.39-.09l.12.1a1 1 0 0 0 1.4-1.43a2.75
                                                                2.75 0 0 0-.18-.21a4.46 4.46 0 0 0-6.09.22l-4.6 4.55a4.48 4.48 0 0 0 6.33 6.33L11.37 19A1 1 0 0 0 10 17.55ZM20.69
                                                                3.31a4.49 4.49 0 0 0-6.33 0L12.63 5A1 1 0 0 0 14 6.45l1.73-1.72a2.47 2.47 0 0 1 3.5 3.5l-4.54 4.55a2.46 2.46 0 0
                                                                1-3.39.09l-.12-.1a1 1 0 0 0-1.4 1.43a2.75 2.75 0 0 0 .23.21a4.47 4.47 0 0 0 6.09-.22l4.55-4.55a4.49 4.49 0 0 0 .04-6.33Z" />
                                </svg>
                            @endif

                            <div>
                                <h3 class="text-md font-medium text-gray-800">
                                    {{ $material->judul_materi }}
                                </h3>
                                <p class="text-md text-[#737373] flex flex-wrap gap-2 font-medium">
                                    @if ($material->tipe_materi === 'video')
                                        <span
                                            class="text-[#AE00FF] bg-purple-100 px-3 rounded-lg text-sm flex items-center uppercase">
                                            Video
                                        </span>
                                    @elseif ($material->tipe_materi === 'pdf')
                                        <span
                                            class="text-[#FF4D00] bg-orange-100 px-3 rounded-lg text-sm flex items-center uppercase">
                                            PDF
                                        </span>
                                    @elseif ($material->tipe_materi === 'recording')
                                        <span
                                            class="text-[#5EABD6] bg-[#ebf8ff] px-3 rounded-lg text-sm flex items-center uppercase">
                                            Recording
                                        </span>
                                    @elseif ($material->tipe_materi === 'link')
                                        <span class="text-[#0059FF] bg-blue-100 px-3 rounded-lg text-sm flex items-center uppercase">
                                            Link
                                        </span>
                                    @endif
                                    <span>{{ $material->created_at->format('d/m/Y') }}</span>
                                    <span>oleh {{ $material->trainer->name }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <a href="{{ $material->link_materi }}" target="_blank"
                                class="px-3 py-1 text-sm font-medium rounded-lg border flex justify-center items-center gap-3 hover:bg-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24">
                                    <path fill="#000000"
                                        d="m10 17.55l-1.77 1.72a2.47 2.47 0 0 1-3.5-3.5l4.54-4.55a2.46 2.46 0 0 1 3.39-.09l.12.1a1 1 0 0 0 1.4-1.43a2.75
                                                                2.75 0 0 0-.18-.21a4.46 4.46 0 0 0-6.09.22l-4.6 4.55a4.48 4.48 0 0 0 6.33 6.33L11.37 19A1 1 0 0 0 10 17.55ZM20.69
                                                                3.31a4.49 4.49 0 0 0-6.33 0L12.63 5A1 1 0 0 0 14 6.45l1.73-1.72a2.47 2.47 0 0 1 3.5 3.5l-4.54 4.55a2.46 2.46 0 0
                                                                1-3.39.09l-.12-.1a1 1 0 0 0-1.4 1.43a2.75 2.75 0 0 0 .23.21a4.47 4.47 0 0 0 6.09-.22l4.55-4.55a4.49 4.49 0 0 0 .04-6.33Z" />
                                </svg>
                                <p>Lihat</p>
                            </a>
                            <button
                                @click="
                                        openEditMateri = true;
                                        editMateri = @js([
                                        'id' => $material->id,
                                        'batch_id' => $material->batch_id,
                                        'judul_materi' => $material->judul_materi,
                                        'tipe_materi' => $material->tipe_materi,
                                        'link_materi' => $material->link_materi,
                                    ])
                                    "
                                class="text-[#10AF14] hover:text-[#0e8e0f]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                            </button>
                            <button @click="openDeleteMateri = true" class="text-[#ff0000] hover:text-[#E81B1B]">
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
                        </div>

                        <!-- Modal Edit Materi -->
                        <div x-show="openEditMateri" x-cloak x-transition
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                            <div class="bg-white w-full max-w-xl rounded-2xl p-6 relative">
                                <button @click="openEditMateri = false"
                                    class="absolute top-6 right-6 text-[#737373] hover:text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M18 6l-12 12" />
                                        <path d="M6 6l12 12" />
                                    </svg>
                                </button>
                                <div class="flex justify-between items-center mb-4 p-2">
                                    <div>
                                        <h2 class="text-xl font-semibold">Edit Materi Baru</h2>
                                        <p class="text-[#737373]">Ubah materi pembelajaran peserta</p>
                                    </div>
                                </div>
                                <form method="POST" :action="`{{ route('upload-materi.update', '') }}/${editMateri.id}`">
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
                                            }" x-init="$watch('editMateri.batch_id', newBatchId => {
                                                value = String(newBatchId)
                                                label = daftarBatch[newBatchId] ?? 'Pilih Batch'
                                            });" class="relative w-full">
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
                                                        viewBox="0 0 24 24" fill="none" stroke="#374151"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                                                        <svg x-show="value === ''" xmlns="http://www.w3.org/2000/svg"
                                                            width="16" height="16" viewBox="0 0 24 24"
                                                            fill="none" stroke="#10AF13" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
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
                                                            <svg x-show="value === '{{ $batch->id }}'"
                                                                xmlns="http://www.w3.org/2000/svg" width="16"
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
                                                <input type="hidden" name="batch_id" :value="value" required>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="text-md font-semibold text-gray-700">
                                                Judul Materi <span class="text-[#ff0000] text-lg">*</span>
                                            </label>
                                            <input type="text" name="judul_materi" x-model="editMateri.judul_materi"
                                                class="w-full mt-1 px-3 py-2
                                                border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                                dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm text-md"
                                                placeholder="Contoh: Modul Python Game Development" required>
                                        </div>
                                        <div>
                                            <label class="text-md font-semibold text-gray-700">
                                                Tipe materi <span class="text-[#ff0000] text-lg">*</span>
                                            </label>

                                            <!-- Dropdown Tipe Materi -->
                                            <div x-data="{
                                                open: false,
                                                value: '{{ old('tipe_materi', $material->tipe_materi) }}',
                                                label: '{{ old('tipe_materi')
                                                    ? (old('tipe_materi') == 'pdf'
                                                        ? 'PDF'
                                                        : (old('tipe_materi') == 'video'
                                                            ? 'Video'
                                                            : (old('tipe_materi') == 'recording'
                                                                ? 'Recording'
                                                                : (old('tipe_materi') == 'link'
                                                                    ? 'Link'
                                                                    : 'Pilih tipe materi'))))
                                                    : ($material->tipe_materi == 'pdf'
                                                        ? 'PDF'
                                                        : ($material->tipe_materi == 'video'
                                                            ? 'Video'
                                                            : ($material->tipe_materi == 'recording'
                                                                ? 'Recording'
                                                                : ($material->tipe_materi == 'link'
                                                                    ? 'Link'
                                                                    : 'Pilih tipe materi')))) }}'
                                            }" class="relative w-full">
                                                <button type="button" @click="open = !open"
                                                    :class="open
                                                        ?
                                                        'border-[#10AF13] ring-1 ring-[#10AF13]' :
                                                        'border-gray-300'"
                                                    class="w-full px-3 py-2 rounded-md border cursor-pointer
                                                    flex justify-between items-center text-md bg-white transition"
                                                    type="button">
                                                    <span x-text="label"></span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="#374151"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                                                    class="absolute z-20 mt-2 w-full bg-white border rounded-lg shadow-md overflow-hidden">

                                                    <!-- Item -->
                                                    <template
                                                        x-for="item in [
                                                            { value: '', label: 'Pilih tipe materi' },
                                                            { value: 'pdf', label: 'PDF' },
                                                            { value: 'video', label: 'Video' },
                                                            { value: 'recording', label: 'Recording' },
                                                            { value: 'link', label: 'Link' }
                                                        ]"
                                                        :key="item.value">

                                                        <div @click="
                                                                value = item.value; 
                                                                label = item.label; 
                                                                open = false;
                                                            "
                                                            class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">

                                                            <span x-text="item.label"></span>

                                                            <!-- Check Icon -->
                                                            <svg x-show="value === item.value"
                                                                xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" viewBox="0 0 24 24" fill="none"
                                                                stroke="#10AF13" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M5 12l5 5l10 -10" />
                                                            </svg>
                                                        </div>
                                                    </template>
                                                </div>

                                                <!-- Hidden input untuk backend -->
                                                <input type="hidden" name="tipe_materi" :value="value">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="text-md font-semibold text-gray-700">
                                                URL/Link <span class="text-[#ff0000] text-lg">*</span>
                                            </label>
                                            <input type="url" name="link_materi" x-model="editMateri.link_materi"
                                                class="w-full mt-1 px-3 py-2
                                                border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                                dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm text-md"
                                                placeholder="https://..." required>
                                            <p class="text-md font-medium text-gray-500 pt-2">
                                                Link ke file materi (Google Drive, Dropbox, dll)
                                            </p>
                                        </div>
                                    </div>

                                    <hr class="mt-4 ms-2 me-2">

                                    <!-- Button -->
                                    <div class="mt-3 flex justify-end gap-3 me-2">
                                        <button type="button" @click="openEditMateri = false"
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

                        <!-- Modal Delete Materi -->
                        <div x-show="openDeleteMateri" x-cloak x-transition
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                            <div class="bg-white w-full max-w-md rounded-2xl p-6 space-y-4">

                                <!-- Icon -->
                                <div class="flex justify-center text-[#ff0000]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-file-x">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                                        <path d="M10 12l4 4m0 -4l-4 4" />
                                    </svg>
                                </div>

                                <!-- Text -->
                                <div class="text-center">
                                    <h2 class="text-2xl font-semibold">Hapus Materi</h2>
                                    <p class="text-gray-600 mt-2">
                                        Apakah Anda yakin ingin menghapus materi
                                        <span class="font-semibold">
                                            {{ $material->judul_materi }}
                                        </span>
                                        dari batch <strong>{{ $material->batch->title }}</strong>?
                                    </p>
                                </div>

                                <!-- Aksi -->
                                <div class="flex justify-end gap-3 pt-4">
                                    <button @click="openDeleteMateri = false"
                                        class="px-4 py-2 border rounded-lg hover:bg-gray-50 font-medium">
                                        Batal
                                    </button>
                                    <form action="{{ route('upload-materi.destroy', $material->id) }}" method="POST">
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
                        <script>
                            const daftarBatch = @json($batches->pluck('title', 'id'));
                        </script>
                    </div>
                @empty
                    <div class="p-11 border border-dashed rounded-xl bg-gray-50 transition" x-data="{ openUploadMateri: false }">
                        <div class="flex justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
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
                                Belum ada materi untuk batch ini.
                            </p>
                        </div>
                        <div class="flex justify-center">
                            <button @click="openUploadMateri = true"
                                class="flex items-center bg-[#10AF13] text-white rounded-lg px-3 gap-3 py-1 w-fit cursor-pointer hover:bg-[#0e8e0f] transitionn font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-upload">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                    <path d="M7 9l5 -5l5 5" />
                                    <path d="M12 4l0 12" />
                                </svg>
                                <span>Upload Materi Pertama</span>
                            </button>

                            <!-- Modal Upload Materi -->
                            <div x-show="openUploadMateri" x-cloak x-transition
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                                <div class="bg-white w-full max-w-xl rounded-2xl p-6 relative">
                                    <button @click="openUploadMateri = false"
                                        class="absolute top-6 right-6 text-[#737373] hover:text-black">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M18 6l-12 12" />
                                            <path d="M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <div class="flex justify-between items-center mb-4 p-2">
                                        <div>
                                            <h2 class="text-xl font-semibold">Upload Materi Baru</h2>
                                            <p class="text-[#737373]">Upload materi pembelajaran untuk peserta</p>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('upload-materi.store') }}">
                                        @csrf
                                        <div class="space-y-4 bg-gray-50 rounded-xl px-6 py-4 mx-2 mb-2 pb-7">
                                            <div>
                                                <label class="text-md font-semibold text-gray-700">
                                                    Batch <span class="text-[#ff0000] text-lg">*</span>
                                                </label>

                                                <!-- Dropdown Batch -->
                                                <div x-data="{ 
                                                        open: false, 
                                                        value: '{{ $batchesWithoutMaterials->first()?->id }}', 
                                                        label: '{{ $batchesWithoutMaterials->first()?->title ?? 'Tidak ada batch tersedia' }}' 
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
                                                            <svg x-show="value === ''" xmlns="http://www.w3.org/2000/svg"
                                                                width="16" height="16" viewBox="0 0 24 24"
                                                                fill="none" stroke="#10AF13" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
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
                                                    Judul Materi <span class="text-[#ff0000] text-lg">*</span>
                                                </label>
                                                <input type="text" name="judul_materi"
                                                    class="w-full mt-1 px-3 py-2
                                                    border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                                    dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm text-md"
                                                    placeholder="Contoh: Modul Python Game Development" required>
                                            </div>
                                            <div>
                                                <label class="text-md font-semibold text-gray-700">
                                                    Tipe materi <span class="text-[#ff0000] text-lg">*</span>
                                                </label>

                                                <!-- Dropdown Tipe Materi -->
                                                <div x-data="{
                                                        open: false,
                                                        value: '',
                                                        label: 'Pilih tipe materi'
                                                    }" 
                                                    class="relative w-full">
                                                    <button type="button" @click="open = !open"
                                                        :class="open
                                                            ?
                                                            'border-[#10AF13] ring-1 ring-[#10AF13]' :
                                                            'border-gray-300'"
                                                        class="w-full px-3 py-2 rounded-md border cursor-pointer
                                                        flex justify-between items-center text-md bg-white transition"
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
                                                        class="absolute z-20 mt-2 w-full bg-white border rounded-lg shadow-md overflow-hidden">

                                                        <!-- Item -->
                                                        <template
                                                            x-for="item in [
                                                                { value: '', label: 'Pilih tipe materi' },
                                                                { value: 'pdf', label: 'PDF' },
                                                                { value: 'video', label: 'Video' },
                                                                { value: 'recording', label: 'Recording' },
                                                                { value: 'link', label: 'Link' }
                                                            ]"
                                                            :key="item.value">

                                                            <div @click="
                                                                    value = item.value; 
                                                                    label = item.label; 
                                                                    open = false;
                                                                "
                                                                class="px-3 py-2 text-sm cursor-pointer flex justify-between items-center hover:bg-gray-100">

                                                                <span x-text="item.label"></span>

                                                                <!-- Check Icon -->
                                                                <svg x-show="value === item.value"
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
                                                        </template>
                                                    </div>

                                                    <!-- Hidden input untuk backend -->
                                                    <input type="hidden" name="tipe_materi" :value="value">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="text-md font-semibold text-gray-700">
                                                    URL/Link <span class="text-[#ff0000] text-lg">*</span>
                                                </label>
                                                <input type="url" name="link_materi"
                                                    class="w-full mt-1 px-3 py-2
                                                    border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                                                    dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm text-md"
                                                    placeholder="https://..." required>
                                                <p class="text-md font-medium text-gray-500 pt-2">
                                                    Link ke file materi (Google Drive, Dropbox, dll)
                                                </p>
                                            </div>
                                        </div>

                                        <hr class="mt-4 ms-2 me-2">

                                        <!-- Button -->
                                        <div class="mt-3 flex justify-end gap-3 me-2">
                                            <button type="button" @click="openUploadMateri = false"
                                                class="gap-3 px-4 py-2 border rounded-lg hover:bg-gray-50 font-medium">
                                                Batal
                                            </button>
                                            <button
                                                class="justify-center gap-3 px-4 py-2 rounded-lg text-white bg-[#10AF13] hover:bg-[#0e8e0f] font-medium">
                                                Upload Materi
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    @endforeach
@endsection
