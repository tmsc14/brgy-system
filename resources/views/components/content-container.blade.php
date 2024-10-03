<div class="content-container">
    @if ($headerText != '')
    <div class="content-container-header">
        @if ($iconResourcePath != '')
        <img src="{{ asset($iconResourcePath) }}" class="icon">
        @endif
        <h1 class="content-container-header-title">{{ $headerText }}</h1>
        <!-- <div class="content-container-search-bar">
            <input type="text" />
        </div> -->
    </div>
    @endif
    <div class="content {{ $class }}">
        {{ $slot }}
    </div>
</div>