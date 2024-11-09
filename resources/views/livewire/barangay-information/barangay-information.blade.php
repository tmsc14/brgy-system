<div>
    <livewire:brgy-banner />
    <x-container class="mt-3">
        <div class="d-flex align-items-center">
            <x-gmdi-group class="bigger-icon brgy-primary-text me-1" />
            <x-title class="brgy-primary-text">Barangay Officials</x-title>
            @if (auth()->user()->signedInAs === 'staff')
                <button class="btn btn-success ms-auto" wire:click="addBarangayOfficial">Add</button>
            @endif
        </div>
        <div class="brgy-bg-content p-2">
            @foreach ($officials as $official)
                <div class="d-flex justify-content-center mb-3 gap-3">
                    @foreach ($official as $officialInner)
                        <div class="d-flex flex-column align-items-center clickable"
                            wire:click="editBarangayOfficial({{ $officialInner->id }})">
                            @if (isset($officialInner->photo))
                                <img src="{{ asset('storage/' . $officialInner->photo) }}"
                                    class="official-profile-photo" />
                            @else
                                <x-gmdi-image class="official-profile-photo" />
                            @endif
                            <span class="brgy-color-primary">{{ $officialInner->title }}</span>
                            <span>{{ $officialInner->name }}</span>
                            <span>{{ $officialInner->contact_number }}</span>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </x-container>
</div>
