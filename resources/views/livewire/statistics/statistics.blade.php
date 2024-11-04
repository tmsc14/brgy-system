<div>
    <x-icon-header text="Statistics" iconName="analytics" />
    <div>
        <div class="d-flex gap-3">
            <canvas id="resident-count-bar-graph" class="col-6 flex-shrink-1"></canvas>
            @if (isset($statisticsData['NumberOfResidents']))
                <x-statistics.simple-widget iconName="groups" :stat="$statisticsData['NumberOfResidents']" />
            @endif
            @if (isset($statisticsData['NumberOfHousehold']))
                <x-statistics.simple-widget iconName="home" :stat="$statisticsData['NumberOfHousehold']" />
            @endif
        </div>
        <div class="d-flex">
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const residentChartData = {
            labels: @json($statisticsData['ResidentsBarGraph']['labels']),
            datasets: [
                @json($statisticsData['ResidentsBarGraph']['residentsThisYear']),
                @json($statisticsData['ResidentsBarGraph']['residentsLastYear'])
            ]
        };

        const config = {
            type: 'bar',
            data: residentChartData,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Barangay Residents'
                    }
                },
                responsive: false,
                aspectRatio: 2 | 1,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        const residentCountBarGraph = new Chart(
            document.getElementById('resident-count-bar-graph'),
            config
        );
    </script>
@endpush
