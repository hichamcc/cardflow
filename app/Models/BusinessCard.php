<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class BusinessCard extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        'user_id',
        'card_name',
        'full_name',
        'job_title',
        'company_name',
        'email',
        'phone',
        'website',
        'profile_photo_path',
        'company_logo_path',
        'bio',
        'theme_color',
        'layout_style',
        'is_active',
        'slug',
        'hide_branding',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'hide_branding' => 'boolean',
            'view_count' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (BusinessCard $card) {
            if (empty($card->slug)) {
                $card->slug = static::generateUniqueSlug($card->full_name);
            }
        });
    }

    public static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $counter = 1;

        while (static::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }

    // --- Relationships ---

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(CardSocialLink::class)->orderBy('display_order');
    }

    public function customFields(): HasMany
    {
        return $this->hasMany(CardCustomField::class)->orderBy('display_order');
    }

    public function savedCards(): HasMany
    {
        return $this->hasMany(SavedCard::class);
    }

    // --- Scout Search ---

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'job_title' => $this->job_title,
            'company_name' => $this->company_name,
            'email' => $this->email,
            'bio' => $this->bio,
        ];
    }

    // --- Helpers ---

    public function getPublicUrl(): string
    {
        return url("/c/{$this->slug}");
    }

    public function incrementViews(): void
    {
        $this->increment('view_count');
    }

    public function getProfilePhotoUrl(): ?string
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : null;
    }

    public function getCompanyLogoUrl(): ?string
    {
        return $this->company_logo_path
            ? asset('storage/' . $this->company_logo_path)
            : null;
    }
}
