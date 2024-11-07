<?php

namespace App\Livewire\Documents;

use App\Models\DocumentRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Documents extends Component
{
    private User $user;

    public function mount()
    {
        $this->user = auth()->user();

        if (!$this->user->staff)
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
        $this->redirectRoute('documents.request-document.staff');
    }

    public function render()
    {
        $documentRequests = DocumentRequest::all()
            ->select('id', 'document_owner_name', 'document_type', 'created_at');
            
        return view('livewire.documents.documents', compact('documentRequests'));
    }
}
