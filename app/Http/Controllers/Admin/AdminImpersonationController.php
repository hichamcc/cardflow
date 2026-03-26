<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AdminImpersonationController extends Controller
{
    public function stop(): RedirectResponse
    {
        $adminId = session('impersonating_from');

        if (! $adminId) {
            return redirect()->route('dashboard');
        }

        $admin = User::find($adminId);

        if ($admin && $admin->is_admin) {
            session()->forget('impersonating_from');
            Auth::login($admin);

            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }
}
