<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay System</title>
    @vite(['resources/css/role-dashboard.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
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
    <div class="container">
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('resources/img/logo.png') }}" alt="Brgy+ Logo" class="brgy-logo">
            </div>
            <div class="barangay-logo-container">
                @if($appearanceSettings && $appearanceSettings->logo_path)
                    <img src="{{ asset('storage/' . $appearanceSettings->logo_path) }}" alt="Barangay Logo" class="barangay-logo">
                @else
                    <img src="{{ asset('resources/img/default-logo.png') }}" alt="Default Barangay Logo" class="barangay-logo">
                @endif
            </div>
            @if($role == 'barangay_official')
                @include('layouts.partials.sidebar_barangay_official', ['barangay' => $barangay])
            @elseif($role == 'barangay_staff')
                @include('layouts.partials.sidebar_staff', ['barangay' => $barangay])
            @elseif($role == 'barangay_resident')
                @include('layouts.partials.sidebar_resident')
            @endif
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
            </div>
            <hr class="header-line">
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>
    @yield('scripts')
</body>
</html>
