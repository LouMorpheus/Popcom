<?php

include 'db.php';

?>

<!DOCTYPE html>
<html>
<head>

    <title>Demographic Records</title>

    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/demographic_data.css">

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

    </ul>

</div>

<div class="main">

    <div class="record-header">

        <div>

            <h1>Demographic Records</h1>

            <p>
                Manage demographic records
            </p>

        </div>

        <button class="add-btn" id="openModal">
            + Add Record
        </button>

    </div>

    <!-- FILTERS -->

    <div class="filter-wrapper">

        <div class="filter-group">

            <label>Municipality</label>

            <select id="municipalitySearch">

    <option value="">
        All Municipalities
    </option>

    <?php

    $municipalities = mysqli_query(
        $conn,
        "SELECT * FROM municipalities ORDER BY mun_name ASC"
    );

    while($m = mysqli_fetch_assoc($municipalities)){

    ?>

        <option value="<?= strtolower($m['mun_name']); ?>">

            <?= $m['mun_name']; ?>

        </option>

    <?php } ?>

</select>

        </div>

        <div class="filter-group">

            <label>Month</label>

            <select id="monthFilter">

                <option value="">All Months</option>

                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>

            </select>

        </div>

        <div class="filter-group">

            <label>Year</label>

            <select id="yearFilter">

    <option value="">
        All Years
    </option>

    <?php

    $years = mysqli_query(
        $conn,
        "SELECT DISTINCT record_year
         FROM demographic_datas
         ORDER BY record_year DESC"
    );

    while($y = mysqli_fetch_assoc($years)){

    ?>

        <option value="<?= $y['record_year']; ?>">

            <?= $y['record_year']; ?>

        </option>

    <?php } ?>

</select>

        </div>

    </div>

    <!-- RECORD TABLE -->

<div class="modern-table-card">

    <table id="recordsTable">

        <thead>

            <tr>

                <th>Municipality</th>
                <th>Month</th>
                <th>Year</th>
                <th>Deaths</th>
                <th>Births</th>
                <th>Adolescent Pregnancy</th>
                <th>Marriages</th>
                <th>Actions</th>

            </tr>

        </thead>

        <tbody>

            <?php

            $records = mysqli_query($conn, "

                SELECT 
                    demographic_datas.*,
                    municipalities.mun_name

                FROM demographic_datas

                INNER JOIN municipalities
                ON demographic_datas.municipality_id =
                municipalities.municipality_id

                ORDER BY
                record_year DESC,
                record_month DESC,
                dedaID DESC

            ");

            while($row = mysqli_fetch_assoc($records)){

                $totalDeaths =
                    $row['male_death'] +
                    $row['female_death'];

                $totalBirths =
                    $row['birth_on_date_male'] +
                    $row['birth_on_date_female'] +
                    $row['birth_late_male'] +
                    $row['birth_late_female'];

                $adolescentQuery = mysqli_query($conn, "
                SELECT SUM(total_count) as total
                FROM adolescent_mother_records
                WHERE dedaID = '".$row['dedaID']."'

            ");

            $adolescentData =
                mysqli_fetch_assoc($adolescentQuery);

            $totalAdolescent =
                $adolescentData['total'] ?? 0;
            ?>

            <tr>

                <!-- MUNICIPALITY -->

                <td>

                    <div class="municipality-box">

                        <div class="municipality-avatar">

                            <?= strtoupper(
                                substr(
                                    $row['mun_name'],
                                    0,
                                    1
                                )
                            ); ?>

                        </div>

                        <span>

                            <?= $row['mun_name']; ?>

                        </span>

                    </div>

                </td>

                <!-- MONTH -->

                <td>

                    <?= date(
                        'F',
                        mktime(
                            0,
                            0,
                            0,
                            $row['record_month'],
                            1
                        )
                    ); ?>

                </td>

                <!-- YEAR -->

                <td>

                    <?= $row['record_year']; ?>

                </td>

                <!-- DEATHS -->

                <td>

                    <span class="badge death-badge">

                        <?= $totalDeaths; ?>

                    </span>

                </td>

                <!-- BIRTHS -->

                <td>

                    <span class="badge birth-badge">

                        <?= $totalBirths; ?>

                    </span>

                </td>

                <td>

    <span class="badge adolescent-badge">

        <?= $totalAdolescent; ?>

    </span>

</td>

                <!-- MARRIAGES -->

                <td>

                    <span class="badge marriage-badge">

                        <?= $row['marriages']; ?>

                    </span>

                </td>

                <!-- ACTIONS -->

                <td>

                    <div class="action-buttons">

                        <!-- VIEW -->

    <button
    class="view-btn"

    onclick='openViewModal(

        "<?= htmlspecialchars($row['mun_name']); ?>",

                "<?= date(
            "F",
            mktime(
                0,
                0,
                0,
                $row["record_month"],
                1
            )
        ); ?>",

        "<?= $row["record_year"]; ?>",

        "<?= $row["male_death"]; ?>",

        "<?= $row["female_death"]; ?>",

        "<?= $row["birth_on_date_male"]; ?>",

        "<?= $row["birth_on_date_female"]; ?>",

        "<?= $row["birth_late_male"]; ?>",

        "<?= $row["birth_late_female"]; ?>",

        "<?= $row["birth_married_parents"]; ?>",

        "<?= $row["birth_not_married_parents"]; ?>",

        "<?= $totalAdolescent; ?>",

        "<?= $row["marriages"]; ?>"

    )'
>
    View
</button>

    <!-- PRINT -->

    <a
        href="print_record.php?id=<?= $row['dedaID']; ?>"
        target="_blank"
        class="print-btn"
    >
        Print
    </a>


                    <?php

$adolescentRecords = [];

$adolescentQuery = mysqli_query($conn, "

    SELECT age, total_count

    FROM adolescent_mother_records

    WHERE dedaID = '".$row['dedaID']."'

");

while($a = mysqli_fetch_assoc($adolescentQuery)){

    $adolescentRecords[$a['age']] =
        $a['total_count'];

}

$adolescentJson =
    json_encode($adolescentRecords);

?>

                        <!-- EDIT -->

                        <button
                            class="edit-btn"

                            onclick='openEditModal(

                                <?= $row["dedaID"]; ?>,
                                <?= $row["municipality_id"]; ?>,
                                <?= $row["record_month"]; ?>,
                                <?= $row["record_year"]; ?>,

                                <?= $row["male_death"]; ?>,
                                <?= $row["female_death"]; ?>,

                                <?= $row["birth_on_date_male"]; ?>,
                                <?= $row["birth_on_date_female"]; ?>,

                                <?= $row["birth_late_male"]; ?>,
                                <?= $row["birth_late_female"]; ?>,

                                <?= $row["birth_married_parents"]; ?>,
                                <?= $row["birth_not_married_parents"]; ?>,

                                <?= json_encode($adolescentJson); ?>,

                                <?= $row["marriages"]; ?>

                            )'
                        >
                            Edit
                        </button>

                        <!-- DELETE -->

                        <a
                            href="delete.php?id=<?= $row['dedaID']; ?>"
                            class="delete-btn"

                            onclick="
                                return confirm(
                                    'Delete this record?'
                                )
                            "
                        >
                            Delete
                        </a>

                    </div>

                </td>

            </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

</div>


<?php include 'view_demographic_modal.php'; ?>
<?php include 'edit_demographic_modal.php'; ?>
<?php include 'add_demographic_modal.php'; ?>

<script src="js/demographic.js"></script>

</body>
</html>