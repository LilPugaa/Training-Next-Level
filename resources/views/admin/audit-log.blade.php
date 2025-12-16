@extends('layouts.app')

@section('content')
    <div class="px-2">
        <h1 class="text-2xl font-semibold">Audit Log</h1>
        <p class="text-[#737373] mt-2 font-medium">Riwayat aktivitas sistem dan perubahan data</p>
    </div>

    <div class="grid grid-cols-1 border lg:grid-cols-3 gap-4 px-5 bg-white py-6 rounded-2xl mt-8 mx-2">
        <!-- Search -->
        <div class="flex items-center bg-[#F1F1F1] rounded-lg px-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round"
                class="text-[#737373]">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                <path d="M21 21l-6 -6" />
            </svg>
            <input type="text"
                name="search"
                class="w-full border-0 focus:ring-0 text-sm bg-[#F1F1F1] placeholder-[#737373]"
                placeholder="Cari user atau detail..." />
        </div>

        <!-- Dropdown Status -->
        <div>
            <select name="status"
                class="w-full h-full px-3 py-2 rounded-lg border-gray-300 text-sm cursor-pointer
                    focus:ring-[#10AF13] focus:border-[#10AF13]">
                <option value="">Semua Aksi</option>
                <option value="create">Create</option>
                <option value="update">Update</option>
                <option value="delete">Delete</option>
                <option value="approve">Approve</option>
                <option value="reject">Reject</option>
            </select>
        </div>

        <!-- Dropdown Cabang -->
        <div>
            <select name="branch"
                class="w-full h-full px-3 py-2 rounded-lg border-gray-300 text-sm cursor-pointer
                    focus:ring-[#10AF13] focus:border-[#10AF13]">
                <option value="">Semua Entitas</option>
                <option value="admin">HQ Curriculum Admin</option>
                <option value="coordinator">Training Coordinator</option>
                <option value="trainer">Trainer</option>
                <option value="branch">Branch PIC</option>
                <option value="participant">Participant</option>
            </select>
        </div>
    </div>

    <!-- Riwayat Aktivitas -->
    <div class="bg-white border rounded-2xl p-6 mt-8 mx-2">
        <h2 class="text-lg font-semibold mb-5">
            Riwayat Aktivitas <span>(6)</span>
        </h2>
        <div class="space-y-4 max-h-[1000px] overflow-y-auto pr-1">
            <!-- ITEM 1 -->
            <div class="px-4 py-3 border rounded-xl hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-gray-200 px-3 w-fit py-1">
                        <p class="text-sm font-bold text-gray-800">
                            UPDATE_BATCH
                        </p>
                    </div>
                    <div class="rounded-xl border px-3 w-fit py-1">
                        <p class="text-sm font-bold">
                            Training Coordinator
                        </p>
                    </div>
                    <div>
                        <p class="text-lg font-medium">
                            Koordinator Pelatihan
                        </p>
                    </div>
                    <div class="ml-auto text-right">
                        <p class="px-3 py-1 text-md font-medium">
                            2 Des 2025, 11.53
                        </p>
                    </div>
                </div>
                <div class="mt-1">
                    <p class="text-lg font-medium text-gray-700">
                        Update batch: Python Game Developer Batch 1
                    </p>
                </div>
            </div>

            <!-- ITEM 2 -->
            <div class="px-4 py-3 border rounded-xl hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-gray-200 px-3 w-fit py-1">
                        <p class="text-sm font-bold text-gray-800">
                            CREATE_BATCH
                        </p>
                    </div>
                    <div class="rounded-xl border px-3 w-fit py-1">
                        <p class="text-sm font-bold">
                            Training Coordinator
                        </p>
                    </div>
                    <div>
                        <p class="text-lg font-medium">
                            Koordinator Pelatihan
                        </p>
                    </div>
                    <div class="ml-auto text-right">
                        <p class="px-3 py-1 text-md font-medium">
                            1 Nov 2025, 18.30
                        </p>
                    </div>
                </div>
                <div class="mt-1">
                    <p class="text-lg font-medium text-gray-700">
                        Membuat batch baru: Python Game Developer Batch 1
                    </p>
                </div>
            </div>

            <!-- ITEM 3 -->
            <div class="px-4 py-3 border rounded-xl hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-gray-200 px-3 w-fit py-1">
                        <p class="text-sm font-bold text-gray-800">
                            UPDATE_BATCH_STATUS
                        </p>
                    </div>
                    <div class="rounded-xl border px-3 w-fit py-1">
                        <p class="text-sm font-bold">
                            Training Coordinator
                        </p>
                    </div>
                    <div>
                        <p class="text-lg font-medium">
                            Koordinator Pelatihan
                        </p>
                    </div>
                    <div class="ml-auto text-right">
                        <p class="px-3 py-1 text-md font-medium">
                            10 Nov 2025, 16.00
                        </p>
                    </div>
                </div>
                <div class="mt-1">
                    <p class="text-lg font-medium text-gray-700">
                        Mengubah status batch menjadi ONGOING
                    </p>
                </div>
            </div>

            <!-- ITEM 4 -->
            <div class="px-4 py-3 border rounded-xl hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-gray-200 px-3 w-fit py-1">
                        <p class="text-sm font-bold text-gray-800">
                            APPROVE_PARTICIPANT
                        </p>
                    </div>
                    <div class="rounded-xl border px-3 w-fit py-1">
                        <p class="text-sm font-bold">
                            Branch PIC
                        </p>
                    </div>
                    <div>
                        <p class="text-lg font-medium">
                            PIC Jakarta
                        </p>
                    </div>
                    <div class="ml-auto text-right">
                        <p class="px-3 py-1 text-md font-medium">
                            21 Okt 2025, 22.20
                        </p>
                    </div>
                </div>
                <div class="mt-1">
                    <p class="text-lg font-medium text-gray-700">
                        Menyetujui pendaftaran peserta: Guru Peserta
                    </p>
                </div>
            </div>

            <!-- ITEM 5 -->
            <div class="px-4 py-3 border rounded-xl hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-gray-200 px-3 w-fit py-1">
                        <p class="text-sm font-bold text-gray-800">
                            VALIDATE_ATTENDANCE
                        </p>
                    </div>
                    <div class="rounded-xl border px-3 w-fit py-1">
                        <p class="text-sm font-bold">
                            Trainer
                        </p>
                    </div>
                    <div>
                        <p class="text-lg font-medium">
                            Ahmad
                        </p>
                    </div>
                    <div class="ml-auto text-right">
                        <p class="px-3 py-1 text-md font-medium">
                            10 Nov 2025, 17.05
                        </p>
                    </div>
                </div>
                <div class="mt-1">
                    <p class="text-lg font-medium text-gray-700">
                        Validasi kehadiran peserta: Guru Peserta
                    </p>
                </div>
            </div>

            <!-- ITEM 6 -->
            <div class="px-4 py-3 border rounded-xl hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-gray-200 px-3 w-fit py-1">
                        <p class="text-sm font-bold text-gray-800">
                            SUBMIT_ASSIGNMENT
                        </p>
                    </div>
                    <div class="rounded-xl border px-3 w-fit py-1">
                        <p class="text-sm font-bold">
                            Participant
                        </p>
                    </div>
                    <div>
                        <p class="text-lg font-medium">
                            Guru Peserta
                        </p>
                    </div>
                    <div class="ml-auto text-right">
                        <p class="px-3 py-1 text-md font-medium">
                            12 Nov 2025, 22.30
                        </p>
                    </div>
                </div>
                <div class="mt-1">
                    <p class="text-lg font-medium text-gray-700">
                        Submit tugas: Game Sederhana dengan Pygame
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection