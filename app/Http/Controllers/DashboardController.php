<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $stats = [
            'total_cards' => $user->businessCards()->count(),
            'total_saved' => $user->savedCards()->count(),
            'total_views' => $user->businessCards()->sum('view_count'),
            'pending_follow_ups' => $user->followUps()->where('status', 'pending')->count(),
        ];

        $recentCards = $user->businessCards()
            ->latest()
            ->take(5)
            ->get();

        $upcomingFollowUps = $user->followUps()
            ->with('savedCard.businessCard')
            ->where('status', 'pending')
            ->orderBy('follow_up_date')
            ->take(5)
            ->get();

        $recentInteractions = $user->interactions()
            ->with('savedCard.businessCard')
            ->latest('interaction_date')
            ->take(5)
            ->get();

        $todayEvents = $user->events()
            ->with('savedCard')
            ->today()
            ->scheduled()
            ->orderBy('start_at')
            ->get();

        return view('dashboard', compact('stats', 'recentCards', 'upcomingFollowUps', 'recentInteractions', 'todayEvents'));
    }
}
