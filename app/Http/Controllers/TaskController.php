<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainerId = Auth::id();

        $now = Carbon::now();

        $batches = Batch::with(['category', 'participants'])
            ->where('trainer_id', $trainerId)
            ->latest()
            ->get();

        $batchCounts = [
            'totalBatches' => $batches->count(),
            'scheduled' => $batches->where('status', 'Scheduled')->count(),
            'ongoing' => $batches->where('status', 'Ongoing')->count(),
            'completed' => $batches->where('status', 'Completed')->count(),
        ];

        $taskCounts = [
            'totalTasks' => Task::whereHas('batch', function ($queryTotalTasks) use ($trainerId) {
                $queryTotalTasks->where('trainer_id', $trainerId);
            })->count(),

            'totalAktif' => Task::whereHas('batch', function ($queryTotalAktif) use ($trainerId) {
                $queryTotalAktif->where('trainer_id', $trainerId);
            })
                ->whereDate('deadline', '>=', now())
                ->count(),

            'totalTerlambat' => Task::whereHas('batch', function ($queryTotalTerlambat) use ($trainerId) {
                $queryTotalTerlambat->where('trainer_id', $trainerId);
            })
                ->whereDate('deadline', '<', now())
                ->count(),
        ];

        $batchesWithoutTasks = Batch::where('trainer_id', $trainerId)
            ->whereDoesntHave('tasks', function ($query) use ($trainerId) {
                $query->where('trainer_id', $trainerId);
            })
            ->orderBy('title', 'asc')
            ->get();

        return view('trainer.upload-tugas', compact('batches', 'batchCounts', 'taskCounts', 'batchesWithoutTasks'));
    }

    public function dashboard()
    {
        //
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
        $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'title' => 'required|string|max:255',
            'description' => 'required',
            'deadline' => 'required',
            'link_lampiran' => 'required|url',
        ]);

        Task::create([
            'batch_id' => $request->batch_id,
            'trainer_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'link_lampiran' => $request->link_lampiran,
        ]);

        return redirect()->back()->with('success', 'Tugas berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'title' => 'required|string|max:255',
            'description' => 'required',
            'deadline' => 'required',
            'link_lampiran' => 'required|url',
        ]);

        $task->update([
            'batch_id' => $request->batch_id,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'link_lampiran' => $request->link_lampiran,
        ]);

        return redirect()->back()->with('success', 'Tugas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->back()->with('success', 'Tugas berhasil dihapus'); 
    }
}
