<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignupRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay_id',
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'valid_id',
        'user_type',
        'position',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    public const PENDING_STATUS = 'Pending';
    public const APPROVED_STATUS = 'Approved';
    public const DENIED_STATUS = 'Denied';
}

