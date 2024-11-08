<div>
    <x-container iconName="description" titleName="Documents">
        <x-container-content>
            <div class="text-center brgy-bg-primary brgy-primary-text rounded p-2 mb-2">
                <x-title>{{ strtoupper($documentType->getDescription()) }}</x-title>
            </div>
            <div class="document-preview">
                <div class="document-preview-content">
                    {{ $slot }}
                </div>
            </div>
            {{ $footer }}
        </x-container-content>
    </x-container>
</div>
