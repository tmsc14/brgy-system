    <ul class="list-unstyled w-100">
        <li class="w-100">
            <a href="{{ route('bc-dashboard') }}" class="{{ request()->routeIs('bc-dashboard') ? 'active' : '' }}">
                <img src="{{ request()->routeIs('bc-dashboard') ? asset('resources/img/sidebar-icons/dashboard-sblogo.png') : asset('resources/img/sidebar-icons/dashboard-sblogo-inactive.png') }}"
                    class="icon" alt="Dashboard Icon">
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('bc-requests') }}" class="{{ request()->routeIs('bc-requests') ? 'active' : '' }}">
                <img src="{{ request()->routeIs('bc-requests') ? asset('resources/img/sidebar-icons/request-sblogo.png') : asset('resources/img/sidebar-icons/request-sblogo-inactive.png') }}"
                    class="icon" alt="Requests Icon">
                Requests
            </a>
        </li>
        <li>
            <a href="{{ route('barangay_captain.admins') }}"
                class="{{ request()->routeIs('barangay_captain.admins') ? 'active' : '' }}">
                <img src="{{ request()->routeIs('barangay_captain.admins') ? asset('resources/img/sidebar-icons/admins-sblogo.png') : asset('resources/img/sidebar-icons/admins-sblogo-inactive.png') }}"
                    class="icon" alt="Admins Icon">
                Admins
            </a>
        </li>
        <li>
            <a href="{{ route('barangay_captain.statistics') }}"
                class="{{ request()->routeIs('barangay_captain.statistics') ? 'active' : '' }}">
                <img src="{{ request()->routeIs('barangay_captain.statistics') ? asset('resources/img/sidebar-icons/statistics-sblogo.png') : asset('resources/img/sidebar-icons/statistics-sblogo-inactive.png') }}"
                    class="icon" alt="Statistics Icon">
                Statistics
            </a>
        </li>
        </li>
        <a href="{{ route('barangay_captain.customize_barangay') }}"
            class="{{ request()->routeIs('barangay_captain.customize_barangay') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('barangay_captain.customize_barangay') ? asset('resources/img/sidebar-icons/customize-sblogo.png') : asset('resources/img/sidebar-icons/customize-sblogo-inactive.png') }}"
                class="icon" alt="Customize Icon">
            Customize
        </a>
        </li>
        <li>
            <a href="{{ route('barangay_captain.settings') }}"
                class="{{ request()->routeIs('barangay_captain.settings') ? 'active' : '' }}">
                <img src="{{ request()->routeIs('settings') ? asset('resources/img/sidebar-icons/settings-sblogo.png') : asset('resources/img/sidebar-icons/settings-sblogo-inactive.png') }}"
                    class="icon" alt="Settings Icon">
                Settings
            </a>
        </li>
    </ul>
