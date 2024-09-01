@extends('layouts.bc-template-dashboard')

@section('styles')
@vite(['resources/css/barangay_captain/settings/bc-turnover.css'])
@endsection

@section('content')
<div class="turnover-container">
    <h1>Initiate Turnover</h1>
    <p>Select the new Barangay Captain from the list of eligible candidates who have signed up with your barangay's location.</p>
    
    <form action="{{ route('barangay_captain.initiate_turnover') }}" method="POST">
        @csrf
        <!-- Example of a dropdown to select the new Barangay Captain -->
        <div class="form-group">
            <label for="new_captain_id">Select New Barangay Captain</label>
            <select name="new_captain_id" id="new_captain_id" required>
                @foreach ($potentialCaptains as $captain)
                    <option value="{{ $captain->id }}">{{ $captain->first_name }} {{ $captain->last_name }} ({{ $captain->email }})</option>
                @endforeach
            </select>
        </div>
    
        <button type="submit" class="btn-primary">Initiate Turnover</button>
    </form>         
</div>
@endsection

@section('scripts')
@vite(['resources/js/barangay_captain/turnover.js'])
@endsection
