<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return view('admin.pages.user.index', [
            'title' => 'Data Pengguna',
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone_number' => 'required|string|unique:users,phone_number',
                'password' => 'required|string|min:6|confirmed',
                'role' => 'required|in:customer,technician,admin',
            ]);

            $validated['password'] = Hash::make($validated['password']);

            User::create($validated);

            return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone_number' => 'required|string|unique:users,phone_number,' . $user->id,
                'role' => 'required|in:technician,admin',
                'password' => 'nullable|string|min:6|confirmed',
            ]);

            if ($request->filled('password')) {
                $validated['password'] = Hash::make($request->password);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            return redirect()->back()->with('success', 'Pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui pengguna: ' . $e->getMessage());
        }
    }

    public function delete(User $user)
    {
        try {
            $user->delete();
            return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }
}
