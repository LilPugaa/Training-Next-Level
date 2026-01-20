@extends('layouts.branch-pic')

@section('content')
    <div class="px-2">
        <h1 class="text-2xl font-semibold">Validasi Pendaftaran</h1>
        <p class="text-[#737373] mt-2 font-medium">Kelola persetujuan pendaftaran peserta dari Cabang Denpasar</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-8 px-2">
        @include('dashboard.card', [
            'title' => 'Registered',
            'value' => $statusCounts['statusRegistered'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-4">
                                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 12l3 2" /><path d="M12 7v5" /></svg>',
            'color' => 'text-gray-700',
        ])
        @include('dashboard.card', [
            'title' => 'Approved',
            'value' => $statusCounts['statusApproved'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-check">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4" /><path d="M15 19l2 2l4 -4" /></svg>',
            'color' => 'text-[#0059FF]',
        ])
        @include('dashboard.card', [
            'title' => 'Rejected',
            'value' => $statusCounts['statusRejected'] ?? 0,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-user-x"><path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                <path d="M22 22l-5 -5" /><path d="M17 22l5 -5" /></svg>',
            'color' => 'text-[#ff0000]',
        ])
    </div>

    <form method="GET" action="{{ route('validasi-data') }}">
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
                    placeholder="Cari nama atau batch..." />
            </div>

            <!-- Dropdown Status -->
            <div x-data="{
                open: false,
                value: '{{ request('statusValidasi') }}',
                label: '{{ request('statusValidasi') ? ucfirst(request('statusValidasi')) : 'Semua Status' }}'
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
                <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute z-20 mt-2 w-full bg-white border rounded-lg shadow-md overflow-hidden">

                    <!-- Item -->
                    <template
                        x-for="item in [
                            { value: '', label: 'Semua Status' },
                            { value: 'registered', label: 'Registered' },
                            { value: 'approved', label: 'Approved' },
                            { value: 'rejected', label: 'Rejected' }
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
                <input type="hidden" name="statusValidasi" :value="value">
            </div>
        </div>
    </form>

    <!-- Daftar Peserta -->
    <div class="grid gap-6 mt-8 px-2">
        <div class="bg-white border rounded-2xl p-6 max-h-[440px] overflow-y-auto pr-1">
            <div class="flex items-center justify-between position-relative w-full mb-5">
                <h2 class="text-lg font-semibold">
                    Daftar Registrasi Batch Peserta
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full rounded-xl overflow-hidden">
                    <thead class="border-b">
                        <tr class="text-left text-sm font-semibold text-gray-700">
                            <th class="px-4 py-3 text-center">No</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Batch</th>
                            <th class="px-4 py-3">Tanggal Daftar</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @foreach ($participants as $participant)
                            <tr class="hover:bg-gray-50 transition text-left" x-data=" { openDetail: false, openRejectConfirm: false }">
                                <td class="px-4 py-3 text-center">
                                    {{ $participant->id }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $participant->user->name }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $participant->user->email }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $participant->batch->title }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $participant->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusColor = match ($participant->status) {
                                            'Approved' => 'bg-blue-100 text-[#0059FF]',
                                            'Rejected' => 'bg-red-100 text-[#ff0000]',
                                            default => 'bg-gray-200 text-gray-700',
                                        };
                                    @endphp
                                    <div
                                        class="px-2 py-1 w-fit text-xs uppercase font-medium rounded-full gap-2 {{ $statusColor }}">
                                        <p>{{ $participant->status }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-4">

                                        {{-- Button Detail --}}
                                        <button @click="openDetail = true">
                                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 hover:text-gray-700" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path d="M10 3C5 3 1.73 7.11 1.07 10c.66 2.89 4 7 8.93 7s8.27-4.11 8.93-7C18.27 7.11 15 3 10 3zM10 15a5 5 0 110-10 5 5 0 010 10z" />
                                                <path d="M10 7a3 3 0 100 6 3 3 0 000-6z" />
                                            </svg>
                                        </button>

                                        @if ($participant->status === 'Registered')
                                            {{-- Button Setujui --}}
                                            <form action="{{ route('validasi-data.approve', $participant->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-check text-[#10AF13] hover:text-[#0e8e0f]">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                                        <path d="M15 19l2 2l4 -4" />
                                                    </svg>
                                                </button>
                                            </form>

                                            {{-- Button Tolak --}}
                                            <button type="button" @click="openRejectConfirm = true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-x text-[#ff0000] hover:text-[#E81B1B]">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                                                    <path d="M22 22l-5 -5" />
                                                    <path d="M17 22l5 -5" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>

                                <!-- Modal Detail -->
                                <td colspan="7">
                                    <div x-show="openDetail" x-cloak x-transition
                                        class="fixed inset-0 bg-black/40 z-50 items-center flex justify-center">
                                        <div class="bg-white max-w-xl rounded-2xl shadow-lg p-8 relative">

                                            <!-- Close Button -->
                                            <button @click="openDetail = false"
                                                class="absolute top-6 right-6 text-[#737373] hover:text-black text-xl">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M18 6l-12 12" />
                                                    <path d="M6 6l12 12" />
                                                </svg>
                                            </button>

                                            <!-- Header -->
                                            <h2 class="text-xl font-semibold">Detail Peserta</h2>
                                            <p class="text-[#737373] mb-6">Informasi lengkap peserta pelatihan</p>

                                            <!-- Content -->
                                            <div class="bg-gray-50 rounded-xl p-6 grid grid-cols-2 gap-y-6 gap-x-10">
                                                <div>
                                                    <p class="text-gray-700 text-md font-medium">Nama Lengkap</p>
                                                    <p>{{ $participant->user->name }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-700 text-md font-medium">Email</p>
                                                    <p>{{ $participant->user->email }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-700 text-md font-medium">Cabang</p>
                                                    <p>{{ $participant->branch->name ?? '-' }}</p>
                                                </div>
                                                <div class="col-span-2">
                                                    <p class="text-gray-700 text-md font-medium">Batch Pelatihan</p>
                                                    <p>{{ $participant->batch->title }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-700 text-md font-medium">Tanggal Pendaftaran</p>
                                                    <p>{{ $participant->created_at->translatedFormat('d F Y') }}<span
                                                            class="text-[#737373]"></span></p>
                                                </div>
                                                <div>
                                                    @php
                                                        $statusColor = match ($participant->status) {
                                                            'Approved' => 'bg-blue-100 text-[#0059FF]',
                                                            'Rejected' => 'bg-red-100 text-[#ff0000]',
                                                            default => 'bg-gray-200 text-gray-700',
                                                        };
                                                    @endphp
                                                    <p class="text-gray-700 text-md font-medium">Status</p>
                                                    <span
                                                        class="inline-block px-2 py-1 uppercase text-xs font-medium rounded-full {{ $statusColor }}">
                                                        {{ $participant->status }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Button (Hanya dengan Status Pending) -->
                                            @if ($participant->status === 'Registered')
                                                <hr class="mt-4">

                                                <div class="mt-3 flex justify-end gap-3">
                                                    <button type="button" @click="openRejectConfirm = true"
                                                        class="flex justify-center min-w-[100px] h-8 items-center gap-3 px-4 py-1 border rounded-lg text-[#ff0000] hover:bg-gray-50 font-medium">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-x">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                                                            <path d="M22 22l-5 -5" />
                                                            <path d="M17 22l5 -5" />
                                                        </svg>
                                                        <p>Tolak</p>
                                                    </button>

                                                    <form action="{{ route('validasi-data.approve', $participant->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button
                                                            class="flex justify-center min-w-[100px] h-8 items-center gap-3 px-4 py-1 rounded-lg text-white bg-[#10AF13] hover:bg-[#0e8e0f] font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-check">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                                                <path d="M15 19l2 2l4 -4" />
                                                            </svg>
                                                            <p>Setujui</p>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Modal Konfirmasi Tolak -->
                                    <div x-show="openRejectConfirm" x-cloak x-transition
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                                        <div class="bg-white w-full max-w-md rounded-2xl p-6 space-y-4">

                                            <!-- Icon -->
                                            <div class="flex justify-center text-[#ff0000]">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-x text-[#ff0000] hover:text-[#E81B1B]">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                                                    <path d="M22 22l-5 -5" />
                                                    <path d="M17 22l5 -5" />
                                                </svg>
                                            </div>

                                            <!-- Text -->
                                            <div class="text-center">
                                                <h2 class="text-2xl font-semibold">Tolak Pendaftaran</h2>
                                                <p class="text-gray-600 mt-2">
                                                    Apakah Anda yakin ingin menolak pendaftaran
                                                    <span class="font-semibold">{{ $participant->user->name }}</span>?
                                                </p>
                                            </div>

                                            <!-- Aksi -->
                                            <div class="flex justify-end gap-3 pt-4">
                                                <button @click="openRejectConfirm = false"
                                                    class="px-4 py-2 border rounded-lg hover:bg-gray-50 font-medium">
                                                    Batal
                                                </button>
                                                <form action="{{ route('validasi-data.reject', $participant->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-[#ff0000] text-white rounded-lg hover:bg-[#E81B1B] font-medium">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {{-- Jika tidak ada data peserta --}}
                @if ($participants->isEmpty())
                    @php
                        $status = request('statusValidasi');
                        $search = request('search');

                        $statusLabel = match ($status) {
                            'registered' => 'Registered',
                            'approved' => 'Approved',
                            'rejected' => 'Rejected',
                            default => null,
                        };
                    @endphp

                    <div class="p-11 border border-dashed rounded-2xl bg-gray-50 transition mt-8 mx-2 text-center">
                        <div class="flex justify-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" 
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                class="icon icon-tabler icons-tabler-outline icon-tabler-users text-gray-300">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                            </svg>
                        </div>

                        <p class="text-md font-medium text-gray-700">
                            @if ($statusLabel && $search)
                                Tidak ada data peserta dengan status
                                <strong>{{ $statusLabel }}</strong>
                                untuk
                                <strong>"{{ $search }}"</strong>.
                            @elseif ($statusLabel)
                                Tidak ada data peserta dengan status
                                <strong>{{ $statusLabel }}</strong>.
                            @elseif ($search)
                                Tidak ada data peserta dengan kata kunci
                                <strong>"{{ $search }}"</strong>.
                            @else
                                Tidak ada data peserta.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
