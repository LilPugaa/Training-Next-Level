@extends('layouts.participant')

@section('content')
    <div class="px-2">
        <h1 class="text-2xl font-semibold">Pendaftaran Training</h1>
        <p class="text-[#737373] mt-2 font-medium">Daftar batch training yang tersedia</p>
    </div>

    <form method="GET" action="{{ route('pendaftaran') }}">
        <div class="grid border lg:grid-cols-2 gap-4 px-5 bg-white py-6 rounded-2xl mt-8 mx-2">
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

            <!-- Dropdown Status -->
            <div x-data="{ 
                    open: false, 
                    value: '{{ request('statusPendaftaran') }}', 
                    label: '{{ request('statusPendaftaran') ? ucfirst(request('statusPendaftaran')) : 'Semua Status' }}'
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
                <input type="hidden" name="statusPendaftaran" :value="value">
            </div>
        </div>
    </form>

    {{-- Jika tidak ada batch --}}
    @if ($batches->isEmpty())
        @php
            $status = request('statusPendaftaran');
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
                    Tidak ada batch dengan status
                    <strong>{{ $statusLabel }}</strong>
                    untuk
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

    <!-- Daftar Batch -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-8 px-2">
        @foreach ($batches as $batch)
            <div class="bg-white border rounded-2xl p-6 flex flex-col h-33 hover:shadow-md transition"
                x-data="{ detailBatch: false }">
                @php
                    $now = \Carbon\Carbon::now();
                    $status = $now->between($batch->start_date, $batch->end_date)
                        ? 'ongoing'
                        : ($now->lessThan($batch->start_date)
                            ? 'scheduled'
                            : 'completed');
                @endphp
                <div class="flex justify-between items-start">
                    <h1 class="text-black font-medium text-xl">
                        {{ $batch->title }}
                    </h1>
                </div>

                <!-- Status -->
                <div class="flex items-start mt-2">
                    @php
                        $statusBatch = match ($batch->status) {
                            'Scheduled' => 'bg-blue-100 text-[#0059FF]',
                            'Ongoing' => 'bg-green-100 text-[#10AF13]',
                            'Completed' => 'bg-orange-100 text-[#FF4D00]',
                        };
                    @endphp
                    <div class="px-3 py-1 text-xs font-medium rounded-full {{ $statusBatch }}">
                        <p class="uppercase">{{ $batch->status }}</p>
                    </div>
                </div>

                <div class="mt-7">
                    <p class="text-md font-medium text-gray-600">
                        {{ $batch->description }}
                    </p>
                </div>

                <!-- BOTTOM: VALUE -->
                <div class="mt-5 flex gap-2 text-gray-600 items-center">
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
                    <p class="text-md font-semibold">
                        {{ $batch->active_participants_count ?? 0 }} / {{ $batch->max_quota }} peserta
                    </p>
                </div>
                <div class="mt-2 flex gap-2 text-gray-600 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-chalkboard-teacher">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8 19h-3a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v11a1 1 0 0 1 -1 1" />
                        <path d="M12 14a2 2 0 1 0 4.001 -.001a2 2 0 0 0 -4.001 .001" />
                        <path d="M17 19a2 2 0 0 0 -2 -2h-2a2 2 0 0 0 -2 2" />
                    </svg>
                    <p class="text-md font-semibold">
                        {{ $batch->trainer->name }}
                    </p>
                </div>

                @if ($batch->category->prerequisites->isNotEmpty())
                    <div class="grid sm:grid-cols-1 mt-6">
                        <div
                            class="w-full px-4 py-2 font-medium rounded-lg flex items-center justify-start bg-orange-100 border border-orange-300 text-[#FF4D00] gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-exclamation-circle">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 9v4" />
                                <path d="M12 16v.01" />
                            </svg>
                            <p class="text-md">
                                Memerlukan prerequisite
                            </p>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-6">
                    <button type="button" @click="detailBatch = true"
                        class="w-full px-4 py-1 border rounded-lg flex flex-col items-center justify-center hover:bg-gray-100 text-md font-semibold text-black">
                        Detail
                    </button>

                    @if ($batch->participants->isNotEmpty())
                        {{-- Sudah Terdaftar --}}
                        <button type="button" disabled
                            class="w-full px-4 rounded-lg flex flex-col items-center justify-center bg-[#10AF13]/60 text-md font-semibold text-white cursor-not-allowed">
                            Sudah Terdaftar
                        </button>
                    @else
                        <form action="{{ route('participant.daftar', $batch->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full px-4 py-1 rounded-lg flex flex-col items-center justify-center bg-[#10AF13] hover:bg-[#0e8e0f] text-md font-semibold text-white">
                                Daftar
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Modal Detail -->
                <div x-show="detailBatch" x-cloak x-transition id="detailBatch"
                    class="fixed inset-0 bg-black/40 z-50 items-center flex justify-center">
                    <div @click.outside="detailBatch = false"
                        class="bg-white max-w-xl rounded-2xl shadow-lg p-8 relative max-h-[89vh] overflow-y-auto">

                        <!-- Close Button -->
                        <button @click="detailBatch = false"
                            class="absolute top-6 right-6 text-[#737373] hover:text-black text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M18 6l-12 12" />
                                <path d="M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- Header -->
                        <h2 class="text-xl font-semibold">Detail Peserta</h2>
                        <p class="text-[#737373] mb-6">Informasi lengkap tentang batch training</p>

                        <!-- Judul Batch -->
                        <h2 class="text-lg font-medium">
                            {{ $batch->title }}
                        </h2>
                        <p class="text-[#737373] mb-6 uppercase">
                            {{ $batch->display_code ?? '-' }}
                        </p>

                        <!-- Content -->
                        <div class="bg-gray-50 rounded-xl p-6 grid grid-cols-2 gap-y-6 gap-x-10">
                            <div class="col-span-2">
                                <p class="text-gray-700 text-md font-medium">Deskripsi</p>
                                <p>
                                    {{ $batch->description }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-700 text-md font-medium">Kategori</p>
                                <p>
                                    {{ $batch->category->name }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-700 text-md font-medium">Trainer</p>
                                <p>
                                    {{ $batch->trainer->name }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-700 text-md font-medium">Tanggal Mulai</p>
                                <p>
                                    {{ \Carbon\Carbon::parse($batch->start_date)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-700 text-md font-medium">Waktu</p>
                                <p>
                                    {{ \Carbon\Carbon::parse($batch->start_date)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($batch->end_date)->format('H:i') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-700 text-md font-medium">Kapasitas</p>
                                <p>
                                    {{ $batch->active_participants_count ?? 0 }} / {{ $batch->max_quota }} peserta
                                </p>
                            </div>
                            <div>
                                @php
                                    $statusBatch = match ($batch->status) {
                                        'Scheduled' => 'bg-blue-100 text-[#0059FF]',
                                        'Ongoing' => 'bg-green-100 text-[#10AF13]',
                                        'Completed' => 'bg-orange-100 text-[#FF4D00]',
                                    };
                                @endphp
                                <p class="text-gray-700 text-md font-medium">Status</p>
                                <span
                                    class="inline-block px-2 py-1 uppercase text-xs font-medium rounded-full {{ $statusBatch }}">
                                    {{ $batch->status }}
                                </span>
                            </div>
                            <div class="col-span-2">
                                @forelse ($batch->category->prerequisites as $prerequisite)
                                    <p class="text-gray-700 text-md font-medium">Prerequisite</p>
                                    <span
                                        class="inline-block px-2 py-1 my-1 capitalize text-xs font-medium rounded-full bg-orange-100 text-[#FF4D00]">
                                        {{ $prerequisite->name }}
                                    </span>
                                @empty
                                @endforelse
                            </div>
                        </div>

                        <hr class="mt-4">

                        <div class="flex justify-end gap-3 pt-4 me-2">
                            <button type="button" @click="detailBatch = false"
                                class="px-4 py-2 border rounded-lg hover:bg-gray-50 font-medium">
                                Tutup
                            </button>

                            @if ($batch->participants->isNotEmpty())
                                {{-- Sudah Terdaftar --}}
                                <button type="button" disabled class="px-4 py-2 bg-[#10AF13]/60 text-white rounded-lg font-medium cursor-not-allowed">
                                    Sudah Terdaftar
                                </button>
                            @else
                                {{-- Belum Terdaftar --}}
                                <form action="{{ route('participant.daftar', $batch->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 bg-[#10AF13] hover:bg-[#0e8e0f] text-white rounded-lg font-medium">
                                        Daftar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
