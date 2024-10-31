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
            datasets: [{
                label: 'Barangay Residents',
                data: @json($statisticsData['ResidentsBarGraph']['values']),
                backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF'],
            }]
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
