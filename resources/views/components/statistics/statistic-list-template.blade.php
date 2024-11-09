<div>
    <x-container titleName="{{ $statisticName . ' (' . $records->total() . ')' }}" iconName="{{ $titleIconName }}">
        <x-paginate-table :records="$records">
            <thead>
                <tr>
                    @foreach ($tableStructure as $header => $callback)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        @foreach ($tableStructure as $callback)
                            <td>{{ $callback($record) }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </x-paginate-table>
        <div class="d-flex">
            <button type="button" class="btn btn-secondary-brgy" wire:click="back">Back</button>
            <button type="button" class="btn btn-success ms-auto" wire:click="generateReport">Download PDF Report</button>
        </div>
    </x-container>
</div>
