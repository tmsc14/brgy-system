@extends('layouts.app')

@section('content')
    @if (Auth::guard('barangay_captain')->check())
        <p>Welcome, {{ Auth::guard('barangay_captain')->user()->first_name }} {{ Auth::guard('barangay_captain')->user()->last_name }}</p>
    @else
        <p>Please log in.</p>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (!Auth::guard('barangay_captain')->user()->barangay)
        <p>You have not created a barangay yet.</p>
        <a href="{{ route('barangay_captain.create_barangay_form') }}">Create Barangay</a>
    @else
        <p>You have already created a barangay.</p>
    @endif

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endsection

