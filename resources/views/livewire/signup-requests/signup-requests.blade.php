<div class="requests-container">
    <x-icon-header text="Requests" iconResourcePath='resources/img/sidebar-icons/requests-sblogo.png' />
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="#">Requests</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">History</a>
        </li>
    </ul>
    @if ($requests->isEmpty())
        <p>No pending signup requests.</p>
    @else
        <div class="table d-flex p-3 rounded bg-light-brown flex-column">
            <table class='flex-grow-1'>
                <thead>
                    <tr class="text-light bg-brown-primary border-0">
                        <th class="p-2">Full Name</th>
                        <th class="p-2">User Type</th>
                        <th class="p-2">Position</th>
                        <th class="p-2">Valid ID</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                        <tr class="text-light bg-light-brown">
                            <td class="p-2">{{ $request->first_name }} {{ $request->middle_name }}
                                {{ $request->last_name }}</td>
                            <td class="p-2">{{ $request->user_type }}</td>
                            <td class="p-2">{{ $request->position }}</td>
                            <td class="p-2">
                                <a href="{{ asset('storage/' . $request->valid_id) }}" target="_blank">View
                                    ID</a>
                            </td>
                            <td class="p-2">
                                <button type="submit" class="btn btn-success"
                                    wire:click="approve({{ $request->id }})">Approve</button>
                                <button type="submit" class="btn btn-danger"
                                    wire:click="deny({{ $request->id }})">Deny</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr class="bg-brown-primary" />
            {{ $requests->links() }}
        </div>
    @endif
    {{-- <a href="{{ route('bc-request-history') }}" class="view-history">View History</a> --}}
</div>
