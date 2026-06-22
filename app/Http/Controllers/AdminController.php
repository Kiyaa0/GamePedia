<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WishlistItem;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $selectedUserId = $request->input('user');

        $users = User::where('role', 'user')->with(['wishlistItems' => function ($q) {
            $q->latest();
        }])->when($selectedUserId, function ($q) use ($selectedUserId) {
            $q->whereKey($selectedUserId);
        })->get();

        $totalUsers = User::where('role', 'user')->count();
        $totalWishlisted = WishlistItem::count();
        $totalOwned = WishlistItem::where('status', 'owned')->count();

        return view('admin.dashboard', compact(
            'users',
            'selectedUserId',
            'totalUsers',
            'totalWishlisted',
            'totalOwned',
        ));
    }
}
