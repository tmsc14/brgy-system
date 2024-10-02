<?php

namespace App\Http\Controllers\API;

use App\Enums\Documents\DocumentRequestStatus;
use App\Enums\DocumentType;
use App\Helpers\NameHelper;
use App\Models\DocumentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DocumentsController extends Controller
{
    public function showBarangayOfficialDocuments()
    {
        $user = Auth::guard('barangay_official')->user();
        $barangay = $user->barangay;
        $appearanceSettings = $user->barangay ? $user->barangay->appearanceSettings : null;
    
        $role = 'barangay_official';
        return view('barangay_official.documents.bo-documents', compact('user', 'appearanceSettings', 'role', 'barangay'));
    }

    public function createDocumentRequest()
    {
        $user = Auth::guard('barangay_resident')->user();

        $documentRequest = DocumentRequest::create([
            'barangay_id' => $user->barangay_id,
            'resident_id' => $user->id,
            'document_owner_name' => NameHelper::getReadableName($user->first_name, $user->last_name),
            'document_type' => request('document_type'),
            'document_data_json' => request('document_data_json'),
            'document_file_urls_csv' => request('document_file_urls_csv'),
            'status' => DocumentRequestStatus::PENDING
        ]);

        return response()->json("");
    }
}
