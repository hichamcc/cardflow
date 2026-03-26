<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($tier = $request->input('tier')) {
            $query->where('subscription_tier', $tier);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $users = $query->withCount('businessCards')->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $user->loadCount('businessCards', 'savedCards', 'supportTickets');
        $cards = $user->businessCards()->latest()->get();

        return view('admin.users.show', compact('user', 'cards'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'subscription_tier' => 'required|in:free,pro,business',
            'status' => 'required|in:active,suspended,banned',
            'admin_notes' => 'nullable|string',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)->with('success', 'User updated successfully.');
    }

    public function ban(User $user): RedirectResponse
    {
        $user->update(['status' => 'banned']);

        return back()->with('success', 'User has been banned.');
    }

    public function suspend(User $user): RedirectResponse
    {
        $user->update(['status' => 'suspended']);

        return back()->with('success', 'User has been suspended.');
    }

    public function activate(User $user): RedirectResponse
    {
        $user->update(['status' => 'active']);

        return back()->with('success', 'User has been activated.');
    }

    public function makePro(User $user): RedirectResponse
    {
        $user->update(['subscription_tier' => 'pro']);

        return back()->with('success', "{$user->name} has been granted Pro access.");
    }

    public function makeFree(User $user): RedirectResponse
    {
        $user->update(['subscription_tier' => 'free']);

        return back()->with('success', "{$user->name} has been moved to Free.");
    }

    public function impersonate(User $user): RedirectResponse
    {
        session(['impersonating_from' => Auth::id()]);
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
