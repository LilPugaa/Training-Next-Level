<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Material;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainerId = Auth::id();

        $batches = Batch::with(['category', 'participants'])
            ->where('trainer_id', Auth::id())
            ->latest()
            ->get();

        $materialCounts = [
            'totalMaterials' => Material::where('trainer_id', Auth::id())->count(),
            'totalPdf' => Material::where('trainer_id', Auth::id())->where('tipe_materi', 'pdf')->count(),
            'totalVideos' => Material::where('trainer_id', Auth::id())->where('tipe_materi', 'video')->count(),
            'totalRecords' => Material::where('trainer_id', Auth::id())->where('tipe_materi', 'recording')->count(),
            'totalLinks' => Material::where('trainer_id', Auth::id())->where('tipe_materi', 'link')->count(),
        ];

        $batchesWithoutMaterials = Batch::where('trainer_id', $trainerId)
            ->whereDoesntHave('materials', function($query) use ($trainerId) {
                $query->where('trainer_id', $trainerId);
            })
            ->latest()
            ->get();

        return view('trainer.upload-materi', compact('batches', 'materialCounts', 'batchesWithoutMaterials'));
    }

    public function trainerDashboard()
    {
        $materialCounts = [
            'totalMaterials' => Material::where('trainer_id', Auth::id())->count(),
            'totalPdf' => Material::where('trainer_id', Auth::id())->where('tipe_materi', 'pdf')->count(),
            'totalVideos' => Material::where('trainer_id', Auth::id())->where('tipe_materi', 'video')->count(),
            'totalRecords' => Material::where('trainer_id', Auth::id())->where('tipe_materi', 'recording')->count(),
            'totalLinks' => Material::where('trainer_id', Auth::id())->where('tipe_materi', 'link')->count(),
        ];

        $batches = Batch::with(['category', 'participants'])
            ->where('trainer_id', Auth::id())
            ->latest()
            ->get();

        $batchCounts = [
            'totalBatches' => $batches->count(),
            'scheduled' => $batches->where('status', 'Scheduled')->count(),
            'ongoing' => $batches->where('status', 'Ongoing')->count(),
            'completed' => $batches->where('status', 'Completed')->count(),
        ];

        return view('trainer.dashboard', compact('batches', 'batchCounts', 'materialCounts'));
    }

    public function trainerBatches()
    {
        $allBatches = Batch::with(['category', 'participants'])
            ->where('trainer_id', Auth::id())
            ->latest()
            ->get();

        $batches = $allBatches->groupBy(fn ($batch) => strtolower($batch->status));

        $batchCounts = [
            'totalBatches' => $allBatches->count(),
            'scheduled' => $batches->get('scheduled', collect())->count(),
            'ongoing' => $batches->get('ongoing', collect())->count(),
            'completed' => $batches->get('completed', collect())->count(),
        ];

        return view('trainer.batches', compact('batches', 'batchCounts'));
    }

    public function trainerApprovalKehadiran()
    {
        $batches = Batch::with(['category', 'participants'])
            ->where('trainer_id', Auth::id())
            ->latest()
            ->get();

        return view('trainer.approval-kehadiran', compact('batches'));
    }

    public function trainerPenilaianTugas()
    {
        $batches = Batch::with(['category', 'participants'])
            ->where('trainer_id', Auth::id())
            ->latest()
            ->get();

        return view('trainer.penilaian-tugas', compact('batches'));
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
            'judul_materi' => 'required|string|max:255',
            'tipe_materi' => 'required',
            'link_materi' => 'required|url',
        ]);

        Material::create([
            'batch_id' => $request->batch_id,
            'trainer_id' => Auth::id(),
            'judul_materi' => $request->judul_materi,
            'tipe_materi' => $request->tipe_materi,
            'link_materi' => $request->link_materi,
        ]);

        return redirect()->back()->with('success', 'Materi berhasil diupload');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'judul_materi' => 'required|string|max:255',
            'tipe_materi' => 'required',
            'link_materi' => 'required|url',
        ]);

        $material->update([
            'batch_id' => $request->batch_id,
            'judul_materi' => $request->judul_materi,
            'tipe_materi' => $request->tipe_materi,
            'link_materi' => $request->link_materi,
        ]);

        return redirect()->back()->with('success', 'Materi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->back()->with('success', 'Materi berhasil dihapus'); 
    }
}
