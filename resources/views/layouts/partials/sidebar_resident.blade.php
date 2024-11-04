<x-sidebar>
    <x-sidebar-item moduleName='dashboard' iconName='grid-view'  />
    <x-sidebar-item moduleName='documents' iconName='edit-square' />
    <x-sidebar-item moduleName='barangay-information' iconName='group' label="Barangay Information" />
    <x-sidebar-item moduleName='announcements' iconName='feedback' />
    <x-sidebar-item moduleName='household' label='Household' iconName='groups' />
    <x-sidebar-item moduleName='settings' iconName='settings' />
    {{-- <li>
        <a href="{{ route('barangay_resident.dashboard')}}" class="{{ request()->routeIs('barangay_resident.dashboard') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('barangay_resident.dashboard') ? asset('resources/img/sidebar-icons/dashboard-sblogo.png') : asset('resources/img/sidebar-icons/dashboard-sblogo-inactive.png') }}" class="icon" alt="Dashboard Icon">
            Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('households.index') }}" class="{{ request()->routeIs('households.*') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('households.*') ? asset('resources/img/sidebar-icons/admins-sblogo.png') : asset('resources/img/sidebar-icons/admins-sblogo-inactive.png') }}" class="icon" alt="Household Management Icon">
            Household Management
        </a>
    </li>    
    <li>
        <a href="{{ route('barangay_resident.documentrequests.types') }}" class="{{ request()->routeIs('barangay_resident.documentrequests.types') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('barangay_resident.documentrequests.types') ? asset('resources/img/sidebar-icons/documents-sblogo.png') : asset('resources/img/sidebar-icons/documents-sblogo-inactive.png') }}" class="icon" alt="Documents Icon">
            Documents
        </a>
    </li>
    <li>
        <a href="#" class="{{ request()->routeIs('barangay_information') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('barangay_information') ? asset('resources/img/sidebar-icons/information-sblogo.png') : asset('resources/img/sidebar-icons/information-sblogo-inactive.png') }}" class="icon" alt="Barangay Information Icon">
            Barangay Information
        </a>
    </li>
    <li>
        <a href="#" class="{{ request()->routeIs('announcements') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('announcements') ? asset('resources/img/sidebar-icons/announcement-sblogo.png') : asset('resources/img/sidebar-icons/announcement-sblogo-inactive.png') }}" class="icon" alt="Announcement Icon">
            Announcements
        </a>
    </li>
    <li>
        <a href="#" class="{{ request()->routeIs('settings') ? 'active' : '' }}">
            <img src="{{ request()->routeIs('settings') ? asset('resources/img/sidebar-icons/settings-sblogo.png') : asset('resources/img/sidebar-icons/settings-sblogo-inactive.png') }}" class="icon" alt="Settings Icon">
            Settings
        </a>
    </li> --}}
</x-sidebar>
