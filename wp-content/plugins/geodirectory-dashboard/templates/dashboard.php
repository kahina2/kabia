<?php
global $wpdb;

// 1. Lieux par ville
$city_data = $wpdb->get_results("
    SELECT city, COUNT(*) as total
    FROM {$wpdb->prefix}geodir_gd_place_detail
    GROUP BY city
    ORDER BY total DESC
");



$chart_data = [
    'city' => [
        'labels' => array_column($city_data, 'city'),
        'data'   => array_map('intval', array_column($city_data, 'total'))
    ],
];
?>

<!-- Choices.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

<style>
.titre {
    margin-top: 50px;
}
.card-metric {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem;
    border-left: 4px solid #4e73df;
    background: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    min-height: 100px;
    transition: 0.3s ease;
    margin-bottom: 25px;
    margin-top: 25px;
}
.card-metric .info {
    display: flex;
    flex-direction: column;
}
.card-metric .label {
    font-size: 0.75rem;
    font-weight: bold;
    text-transform: uppercase;
    margin-bottom: 0.25rem;
}
.card-metric .value {
    font-size: 1.25rem;
    font-weight: bold;
    color: #4b4f56;
}
.card-metric .icon {
    font-size: 1.75rem;
    color: #d6d8db;
}
.border-primary { border-left-color: #4e73df; }
.border-success { border-left-color: #1cc88a; }
.border-info    { border-left-color: #36b9cc; }
.border-warning { border-left-color: #f6c23e; }

#citySelect {
    max-height: 200px;
    overflow-y: auto;
}
</style>

<div class="container mt-4">
    <h1 class="titre">📊 Statistiques Structures ESS</h1>

    <div class="row my-4">
        <!-- Cartes -->
        <div class="col-md-3">
            <div class="card-metric border-primary">
                <div class="info">
                    <div class="label" style="color:#4e73df;">Total de structure</div>
                    <div class="value">1200</div>
                </div>
                <div class="icon"><i class="fa-solid fa-house"></i></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-metric border-success">
                <div class="info">
                    <div class="label" style="color:#1cc88a;">Nombres de comptes</div>
                    <div class="value">200</div>
                </div>
                <div class="icon"><i class="fa-solid fa-circle-user"></i></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-metric border-info">
                <div class="info">
                    <div class="label" style="color:#36b9cc;">Exemple</div>
                    <div class="value">500</div>
                </div>
                <div class="icon"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-metric border-warning">
                <div class="info">
                    <div class="label" style="color:#f6c23e;">Exemple</div>
                    <div class="value">18</div>
                </div>
                <div class="icon"></div>
            </div>
        </div>
    </div>

    <!-- Filtres et graphiques -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="form-group">
                <label for="citySelect"><strong>Filtrer par ville :</strong></label>
                <select id="citySelect" multiple>
                    <?php foreach ($city_data as $city): ?>
                        <?php if (!empty($city->city)): ?>
                            <option value="<?= htmlspecialchars($city->city) ?>"><?= htmlspecialchars($city->city) ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <canvas id="cityChart"></canvas>
        </div>

    </div>
</div>

<!-- Données pour JS -->
<script type="application/json" id="charts-data"><?= json_encode($chart_data) ?></script>

<!-- Scripts Choices.js et graphique -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rawData = JSON.parse(document.getElementById('charts-data').textContent);
    const citySelect = document.getElementById('citySelect');
    const ctxCity = document.getElementById('cityChart').getContext('2d');

    const choices = new Choices(citySelect, {
        removeItemButton: true,
        placeholder: true,
        placeholderValue: 'Sélectionner des villes',
        searchPlaceholderValue: 'Rechercher une ville'
    });

    const cityChart = new Chart(ctxCity, {
        type: 'bar',
        data: {
            labels: rawData.city.labels,
            datasets: [{
                label: 'Structures par ville',
                data: rawData.city.data,
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

    citySelect.addEventListener('change', () => {
        const selected = Array.from(citySelect.selectedOptions).map(opt => opt.value);
        const allLabels = rawData.city.labels;
        const allData = rawData.city.data;

        const filteredLabels = [];
        const filteredData = [];

        if (selected.length === 0) {
            cityChart.data.labels = allLabels;
            cityChart.data.datasets[0].data = allData;
        } else {
            allLabels.forEach((label, i) => {
                if (selected.includes(label)) {
                    filteredLabels.push(label);
                    filteredData.push(allData[i]);
                }
            });
            cityChart.data.labels = filteredLabels;
            cityChart.data.datasets[0].data = filteredData;
        }

        cityChart.update();
    });
});
</script>
