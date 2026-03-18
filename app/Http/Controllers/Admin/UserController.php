<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function toggleRole(User $user)
    {
        if ($user->id === Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Cannot change your own role.'], 422);
        }

        $user->update(['role' => $user->role === 'admin' ? 'user' : 'admin']);

        ActivityLog::log('user_role_changed', "User '{$user->name}' role changed to '{$user->role}'");

        return response()->json(['success' => true, 'role' => $user->role]);
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Cannot delete yourself.'], 422);
        }

        $name = $user->name;
        $user->delete();

        ActivityLog::log('user_deleted', "Admin deleted user '{$name}'");

        return response()->json(['success' => true]);
    }
}
