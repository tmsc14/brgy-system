document.addEventListener('DOMContentLoaded', function () {
    const genderData = {
        labels: ['Male', 'Female', 'Other'],
        datasets: [{
            label: 'Gender Demographics',
            data: [
                genderDemographicsMale, // Dynamic values passed from Blade
                genderDemographicsFemale,
                genderDemographicsOther
            ],
            backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56'],
        }]
    };

    const config = {
        type: 'pie',
        data: genderData,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',  // Keep the legend on top of the chart
                    align: 'center',  // Center the legend horizontally
                    labels: {
                        boxWidth: 20,   // Control the size of the color box
                        padding: 15,    // Control spacing between labels
                    }
                },
                datalabels: {
                    color: 'white',
                    font: {
                        weight: 'bold',
                        size: 16,
                    },
                    formatter: (value) => value,
                }
            }
        },
        plugins: [ChartDataLabels],  // Register the datalabels plugin
    };

    const genderChart = new Chart(
        document.getElementById('genderChart'),
        config
    );
});
