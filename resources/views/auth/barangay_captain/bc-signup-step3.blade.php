@extends('layouts.app')

@section('content')
    <form action="{{ route('barangay_captain.register.step3.post') }}" method="POST">
        @csrf

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <label for="access_code">Access Code:</label>
        <input type="text" name="access_code" id="access_code" required>

        <button type="submit">Confirm</button>
        <button type="button" onclick="location.href='{{ route('barangay_captain.register.step2') }}'">Back</button>
    </form>
    </form>

    @if (session('error'))
        <div id="error-banner" class="alert-banner">
            <p>{{ session('error') }}</p>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorBanner = document.getElementById('error-banner');
            if (errorBanner) {
                errorBanner.style.display = 'block';
                setTimeout(() => {
                    errorBanner.style.display = 'none';
                }, 3000);
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        .alert-banner {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 1000;
        }
    </style>
@endpush
