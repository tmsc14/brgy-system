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

    protected $table = "document_request";

    protected $fillable = [
        'barangay_id',
        'user_id',
        'requester_entity_id',
        'requester_entity_type',
        'document_type',
        'document_data_json',
        'document_file_urls_csv',
        'status'
    ];

    const STATUS_PENDING = "Pending";
    const STATUS_APPROVED = "Approved";
    const STATUS_DENIED = "Denied";
}
