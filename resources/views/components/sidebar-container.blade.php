@props(['containerClass', 'id'])

<div {{ $attributes->merge(['class' => $containerClass]) }} id="{{$id}}">
    <div class="text-center mb-2">
        <img src="{{ asset('resources/img/logo.png') }}" alt="Brgy+ Logo" class="w-50 h-auto">
    </div>
    <x-sidebar-logo />
    @if ($_user_role == 'Captain')
        @include('layouts.partials.sidebar_barangay_captain')
    @elseif ($_user_role == 'Official')
        @include('layouts.partials.sidebar_barangay_official')
    @elseif ($_user_role == 'Staff')
        @include('layouts.partials.sidebar_staff')
    @elseif ($_user_role == 'Resident')
        @include('layouts.partials.sidebar_resident')
    @endif
    <form class="w-100" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="d-flex justify-content-center btn btn-secondary-brown w-100">
            <img src="{{ asset('resources/img/sidebar-icons/logout-sblogo.png') }}" class="icon" alt="Logout Icon">
            <span>Logout</span>
        </button>
    </form>
</div>