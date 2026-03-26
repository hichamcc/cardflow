<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardSocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_card_id',
        'platform',
        'url',
        'display_order',
        'link_clicks',
    ];

    protected function casts(): array
    {
        return [
            'display_order' => 'integer',
            'link_clicks' => 'integer',
        ];
    }

    public function businessCard(): BelongsTo
    {
        return $this->belongsTo(BusinessCard::class);
    }

    public function incrementClicks(): void
    {
        $this->increment('link_clicks');
    }

    public function getPlatformIcon(): string
    {
        return match ($this->platform) {
            'linkedin' => 'linkedin-logo',
            'twitter' => 'twitter-logo',
            'instagram' => 'instagram-logo',
            'facebook' => 'facebook-logo',
            'github' => 'github-logo',
            'youtube' => 'youtube-logo',
            'tiktok' => 'tiktok-logo',
            'dribbble' => 'dribbble-logo',
            'behance' => 'behance-logo',
            default => 'link',
        };
    }
}
