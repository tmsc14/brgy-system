@extends('layouts.app')

@section('content')
    @if ($_user_role == 'Captain')
        <livewire:dashboard.barangay-captain-dashboard />
    @endif
@endsection
