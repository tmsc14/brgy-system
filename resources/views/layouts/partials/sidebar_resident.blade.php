<!-- resources/views/partials/sidebar_resident.blade.php -->
<ul>
    <li><a href="#">Dashboard</a></li>
    <li><a href="#">Documents</a></li>
    <li><a href="#">Barangay Information</a></li>
    <li><a href="#">Announcements</a></li>
    <li><a href="#">Settings</a></li>
    <li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    </li>
</ul>
