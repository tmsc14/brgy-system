<div>
    <x-icon-header text="Statistics" iconName='analytics' />
    <div>
        <div class='d-flex'>
            @if (isset($statisticsData['NumberOfResidents']))
                <x-statistics.simple-widget :stat="$statisticsData['NumberOfResidents']" />
            @endif
        </div>
        <div class='d-flex'>
        </div>
        <div class='d-flex'>
        </div>
    </div>
</div>
