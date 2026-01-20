@extends('layouts.participant')

@section('content')
    <div class="px-2">
        <h1 class="text-2xl font-semibold">Pelatihan Saya</h1>
        <p class="text-[#737373] mt-2 font-medium">Daftar pelatihan yang Anda ikuti</p>
    </div>

    <form method="GET" action="{{ route('pelatihan') }}">
        <div class="grid border lg:grid-cols-3 gap-4 px-5 bg-white py-6 rounded-2xl mt-8 mx-2">
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
                    placeholder="Cari batch, kategori, atau trainer..." />
            </div>

            <!-- Dropdown Status Pelatihan -->
            <div x-data="{
                open: false,
                value: '{{ request('statusPelatihan') }}',
                label: '{{ request('statusPelatihan') ? ucfirst(request('statusPelatihan')) : 'Semua Status Pelatihan' }}'
            }" class="relative w-full">
                <button type="button" @click="open = !open"
                    :class="open
                        ?
                        'border-[#10AF13] ring-1 ring-[#10AF13]' :
                        'border-gray-300'"
                    class="w-full px-3 py-2 rounded-lg border cursor-pointer
                    flex justify-between items-center text-sm bg-white transition">
                    <span x-text="label"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#374151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                            { value: '', label: 'Semua Status Pelatihan' },
                            { value: 'scheduled', label: 'Scheduled' },
                            { value: 'ongoing', label: 'Ongoing' },
                            { value: 'completed', label: 'Completed' }
                        ]"
                        :key="item.value">

                        <div @click="
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
                <input type="hidden" name="statusPelatihan" :value="value">
            </div>

            <!-- Dropdown Status Pendaftaran -->
            <div x-data="{
                open: false,
                value: '{{ request('statusPendaftaran') }}',
                label: '{{ request('statusPendaftaran') ? ucfirst(request('statusPendaftaran')) : 'Semua Status Pendaftaran' }}'
            }" class="relative w-full">
                <button type="button" @click="open = !open"
                    :class="open
                        ?
                        'border-[#10AF13] ring-1 ring-[#10AF13]' :
                        'border-gray-300'"
                    class="w-full px-3 py-2 rounded-lg border cursor-pointer
                    flex justify-between items-center text-sm bg-white transition">
                    <span x-text="label"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#374151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                            { value: '', label: 'Semua Status Pendaftaran' },
                            { value: 'registered', label: 'Registered' },
                            { value: 'approved', label: 'Approved' },
                            { value: 'ongoing', label: 'Ongoing' },
                            { value: 'completed', label: 'Completed' },
                            { value: 'failed', label: 'Failed' }
                        ]"
                        :key="item.value">

                        <div @click="
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
                <input type="hidden" name="statusPendaftaran" :value="value">
            </div>
        </div>
    </form>

    {{-- Jika tidak ada batch --}}
    @if ($batches->isEmpty())
        @php
            $statusPelatihan = request('statusPelatihan');
            $search = request('search');
            $statusPendaftaran = request('statusPendaftaran');

            $statusPelatihanLabel = match ($statusPelatihan) {
                'scheduled' => 'Scheduled',
                'ongoing' => 'Ongoing',
                'completed' => 'Completed',
                default => null,
            };

            $statusPendaftaranLabel = match ($statusPendaftaran) {
                'registered' => 'Registered',
                'approved' => 'Approved',
                'ongoing' => 'Ongoing',
                'completed' => 'Completed',
                'failed' => 'Failed',
                default => null,
            };
        @endphp

        <div class="p-11 border border-dashed rounded-2xl bg-gray-50 transition mt-8 mx-2 text-center">
            <div class="flex justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2zm20 0h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"
                        class="text-gray-300" />
                </svg>
            </div>

            <p class="text-md font-medium text-gray-700">
                @if ($statusPelatihanLabel && $search && $statusPendaftaranLabel)
                    Tidak ada batch dengan kata kunci
                    <strong>"{{ $search }}"</strong>
                    yang memiliki status pelatihan
                    <strong>{{ $statusPelatihanLabel }}</strong>
                    dan status pendaftaran
                    <strong>{{ $statusPendaftaranLabel }}</strong>.
                @elseif ($statusPelatihanLabel && $search)
                    Tidak ada batch yang memiliki status pelatihan
                    <strong>{{ $statusPelatihanLabel }}</strong>
                    dengan kata kunci
                    <strong>"{{ $search }}"</strong>.
                @elseif ($search && $statusPendaftaranLabel)
                    Tidak ada batch yang memiliki status pendaftaran
                    <strong>{{ $statusPendaftaranLabel }}</strong>
                    dengan kata kunci
                    <strong>"{{ $search }}"</strong>.
                @elseif ($statusPelatihanLabel && $statusPendaftaranLabel)
                    Tidak ada batch yang memiliki status pelatihan
                    <strong>{{ $statusPelatihanLabel }}</strong>
                    dan status pendaftaran
                    <strong>{{ $statusPendaftaranLabel }}</strong>.
                @elseif ($statusPelatihanLabel)
                    Tidak ada batch dengan status pelatihan
                    <strong>{{ $statusPelatihanLabel }}</strong>.
                @elseif ($search)
                    Tidak ada batch dengan kata kunci
                    <strong>"{{ $search }}"</strong>.
                @elseif ($statusPendaftaranLabel)
                    Tidak ada batch dengan status pendaftaran
                    <strong>{{ $statusPendaftaranLabel }}</strong>.
                @else
                    Tidak ada batch yang tersedia.
                @endif
            </p>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-8 px-2">
        @foreach ($batches as $batch)
            <div class="bg-white border rounded-2xl p-6 flex flex-col h-33 hover:shadow-md transition">
                <!-- TOP: Title + Status -->
                <div class="flex justify-between items-start">
                    <h1 class="text-black font-medium text-xl">
                        {{ $batch->title }}
                    </h1>
                </div>

                <div class="flex justify-between">
                    <div class="mt-4 text-gray-600 gap-2 items-center">
                        <h2 class="text-md font-medium">
                            Status Pelatihan
                        </h2>
                        @php
                            $statusPelatihanColor = match ($batch->status) {
                                'Scheduled' => 'bg-blue-100 text-[#0059FF]',
                                'Ongoing' => 'bg-green-100 text-[#10AF13]',
                                'Completed' => 'bg-orange-100 text-[#FF4D00]',
                            };
                        @endphp
                        <div class="px-3 py-1 w-fit uppercase rounded-full {{ $statusPelatihanColor }}">
                            <p class="text-xs font-medium">{{ $batch->status }}</p>
                        </div>
                    </div>
                    <div class="mt-4 text-gray-600 gap-2 items-center">
                        <h2 class="text-md font-medium">
                            Status Pendaftaran
                        </h2>
                        @php
                            $statusPendaftaran = $batch->participants->first()?->pivot->status;

                            $statusPendaftaranColor = match ($statusPendaftaran) {
                                'Approved' => 'bg-blue-100 text-[#0059FF]',
                                'Rejected' => 'bg-red-100 text-[#ff0000]',
                                'Ongoing' => 'bg-green-100 text-[#10AF13]',
                                'Completed' => 'bg-orange-100 text-[#FF4D00]',
                                'Failed' => 'bg-red-100 text-[#ff0000]',
                                default => 'bg-gray-200 text-gray-700',
                            };
                        @endphp
                        <div class="px-3 py-1 w-fit uppercase rounded-full {{ $statusPendaftaranColor }}">
                            <p class="text-xs font-medium">{{ $statusPendaftaran ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- BOTTOM: VALUE -->
                <div class="mt-7 flex gap-2 text-gray-600 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2zm20 0h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                    </svg>
                    <p class="text-md font-semibold">
                        {{ $batch->category->name }}
                    </p>
                </div>
                <div class="mt-2 flex gap-2 text-gray-600 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="20"
                        height="20" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                        <path d="M16 3v4" />
                        <path d="M8 3v4" />
                        <path d="M4 11h16" />
                    </svg>
                    <p class="text-md font-semibold">
                        {{ \Carbon\Carbon::parse($batch->start_date)->translatedFormat('d F Y') }}
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
                    <p class="text-md font-semibold">
                        {{ \Carbon\Carbon::parse($batch->start_date)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($batch->end_date)->format('H:i') }}
                    </p>
                </div>

                <hr class="border-gray-200 mt-4">

                @php
                    $allowedStatuses = ['Approved', 'Ongoing', 'Completed']
                @endphp
                <div class="flex items-start gap-20 mt-3">
                    <div>
                        <h2 class="text-md font-medium text-gray-600">
                            Materi
                        </h2>
                        @if (in_array($statusPendaftaran, $allowedStatuses))
                            <p class="text-md font-semibold text-black">
                                {{ $batch->materials_count ?? 0 }}
                            </p>
                        @else
                            <p class="text-md font-semibold text-black">-</p>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-md font-medium text-gray-600">
                            Tugas
                        </h2>
                        @if (in_array($statusPendaftaran, $allowedStatuses))
                            <p class="text-md font-semibold text-black">
                                {{ $batch->tasks_count ?? 0 }}
                            </p>
                        @else
                            <p class="text-md font-semibold text-black">-</p>
                        @endif
                    </div>
                </div>

                <div class="mt-4 text-gray-600 gap-2 items-center">
                    <h2 class="text-md font-medium">
                        Kehadiran
                    </h2>
                    <div class="px-3 py-1 w-fit text-xs uppercase font-medium rounded-full bg-orange-100 text-[#FF4D00]">
                        Check-In
                    </div>
                </div>

                @php
                    $allowedStatusPendaftaran = ['Approved', 'Ongoing', 'Completed']
                @endphp
                <div class="gap-2 mt-6" x-data="{ trainingDetail: false }">
                    <button type="button"
                        @click="
                            @if(in_array($statusPendaftaran, $allowedStatusPendaftaran))
                                trainingDetail = true
                            @elseif ($statusPendaftaran === 'Rejected')
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    background: '#ff0000',
                                    padding: '1px',

                                    animation: false,
                                    showClass: { popup: '' },
                                    hideClass: { popup: '' },

                                    customClass: {
                                        popup: 'mb-4 mr-2 rounded-lg shadow-lg overflow-hidden'
                                    },
                                    html: `
                                        <div class='flex items-center gap-3 text-white'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none' 
                                                stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' 
                                                class='icon icon-tabler icons-tabler-x-circle'>
                                                <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                                                <circle cx='12' cy='12' r='9' />
                                                <path d='M10 10l4 4m0 -4l-4 4' />
                                            </svg>
                                            <span class='font-medium'>
                                                Pendaftaran Anda ditolak oleh Branch PIC
                                            </span>
                                        </div>
                                    `
                                })
                            @else
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    background: '#FFE100',
                                    padding: '1px',

                                    animation: false,
                                    showClass: { popup: '' },
                                    hideClass: { popup: '' },

                                    customClass: {
                                        popup: 'mb-4 mr-2 rounded-lg shadow-lg overflow-hidden'
                                    },
                                    html: `
                                        <div class='flex items-center gap-3 text-white'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24'
                                                fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round'
                                                stroke-linejoin='round'
                                                class='icon icon-tabler icons-tabler-outline icon-tabler-exclamation-circle'>
                                                <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                                                <path d='M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0' />
                                                <path d='M12 9v4' />
                                                <path d='M12 16v.01' />
                                            </svg>
                                            <span class='font-medium'>
                                                Pendaftaran Anda belum disetujui oleh Branch PIC
                                            </span>
                                        </div>
                                    `
                                })
                            @endif
                        "
                        class="w-full px-4 py-1 border rounded-lg flex justify-center items-center gap-3 hover:bg-gray-100">
                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                            fill="currentColor"><path d="M10 3C5 3 1.73 7.11 1.07 10c.66 2.89 4 7 8.93 7s8.27-4.11 8.93-7C18.27 7.11 15 3 10 3zM10 15a5 5 0 110-10 5 5 0 010 10z" />
                            <path d="M10 7a3 3 0 100 6 3 3 0 000-6z" />
                        </svg>
                        <p class="text-md font-semibold text-black">
                            Lihat Detail
                        </p>
                    </button>

                    <!-- Modal Training Detail -->
                    <div x-show="trainingDetail" x-cloak x-transition
                        class="fixed inset-0 bg-black/40 z-50 items-center flex justify-center">
                        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-lg p-8 relative">
                            <!-- Close Button -->
                            <button @click="trainingDetail = false"
                                class="absolute top-6 right-6 text-[#737373] hover:text-black text-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- Header -->
                            <h2 class="text-xl font-semibold">Detail Pelatihan</h2>
                            <p class="text-[#737373] mb-4">Informasi lengkap tentang pelatihan Anda</p>

                            <div x-data="{ tab: 'info-pelatihan' }" x-cloak>
                                <div class="flex bg-[#eaeaea] p-1 rounded-2xl mb-5">
                                    <button @click="tab = 'info-pelatihan'"
                                        :class="tab === 'info-pelatihan' ? 'bg-white' : ''"
                                        class="w-full py-1 rounded-full text-sm font-semibold hover:bg-white transition">
                                        Info
                                    </button>

                                    <button @click="tab = 'materi-pelatihan'"
                                        :class="tab === 'materi-pelatihan' ? 'bg-white' : ''"
                                        class="w-full py-1 rounded-full text-sm font-semibold hover:bg-white transition">
                                        Materi
                                    </button>

                                    <button @click="tab = 'tugas-pelatihan'"
                                        :class="tab === 'tugas-pelatihan' ? 'bg-white' : ''"
                                        class="w-full py-1 rounded-full text-sm font-semibold hover:bg-white transition">
                                        Tugas
                                    </button>

                                    <button @click="tab = 'jadwal-pelatihan'"
                                        :class="tab === 'jadwal-pelatihan' ? 'bg-white' : ''"
                                        class="w-full py-1 rounded-full text-sm font-semibold hover:bg-white transition">
                                        Jadwal
                                    </button>
                                </div>

                                <!-- Info Pelatihan -->
                                <div x-show="tab === 'info-pelatihan'">
                                    <!-- Content -->
                                    <div class="bg-gray-50 rounded-xl p-6 grid lg:grid-cols-2 gap-y-4 gap-x-10">
                                        <div class="col-span-2">
                                            <div class="mb-4">
                                                <h2 class="text-black text-xl font-semibold">{{ $batch->title }}</h2>
                                                <p class="text-gray-700 text-md font-medium">{{ $batch->display_code }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-gray-700 text-md font-medium">Deskripsi</p>
                                                <p class="text-black text-md font-medium">
                                                    {{ $batch->description }}
                                                </p>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-gray-700 text-md font-medium">Kategori</p>
                                            <p class="text-black text-md font-medium">{{ $batch->category->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-700 text-md font-medium">Trainer</p>
                                            <p class="text-black text-md font-medium">{{ $batch->trainer->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-700 text-md font-medium">Tanggal Daftar</p>
                                            <p class="text-black text-md font-medium">
                                                {{ \Carbon\Carbon::parse($batch->participants->first()?->pivot->created_at)->translatedFormat('d F Y') }}
                                            <p>
                                        </div>
                                        <div>
                                            <p class="text-gray-700 text-md font-medium">Status Pelatihan</p>
                                            @php
                                                $statusPelatihanColor = match ($batch->status) {
                                                    'Scheduled' => 'bg-blue-100 text-[#0059FF]',
                                                    'Ongoing' => 'bg-green-100 text-[#10AF13]',
                                                    'Completed' => 'bg-orange-100 text-[#FF4D00]',
                                                };
                                            @endphp
                                            <span class="inline-block px-4 py-1 text-xs uppercase font-medium rounded-full {{ $statusPelatihanColor }}">
                                                {{ $batch->status }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-gray-700 text-md font-medium">Status Pendaftaran</p>
                                            @php
                                                $statusPendaftaran = $batch->participants->first()?->pivot->status;

                                                $statusPendaftaranColor = match ($statusPendaftaran) {
                                                    'Approved' => 'bg-blue-100 text-[#0059FF]',
                                                    'Rejected' => 'bg-red-100 text-[#ff0000]',
                                                    'Ongoing' => 'bg-green-100 text-[#10AF13]',
                                                    'Completed' => 'bg-orange-100 text-[#FF4D00]',
                                                    'Failed' => 'bg-red-100 text-[#ff0000]',
                                                    default => 'bg-gray-200 text-gray-700',
                                                };
                                            @endphp
                                            <span
                                                class="inline-block px-4 py-1 text-xs font-medium uppercase rounded-full {{ $statusPendaftaranColor }}">
                                                {{ $statusPendaftaran ?? '-' }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-gray-700 text-md font-medium">Status Kehadiran</p>
                                            <span
                                                class="inline-block px-4 py-1 text-xs font-medium uppercase rounded-full bg-orange-100 text-[#FF4D00]">
                                                Check_In
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Materi Pelatihan -->
                                <div x-show="tab === 'materi-pelatihan'">
                                    <!-- Content -->
                                    <div class="mt-5 space-y-4 max-h-[350px] overflow-y-auto pr-1">
                                        @forelse ($batch->materials as $material)
                                            <div class="flex items-center justify-between p-4 border rounded-xl hover:bg-gray-50 transition">
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
                                                                    class="text-[#AE00FF] bg-purple-100 px-3 rounded-lg text-sm flex items-center">
                                                                    VIDEO
                                                                </span>
                                                            @elseif ($material->tipe_materi === 'pdf')
                                                                <span
                                                                    class="text-[#FF4D00] bg-orange-100 px-3 rounded-lg text-sm flex items-center">
                                                                    PDF
                                                                </span>
                                                            @elseif ($material->tipe_materi === 'recording')
                                                                <span
                                                                    class="text-[#5EABD6] bg-[#ebf8ff] px-3 rounded-lg text-sm flex items-center">
                                                                    RECORDING
                                                                </span>
                                                            @elseif ($material->tipe_materi === 'link')
                                                                <span class="text-[#0059FF] bg-blue-100 px-3 rounded-lg text-sm flex items-center">
                                                                    LINK
                                                                </span>
                                                            @endif
                                                            <span>•</span>
                                                            <span>{{ $material->created_at->format('d/m/Y') }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-4">
                                                    <a href="{{ $material->link_materi }}" target="_blank"
                                                        class="text-black hover:bg-gray-200 border p-2 rounded-md">
                                                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                            fill="currentColor"><path d="M10 3C5 3 1.73 7.11 1.07 10c.66 2.89 4 7 8.93 7s8.27-4.11 8.93-7C18.27 7.11 15 3 10 3zM10 15a5 5 0 110-10 5 5 0 010 10z" />
                                                            <path d="M10 7a3 3 0 100 6 3 3 0 000-6z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        @empty
                                        <div class="text-center py-6">
                                            <div class="flex justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-text text-gray-300">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                    <path d="M9 9l1 0" />
                                                    <path d="M9 13l6 0" />
                                                    <path d="M9 17l6 0" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-700 py-2">
                                                Belum ada materi pelatihan
                                            </p>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Tugas Pelatihan -->
                                <div x-show="tab === 'tugas-pelatihan'">
                                    <!-- Content -->
                                    <div class="mt-5 space-y-4 max-h-[350px] overflow-y-auto pr-1">
                                        @forelse ($batch->tasks as $task)
                                            <div class="p-4 border rounded-xl hover:bg-gray-50 transition">
                                                <div>
                                                    <h3 class="text-lg font-medium text-black">
                                                        {{ $task->title }}
                                                    </h3>
                                                    <p class="text-md text-gray-700 font-medium mt-2">
                                                        {{ $task->description }}
                                                    </p>
                                                </div>
                                                <div class="flex gap-2 mt-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-calendar text-gray-700"
                                                        width="20" height="20" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                        <path d="M16 3v4" />
                                                        <path d="M8 3v4" />
                                                        <path d="M4 11h16" />
                                                    </svg>
                                                    <p class="text-md text-gray-700 font-medium">
                                                        Deadline: {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d F Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-6">
                                                <div class="flex justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-file-text text-gray-300">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                        <path d="M9 9l1 0" />
                                                        <path d="M9 13l6 0" />
                                                        <path d="M9 17l6 0" />
                                                    </svg>
                                                </div>
                                                <p class="text-gray-700 py-2">
                                                    Belum ada tugas pelatihan
                                                </p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Jadwal Pelatihan -->
                                <div x-show="tab === 'jadwal-pelatihan'">
                                    <!-- Content -->
                                    <div class="mt-5 space-y-4">
                                        @if ($batch)
                                            <div class="p-4 border rounded-xl hover:bg-gray-50 transition">
                                                <h3 class="text-lg font-medium text-black">
                                                    {{ $batch->description }}
                                                </h3>
                                                <div class="flex gap-2 mt-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-calendar text-gray-700"
                                                        width="20" height="20" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                        <path d="M16 3v4" />
                                                        <path d="M8 3v4" />
                                                        <path d="M4 11h16" />
                                                    </svg>
                                                    <p class="text-md text-gray-700 font-medium">{{ \Carbon\Carbon::parse($batch->start_date)->translatedFormat('d F Y') }}</p>
                                                </div>
                                                <div class="flex gap-2 mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-9">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                        <path d="M12 12h-3.5" />
                                                        <path d="M12 7v5" />
                                                    </svg>
                                                    <p class="text-md text-gray-700 font-medium">
                                                        {{ \Carbon\Carbon::parse($batch->start_date)->format('H:i') }} -
                                                        {{ \Carbon\Carbon::parse($batch->end_date)->format('H:i') }}
                                                    </p>
                                                </div>
                                                <div class="text-md font-medium text-[#0059FF] mt-2">
                                                    <a href="{{ $batch->zoom_link }}" target="_blank"
                                                        class="inline-block hover:underline">
                                                        Join Zoom Meeting
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-center py-6">
                                                <div class="flex justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-9 text-gray-300">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                        <path d="M12 12h-3.5" />
                                                        <path d="M12 7v5" />
                                                    </svg>
                                                </div>
                                                <p class="text-gray-700 py-2">
                                                    Belum ada jadwal pelatihan
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
