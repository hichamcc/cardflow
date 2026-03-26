<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'saved_card_id',
        'name',
        'description',
        'status',
        'priority',
        'due_date',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
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

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->orderBy('position');
    }

    // --- Scopes ---

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopePriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    // --- Helpers ---

    public function completedTasksCount(): int
    {
        return $this->tasks()->where('is_completed', true)->count();
    }

    public function totalTasksCount(): int
    {
        return $this->tasks()->count();
    }

    public function progressPercent(): int
    {
        $total = $this->totalTasksCount();

        if ($total === 0) {
            return 0;
        }

        return (int) round(($this->completedTasksCount() / $total) * 100);
    }

    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'completed';
    }
}
