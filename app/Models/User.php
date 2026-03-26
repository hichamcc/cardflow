<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Paddle\Billable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Billable, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'subscription_tier',
        'is_admin',
        'status',
        'admin_notes',
        'google_id',
        'profile_photo_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    // --- Relationships ---

    public function businessCards(): HasMany
    {
        return $this->hasMany(BusinessCard::class);
    }

    public function savedCards(): HasMany
    {
        return $this->hasMany(SavedCard::class);
    }

    public function folders(): HasMany
    {
        return $this->hasMany(Folder::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(CardTag::class);
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class);
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class);
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

    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function ticketMessages(): HasMany
    {
        return $this->hasMany(TicketMessage::class);
    }

    // --- Helpers ---

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    public function isBanned(): bool
    {
        return $this->status === 'banned';
    }

    public function isFree(): bool
    {
        return $this->subscription_tier === 'free';
    }

    public function isPro(): bool
    {
        return $this->subscription_tier === 'pro';
    }

    public function isBusiness(): bool
    {
        return $this->subscription_tier === 'business';
    }

    public function cardLimit(): int
    {
        return match ($this->subscription_tier) {
            'free' => 3,
            'pro', 'business' => PHP_INT_MAX,
        };
    }

    public function canCreateCard(): bool
    {
        return $this->businessCards()->count() < $this->cardLimit();
    }

    public function monthlyInteractionLimit(): int
    {
        return match ($this->subscription_tier) {
            'free' => 20,
            'pro', 'business' => PHP_INT_MAX,
        };
    }

    // --- Paddle ---

    public function paddleName(): string
    {
        return $this->name;
    }

    public function paddleEmail(): string
    {
        return $this->email;
    }

    public function syncSubscriptionTier(): void
    {
        $subscription = $this->subscription();

        if (! $subscription || $subscription->canceled()) {
            $this->update(['subscription_tier' => 'free']);
            return;
        }

        $priceId = $subscription->items->first()?->price_id;

        $tier = match ($priceId) {
            config('services.paddle.price_pro_monthly') => 'pro',
            config('services.paddle.price_business_monthly') => 'business',
            default => 'free',
        };

        $this->update(['subscription_tier' => $tier]);
    }
}
