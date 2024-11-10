<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use App\Models\Scopes\BarangayScope;
use Illuminate\Contracts\Database\Eloquent\Builder;

#[ScopedBy([BarangayScope::class])]
class Resident extends Authenticatable
{
    use HasFactory;

    protected $table = 'resident';

    protected $fillable = [
        'barangay_id',
        'user_id',
        'household_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'email',
        'contact_number',
        'date_of_birth',
        'is_head_of_household',
        'relationship_to_head',
        'ethnicity',
        'religion',
        'civil_status',
        'valid_id',
        'is_temporary_resident',
        'is_pwd',
        'is_voter',
        'is_employed',
        'is_active',
        'is_birth_registered',
        'is_literate',
        'is_single_parent'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($resident) {
            if ($resident->user) {
                $resident->user->delete();
            }

            DocumentRequest::where('requester_entity_id', $resident->id)
                ->where('requester_entity_type', 'Resident')
                ->delete();
        });
    }

    public function scopeActive(Builder $query)
    {
        $query->where('is_active', true);
    }

    public function scopeGender(Builder $query, string $gender)
    {
        $query->where('gender', $gender);
    }

    public function scopeEmployed(Builder $query, bool $isEmployed)
    {
        $query->where('is_employed', $isEmployed);
    }

    public function scopePwd(Builder $query, bool $isPwd)
    {
        $query->where('is_pwd', $isPwd);
    }

    public function scopeVoter(Builder $query, bool $isVoter)
    {
        $query->where('is_voter', $isVoter);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function household()
    {
        return $this->belongsTo(Household::class, 'household_id');
    }

    public function getFullName()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }
}
