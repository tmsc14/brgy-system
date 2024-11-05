<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use App\Models\Scopes\BarangayScope;

#[ScopedBy([BarangayScope::class])]
class DocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay_id',
        'resident_id',
        'document_owner_name',
        'document_type',
        'document_data_json',
        'document_file_urls_csv',
        'status'
    ];
}
