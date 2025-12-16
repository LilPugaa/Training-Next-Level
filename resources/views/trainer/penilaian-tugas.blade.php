@extends('layouts.trainer')

@section('content')
    <div class="px-2">
        <h1 class="text-2xl font-semibold">Penilaian Tugas</h1>
        <p class="text-[#737373] mt-2 font-medium">Review dan beri penilaian submission peserta</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-8 px-2">
        @include('dashboard.card', [
            'title'=>'Pending',
            'value'=>1,
            'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-4">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 12l3 2" /><path d="M12 7v5" /></svg>',
            'color'=>'text-[#FF4D00]'
        ])
        @include('dashboard.card', [
            'title'=>'Accepted',
            'value'=>0,
            'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg>',
            'color'=>'text-[#10AF13]'
        ])
        @include('dashboard.card', [
            'title'=>'Rejected',
            'value'=>0,
            'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                class="icon icon-tabler icons-tabler-x-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <circle cx="12" cy="12" r="9" /><path d="M10 10l4 4m0 -4l-4 4" /></svg>',
            'color'=>'text-[#ff0000]'
        ])
    </div>

    <div class="grid grid-cols-1 border lg:grid-cols-2 gap-4 px-5 bg-white py-6 rounded-2xl mt-8 mx-2">
        <!-- Dropdown Status -->
        <div>
            <select name="status"
                class="w-full h-full px-3 py-2 rounded-lg border-gray-300 text-sm cursor-pointer
                    focus:ring-[#10AF13] focus:border-[#10AF13]">
                <option value="">Semua Batch</option>
                <option value="pyGame">Python Game Developer Batch 1</option>
                <option value="pyCode">Python Coder Batch 3</option>
                <option value="webDev">Web Development Fundamentals</option>
            </select>
        </div>

        <!-- Dropdown Cabang -->
        <div>
            <select name="branch"
                class="w-full h-full px-3 py-2 rounded-lg border-gray-300 text-sm cursor-pointer
                    focus:ring-[#10AF13] focus:border-[#10AF13]">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="accepted">Accepted</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
    </div>

    <!-- Daftar Submission -->
    <div class="grid gap-6 mt-8 px-2">
        <div class="bg-white border rounded-2xl p-6">
            <div class="flex items-center justify-between position-relative w-full mb-5">
                <h2 class="text-lg font-semibold">
                    Daftar Submission
                </h2>
            </div>
            <div class="overflow-x-auto" x-data="{ openSubmission: false }">
                <table class="min-w-full rounded-xl overflow-hidden">
                    <thead class="border-b">
                        <tr class="text-left text-sm font-semibold text-gray-700">
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Tugas</th>
                            <th class="px-4 py-3">Batch</th>
                            <th class="px-4 py-3">Submitted</th>
                            <th class="px-4 py-3">Notes</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        <tr class="hover:bg-gray-50 transition text-left">
                            <td class="px-4 py-3 text-left">
                                Guru Peserta
                            </td>
                            <td class="px-4 py-3">
                                Buat Game Sederhana dengan Pygame
                            </td>
                            <td class="px-4 py-3">
                                Python Game Developer Batch 1
                            </td>
                            <td class="px-4 py-3">
                                12 Nov 2025
                            </td>
                            <td class="px-4 py-3">
                                Game Snake sederhana dengan scoring system
                            </td>
                            <td class="px-4 py-3">
                                <div class="px-2 py-1 w-fit text-xs font-medium rounded-full flex gap-2 items-center bg-orange-100 text-[#FF4D00]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" 
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-4">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M12 12l3 2" />
                                        <path d="M12 7v5" />
                                    </svg>
                                    <p>Pending</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-4">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" 
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-download hover:text-gray-700">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                            <path d="M7 11l5 5l5 -5" />
                                            <path d="M12 4l0 12" />
                                        </svg>
                                    </button>
                                    <button @click="openSubmission = true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" 
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-file-check hover:text-gray-700">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            <path d="M9 15l2 2l4 -4" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <!-- Modal Review Submission -->
                <div x-show="openSubmission" x-cloak x-transition id="reviewSubmission" class="fixed inset-0 bg-black/40 z-50 items-center flex justify-center">
                    <div @click.outside="openSubmission = false" class="bg-white max-w-xl rounded-2xl shadow-lg p-8 relative">

                        <!-- Close Button -->
                        <button @click="openSubmission = false" class="absolute top-6 right-6 text-[#737373] hover:text-black text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" 
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M18 6l-12 12" />
                                <path d="M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- Header -->
                        <h2 class="text-xl font-semibold">Review Subission</h2>
                        <p class="text-[#737373] mb-6">Berikan penilaian dan feedback untuk tugas peserta</p>

                        <!-- Content -->
                        <div class="bg-gray-50 rounded-xl p-6 grid grid-cols-2 gap-y-6 gap-x-10">
                            <div>
                                <p class="text-gray-700 text-md font-medium">Peserta</p>
                                <p>Guru Peserta</p>
                            </div>
                            <div>
                                <p class="text-gray-700 text-md font-medium">Tugas</p>
                                <p>Buat Game Sederhana dengan Pygame</p>
                            </div>
                            <div>
                                <p class="text-gray-700 text-md font-medium">Submitted</p>
                                <p>12 November 2025 pukul 22.30</p>
                            </div>
                            <div>
                                <p class="text-gray-700 text-md font-medium">Status</p>
                                <span class="px-2 py-1 w-fit text-xs font-medium rounded-full flex gap-2 items-center bg-orange-100 text-[#FF4D00]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" 
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-4">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M12 12l3 2" />
                                        <path d="M12 7v5" />
                                    </svg>
                                    <p>Pending</p>
                                </span>
                            </div>
                            <div class="col-span-2">
                                <p class="text-gray-700 text-md font-medium">Notes dari Peserta</p>
                                <p>Game Snake sederhana dengan scoring system</p>
                            </div>
                        </div>

                        <!-- Download File -->
                        <button class="bg-white rounded-lg border w-full mt-4 hover:bg-gray-50">
                            <div class="flex justify-center gap-3 py-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" 
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                    <path d="M7 11l5 5l5 -5" />
                                    <path d="M12 4l0 12" />
                                </svg>
                                <p class="font-medium">Download File</p>
                            </div>
                        </button>

                        <!-- Feedback -->
                        <div class="mt-5">
                            <p class="mb-1 font-semibold">Feedback untuk Peserta</p>
                            <textarea class="bg-gray-100 focus:ring-[#10AF13] focus:border-[#10AF13] font-medium border-none rounded-xl w-full resize-none focus:border-double" rows="4" placeholder="Berikan feedback..."></textarea>
                        </div>
                        
                        <hr class="mt-3">

                        <!-- Button -->
                        <div class="mt-3 flex justify-end gap-3">
                            <button class="flex justify-center items-center gap-3 px-4 py-1 border rounded-lg text-[#ff0000] hover:bg-gray-50 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" 
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                    class="icon icon-tabler icons-tabler-x-circle">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M10 10l4 4m0 -4l-4 4" />
                                </svg>
                                <p>Tolak</p>
                            </button>
                            <button class="flex justify-center items-center gap-3 px-4 py-1 rounded-lg text-white bg-[#10AF13] hover:bg-[#0e8e0f] font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" 
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M9 12l2 2l4 -4" />
                                </svg>
                                <p>Terima</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection