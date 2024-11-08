<div class="brgy-bg-theme brgy-theme-text rounded">
    @if (isset($records) && count($records) != 0)
        <table class="table brgy-table">
            {{ $slot }}
        </table>
        @if ($records->lastPage() > 1)
            <hr class="bg-brown-primary" />
        @endif
        {{ $records->links() }}
    @else
        <div class="p-2 mb-2">No records are available.</div>
    @endif
</div>
