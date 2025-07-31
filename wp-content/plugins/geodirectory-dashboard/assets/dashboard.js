document.addEventListener('DOMContentLoaded', function () {
    const configs = JSON.parse(document.getElementById('charts-data').textContent);

    const citySelect = document.getElementById('citySelect');
    const ctxCity = document.getElementById('cityChart').getContext('2d');

    // Graphique dynamique pour les villes
    const cityChart = new Chart(ctxCity, {
        type: 'bar',
        data: {
            labels: configs.city.labels,
            datasets: [{
                label: 'Structures par ville',
                data: configs.city.data,
                backgroundColor: 'rgba(78, 115, 223, 0.5)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Filtrer les villes sélectionnées
    citySelect.addEventListener('change', () => {
        const selected = Array.from(citySelect.selectedOptions).map(opt => opt.value);
        const allLabels = configs.city.labels;
        const allData = configs.city.data;

        let filteredLabels = [];
        let filteredData = [];

        if (selected.length === 0) {
            // Aucune sélection => tout afficher
            filteredLabels = allLabels;
            filteredData = allData;
        } else {
            allLabels.forEach((label, i) => {
                if (selected.includes(label)) {
                    filteredLabels.push(label);
                    filteredData.push(allData[i]);
                }
            });
        }

        cityChart.data.labels = filteredLabels;
        cityChart.data.datasets[0].data = filteredData;
        cityChart.update();
    });

});
