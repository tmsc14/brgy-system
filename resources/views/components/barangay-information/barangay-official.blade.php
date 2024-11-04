<div class="d-flex flex-column align-items-center">
    @if (isset($photo))
        <img src="{{ asset('storage/' . $photo) }}" />
    @else
        <x-gmdi-image class="bigger-icon" />
    @endif
    <span>{{ $title }}</span>
    <span>{{ $name }}</span>
    <span>{{ $contact_number }}</span>
</div>