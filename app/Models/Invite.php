<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invite extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'email',
        'token',
        'invited_by',
        'accepted_at',
        'expires_at',
    ];

    /**
     * Get the admin who sent the invite.
     */
    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }
}
