<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Staff extends Authenticatable
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'barangay_id',
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'email',
        'contact_number',
        'date_of_birth',
        'bric_number',
        'is_master',
        'is_active',
        'title',
        'position'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($staff) {
            if ($staff->user) {
                $staff->user->delete();
            }

            DocumentRequest::where('requester_entity_id', $staff->id)
                ->where('requester_entity_type', 'Staff')
                ->delete();
        });
    }

    public function scopeActive(Builder $query)
    {
        $query->where('is_active', true);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function roles()
    {
        return $this->hasMany(Role::class, 'user_id');
    }

    public function featurePermissions()
    {
        return $this->morphMany(FeaturePermission::class, 'permissible');
    }

    public function getFullName()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }
}
