<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use App\Models\Scopes\BarangayScope;
use Illuminate\Contracts\Database\Eloquent\Builder;

#[ScopedBy([BarangayScope::class])]
class BarangayFeature extends Model
{
    protected $fillable = 
    [
        'barangay_id', 
        'category', 
        'name',
        'description',
        'is_enabled',
    ];

    protected $table = 'barangay_feature';

    public function scopeStatistics(Builder $query): void
    {
        $query->where('category', 'Statistics');
    }

    public function scopeEnabled(Builder $query): void
    {
        $query->where('is_enabled', 1);
    }
}
