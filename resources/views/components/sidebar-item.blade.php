<li class="nav-item">
    <a href="{{ route( $moduleName ) }}" class="nav-link nav-link-brgy {{ request()->routeIs($moduleName) ? 'active' : '' }}">
        <img src="{{ request()->routeIs($moduleName) ? asset('resources/img/sidebar-icons/' . $moduleName . '-sblogo.png') : asset('resources/img/sidebar-icons/' . $moduleName . '-sblogo-inactive.png') }}"
            class="icon" alt="{{ $moduleName }} Icon">
            <span class="align-middle">{{ $label ?? ucwords($moduleName) }}</span>
    </a>
</li>