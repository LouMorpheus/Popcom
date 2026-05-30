<?php

include 'db.php';
$currentYear = date('Y');

$totalDeaths = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT SUM(male_death + female_death) as total
    FROM demographic_datas
"))['total'];

$totalBirths = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT SUM(
        birth_on_date_male +
        birth_on_date_female +
        birth_late_male +
        birth_late_female
    ) as total
    FROM demographic_datas
"))['total'];

$totalMarriages = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT SUM(marriages) as total
    FROM demographic_datas
"))['total'];

$totalAdolescent = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT SUM(total_count) as total
    FROM adolescent_mother_records
"))['total'];

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
            <a href="index.php">Dashboard</a>
        </li>

        <li>
            <a href="demographic_data.php">
                Demographic Data
            </a>
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

</div>

<?php include 'add_demographic_modal.php'; ?>

<script src="js/demographic_data.js"></script>

</body>
</html>