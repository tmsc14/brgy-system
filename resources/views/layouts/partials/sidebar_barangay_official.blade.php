<ul class="nav">
    <li>
        <a href="{{ route('barangay_official.dashboard')}}" class="{{ request()->routeIs('barangay_official.dashboard') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('barangay_official.dashboard') ? asset('resources/img/sidebar-icons/dashboard-sblogo.png') : asset('resources/img/sidebar-icons/dashboard-sblogo-inactive.png') }}" class="icon" alt="Dashboard Icon">
            Dashboard
        </a>
    </li>
    <li>
        <a href="#" class="{{ request()->routeIs('residents') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('residents') ? asset('resources/img/sidebar-icons/admins-sblogo.png') : asset('resources/img/sidebar-icons/admins-sblogo-inactive.png') }}" class="icon" alt="Residents Icon">
            Residents
        </a>
    </li>
    <li>
        @php
            // Check if any statistics-related features are enabled
            $statisticsEnabled = $barangay->features()
                                        ->where('category', 'statistics')  // Check only for features in the 'statistics' category
                                        ->wherePivot('is_enabled', true)   // Ensure the feature is enabled
                                        ->exists();                        // Check if such features exist
        @endphp
        
        @if($statisticsEnabled)
            <li>
                <a href="{{ route('barangay_official.statistics')}}" class="{{ request()->routeIs('barangay_official.statistics') ? 'active' : '' }}">
                    <img src="{{ request()->routeIs('barangay_official.statistics') ? asset('resources/img/sidebar-icons/statistics-sblogo.png') : asset('resources/img/sidebar-icons/statistics-sblogo-inactive.png') }}" class="icon" alt="Statistics Icon">
                    Statistics
                </a>
            </li>
        @endif
    </li>
    <li>
        <a href="{{ route('barangay_official.documents')}}" class="{{ request()->routeIs('barangay_official.documents') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('barangay_official.documents') ? asset('resources/img/sidebar-icons/documents-sblogo.png') : asset('resources/img/sidebar-icons/documents-sblogo-inactive.png') }}" class="icon" alt="Documents Icon">
            Documents
        </a>
    </li>
    <li>
        <a href="#" class="{{ request()->routeIs('requests') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('requests') ? asset('resources/img/sidebar-icons/request-sblogo.png') : asset('resources/img/sidebar-icons/request-sblogo-inactive.png') }}" class="icon" alt="Requests Icon">
            Requests
        </a>
    </li>
    <li>
        <a href="#" class="{{ request()->routeIs('announcement') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('announcement') ? asset('resources/img/sidebar-icons/announcement-sblogo.png') : asset('resources/img/sidebar-icons/announcement-sblogo-inactive.png') }}" class="icon" alt="Announcement Icon">
            Announcement
        </a>       
    </li>
    <li>
        <a href="#" class="{{ request()->routeIs('settings') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('settings') ? asset('resources/img/sidebar-icons/settings-sblogo.png') : asset('resources/img/sidebar-icons/settings-sblogo-inactive.png') }}" class="icon" alt="Settings Icon">
            Settings
        </a>
    </li>
</ul>
