@extends('layouts.coordinator')

@section('content')
    <div class="px-2 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold">Manajemen Kategori Pelatihan</h1>
            <p class="text-[#737373] mt-2 font-medium">Kelola kategori dan prerequisite pelatihan</p>
        </div>
        <button @click="openAddCategory = true"
            class="flex items-center bg-[#0059FF] text-white rounded-lg px-3 gap-3 py-2 w-fit cursor-pointer hover:bg-blue-700 transition font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            <span>Tambah Kategori</span>
        </button>
    </div>

    <!-- Modal Tambah Kategori -->
    <div x-show="openAddCategory" x-cloak x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white w-full max-w-2xl rounded-2xl p-6 relative">
            <button @click="openAddCategory = false" class="absolute top-6 right-6 text-[#737373] hover:text-black">
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
                    <h2 class="text-xl font-semibold">Tambah Kategori</h2>
                    <p class="text-[#737373]">Buat kategori pelatihan baru dengan atau tanpa prerequisite</p>
                </div>
            </div>
            <form method="POST" action="{{ route('kategori-pelatihan.store') }}">
                @csrf
                <div class="space-y-4 bg-gray-50 rounded-xl px-6 py-1 mx-2 mb-2 pb-7">
                    <div>
                        <label class="text-md font-semibold text-gray-700">
                            Nama Kategori <span class="text-[#ff0000] text-lg">*</span>
                        </label>
                        <input type="text" name="name"
                            class="w-full mt-1 px-3 py-2
                            border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                            dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm font-medium"
                            placeholder="Contoh: Python Game Developer" required>
                    </div>
                    <div>
                        <label class="text-md font-semibold text-gray-700">
                            Deskripsi <span class="text-[#ff0000] text-lg">*</span>
                        </label>
                        <textarea name="description"
                            class="bg-gray-200 focus:ring-[#10AF13] focus:border-[#10AF13] border-none font-medium rounded-xl w-full resize-none focus:border-double"
                            rows="4" placeholder="Berikan deskripsi..." required></textarea>
                    </div>
                    <div>
                        <label class="text-md font-semibold text-gray-700">Prerequisite (opsional)</label>
                        <p class="text-sm font-medium text-gray-500">Pilih kategori yang harus diselesaikan terlebih dahulu
                            sebelum mengambil kategori ini</p>
                        <div
                            class="w-full border border-gray-300 rounded-xl mt-1 p-4 flex flex-col gap-1 max-h-48 overflow-y-auto">
                            @foreach ($categories as $category)
                                <label class="items-center cursor-pointer hover:bg-gray-100 p-2">
                                    <input type="checkbox" name="prerequisites[]" value="{{ $category->id }}"
                                        class="rounded border-gray-300 text-[#10AF13] focus:ring-[#10AF13]">
                                    <span class="ms-2 text-md font-semibold text-gray-700">
                                        {{ $category->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <hr class="mt-4 ms-2 me-2">

                <div class="flex justify-end gap-3 pt-4 me-2">
                    <button type="button" @click="openAddCategory = false"
                        class="px-4 py-2 border rounded-lg hover:bg-gray-50 font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-[#10AF13] text-white rounded-lg hover:bg-[#0e8e0f] font-medium">
                        Tambah Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-8 px-2">
        @include('dashboard.card', [
            'title' => 'Total Kategori',
            'value' => $kategoriPelatihanCounts['totalKategori'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                                        // stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                        // class="icon icon-tabler icons-tabler-outline icon-tabler-stack-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        // <path d="M12 4l-8 4l8 4l8 -4l-8 -4" /><path d="M4 12l8 4l8 -4" /><path d="M4 16l8 4l8 -4" /></svg>',
            'color' => 'text-[#0059FF]',
        ])
        @include('dashboard.card', [
            'title' => 'Tanpa Prerequisite',
            'value' => $kategoriPelatihanCounts['tanpaPrerequisite'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                                        // stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-lock-open">
                                                        // <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 11m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                                                        // <path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M8 11v-5a4 4 0 0 1 8 0" /></svg>',
            'color' => 'text-[#10AF13]',
        ])
        @include('dashboard.card', [
            'title' => 'Dengan Prerequisite',
            'value' => $kategoriPelatihanCounts['denganPrerequisite'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                                        // stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                        // class="icon icon-tabler icons-tabler-outline icon-tabler-lock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        // <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                                                        // <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>',
            'color' => 'text-[#FF4D00]',
        ])
    </div>

    {{-- Search and Filter --}}
    <form method="GET" action="{{ route('kategori-pelatihan') }}">
        <div class="grid grid-cols-1 border lg:grid-cols-2 gap-4 px-5 bg-white py-6 rounded-2xl mt-8 mx-2">
            <!-- Search -->
            <div class="flex items-center bg-[#F1F1F1] rounded-lg px-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="text-[#737373]">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                    <path d="M21 21l-6 -6" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    @input.debounce.500ms="$el.closest('form').submit()"
                    class="w-full border-0 focus:ring-0 text-sm bg-[#F1F1F1] placeholder-[#737373]"
                    placeholder="Cari kategori..." />
            </div>

            <!-- Dropdown Status -->
            <div x-data="{
                open: false,
                value: '{{ request('statusKategori') }}',
                label: {
                    'prerequisite': 'Dengan Prerequisite',
                    'non-prerequisite': 'Tanpa Prerequisite',
                    '': 'Semua Status'
                } ['{{ request('statusKategori') }}'] ?? 'Semua Status'
                }" 
                class="relative w-full">
                <button type="button" @click="open = !open"
                    :class="open
                        ?
                        'border-[#10AF13] ring-1 ring-[#10AF13]' :
                        'border-gray-300'"
                    class="w-full px-3 py-2 rounded-lg border cursor-pointer flex justify-between items-center text-sm bg-white transition">
                    <span x-text="label"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="#374151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M6 9l6 6l6 -6" />
                    </svg>
                </button>

                <!-- Dropdown Content -->
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute z-20 mt-2 w-full bg-white border rounded-lg shadow-md overflow-hidden">

                    <!-- Item -->
                    <template
                        x-for="item in [
                        { value: '', label: 'Semua Status' },
                        { value: 'prerequisite', label: ' Dengan Prerequisite' },
                        { value: 'non-prerequisite', label: 'Tanpa Prerequisite' },
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
                <input type="hidden" name="statusKategori" :value="value">
            </div>
        </div>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-8 px-2">
        @forelse ($categories as $category)
            <div class="bg-white border rounded-2xl p-6 flex flex-col h-33 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <h1 class="text-black font-bold text-xl">
                        {{ $category->name }}
                    </h1>
                    <button
                        @click="
                            openEditCategory = true;
                            editCategory = @js([
                            'id' => $category->id,
                            'name' => $category->name,
                            'description' => $category->description,
                            'prerequisites' => $category->prerequisites->pluck('id'),
                        ]);
                        "
                        class="px-3 py-1 text-xs font-medium rounded-full text-[#10AF13] hover:text-[#0e8e0f]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                            <path d="M16 5l3 3" />
                        </svg>
                    </button>
                </div>

                {{-- Badge Prerequisite --}}
                @if ($category->prerequisites->count() > 0)
                    <div class="px-3 py-1 w-fit mt-1 text-xs font-medium rounded-full bg-orange-100">
                        <p class="text-[#FF4D00]">Dengan Prerequisite</p>
                    </div>
                @endif

                {{-- Deskripsi --}}
                <div class="mt-7 text-gray-600">
                    <p class="text-md font-medium">
                        {{ $category->description }}
                    </p>
                </div>

                <hr class="border-gray-200 mt-3">

                {{-- List Prerequisite --}}
                @if ($category->prerequisites->count() > 0)
                    <div class="mt-2">
                        <h2 class="text-md font-medium text-gray-600">
                            Prerequisite:
                        </h2>
                        <p class="text-md font-medium text-black">
                            {{ $category->prerequisites->pluck('name')->implode(', ') }}
                        </p>
                    </div>

                    <hr class="border-gray-200 mt-3">
                @endif

                {{-- Tanggal Dibuat --}}
                <div class="mt-2 text-gray-600 flex gap-2 items-center">
                    <h2 class="text-md font-medium">
                        Dibuat:
                    </h2>
                    <p class="text-md font-medium">
                        {{ $category->created_at->format('d/m/Y') }}
                    </p>
                </div>

                {{-- Author --}}
                <div class="text-gray-600 flex gap-2 items-center">
                    <h2 class="text-md font-medium">
                        Oleh:
                    </h2>
                    <p class="text-md font-medium">
                        {{ Auth::user()->name }}
                    </p>
                </div>
            </div>
        @empty
            @php
                $status = request('statusKategori');
                $search = request('search');

                $statusLabel = match ($status) {
                    'prerequisite' => 'Dengan Prerequisite',
                    'non-prerequisite'   => 'Tanpa Prerequisite',
                    default     => null,
                };
            @endphp
            <div class="p-11 border border-dashed rounded-2xl bg-gray-50 transition w-full col-span-1 sm:col-span-2 lg:col-span-3">
                <div class="flex justify-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-stack-2 text-gray-300">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 4l-8 4l8 4l8 -4l-8 -4" />
                        <path d="M4 12l8 4l8 -4" />
                        <path d="M4 16l8 4l8 -4" />
                    </svg>
                </div>
                <div class="flex justify-center mb-2">
                    <p class="text-md font-medium text-gray-700">
                        @if ($statusLabel && $search)
                            Tidak ada kategori yang memiliki status
                            <strong>{{ $statusLabel }}</strong>
                            dengan kata kunci
                            <strong>"{{ $search }}"</strong>.
                        @elseif ($search)
                            Tidak ada kategori dengan kata kunci
                            <strong>"{{ $search }}"</strong>.
                        @elseif ($statusLabel)
                            Tidak ada kategori yang memiliki status
                            <strong>{{ $statusLabel }}</strong>.
                        @else
                            Tidak ada kategori yang tersedia.
                        @endif
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Modal Edit Kategori -->
    <div x-show="openEditCategory" x-cloak x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white w-full max-w-2xl rounded-2xl p-6 relative max-h-[89vh] overflow-y-auto">
            <button @click="openEditCategory = false" class="absolute top-6 right-6 text-[#737373] hover:text-black">
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
                    <h2 class="text-xl font-semibold">Edit Kategori</h2>
                    <p class="text-[#737373]">Ubah informasi kategori pelatihan</p>
                </div>
            </div>
            <form method="POST" :action="`/coordinator/kategori-pelatihan/${editCategory.id}`">
                <div class="space-y-4 bg-gray-50 rounded-xl px-6 py-1 mx-2 mb-2 pb-7">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="text-md font-semibold text-gray-700">
                            Nama Kategori <span class="text-[#ff0000] text-lg">*</span>
                        </label>
                        <input type="text" name="name"
                            class="w-full mt-1 px-3 py-2
                            border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#10AF13] 
                            dark:focus:border-[#10AF13] focus:ring-[#10AF13] dark:focus:ring-[#10AF13] rounded-md shadow-sm font-medium"
                            placeholder="Contoh: Python Game Developer" x-model="editCategory.name" required>
                    </div>
                    <div>
                        <label class="text-md font-semibold text-gray-700">
                            Deskripsi <span class="text-[#ff0000] text-lg">*</span>
                        </label>
                        <textarea name="description" x-model="editCategory.description"
                            class="bg-gray-200 focus:ring-[#10AF13] focus:border-[#10AF13] border-none font-medium rounded-xl w-full resize-none focus:border-double"
                            rows="4" placeholder="Berikan deskripsi..." required></textarea>
                    </div>
                    <div>
                        <label class="text-md font-semibold text-gray-700">Prerequisite (opsional)</label>
                        <p class="text-sm font-medium text-gray-500">Pilih kategori yang harus diselesaikan terlebih dahulu
                            sebelum mengambil kategori ini</p>
                        <div
                            class="w-full border border-gray-300 rounded-xl mt-1 p-4 flex flex-col gap-1 max-h-48 overflow-y-auto">
                            @foreach ($allCategories as $category)
                                <label class="items-center cursor-pointer hover:bg-gray-100 p-2">
                                    <input type="checkbox" name="prerequisites[]" value="{{ $category->id }}"
                                        :checked="editCategory.prerequisites.includes({{ $category->id }})"
                                        class="rounded border-gray-300 text-[#10AF13] focus:ring-[#10AF13]">
                                    <span class="ms-2 text-md font-semibold text-gray-700">
                                        {{ $category->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <hr class="mt-4 ms-2 me-2">

                <div class="flex justify-end gap-3 pt-4 me-2">
                    <button type="button" @click="openEditCategory = false"
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
@endsection
