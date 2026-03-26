<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'free_users' => User::where('subscription_tier', 'free')->count(),
            'pro_users' => User::where('subscription_tier', 'pro')->count(),
            'business_users' => User::where('subscription_tier', 'business')->count(),
            'open_tickets' => SupportTicket::open()->count(),
            'unread_contacts' => ContactSubmission::unread()->count(),
        ];

        $recentSignups = User::latest()->take(5)->get();
        $recentTickets = SupportTicket::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentSignups', 'recentTickets'));
    }
}
