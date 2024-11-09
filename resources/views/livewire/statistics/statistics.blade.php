<div>
    <div>
        <div class="d-flex gap-3 mb-3">
            <div class="brgy-bg-primary col-6 flex-shrink-1 p-2 min-width-zero rounded">
                <canvas id="resident-count-bar-graph"></canvas>
            </div>
            @if (isset($statisticsData['NumberOfResidents']))
                <x-statistics.simple-widget iconName="groups" :stat="$statisticsData['NumberOfResidents']" wire:click="residentsList" />
            @endif
            @if (isset($statisticsData['NumberOfHousehold']))
                <x-statistics.simple-widget iconName="home" :stat="$statisticsData['NumberOfHousehold']" wire:click="households" />
            @endif
        </div>
        <div class="d-flex gap-3 mb-3">
            @if (isset($statisticsData['Gender']))
                <div class="brgy-bg-primary col-4 flex-shrink-1 text-center p-4 rounded">
                    <span class='d-flex justify-content-center align-items-center gap-2'>
                        <x-gmdi-wc class="icon brgy-primary-text" />
                        <x-subtitle class="brgy-primary-text">Gender of Residents</x-subtitle>
                    </span>
                    <canvas id="gender-doughnut-graph"></canvas>
                </div>
            @endif
            @if (isset($statisticsData['Employment']))
                <div class="brgy-bg-primary col-4 flex-shrink-1 text-center p-4 rounded">
                    <span class='d-flex justify-content-center align-items-center gap-2'>
                        <x-gmdi-badge class="icon brgy-primary-text" />
                        <x-subtitle class="brgy-primary-text">Employment Status</x-subtitle>
                    </span>
                    <canvas id="employment-doughnut-graph"></canvas>
                </div>
            @endif
            @if (isset($statisticsData['AgeDemographic']))
                <div class="brgy-bg-primary col-4 flex-shrink-1 text-center p-4 rounded">
                    <span class='d-flex justify-content-center align-items-center gap-2'>
                        <x-gmdi-groups class="icon brgy-primary-text" />
                        <x-subtitle class="brgy-primary-text">Age Groups</x-subtitle>
                    </span>
                    <canvas id="age-doughnut-graph"></canvas>
                </div>
            @endif
        </div>
        <div class="d-flex gap-3 mb-3">
            @if (isset($statisticsData['NumberOfPWD']))
                <x-statistics.simple-widget iconName="accessible" :stat="$statisticsData['NumberOfPWD']" wire:click="pwdList" />
            @endif
            @if (isset($statisticsData['NumberOfSingleParents']))
                <x-statistics.simple-widget iconName="escalator-warning" :stat="$statisticsData['NumberOfSingleParents']" wire:click="singleparents" />
            @endif
            @if (isset($statisticsData['NumberOfVoters']))
                <x-statistics.simple-widget iconName="how-to-vote" :stat="$statisticsData['NumberOfVoters']" wire:click="voters" />
            @endif
            @if (isset($statisticsData['Seniors']))
                <x-statistics.simple-widget iconName="elderly" :stat="$statisticsData['Seniors']" wire:click="seniors" />
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const root = document.documentElement;
        const graphColor = getComputedStyle(root).getPropertyValue('--brgy-primary-text-color').trim();

        const residentChartData = {
            labels: @json($statisticsData['ResidentsBarGraph']['labels']),
            datasets: [
                @json($statisticsData['ResidentsBarGraph']['residentsThisYear']),
                @json($statisticsData['ResidentsBarGraph']['residentsLastYear'])
            ]
        };

        Chart.defaults.color = graphColor;

        const residentBarGraphConfig = {
            type: 'bar',
            data: residentChartData,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Barangay Residents'
                    }
                },
                responsive: true,
                aspectRatio: 2 | 1,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return Number(value).toFixed(0);
                            }
                        }
                    }
                }
            }
        };

        const residentCountBarGraph = new Chart(
            document.getElementById('resident-count-bar-graph'),
            residentBarGraphConfig
        );
    </script>

    @if (isset($statisticsData['Gender']))
        <script>
            const genderChartData = {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: [@json($statisticsData['Gender']['maleCount']), @json($statisticsData['Gender']['femaleCount'])]
                }]
            };

            const genderGraphConfig = {
                type: 'doughnut',
                data: genderChartData,
            };

            const genderGraph = new Chart(
                document.getElementById('gender-doughnut-graph'),
                genderGraphConfig
            );
        </script>
    @endif

    @if (isset($statisticsData['Employment']))
        <script>
            const employmentChartData = {
                labels: ['Employed', 'Unemployed'],
                datasets: [{
                    data: [@json($statisticsData['Employment']['unemployedCount']), @json($statisticsData['Employment']['employedCount'])]
                }]
            };

            const employmentGraphConfig = {
                type: 'doughnut',
                data: employmentChartData,
            };

            const employmentGraph = new Chart(
                document.getElementById('employment-doughnut-graph'),
                employmentGraphConfig
            );
        </script>
    @endif

    @if (isset($statisticsData['AgeDemographic']))
        <script>
            const ageChartData = {
                labels: ['0-17', '18-30', '31-59', '60+'],
                datasets: [{
                    data: [@json($statisticsData['AgeDemographic']['0-17']), @json($statisticsData['AgeDemographic']['18-30']), @json($statisticsData['AgeDemographic']['31-59']),
                        @json($statisticsData['AgeDemographic']['60+'])
                    ]
                }]
            };

            const ageGraphConfig = {
                type: 'doughnut',
                data: ageChartData,
            };

            const ageGraph = new Chart(
                document.getElementById('age-doughnut-graph'),
                ageGraphConfig
            );
        </script>
    @endif
@endpush
