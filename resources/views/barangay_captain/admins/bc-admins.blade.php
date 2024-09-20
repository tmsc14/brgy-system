@extends('layouts.bc-template-dashboard')

@section('styles')
    @vite(['resources/css/barangay_captain/admins/bc-admins.css'])
@endsection

@section('content')
<div class="admins-container">
    <h1>Admins</h1>

    <div class="admin-list">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filteredAdmins as $admin)
                    <tr>
                        <td>
                            {{ $admin->user->first_name }} {{ $admin->user->last_name }}
                        </td>
                        <td>
                            {{ ucfirst($admin->user->position) }}
                        </td>
                        <td>
                            {{ $admin->role_type === 'barangay_official' ? 'Barangay Official' : 'Barangay Staff' }}
                        </td>
                        <td>
                            <form action="{{ route('barangay_captain.toggle_role_status', ['roleId' => $admin->id]) }}" method="POST">
                                @csrf
                                @if($admin->active)
                                    <button type="submit" class="btn btn-danger">Deactivate</button>
                                @else
                                    <button type="submit" class="btn btn-success">Activate</button>
                                @endif
                            </form>
                        </td>                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
