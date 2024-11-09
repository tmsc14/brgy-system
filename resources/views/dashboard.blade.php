@extends('layouts.app')

@section('content')
    @if ($_user_role == 'Resident')
        <livewire:announcements.announcements />
    @else
        <livewire:dashboard.barangay-captain-dashboard />
    @endif
@endsection
