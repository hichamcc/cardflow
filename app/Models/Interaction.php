<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'saved_card_id',
        'interaction_type',
        'subject',
        'notes',
        'interaction_date',
    ];

    protected function casts(): array
    {
        return [
            'interaction_date' => 'datetime',
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

    public function getTypeIcon(): string
    {
        return match ($this->interaction_type) {
            'email' => 'envelope',
            'call' => 'phone',
            'meeting' => 'users',
            'note' => 'note-pencil',
            default => 'chat-circle',
        };
    }
}
