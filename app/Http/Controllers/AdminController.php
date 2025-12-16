<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $users = User::with('role', 'branch')->get();

        $totalHqCurriculumAdminUsers = User::whereHas('role', function($query) {
            $query->where('name', 'admin');
        })->count();

        $totalTrainingCoordinatorUsers = User::whereHas('role', function($query) {
            $query->where('name', 'coordinator');
        })->count();

        $totalTrainerUsers = User::whereHas('role', function($query) {
            $query->where('name', 'trainer');
        })->count();

        $totalBranchPicUsers = User::whereHas('role', function($query) {
            $query->where('name', 'branch_pic');
        })->count();

        $totalParticipantUsers = User::whereHas('role', function($query) {
            $query->where('name', 'participant');
        })->count();

        $dashboardUserCounts = [
            'totalHqCurriculumAdminUsers' => $totalHqCurriculumAdminUsers,
            'totalTrainingCoordinatorUsers' => $totalTrainingCoordinatorUsers,
            'totalTrainerUsers' => $totalTrainerUsers,
            'totalBranchPicUsers' => $totalBranchPicUsers,
            'totalParticipantUsers' => $totalParticipantUsers,
        ];

        return view('admin.role-permission', compact('roles', 'users', 'dashboardUserCounts'));
    }
}
