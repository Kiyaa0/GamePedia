<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::latest()
            ->when($request->search, fn ($q, $search) => $q->whereAny(['name', 'email'], 'like', "%{$search}%"))
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa mengubah role diri sendiri.');
        }

        $user->update(['role' => $user->role === 'admin' ? 'user' : 'admin']);

        $message = "Role {$user->name} diubah menjadi ".($user->role === 'admin' ? 'Admin' : 'User').'.';

        return back()->with('success', $message);
    }

    public function suspend(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa suspend diri sendiri.');
        }

        $user->update(['suspended_at' => now()]);

        return back()->with('success', "Akun {$user->name} telah di-suspend.");
    }

    public function unsuspend(User $user): RedirectResponse
    {
        $user->update(['suspended_at' => null]);

        return back()->with('success', "Akun {$user->name} telah diaktifkan kembali.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return back()->with('success', "Akun {$user->name} telah dihapus.");
    }
}
