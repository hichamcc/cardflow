<?php

use App\Http\Controllers\Admin\AdminContactSubmissionController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminImpersonationController;
use App\Http\Controllers\Admin\AdminTicketController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\BusinessCardController;
use App\Http\Controllers\ContactBulkActionController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\ContactImportExportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicCardController;
use App\Http\Controllers\SavedCardController;
use App\Http\Controllers\Settings;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

// Sitemap
Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Public card view
Route::get('c/{slug}', [PublicCardController::class, 'show'])->name('public.card.show');
Route::get('c/{slug}/vcard', [PublicCardController::class, 'downloadVCard'])->name('public.card.vcard');
Route::get('c/{slug}/qr', [PublicCardController::class, 'downloadQr'])->name('public.card.qr');
Route::get('c/{slug}/link/{link}', [PublicCardController::class, 'trackLink'])->name('public.card.track-link');

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Temporary: logo preview page
Route::get('/logo-preview', fn () => view('logo-preview'));

// Legal pages
Route::view('/terms', 'legal.terms')->name('legal.terms');
Route::view('/privacy', 'legal.privacy')->name('legal.privacy');
Route::view('/refund', 'legal.refund')->name('legal.refund');

// Public contact form
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', [ContactFormController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Upgrade / Billing
    Route::get('upgrade', [Settings\BillingController::class, 'upgrade'])->name('upgrade');

    // Analytics
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // Business Cards CRUD
    Route::resource('cards', BusinessCardController::class);
    Route::post('cards/{card}/duplicate', [BusinessCardController::class, 'duplicate'])->name('cards.duplicate');
    Route::patch('cards/{card}/toggle', [BusinessCardController::class, 'toggle'])->name('cards.toggle');

    // Contacts: CSV Import/Export (must be before resource route)
    Route::get('contacts/export', [ContactImportExportController::class, 'export'])->name('contacts.export');
    Route::get('contacts/import', [ContactImportExportController::class, 'import'])->name('contacts.import');
    Route::post('contacts/import', [ContactImportExportController::class, 'processImport'])->name('contacts.import.process');
    Route::get('contacts/sample-csv', [ContactImportExportController::class, 'sampleCsv'])->name('contacts.sample-csv');

    // Contacts: Bulk Actions
    Route::post('contacts/bulk/move', [ContactBulkActionController::class, 'move'])->name('contacts.bulk.move');
    Route::post('contacts/bulk/tag', [ContactBulkActionController::class, 'tag'])->name('contacts.bulk.tag');
    Route::post('contacts/bulk/status', [ContactBulkActionController::class, 'status'])->name('contacts.bulk.status');
    Route::post('contacts/bulk/export', [ContactBulkActionController::class, 'export'])->name('contacts.bulk.export');
    Route::post('contacts/bulk/delete', [ContactBulkActionController::class, 'destroy'])->name('contacts.bulk.delete');

    // Saved Cards (Contacts)
    Route::resource('contacts', SavedCardController::class);
    Route::post('contacts/{contact}/move', [SavedCardController::class, 'move'])->name('contacts.move');
    Route::post('c/{slug}/save', [SavedCardController::class, 'saveFromPublic'])->name('contacts.save-public');

    // Folders
    Route::resource('folders', FolderController::class)->except(['show']);
    Route::get('folders/{folder}', [SavedCardController::class, 'index'])->name('folders.show');

    // Tags
    Route::resource('tags', TagController::class)->except(['show']);

    // CRM - Interactions
    Route::post('contacts/{contact}/interactions', [InteractionController::class, 'store'])->name('interactions.store');
    Route::delete('interactions/{interaction}', [InteractionController::class, 'destroy'])->name('interactions.destroy');

    // CRM - Notes (free)
    Route::resource('notes', NoteController::class);
    Route::patch('notes/{note}/toggle-pin', [NoteController::class, 'togglePin'])->name('notes.toggle-pin');

    // CRM - Calendar & Events (free)
    Route::get('calendar', [EventController::class, 'index'])->name('calendar.index');
    Route::resource('events', EventController::class);
    Route::patch('events/{event}/complete', [EventController::class, 'complete'])->name('events.complete');
    Route::patch('events/{event}/cancel', [EventController::class, 'cancel'])->name('events.cancel');
    Route::get('api/events', [EventController::class, 'apiEvents'])->name('api.events');

    // CRM - Pro features
    Route::middleware('pro')->group(function () {
        // Follow-ups
        Route::get('follow-ups', [FollowUpController::class, 'index'])->name('follow-ups.index');
        Route::post('contacts/{contact}/follow-ups', [FollowUpController::class, 'store'])->name('follow-ups.store');
        Route::patch('follow-ups/{followUp}/complete', [FollowUpController::class, 'complete'])->name('follow-ups.complete');
        Route::patch('follow-ups/{followUp}/cancel', [FollowUpController::class, 'cancel'])->name('follow-ups.cancel');
        Route::delete('follow-ups/{followUp}', [FollowUpController::class, 'destroy'])->name('follow-ups.destroy');

        // Deals
        Route::resource('deals', DealController::class);
        Route::patch('deals/{deal}/stage', [DealController::class, 'updateStage'])->name('deals.update-stage');

        // Projects
        Route::resource('projects', ProjectController::class);
        Route::post('projects/{project}/tasks', [ProjectController::class, 'storeTask'])->name('projects.tasks.store');
        Route::patch('tasks/{task}/toggle', [ProjectController::class, 'toggleTask'])->name('tasks.toggle');
        Route::delete('tasks/{task}', [ProjectController::class, 'destroyTask'])->name('tasks.destroy');
    });

    // Support Tickets
    Route::get('support', [SupportTicketController::class, 'index'])->name('support.index');
    Route::get('support/create', [SupportTicketController::class, 'create'])->name('support.create');
    Route::post('support', [SupportTicketController::class, 'store'])->name('support.store');
    Route::get('support/{support}', [SupportTicketController::class, 'show'])->name('support.show');
    Route::post('support/{support}/reply', [SupportTicketController::class, 'reply'])->name('support.reply');
    Route::patch('support/{support}/close', [SupportTicketController::class, 'close'])->name('support.close');
});

