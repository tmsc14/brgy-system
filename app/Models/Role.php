<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';

    public const CAPTAIN = 'Captain';
    public const OFFICIAL = 'Official';
    public const STAFF = 'Staff';
    public const RESIDENT = 'Resident';

    protected $fillable = [
        'barangay_id',
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id')
            ->withPivot('barangay_id');
    }
}
