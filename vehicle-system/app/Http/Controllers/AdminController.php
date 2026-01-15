<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('name')->get();

        return view('admin.users', compact('users'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'is_admin' => 'required|boolean'
        ]);

        // prevent removing own admin right unintentionally
        if ($user->id === $request->user()->id && ! $request->boolean('is_admin')) {
            return back()->with('error', "You can't remove your own admin access.");
        }

        $user->is_admin = $request->boolean('is_admin');
        $user->save();

        return back()->with('success', 'User updated.');
    }

    public function destroy(Request $request, User $user)
    {
        // Prevent deleting self
        if ($user->id === $request->user()->id) {
            return back()->with('error', "You can't delete your own account here.");
        }

        // Prevent deleting the last admin
        if ($user->is_admin) {
            $adminsCount = User::where('is_admin', true)->count();
            if ($adminsCount <= 1) {
                return back()->with('error', 'Can not delete the last admin user.');
            }
        }

        $user->delete();

        return back()->with('success', 'User deleted.');
    }

    
}
