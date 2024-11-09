<div>
    @if (auth()->user()->loggedInAs() == 'resident')
        <livewire:announcements.announcements />
    @else
        <livewire:dashboard.barangay-captain-dashboard />
    @endif
</div>
