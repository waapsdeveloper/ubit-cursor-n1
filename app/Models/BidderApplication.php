<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Get the full URL for the payment proof file.
     */
    public function getPaymentProofUrlAttribute(): ?string
    {
        if (!$this->payment_proof) {
            return null;
        }
        
        return asset('storage/' . $this->payment_proof);
    }

    /**
     * Get the actions dropdown HTML for the admin panel.
     */
    public function actionsDropdown()
    {
        $actions = [];
        
        // Preview Action (always available)
        $actions[] = '<a href="' . url('admin/bidder-application/' . $this->id . '/show') . '" class="dropdown-item" title="Preview Application">
                        <i class="la la-eye text-info"></i> Preview
                    </a>';
        
        // Edit Action (always available)
        $actions[] = '<a href="' . url('admin/bidder-application/' . $this->id . '/edit') . '" class="dropdown-item" title="Edit Application">
                        <i class="la la-edit text-warning"></i> Edit
                    </a>';
        
        // Divider
        $actions[] = '<div class="dropdown-divider"></div>';
        
        // Verify Payment Action
        if ($this->status === 'pending') {
            $actions[] = '<a href="' . url('admin/bidder-application/' . $this->id . '/verify-payment') . '" class="dropdown-item" title="Verify Payment">
                            <i class="la la-check text-info"></i> Verify Payment
                        </a>';
        }
        
        // Send Invitation Action
        if ($this->status === 'payment_verified') {
            $actions[] = '<a href="' . url('admin/bidder-application/' . $this->id . '/send-invitation') . '" class="dropdown-item" title="Send Invitation">
                            <i class="la la-envelope text-primary"></i> Send Invitation
                        </a>';
        }
        
        // Approve Action
        if ($this->status === 'invitation_sent') {
            $actions[] = '<a href="' . url('admin/bidder-application/' . $this->id . '/approve') . '" class="dropdown-item" title="Approve Application">
                            <i class="la la-thumbs-up text-success"></i> Approve
                        </a>';
        }
        
        // Reject Action
        if (in_array($this->status, ['pending', 'payment_verified'])) {
            $actions[] = '<a href="' . url('admin/bidder-application/' . $this->id . '/reject') . '" class="dropdown-item text-danger" title="Reject Application" onclick="return confirm(\'Are you sure you want to reject this application?\')">
                            <i class="la la-times"></i> Reject
                        </a>';
        }
        
        // Divider before delete
        $actions[] = '<div class="dropdown-divider"></div>';
        
        // Delete Action (always available)
        $actions[] = '<a href="' . url('admin/bidder-application/' . $this->id . '/delete') . '" class="dropdown-item text-danger" title="Delete Application" onclick="return confirm(\'Are you sure you want to delete this application?\')">
                        <i class="la la-trash"></i> Delete
                    </a>';
        
        // Build dropdown HTML with proper Bootstrap 4/5 classes
        $dropdownHtml = '<div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenu' . $this->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="la la-cog"></i> Actions
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu' . $this->id . '">';
        
        foreach ($actions as $action) {
            if (strpos($action, 'dropdown-divider') !== false) {
                $dropdownHtml .= '<li><hr class="dropdown-divider"></li>';
            } else {
                $dropdownHtml .= '<li>' . $action . '</li>';
            }
        }
        
        $dropdownHtml .= '</ul></div>';
        
        return $dropdownHtml;
    }

    /**
     * Get the reject button HTML for the admin panel.
     */
    public function rejectButton()
    {
        if (in_array($this->status, ['pending', 'payment_verified'])) {
            return '<a href="' . url('admin/bidder-application/' . $this->id . '/reject') . '" class="btn btn-sm btn-danger" title="Reject Application" onclick="return confirm(\'Are you sure you want to reject this application?\')">
                        <i class="la la-times"></i> Reject
                    </a>';
        } elseif ($this->status === 'rejected') {
            return '<span class="btn btn-sm btn-secondary disabled" title="Application already rejected">
                        <i class="la la-times"></i> Rejected
                    </span>';
        } else {
            return '<span class="btn btn-sm btn-secondary disabled" title="Cannot reject application in current status">
                        <i class="la la-times"></i> Cannot Reject
                    </span>';
        }
    }
}
