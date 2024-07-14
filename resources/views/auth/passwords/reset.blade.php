@extends('layouts.app')

@section('content')
<div class="password-reset-container">
    <div class="password-reset-header">
        <img src="{{ url('resources/img/logo.png') }}" alt="Logo" class="logo">
    </div>
    <h2>Reset Password</h2>
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ $email ?? old('email') }}" required autofocus>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="form-group">
            <label for="password-confirm">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password-confirm" required>
        </div>
        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ url('resources/css/password-reset.css') }}">
@endpush
