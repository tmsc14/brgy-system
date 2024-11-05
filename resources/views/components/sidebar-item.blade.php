<li class="nav-item">
    <a href="{{ route( $moduleName ) }}" class="nav-link nav-link-brgy {{ request()->is($moduleName. '*') ? 'active' : '' }}">
        <x-dynamic-component :component="'gmdi-' . $iconName" class="icon" />
            <span class="align-middle">{{ $label ?? ucwords($moduleName) }}</span>
    </a>
</li>