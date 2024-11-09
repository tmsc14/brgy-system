<div class="requests-container">
    <x-icon-header text="Signup Requests" iconName='how-to-reg' />
    <ul class="nav nav-tabs brgy-nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="#">Requests</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/requests/history">History</a>
        </li>
    </ul>

    <x-container titleName="Requests" iconName="how-to-reg">
        <x-paginate-table :records="$requests">
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
                                wire:click="updateStatus({{ $request->id }}, 'Approved')">Approve</button>
                            <button type="submit" class="btn btn-danger"
                                wire:click="updateStatus({{ $request->id }}, 'Denied')">Deny</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-paginate-table>
    </x-container>
</div>
