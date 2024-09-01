<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/bc-template-dashboard.css', 'resources/js/notification.js'])
    <title>Barangay Dashboard</title>
    @yield('styles')
    <style>
        :root {
            --theme-color: {{ $appearanceSettings->theme_color ?? '#FAEED8' }};
            --primary-color: {{ $appearanceSettings->primary_color ?? '#503C2F' }};
            --secondary-color: {{ $appearanceSettings->secondary_color ?? '#FAFAFA' }};
            --text-color: {{ $appearanceSettings->text_color ?? '#000000' }};
        }

        body {
            background-color: var(--theme-color);
            color: var(--text-color);
        }

        .sidebar {
            background-color: var(--primary-color);
            color: var(--secondary-color);
        }

        .nav a,
        .logout-button {
            color: var(--secondary-color);
        }

        .nav a.active,
        .logout-button:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('resources/img/logo.png') }}" alt="Brgy+ Logo" class="brgy-logo">
        </div>
        <div class="barangay-logo-container">
            @if(isset($appearanceSettings) && $appearanceSettings->logo_path)
            <img src="{{ asset('storage/' . $appearanceSettings->logo_path) }}" alt="Barangay Logo" class="barangay-logo">
            @else
                <img src="{{ asset('resources/img/default-logo.png') }}" alt="Default Barangay Logo" class="barangay-logo">
            @endif
        </div>
        <ul class="nav">
            <li>
                <a href="{{ route('bc-dashboard') }}" class="{{ request()->routeIs('bc-dashboard') ? 'active' : '' }}">
                    <img src="{{ request()->routeIs('bc-dashboard') ? asset('resources/img/sidebar-icons/dashboard-sblogo.png') : asset('resources/img/sidebar-icons/dashboard-sblogo-inactive.png') }}" class="icon" alt="Dashboard Icon">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('bc-requests')}}" class="{{ request()->routeIs('bc-requests') ? 'active' : '' }}">
                    <img src="{{ request()->routeIs('bc-requests') ? asset('resources/img/sidebar-icons/request-sblogo.png') : asset('resources/img/sidebar-icons/request-sblogo-inactive.png') }}" class="icon" alt="Requests Icon">
                    Requests
                </a>
            </li>
            <li>
                <a href="#" class="{{ request()->routeIs('admins') ? 'active' : '' }}">
                    <img src="{{ request()->routeIs('admins') ? asset('resources/img/sidebar-icons/admins-sblogo.png') : asset('resources/img/sidebar-icons/admins-sblogo-inactive.png') }}" class="icon" alt="Admins Icon">
                    Admins
                </a>
            </li>
            <li>
                <a href="#" class="{{ request()->routeIs('statistics') ? 'active' : '' }}">
                    <img src="{{ request()->routeIs('statistics') ? asset('resources/img/sidebar-icons/statistics-sblogo.png') : asset('resources/img/sidebar-icons/statistics-sblogo-inactive.png') }}" class="icon" alt="Statistics Icon">
                    Statistics
                </a>
            </li>
            <li>
                <a href="{{ route('barangay_captain.create_barangay_info_form')}}" class="{{ request()->routeIs('barangay_captain.create_barangay_info_form') ? 'active' : '' }}">
                    <img src="{{ request()->routeIs('customize') ? asset('resources/img/sidebar-icons/customize-sblogo.png') : asset('resources/img/sidebar-icons/customize-sblogo-inactive.png') }}" class="icon" alt="Customize Icon">
                    Customize
                </a>
            </li>
            <li>
                <a href="{{ route('barangay_captain.settings')}}" class="{{ request()->routeIs('barangay_captain.settings') ? 'active' : '' }}">
                    <img src="{{ request()->routeIs('settings') ? asset('resources/img/sidebar-icons/settings-sblogo.png') : asset('resources/img/sidebar-icons/settings-sblogo-inactive.png') }}" class="icon" alt="Settings Icon">
                    Settings
                </a>
            </li>
        </ul>
        <div class="logout-container">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">
                    <img src="{{ asset('resources/img/sidebar-icons/logout-sblogo.png') }}" class="icon" alt="Logout Icon">
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
    <div class="main-content">
        <div class="header">
            <h1 class="hello">Hello, {{ Auth::user()->first_name }}!</h1>
            <div class="date">
                <img src="{{ asset('resources/img/header-date.png') }}" class="icon" alt="Date Icon">
                {{ now()->format('F d, Y') }}
            </div>
            <div class="search">
                <input type="text" placeholder="Search here">
            </div>
            <div class="notification" onclick="toggleNotificationDropdown()">
                <img src="{{ asset('resources/img/notification-icon.png') }}" class="notification-icon" alt="Notifications">
                <div class="notification-dropdown" id="notification-dropdown">
                    @if (session('success'))
                        <div class="notification-item">
                            <span>🎉 {{ session('success') }}</span>
                        </div>
                    @else
                        <div class="notification-item">
                            <p>No notifications</p>
                        </div>
                    @endif
                    <div class="clear-notifications">
                        <a href="{{ route('clear-notifications') }}">Clear All</a>
                    </div>
                </div>
            </div>                       
        </div>
        <hr class="header-line">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div> 
</body>
</html>
