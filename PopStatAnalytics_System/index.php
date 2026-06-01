<?php

include 'db.php';

$currentYear = date('Y');

$totalDeaths = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT SUM(male_death + female_death) as total
    FROM demographic_datas
    WHERE record_year = '$currentYear'
"))['total'];

$totalBirths = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT SUM(
        birth_on_date_male +
        birth_on_date_female +
        birth_late_male +
        birth_late_female
    ) as total
    FROM demographic_datas
    WHERE record_year = '$currentYear'
"))['total'];

$totalMarriages = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT SUM(marriages) as total
    FROM demographic_datas
    WHERE record_year = '$currentYear'
"))['total'];

$totalAdolescent = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT SUM(amr.total_count) as total
    FROM adolescent_mother_records amr
    INNER JOIN demographic_datas dd
        ON amr.dedaID = dd.dedaID
    WHERE dd.record_year = '$currentYear'
"))['total'];

/* MONTHLY CHART DATA */

$monthlyData = mysqli_query($conn,"
    SELECT
        dd.record_month,

        SUM(
            dd.birth_on_date_male +
            dd.birth_on_date_female +
            dd.birth_late_male +
            dd.birth_late_female
        ) AS births,

        SUM(dd.male_death + dd.female_death) AS deaths,

        SUM(dd.marriages) AS marriages,

        (
            SELECT COALESCE(SUM(amr.total_count),0)
            FROM adolescent_mother_records amr
            WHERE amr.dedaID IN (
                SELECT dedaID
                FROM demographic_datas d2
                WHERE d2.record_month = dd.record_month
                AND d2.record_year = '$currentYear'
            )
        ) AS adolescent

    FROM demographic_datas dd

    WHERE dd.record_year = '$currentYear'

    GROUP BY dd.record_month

    ORDER BY dd.record_month
");

$months = [];
$births = [];
$deaths = [];
$marriages = [];
$adolescents = [];

while($row = mysqli_fetch_assoc($monthlyData)){

    $months[] = date('F', mktime(0,0,0,$row['record_month'],1));

    $births[] = (int)$row['births'];

    $deaths[] = (int)$row['deaths'];

    $marriages[] = (int)$row['marriages'];

    $adolescents[] = (int)$row['adolescent'];
}

$adolescentMonthly = mysqli_query($conn,"
    SELECT
        dd.record_month,
        SUM(amr.total_count) AS total
    FROM adolescent_mother_records amr
    INNER JOIN demographic_datas dd
        ON amr.dedaID = dd.dedaID
    WHERE dd.record_year = '$currentYear'
    GROUP BY dd.record_month
    ORDER BY dd.record_month
");



$selectedMonth = isset($_GET['month'])
    ? (int)$_GET['month']
    : date('n');

$selectedYear = $currentYear;

$ageAnalysis = mysqli_query($conn,"
    SELECT
        amr.age,
        SUM(amr.total_count) AS total
    FROM adolescent_mother_records amr
    INNER JOIN demographic_datas dd
        ON amr.dedaID = dd.dedaID
    WHERE dd.record_month = '$selectedMonth'
    AND dd.record_year = '$selectedYear'
    GROUP BY amr.age
    ORDER BY amr.age
");

$analysisAges = [];
$analysisTotals = [];
$totalCases = 0;

while($row = mysqli_fetch_assoc($ageAnalysis)){

    $analysisAges[] = $row['age'];

    $analysisTotals[] = (int)$row['total'];

    $totalCases += (int)$row['total'];

}

?>
<!DOCTYPE html>
<html>
<head>

    <title>PopStatAnalytics</title>

    <link rel="stylesheet" href="css/index.css">

</head>
<body>

<div class="sidebar">

    <h2>PopStatAnalytics</h2>

    <ul>

        <li>
            <a href="index.php">Annual Demographic Data</a>
        </li>

        <li>
            <a href="demographic_data.php">
                Demographic Records
            </a>
        </li>

        <li>
            <a href="index.php">Municipal Records</a>
        </li>

    </ul>

</div>

<div class="main">

    <div class="top-bar">

    <div>
    <h1>Annual Demographic Data</h1>
    <p class="year-text">
        (Jan 1 - Dec 31, <?= $currentYear; ?>)
    </p>
</div>

    <button class="add-btn" id="openModal">
        + Add Demographic Data
    </button>

</div>

    <div class="cards">

        <div class="card">

            <h3>Total Deaths</h3>

            <p><?= $totalDeaths ?? 0; ?></p>

        </div>

        <div class="card">

            <h3>Total Births</h3>

            <p><?= $totalBirths ?? 0; ?></p>

        </div>

        <div class="card">

            <h3>Total Marriages</h3>

            <p><?= $totalMarriages ?? 0; ?></p>

        </div>

        <div class="card">

            <h3>Adolescent Pregnancies</h3>

            <p><?= $totalAdolescent ?? 0; ?></p>

        </div>

    </div>

    <div class="chart-container">

    <h3>Monthly Demographic Trends</h3>

    <canvas id="demographicChart"></canvas>

</div>

<div class="chart-container">

    <div class="analysis-header">

    <h3>Adolescent Pregnancy Analysis</h3>

    <div class="analysis-controls">

    <h2>
        Total Cases:
        <span id="totalCases">0</span>
    </h2>

        <select id="monthFilter">

            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>

        </select>

    </div>

</div>

<canvas id="adolescentAnalysisChart"></canvas>

</div>

<?php include 'add_demographic_modal.php'; ?>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="js/demographic_data.js"></script>

<script>

const ctx = document.getElementById('demographicChart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: <?= json_encode($months); ?>,

        datasets: [

            {
                label: 'Births',
                data: <?= json_encode($births); ?>,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37,99,235,0.1)',
                tension: 0.4,
                fill: true
            },

            {
                label: 'Deaths',
                data: <?= json_encode($deaths); ?>,
                borderColor: '#dc2626',
                backgroundColor: 'rgba(220,38,38,0.1)',
                tension: 0.4,
                fill: true
            },

            {
                label: 'Marriages',
                data: <?= json_encode($marriages); ?>,
                borderColor: '#16a34a',
                backgroundColor: 'rgba(22,163,74,0.1)',
                tension: 0.4,
                fill: true
            },

            {
                label: 'Adolescent Pregnancies',
                data: <?= json_encode($adolescents); ?>,
                borderColor: '#ec4899',
                backgroundColor: 'rgba(236,72,153,0.1)',
                tension: 0.4,
                fill: true
            }

        ]
    },

    options: {

        responsive: true,

        plugins: {

            legend: {
                position: 'top'
            }

        }

    }

});

</script>

<script>

const adolescentChart = new Chart(
document.getElementById('adolescentAnalysisChart'),
{
    type:'bar',

    data:{
        labels:[],
        datasets:[{
            label:'Pregnancy Cases',
            data:[],
            backgroundColor:'#ec4899',
            borderRadius:8
        }]
    },

    options:{
        responsive:true,

        plugins:{
            legend:{
                display:false
            }
        },

        scales:{
            y:{
                beginAtZero:true,
                ticks:{
                    precision:0
                }
            }
        }
    }
});

document
.getElementById('monthFilter')
.addEventListener('change', function(){

    fetch(
        'get_adolescent_data.php?month=' +
        this.value
    )

    .then(response => response.json())

    .then(data => {

    let ages = [];
    let totals = [];
    let totalCases = 0;

    data.forEach(item => {

        ages.push(item.age);

        totals.push(item.total);

        totalCases += parseInt(item.total);

    });

    adolescentChart.data.labels = ages;
    adolescentChart.data.datasets[0].data = totals;

    adolescentChart.update();

    document.getElementById('totalCases').innerText = totalCases;

});

});

document
.getElementById('monthFilter')
.dispatchEvent(
    new Event('change')
);

</script>

</body>
</html>