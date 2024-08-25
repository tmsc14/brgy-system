@extends('layouts.bc-template-dashboard')

@section('content')
    @vite(['resources/css/barangay_captain/bc-requests.css'])

    <div class="request-container">
        <h1>Pending Sign-Up Requests</h1>

        @if($requests->isEmpty())
            <p>No pending requests.</p>
        @else
            <table class="request-table">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Contact No</th>
                        <th>Position</th>
                        <th>Valid ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->first_name }}</td>
                            <td>{{ $request->last_name }}</td>
                            <td>{{ $request->email }}</td>
                            <td>{{ $request->contact_no }}</td>
                            <td>{{ $request->position }}</td>
                            <td>
                                @if($request->valid_id)
                                <a href="{{ asset('storage/' . $request->valid_id) }}" target="_blank">View ID</a>
                                @else
                                    <p>No ID available</p>
                                @endif
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
    </div>
@endsection
