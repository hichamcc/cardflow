<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class SavedCard extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'business_card_id',
        'saved_from_user_id',
        'custom_note',
        'folder_id',
        'last_contacted_at',
        'contact_frequency',
        'relationship_status',
        'full_name',
        'email',
        'phone',
        'company_name',
        'job_title',
        'website',
        'profile_photo_path',
    ];

    protected function casts(): array
    {
        return [
            'last_contacted_at' => 'datetime',
        ];
    }

    // --- Relationships ---

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function businessCard(): BelongsTo
    {
        return $this->belongsTo(BusinessCard::class);
    }

    public function savedFromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'saved_from_user_id');
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(CardTag::class, 'card_tag_saved_card');
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class)->orderByDesc('interaction_date');
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class)->orderBy('follow_up_date');
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    // --- Accessor Helpers ---

    public function isManualClient(): bool
    {
        return is_null($this->business_card_id);
    }

    public function isLinkedCard(): bool
    {
        return !is_null($this->business_card_id);
    }

    public function getFullName(): string
    {
        return $this->isLinkedCard() ? ($this->businessCard?->full_name ?? '') : ($this->full_name ?? '');
    }

    public function getEmail(): ?string
    {
        return $this->isLinkedCard() ? $this->businessCard?->email : $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->isLinkedCard() ? $this->businessCard?->phone : $this->phone;
    }

    public function getCompanyName(): ?string
    {
        return $this->isLinkedCard() ? $this->businessCard?->company_name : $this->company_name;
    }

    public function getJobTitle(): ?string
    {
        return $this->isLinkedCard() ? $this->businessCard?->job_title : $this->job_title;
    }

    public function getWebsite(): ?string
    {
        return $this->isLinkedCard() ? $this->businessCard?->website : $this->website;
    }

    public function getProfilePhotoUrl(): ?string
    {
        if ($this->isLinkedCard()) {
            return $this->businessCard?->getProfilePhotoUrl();
        }

        return $this->profile_photo_path ? asset('storage/' . $this->profile_photo_path) : null;
    }

    // --- Scout Search ---

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->getFullName(),
            'job_title' => $this->getJobTitle(),
            'company_name' => $this->getCompanyName(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'custom_note' => $this->custom_note,
            'relationship_status' => $this->relationship_status,
        ];
    }

    // --- Helpers ---

    public function pendingFollowUps(): HasMany
    {
        return $this->followUps()->where('status', 'pending');
    }

    public function markContacted(): void
    {
        $this->update(['last_contacted_at' => now()]);
    }

    public function relationshipHealthScore(): int
    {
        if (!$this->last_contacted_at) {
            return 0;
        }

        $daysSinceContact = $this->last_contacted_at->diffInDays(now());

        return match ($this->contact_frequency) {
            'high' => $daysSinceContact <= 7 ? 100 : max(0, 100 - ($daysSinceContact - 7) * 5),
            'medium' => $daysSinceContact <= 14 ? 100 : max(0, 100 - ($daysSinceContact - 14) * 3),
            'low' => $daysSinceContact <= 30 ? 100 : max(0, 100 - ($daysSinceContact - 30) * 2),
            'never' => 50,
        };
    }
}
