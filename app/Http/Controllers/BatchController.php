<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $trainers = User::where('role_id', 3)->orderBy('name')->get();

        $batches = Batch::with(['category', 'trainer'])
            ->withCount([
                'participants as active_participants_count' => function ($query) {
                    $query->whereIn('batch_participants.status', [
                        'Approved',
                        'Ongoing'
                    ]);
                }
            ])
            ->orderBy('created_at', 'asc');

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
        if ($request->filled('statusBatch')) {
            $batches->where('status', $request->statusBatch);
        }

        $batches = $batches->get();

        foreach ($batches as $batch) {
            $batch->refreshStatus();
        }

        $batchCounts = [
            'totalBatches' => Batch::count(),
            'scheduled' => Batch::where('status', 'Scheduled')->count(),
            'ongoing' => Batch::where('status', 'Ongoing')->count(),
            'completed' => Batch::where('status', 'Completed')->count(),
        ];

        return view('coordinator.batch-management', compact('categories', 'trainers', 'batches', 'batchCounts'));
    }

    public function dashboard()
    {
        $batchCounts = [
            'totalBatches' => Batch::count(),
            'scheduled' => Batch::where('status', 'Scheduled')->count(),
            'ongoing' => Batch::where('status', 'Ongoing')->count(),
            'completed' => Batch::where('status', 'Completed')->count(),
        ];

        $batches = Batch::all();

        return view('coordinator.dashboard', compact('batchCounts', 'batches'));
    }

    public function laporan()
    {
        $batchCounts = [
            'totalBatches' => Batch::count(),
            'scheduled' => Batch::where('status', 'Scheduled')->count(),
            'ongoing' => Batch::where('status', 'Ongoing')->count(),
            'completed' => Batch::where('status', 'Completed')->count(),
        ];

        $batches = Batch::all();

        $kategoriPelatihanCounts = [
            'totalKategori' => Category::count(),
            'denganPrerequisite' => Category::has('prerequisites')->count(),
            'tanpaPrerequisite' => Category::doesntHave('prerequisites')->count()
        ];

        $categories = Category::withCount('batches')->orderBy('name')->get();

        $batchPerKategori = $categories->pluck('batches_count');

        return view('coordinator.laporan', compact('batchCounts', 'batches', 'kategoriPelatihanCounts', 'categories', 'batchPerKategori'));
    }

    public function monitoringAbsensi()
    {
        $batches = Batch::all();

        return view('coordinator.monitoring-absensi', compact('batches'));
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'trainer_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'zoom_link' => 'required|url',
            'min_quota' => 'required|integer|min:0',
            'max_quota' => 'required|integer|gte:min_quota',
        ]);

        // Gabungkan date + time
        $startDateTime = Carbon::parse(
            $request->start_date . ' ' . $request->start_time
        );
        $endDateTime = Carbon::parse(
            $request->end_date . ' ' . $request->end_time
        );

        if ($endDateTime->lt($startDateTime)) {
            return back()->withErrors([
                'end_date' => 'Tanggal selesai harus setelah tanggal mulai.'
            ]);
        }

        $now = now();

        if ($now->lt($startDateTime)) {
            $status = 'Scheduled';
        } elseif ($now->between($startDateTime, $endDateTime)) {
            $status = 'Ongoing';
        } else {
            $status = 'Completed';
        }

        Batch::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'trainer_id' => $request->trainer_id,
            'start_date' => $startDateTime,
            'end_date' => $endDateTime,
            'zoom_link' => $request->zoom_link,
            'min_quota' => $request->min_quota,
            'max_quota' => $request->max_quota,
            'status' => $status,
        ]);

        return redirect()->back()->with('success', 'Batch berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Batch $batch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Batch $batch)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'trainer_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'zoom_link' => 'required|url',
            'min_quota' => 'required|integer|min:0',
            'max_quota' => 'required|integer|gte:min_quota',
        ]);

        // Gabungkan date + time
        $startDateTime = Carbon::parse(
            $request->start_date . ' ' . $request->start_time
        );
        $endDateTime = Carbon::parse(
            $request->end_date . ' ' . $request->end_time
        );

        if ($endDateTime->lt($startDateTime)) {
            return back()->withErrors([
                'end_date' => 'Tanggal selesai harus setelah tanggal mulai.'
            ]);
        }

        $now = now();

        if ($now->lt($startDateTime)) {
            $status = 'Scheduled';
        } elseif ($now->between($startDateTime, $endDateTime)) {
            $status = 'Ongoing';
        } else {
            $status = 'Completed';
        }

        $batch->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'trainer_id' => $request->trainer_id,
            'start_date' => $startDateTime,
            'end_date' => $endDateTime,
            'zoom_link' => $request->zoom_link,
            'min_quota' => $request->min_quota,
            'max_quota' => $request->max_quota,
            'status' => $status,
        ]);

        return redirect()->back()->with('success', 'Batch berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Batch $batch)
    {
        $batch->delete();

        return redirect()->back()->with('success', 'Batch berhasil dihapus');
    }
}
