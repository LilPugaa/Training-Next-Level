<?php

namespace App\Http\Controllers;

use App\Models\BatchParticipant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BranchPicController extends Controller
{
    public function index(Request $request)
    {
        $participants = BatchParticipant::with([
            'user',
            'batch'
        ]);

        $statusCounts = [
            'statusRegistered' => BatchParticipant::where('status', 'Registered')->count(),
            'statusApproved' => BatchParticipant::where('status', 'Approved')->count(),
            'statusRejected' => BatchParticipant::where('status', 'Rejected')->count(),
        ];

        // Fitur search
        if ($request->filled('search')) {
            $participants->where(function ($query) use ($request) {
                $query->whereHas('user', function ($queryParticipant) use ($request) {
                    $queryParticipant->where('name', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('batch', function ($queryBatch) use ($request) {
                    $queryBatch->where('title', 'like', '%' . $request->search . '%');
                });
            });
        }

        // Filter status
        if ($request->filled('statusValidasi')) {
            $participants->where('status', $request->statusValidasi);
        }

        $participants = $participants->orderBy('created_at', 'asc')->get();

        return view('branch_pic.validasi-data', compact('participants', 'statusCounts'));
    }

    public function approve(BatchParticipant $batchParticipant)
    {
        $batchParticipant->update([
            'status' => 'Approved',
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', 'Pendaftaran berhasil disetujui');
    }

    public function reject(BatchParticipant $batchParticipant)
    {
        $batchParticipant->update([
            'status' => 'Rejected',
            'approved_by' => Auth::id(),
        ]);

        return back()->with('error', 'Pendaftaran ditolak');
    }
}
