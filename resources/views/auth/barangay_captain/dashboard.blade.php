@extends('layouts.app')

@section('content')
    <h1>Welcome, {{ $user->first_name }} {{ $user->last_name }}</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (!$barangay)
        <p>You have not created a barangay yet.</p>
        <a href="{{ route('barangay_captain.create_barangay_info_form') }}" class="btn btn-primary">Create Barangay</a>
    @else
        <p>You have already created a barangay.</p>
    @endif

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
@endsection
