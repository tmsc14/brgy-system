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
        'status',
        'walk_in_data_json'
    ];

    public static function getFileUrlString(int $barangayId, int $userId)
    {
        return $barangayId . '/document_requests/' . $userId;
    }

    const STATUS_PENDING = "Pending";
    const STATUS_RELEASED = "Released";
    const STATUS_DENIED = "Denied";
}
