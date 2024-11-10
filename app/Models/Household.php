<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use App\Models\Scopes\BarangayScope;
use Illuminate\Contracts\Database\Eloquent\Builder;

#[ScopedBy([BarangayScope::class])]
class Household extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay_id',
        'household_head_user_id',
        'street_address',
        'purok',
        'sitio'
    ];

    protected $table = "household";

    public function scopeHasActiveResidents($query)
    {
        return $query->whereHas('residents', function ($q) {
            $q->where('is_active', true);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'household_head_user_id');
    }

    public function residents()
    {
        return $this->hasMany(Resident::class, 'household_id');
    }

    public function head()
    {
        return $this->hasOne(Resident::class)
                ->where('is_head_of_household', true);
    }

    public function getHeadNameAttribute()
    {
        return $this->head ? $this->head->getFullName() : null;
    }

    public function getNumberOfResidentsAttribute()
    {
        return $this->residents->count();
    }
}
