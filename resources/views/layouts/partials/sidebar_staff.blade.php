<ul>
    <li><a href="#">Dashboard</a></li>
    <li><a href="#">Employees</a></li>
    <li><a href="#">Documents</a></li>
    <li><a href="#">Residents</a></li>
    <li><a href="#">Calendar</a></li>
    <li><a href="#">Statistics</a></li>
    <li><a href="#">Settings</a></li>
    <li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    </li>
</ul>