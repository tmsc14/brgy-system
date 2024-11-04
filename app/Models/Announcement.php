<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use App\Models\Scopes\BarangayScope;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([BarangayScope::class])]
class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay_id',
        'title',
        'body',
        'photo',
        'created_by_staff_id',
    ];

    protected $table = 'announcement';

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }
}
