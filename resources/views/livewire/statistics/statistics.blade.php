<div>
    <x-icon-header text="Statistics" iconResourcePath='resources/img/sidebar-icons/statistics-sblogo.png' />
    <div>
        @foreach ($statisticsData as $row => $stats)
            <div class='d-flex'>
                @foreach ($stats as $stat)
                    <div class="col-3">
                        <div>
                            <x-gmdi-groups class='icon' />
                        </div>
                        <div>
                            <x-subtitle>
                                {{ $stat['title'] }}
                            </x-subtitle>
                            <span>
                                {{ $stat['count'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
