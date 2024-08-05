<ul class="nav">
    <li>
        <a href="#" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('dashboard') ? asset('resources/img/sidebar-icons/dashboard-sblogo.png') : asset('resources/img/sidebar-icons/dashboard-sblogo-inactive.png') }}" class="icon" alt="Dashboard Icon">
            Dashboard
        </a>
    </li>
    <li>
        <a href="#" class="{{ request()->routeIs('employees') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('employees') ? asset('resources/img/sidebar-icons/admins-sblogo.png') : asset('resources/img/sidebar-icons/admins-sblogo-inactive.png') }}" class="icon" alt="Employees Icon">
            Employees
        </a>
    </li>
    <li>
        <a href="#" class="{{ request()->routeIs('documents') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('documents') ? asset('resources/img/sidebar-icons/documents-sblogo.png') : asset('resources/img/sidebar-icons/documents-sblogo-inactive.png') }}" class="icon" alt="Documents Icon">
            Documents
        </a>
    </li>
    <li>
        <a href="#" class="{{ request()->routeIs('residents') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('residents') ? asset('resources/img/sidebar-icons/admins-sblogo.png') : asset('resources/img/sidebar-icons/admins-sblogo-inactive.png') }}" class="icon" alt="Residents Icon">
            Residents
        </a>
    </li>
    <li>
        <a href="#" class="{{ request()->routeIs('calendar') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('calendar') ? asset('resources/img/sidebar-icons/calendar-sblogo.png') : asset('resources/img/sidebar-icons/calendar-sblogo-inactive.png') }}" class="icon" alt="Calendar Icon">
            Calendar
        </a>
    </li>
    <li>
        <a href="#" class="{{ request()->routeIs('statistics') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('statistics') ? asset('resources/img/sidebar-icons/statistics-sblogo.png') : asset('resources/img/sidebar-icons/statistics-sblogo-inactive.png') }}" class="icon" alt="Statistics Icon">
            Statistics
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
    <li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <img src="{{ asset('resources/img/sidebar-icons/logout-sblogo-inactive.png') }}" class="icon" alt="Logout Icon">
            Logout
        </a>
    </li>
</ul>