// Admin Panel
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::post('users/{user}/ban', [AdminUserController::class, 'ban'])->name('users.ban');
    Route::post('users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('users.suspend');
    Route::post('users/{user}/activate', [AdminUserController::class, 'activate'])->name('users.activate');
    Route::post('users/{user}/impersonate', [AdminUserController::class, 'impersonate'])->name('users.impersonate');
    Route::post('users/{user}/make-pro', [AdminUserController::class, 'makePro'])->name('users.make-pro');
    Route::post('users/{user}/make-free', [AdminUserController::class, 'makeFree'])->name('users.make-free');

    // Support Tickets
    Route::get('tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
    Route::get('tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');
    Route::post('tickets/{ticket}/reply', [AdminTicketController::class, 'reply'])->name('tickets.reply');
    Route::patch('tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.update-status');

    // Contact Submissions
    Route::get('contacts', [AdminContactSubmissionController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{submission}', [AdminContactSubmissionController::class, 'show'])->name('contacts.show');
    Route::patch('contacts/{submission}/read', [AdminContactSubmissionController::class, 'markRead'])->name('contacts.mark-read');
    Route::delete('contacts/{submission}', [AdminContactSubmissionController::class, 'destroy'])->name('contacts.destroy');
});

// Impersonation stop (auth only, no admin middleware needed)
Route::middleware(['auth'])->group(function () {
    Route::post('impersonation/stop', [AdminImpersonationController::class, 'stop'])->name('impersonation.stop');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/billing', [Settings\BillingController::class, 'edit'])->name('settings.billing.edit');
    Route::post('settings/billing/cancel', [Settings\BillingController::class, 'cancel'])->name('settings.billing.cancel');
    Route::post('settings/billing/resume', [Settings\BillingController::class, 'resume'])->name('settings.billing.resume');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');
});

require __DIR__.'/auth.php';
