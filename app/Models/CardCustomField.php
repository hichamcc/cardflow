<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardCustomField extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_card_id',
        'field_name',
        'field_value',
        'icon',
        'display_order',
    ];

    protected function casts(): array
    {
        return [
            'display_order' => 'integer',
        ];
    }

    public function businessCard(): BelongsTo
    {
        return $this->belongsTo(BusinessCard::class);
    }
}
