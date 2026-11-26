<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    // Akun dibatasi satu per role, jadi tidak ada tambah atau hapus pengguna.
    public function index()
    {
        $order = ['admin' => 1, 'operator' => 2, 'pimpinan' => 3];
        $users = User::all()->sortBy(fn (User $user) => $order[$user->role] ?? 99)->values();

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        // Mencegah admin menonaktifkan akunnya sendiri sehingga tidak bisa login lagi.
        if ($user->is(auth()->user())) {
            $data['status'] = 'aktif';
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }
}
