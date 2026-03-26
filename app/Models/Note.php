<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'saved_card_id',
        'title',
        'content',
        'is_pinned',
        'category',
    ];

    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
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

    public function scopePinned(Builder $query): Builder
    {
        return $query->where('is_pinned', true);
    }

    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function scopeStandalone(Builder $query): Builder
    {
        return $query->whereNull('saved_card_id');
    }

    public function scopeAttached(Builder $query): Builder
    {
        return $query->whereNotNull('saved_card_id');
    }

    // --- Helpers ---

    public function togglePin(): void
    {
        $this->update(['is_pinned' => !$this->is_pinned]);
    }

    public function getCategoryIcon(): string
    {
        return match ($this->category) {
            'meeting' => 'users',
            'idea' => 'lightbulb',
            'todo' => 'check-square',
            default => 'note',
        };
    }

    public function getCategoryColor(): string
    {
        return match ($this->category) {
            'meeting' => 'blue',
            'idea' => 'amber',
            'todo' => 'green',
            default => 'gray',
        };
    }
}
