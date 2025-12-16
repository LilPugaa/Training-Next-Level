<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'tokenInputUser' => 'nullable|string',
        ]);

        $role = Role::findOrFail($request->role_id);

        if ($role->name !== 'participant') {
            if ($request->tokenInputUser !== $role->access_token) {
                return back()->withErrors([
                    'tokenInputUser' => 'Token akses tidak valid.',
                ])->withInput();
            }
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.role-permission')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.role-permission')
            ->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy(User $user) {
        $user->delete();

        return redirect()->route('admin.role-permission')
            ->with('success', 'User berhasil dihapus!');
    }
}
