<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\TicketMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupportTicketController extends Controller
{
    public function index(Request $request): View
    {
        $tickets = $request->user()
            ->supportTickets()
            ->with('latestMessage')
            ->latest()
            ->paginate(15);

        return view('support.index', compact('tickets'));
    }

    public function create(): View
    {
        return view('support.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'category' => 'nullable|in:billing,bug,feature_request,general',
            'priority' => 'required|in:low,medium,high',
            'message' => 'required|string',
        ]);

        $priority = $validated['priority'];
        if ($request->user()->isPro() || $request->user()->isBusiness()) {
            $priority = 'high';
        }

        $ticket = $request->user()->supportTickets()->create([
            'subject' => $validated['subject'],
            'category' => $validated['category'],
            'priority' => $priority,
        ]);

        TicketMessage::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'message' => $validated['message'],
            'is_admin_reply' => false,
        ]);

        return redirect()->route('support.show', $ticket)->with('success', 'Ticket created successfully.');
    }

    public function show(Request $request, SupportTicket $support): View
    {
        abort_unless($support->user_id === $request->user()->id, 403);

        $support->load('messages.user');

        return view('support.show', ['ticket' => $support]);
    }

    public function reply(Request $request, SupportTicket $support): RedirectResponse
    {
        abort_unless($support->user_id === $request->user()->id, 403);
        abort_unless($support->isOpen(), 403);

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        TicketMessage::create([
            'support_ticket_id' => $support->id,
            'user_id' => $request->user()->id,
            'message' => $validated['message'],
            'is_admin_reply' => false,
        ]);

        return back()->with('success', 'Reply sent.');
    }

    public function close(Request $request, SupportTicket $support): RedirectResponse
    {
        abort_unless($support->user_id === $request->user()->id, 403);

        $support->update(['status' => 'closed']);

        return back()->with('success', 'Ticket closed.');
    }
}
