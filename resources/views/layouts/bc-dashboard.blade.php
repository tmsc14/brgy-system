<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('resources/css/bc-dashboard.css') }}">
    <title>Barangay Dashboard</title>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('resources/img/logo.png') }}" alt="Brgy+ Logo" class="brgy-logo">
        </div>
        <div class="barangay-logo-container">
            <img src="{{ asset('images/barangay-logo.png') }}" alt="Barangay Logo" class="barangay-logo">
        </div>
        <ul class="nav">
            <li>
                <a href="{{ route('bc-dashboard') }}" class="{{ request()->routeIs('bc-dashboard') ? 'active' : '' }}">
                    <img src="{{ request()->routeIs('bc-dashboard') ? asset('resources/img/sidebar-icons/dashboard-sblogo.png') : asset('resources/img/sidebar-icons/dashboard-sblogo-inactive.png') }}" class="icon" alt="Dashboard Icon">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="#" class="{{ request()->routeIs('bc-requests') ? 'active' : '' }}">
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
                <a href="#" class="{{ request()->routeIs('customize') ? 'active' : '' }}">
                    <img src="{{ request()->routeIs('customize') ? asset('resources/img/sidebar-icons/customize-sblogo.png') : asset('resources/img/sidebar-icons/customize-sblogo-inactive.png') }}" class="icon" alt="Customize Icon">
                    Customize
                </a>
            </li>
            <li>
                <a href="#" class="{{ request()->routeIs('settings') ? 'active' : '' }}">
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
                    Logout
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
        </div>
        <hr class="header-line">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
</body>
</html>
