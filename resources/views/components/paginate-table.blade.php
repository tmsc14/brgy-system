<div class="brgy-bg-theme">
    <table class="table brgy-table">
        {{ $slot }}
    </table>
    @if ($records->lastPage() > 1)
        <hr class="bg-brown-primary" />
    @endif
    {{ $records->links() }}
</div>
