<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'saved_card_id',
        'deal_name',
        'deal_value',
        'currency',
        'stage',
        'expected_close_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'deal_value' => 'decimal:2',
            'expected_close_date' => 'date',
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

    public function isOpen(): bool
    {
        return in_array($this->stage, ['lead', 'negotiation']);
    }

    public function isClosed(): bool
    {
        return in_array($this->stage, ['closed_won', 'closed_lost']);
    }

    public function formattedValue(): string
    {
        return number_format($this->deal_value, 2) . ' ' . $this->currency;
    }

    public function scopeOpen($query)
    {
        return $query->whereIn('stage', ['lead', 'negotiation']);
    }

    public function scopeWon($query)
    {
        return $query->where('stage', 'closed_won');
    }

    public function scopeLost($query)
    {
        return $query->where('stage', 'closed_lost');
    }
}
