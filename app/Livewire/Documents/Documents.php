<?php

namespace App\Livewire\Documents;

use App\Models\DocumentRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Documents extends Component
{
    public function mount()
    {
        $user = Auth::user();

        if (!$user->staff)
        {
            $this->redirectRoute('documents.request-document');
        }
    }

    public function goToRequestList()
    {
        $this->redirectRoute('documents.request-list');
    }

    public function goToRequestDocument()
    {
        $this->redirectRoute('documents.request-document');
    }

    public function render()
    {
        $documentRequests = DocumentRequest::all()
            ->select('id', 'document_owner_name', 'document_type', 'created_at');
            
        return view('livewire.documents.documents', compact('documentRequests'));
    }
}
