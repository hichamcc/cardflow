<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'saved_card_id',
        'follow_up_date',
        'reminder_date',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'follow_up_date' => 'date',
            'reminder_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function savedCard(): BelongsTo
    {
        return $this->belongsTo(SavedCard::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isOverdue(): bool
    {
        return $this->isPending() && $this->follow_up_date->isPast();
    }

    public function markCompleted(): void
    {
        $this->update(['status' => 'completed']);
        $this->savedCard->markContacted();
    }

    public function markCancelled(): void
    {
        $this->update(['status' => 'cancelled']);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeOverdue($query)
    {
        return $query->pending()->where('follow_up_date', '<', now());
    }

    public function scopeDueToday($query)
    {
        return $query->pending()->whereDate('follow_up_date', today());
    }

    public function scopeNeedsReminder($query)
    {
        return $query->pending()
            ->whereNotNull('reminder_date')
            ->whereDate('reminder_date', today());
    }
}
