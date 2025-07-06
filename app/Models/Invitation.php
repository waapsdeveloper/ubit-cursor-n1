<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'email',
        'invitation_code',
        'name',
        'phone',
        'status',
        'sent_at',
        'registered_at',
        'expires_at',
        'notes',
        'created_by',
        'registered_user_id'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'registered_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the admin who created the invitation.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who registered using this invitation.
     */
    public function registeredUser()
    {
        return $this->belongsTo(User::class, 'registered_user_id');
    }

    /**
     * Generate a unique invitation code.
     */
    public static function generateInvitationCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (self::where('invitation_code', $code)->exists());

        return $code;
    }

    /**
     * Check if the invitation is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at && now()->gt($this->expires_at);
    }

    /**
     * Check if the invitation can be used.
     */
    public function canBeUsed(): bool
    {
        return $this->status === 'sent' && !$this->isExpired() && !$this->registered_user_id;
    }

    /**
     * Mark invitation as sent.
     */
    public function markAsSent(): void
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
            'expires_at' => now()->addDays(30) // 30 days expiry
        ]);
    }

    /**
     * Mark invitation as registered.
     */
    public function markAsRegistered(int $userId): void
    {
        $this->update([
            'status' => 'registered',
            'registered_at' => now(),
            'registered_user_id' => $userId
        ]);
    }

    /**
     * Get the invitation URL.
     */
    public function getInvitationUrl(): string
    {
        return route('register', ['invite' => $this->invitation_code]);
    }

    /**
     * Scope for active invitations.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'sent')
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    /**
     * Scope for pending invitations.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for registered invitations.
     */
    public function scopeRegistered($query)
    {
        return $query->where('status', 'registered');
    }
}
