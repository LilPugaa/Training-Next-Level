<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Category;
use App\Models\User;
use App\Models\BatchParticipant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BatchParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        
        $batches = Batch::with([
            'category.prerequisites',
            'trainer',
            'participants' => function ($query) use ($userId) {
                $query->where('users.id', $userId);
            }
        ])
        ->withCount([
            'participants as active_participants_count' => function ($query) {
                $query->whereIn('batch_participants.status', [
                    'Approved',
                    'Ongoing'
                ]);
            }
        ])
        ->orderBy('start_date', 'asc');

        // Fitur search
        if ($request->filled('search')) {
            $search = $request->search;

            $batches->where(function ($queryBatch) use ($search) {
                $queryBatch->where('title', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($queryKategori) use ($search) {
                        $queryKategori->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('trainer', function ($queryTrainer) use ($search) {
                        $queryTrainer->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Filter status
        if ($request->filled('statusPendaftaran')) {
            $batches->where('status', ucfirst($request->statusPendaftaran));
        }

        $batches = $batches->get();

        return view('participant.pendaftaran', compact('batches'));
    }

    public function pelatihan(Request $request)
    {
        $userId = Auth::id();

        $batches = Batch::query()
            // Filter Status Pendaftaran
            ->whereHas('participants', function ($query) use ($userId, $request) {
                $query->where('users.id', $userId);

                if ($request->filled('statusPendaftaran')) {
                    $query->where(
                        'batch_participants.status', 
                        $request->statusPendaftaran
                    );
                }
            })

            // Filter Status Pelatihan
            ->when($request->filled('statusPelatihan'), function ($query) use ($request) {
                $query->where('status', ucfirst($request->statusPelatihan));
            })

            // Fitur Search
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($queryBatch) use ($search) {
                    $queryBatch->where('title', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($queryCategory) use ($search) {
                            $queryCategory->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('trainer', function ($queryTrainer) use ($search) {
                            $queryTrainer->where('name', 'like', "%{$search}%");
                        });
                });
            })

            // Load Relation
            ->with([
                'category.prerequisites',
                'trainer',
                'participants' => function ($query) use ($userId) {
                    $query->where('users.id', $userId);
                }
            ])

            // Hitung jumlah materi & tugas
            ->withCount([
                'materials',
                'tasks'
            ])
            ->orderBy('start_date', 'asc')
            ->get();

        return view('participant.pelatihan', compact('batches'));
    }

    public function dashboard(Request $request)
    {
        $userId = Auth::id();

        $batches = Batch::query()
            // Filter Status Pendaftaran
            ->whereHas('participants', function ($query) use ($userId, $request) {
                $query->where('users.id', $userId);

                if ($request->filled('statusPendaftaran')) {
                    $query->where(
                        'batch_participants.status', 
                        $request->statusPendaftaran
                    );
                }
            })
            ->orderBy('start_date', 'asc')
            ->get();

            $batchCounts = [
                'totalBatches' => $batches->count(),
                'scheduled' => $batches->where('status', 'Scheduled')->count(),
                'ongoing' => $batches->where('status', 'Ongoing')->count(),
                'completed' => $batches->where('status', 'Completed')->count(),
            ];

        return view('participant.dashboard', compact('batches', 'batchCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Batch $batch)
    {
        // Jika batch Penuh
        if ($batch->participants()->count() >= $batch->max_quota) {
            return back()->with('error', 'Kuota batch sudah penuh!');
        }

        // Jika ada prerequisite
        if ($batch->category->prerequisites->isNotEmpty()) {
            return back()->with('warning', 'Selesaikan prerequisite terlebih dahulu');
        }

        // Jika sudah daftar batch
        $exists = BatchParticipant::where('batch_id', $batch->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($exists) {
            return back()->with('warning', 'Anda sudah terdaftar di batch ini');
        }

        // Simpan ke database
        BatchParticipant::create([
            'batch_id' => $batch->id,
            'user_id'  => Auth::id(),
            'status'   => 'Registered',
        ]);

        return back()->with('success', 'Pendaftaran berhasil! Menunggu approval dari Branch PIC');
    }

    /**
     * Display the specified resource.
     */
    public function show(BatchParticipant $batchParticipant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BatchParticipant $batchParticipant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BatchParticipant $batchParticipant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BatchParticipant $batchParticipant)
    {
        //
    }
}
