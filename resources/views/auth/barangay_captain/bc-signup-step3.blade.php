@extends('layouts.app')

@section('content')
    <div class="signup-container">
        <div class="signup-header">
            <img class="logo" src="{{ asset('resources/img/logo.png') }}" alt="Brgy+">
            <div class="line"></div>
        </div>
        <h2>Barangay Captain User Details</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('barangay_captain.register.step3.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="password">Create your own Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Re-type your Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>
            <div class="form-group">
                <label for="access_code">Access Code</label>
                <input type="text" name="access_code" id="access_code" required>
                <small>This is the code from the system developers.</small>
            </div>
            <button type="submit" class="btn-primary">Confirm</button>
            <a href="{{ route('barangay_captain.register.step2') }}" class="btn-secondary">Back</a>
        </form>
    </div>
@endsection
@push('styles')
<link rel="stylesheet" href="{{ asset('resources/css/bc-signup-step3.css') }}">
@endpush
