<div>
    @if ($isRequestCreated)
        <x-container iconName="description" titleName="Documents">
            <x-container-content>
                <div class="d-flex flex-column justify-content-center align-items-center mt-2">
                    <h3>
                        Your request for printing of a
                    </h3>
                    <h1 class="brgy-color-secondary">
                        {{ strtoupper($documentType->getDescription()) }}
                    </h1>
                    <h3>
                        is confirmed! Kindly proceed to your Barangay Hall for claiming.
                    </h3>
                </div>
                <div>
                    <h1 class="brgy-color-secondary">
                        IMPORTANT REMINDERS!
                    </h1>
                    <div class="document-request-success-reminders">
                        <ul>
                            <li>Prepare the amount (###) for the Certification Fee.</li>
                            <li>Proceed to the Barangay Hall Brgy. Secretary to claim your printed document.</li>
                            <li>Present your Barangay Resident Account upon claiming.</li>
                            <li>Office hours are between 9:00 am - 5:00 pm, every Sunday to Saturday.</li>
                        </ul>
                    </div>
                </div>
                <hr class="line brgy-content-text" />
                <button wire:click="goToDocumentsHome" class="btn btn-success ms-auto">Confirm</button>
            </x-container-content>
        </x-container>
    @elseif ($isPreviewing)
        <x-documents.document-preview-container :documentType="$documentType">
            <x-documents.templates.certificate-of-residency :previewData="$previewData" />
            <x-slot name="footer">
                <hr class="line brgy-content-text" />
                <div class="document-preview-button-footer">
                    <button class="btn btn-primary-brgy" wire:click="cancel">
                        Back
                    </button>
                    <button class="btn btn-success" wire:click="request">
                        Request
                    </button>
                </div>
            </x-slot>
        </x-documents.document-preview-container>
    @else
        <x-container iconName="description" titleName="Documents">
            <x-container-content>
                <div class="text-center brgy-bg-primary brgy-primary-text rounded p-2 mb-2">
                    <x-title>CERTIFICATE OF RESIDENCY</x-title>
                </div>
                <div class="col-12 col-lg-6">
                    <x-form-select id="document-request-requester-select" label="Request Document for:"
                        wire:model="form.entity_id" propertyName="entity_id" hideDefaultOption="true"
                        class="brgy-content-text" :isDisabled="$form->entity_type == 'Staff'">
                        <option value="" disabled selected>Select a household member here</option>
                        @foreach ($availableRequesters as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </x-form-select>
                </div>
                <x-container-content-footer>
                    <div class="d-flex">
                        <a href="/documents/request-document" wire.navigate>
                            <button class="btn btn-primary-brgy">Back</button>
                        </a>
                        <button wire:click="preview" class="btn btn-success ms-auto px-4">Next</button>
                    </div>
                </x-container-content-footer>
            </x-container-content>
        </x-container>
    @endif
</div>
