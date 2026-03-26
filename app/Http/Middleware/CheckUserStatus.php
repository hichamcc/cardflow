<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && in_array($user->status, ['banned', 'suspended'])) {
            $status = $user->status;
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = $status === 'banned'
                ? 'Your account has been banned. Please contact support.'
                : 'Your account has been suspended. Please contact support.';

            return redirect()->route('login')->withErrors(['email' => $message]);
        }

        return $next($request);
    }
}
