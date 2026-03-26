<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'saved_card_id',
        'title',
        'description',
        'start_at',
        'end_at',
        'location',
        'type',
        'status',
        'color',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
        ];
    }

    // --- Relationships ---

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function savedCard(): BelongsTo
    {
        return $this->belongsTo(SavedCard::class);
    }

    // --- Scopes ---

    public function scopeScheduled(Builder $query): Builder
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('start_at', today());
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('start_at', '>', now())->where('status', 'scheduled');
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('end_at', '<', now())->where('status', 'scheduled');
    }

    public function scopeBetween(Builder $query, $start, $end): Builder
    {
        return $query->where('start_at', '>=', $start)->where('start_at', '<=', $end);
    }

    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    // --- Helpers ---

    public function isOverdue(): bool
    {
        return $this->status === 'scheduled' && $this->end_at->isPast();
    }

    public function markCompleted(): void
    {
        $this->update(['status' => 'completed']);
    }

    public function markCancelled(): void
    {
        $this->update(['status' => 'cancelled']);
    }

    public function getTypeIcon(): string
    {
        return match ($this->type) {
            'meeting' => 'users',
            'call' => 'phone',
            'task' => 'check-square',
            'reminder' => 'bell',
            default => 'calendar-blank',
        };
    }

    public function getTypeColor(): string
    {
        return match ($this->type) {
            'meeting' => 'blue',
            'call' => 'green',
            'task' => 'purple',
            'reminder' => 'amber',
            default => 'gray',
        };
    }

    public function duration(): string
    {
        $diff = $this->start_at->diff($this->end_at);

        if ($diff->h > 0 && $diff->i > 0) {
            return $diff->h . 'h ' . $diff->i . 'm';
        } elseif ($diff->h > 0) {
            return $diff->h . 'h';
        }

        return $diff->i . 'm';
    }
}
