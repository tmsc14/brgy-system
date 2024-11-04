<div>
    <x-icon-header iconName="feedback" text="Announcements" />
    <x-container>
        <div class="d-flex align-items-center">
            <x-gmdi-feedback class="bigger-icon brgy-primary-text me-1" />
            <x-title class="brgy-primary-text">Announcements</x-title>
            <button class="btn btn-success ms-auto" wire:click="addAnnouncement">Add</span>
        </div>
        <div class="brgy-bg-content p-2">
            @if (isset($latestAnnouncement))
                <div class="d-flex align-items-center clickable" wire:click="viewAnnouncement({{$latestAnnouncement->id}})">
                    @if (isset($latestAnnouncement->photo))
                        <img src="{{ asset('storage/' . $latestAnnouncement->photo) }}"
                            class="latest-announcement-photo me-4" />
                    @else
                        <x-gmdi-image class="latest-announcement-photo" />
                    @endif
                    <span class="fs-1">{{ $latestAnnouncement->title }}</span>
                </div>
                @if (count($oldAnnouncements) != 0)
                    <hr />
                    <div class="d-flex">
                        @foreach ($oldAnnouncements as $oldAnnouncement)
                            <div class="d-flex flex-column align-items-center col-3 clickable" wire:click="viewAnnouncement({{$oldAnnouncement->id}})">
                                @if (isset($oldAnnouncement->photo))
                                    <img src="{{ asset('storage/' . $oldAnnouncement->photo) }}"
                                        class="latest-announcement-photo" />
                                @else
                                    <x-gmdi-image class="latest-announcement-photo" />
                                @endif
                                <div class="fs-3">
                                    {{ $oldAnnouncement->title }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <span>No announcements have been made yet.</span>
            @endif
        </div>
    </x-container>
</div>
