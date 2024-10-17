@extends('layouts.app')

@section('content')
    @vite(['resources/css/barangay_captain/bc-requests.css'])

    <div class="requests-container">
        <h2>Signup Requests</h2>
        @if($requests->isEmpty())
            <p>No pending signup requests.</p>
        @else
            <table class="requests-table">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>User Type</th>
                        <th>Position</th>
                        <th>Valid ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->first_name }} {{ $request->middle_name }} {{ $request->last_name }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $request->user_type)) }}</td>
                            <td>{{ $request->position }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $request->valid_id) }}" target="_blank">View ID</a>
                            </td>
                            <td>
                                <form action="{{ route('bc-requests.approve', $request->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="approve-btn">Approve</button>
                                </form>
                                <form action="{{ route('bc-requests.deny', $request->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="deny-btn">Deny</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <a href="{{ route('bc-request-history') }}" class="view-history">View History</a>
    </div>
@endsection
