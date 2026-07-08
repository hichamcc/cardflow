<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function create(): View
    {
        return view('auth.register', [
            'formRenderedAt' => encrypt(now()->timestamp),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Honeypot: real users never see or fill this field; bots that
        // autofill every input do. Silently pretend registration worked.
        if (filled($request->input('website'))) {
            return redirect(route('dashboard', absolute: false));
        }

        // Timing check: reject submissions faster than a human could
        // plausibly fill the form (page load -> submit).
        $renderedAt = rescue(fn () => (int) decrypt($request->input('form_rendered_at')), 0, report: false);
        if ($renderedAt === 0 || now()->timestamp - $renderedAt < 3) {
            return redirect(route('dashboard', absolute: false));
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        $user->notify(new WelcomeNotification);

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
