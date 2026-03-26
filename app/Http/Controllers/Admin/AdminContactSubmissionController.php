<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminContactSubmissionController extends Controller
{
    public function index(Request $request): View
    {
        $query = ContactSubmission::query();

        if ($request->input('filter') === 'unread') {
            $query->unread();
        } elseif ($request->input('filter') === 'read') {
            $query->where('is_read', true);
        }

        $submissions = $query->latest()->paginate(20)->withQueryString();

        return view('admin.contacts.index', compact('submissions'));
    }

    public function show(ContactSubmission $submission): View
    {
        return view('admin.contacts.show', compact('submission'));
    }

    public function markRead(ContactSubmission $submission): RedirectResponse
    {
        $submission->update(['is_read' => ! $submission->is_read]);

        return back()->with('success', $submission->is_read ? 'Marked as read.' : 'Marked as unread.');
    }

    public function destroy(ContactSubmission $submission): RedirectResponse
    {
        $submission->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Submission deleted.');
    }
}
