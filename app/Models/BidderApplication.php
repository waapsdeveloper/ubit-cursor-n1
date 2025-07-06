<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BidderApplication extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'cnic',
        'deposit_amount',
        'bank_name',
        'account_number',
        'transaction_id',
        'payment_proof',
        'status',
        'admin_notes',
        'payment_verified_at',
        'invitation_sent_at',
        'approved_at',
        'verified_by'
    ];

    protected $casts = [
        'deposit_amount' => 'decimal:2',
        'payment_verified_at' => 'datetime',
        'invitation_sent_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the user who submitted the application.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who verified the application.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Check if the application is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment has been verified.
     */
    public function isPaymentVerified(): bool
    {
        return in_array($this->status, ['payment_verified', 'invitation_sent', 'approved']);
    }

    /**
     * Check if invitation has been sent.
     */
    public function isInvitationSent(): bool
    {
        return in_array($this->status, ['invitation_sent', 'approved']);
    }

    /**
     * Check if the application is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Mark payment as verified.
     */
    public function markPaymentVerified(int $adminId): void
    {
        $this->update([
            'status' => 'payment_verified',
            'payment_verified_at' => now(),
            'verified_by' => $adminId
        ]);
    }

    /**
     * Mark invitation as sent.
     */
    public function markInvitationSent(): void
    {
        $this->update([
            'status' => 'invitation_sent',
            'invitation_sent_at' => now()
        ]);
    }

    /**
     * Mark application as approved.
     */
    public function markApproved(): void
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);
    }

    /**
     * Get the status badge color.
     */
    public function getStatusBadgeColor(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'payment_verified' => 'info',
            'invitation_sent' => 'primary',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary'
        };
    }
}
