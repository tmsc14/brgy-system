<div>
    <x-documents.document-preview-container :documentType="$documentType">
        <x-dynamic-component :component="'documents.templates.' . $documentType->getViewName()" :previewData="$documentData" />
        <x-slot name="footer">
            <hr class="line brgy-content-text" />
            <div class="document-preview-button-footer">
                <button class="btn btn-primary-brgy" wire:click="cancel">
                    Back
                </button>
                <button class="btn btn-success" wire:click="print">
                    Print
                </button>
            </div>
        </x-slot>
    </x-documents.document-preview-container>
</div>
