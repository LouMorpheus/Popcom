<?php

include 'db.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "

    SELECT d.*,
           m.mun_name

    FROM demographic_datas d

    JOIN municipalities m

    ON d.municipality_id =
       m.municipality_id

    WHERE d.dedaID = '$id'

");

$row = mysqli_fetch_assoc($query);

/* TOTAL ADOLESCENT */

$adolescentQuery = mysqli_query($conn, "

    SELECT age, total_count

    FROM adolescent_mother_records

    WHERE dedaID = '$id'

");

$totalAdolescent = 0;

$ageBreakdown = [];

while($a = mysqli_fetch_assoc($adolescentQuery)){

    $totalAdolescent += $a['total_count'];

    $ageBreakdown[] =
        "Age {$a['age']} : {$a['total_count']}";

}

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Demographic Report</title>

<style>

body{

    font-family: Arial, sans-serif;

    margin:40px;

}

.header{

    text-align:center;

    margin-bottom:30px;

}

.header h1{

    margin:0;

}

.section{

    margin-bottom:25px;

}

table{

    width:100%;

    border-collapse:collapse;

}

table,
th,
td{

    border:1px solid #000;

}

th,
td{

    padding:10px;

}

@media print{

    button{

        display:none;

    }

}

</style>

</head>

<body>

<div class="header">

    <h1>PopStatAnalytics</h1>

    <p>Demographic Record Report</p>

</div>

<div class="section">

    <strong>Municipality:</strong>

    <?= $row['mun_name']; ?>

    <br>

    <strong>Month:</strong>

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

    <br>

    <strong>Year:</strong>

    <?= $row['record_year']; ?>

</div>

<table>

<tr>

    <th colspan="2">
        Death Statistics
    </th>

</tr>

<tr>

    <td>Male</td>

    <td><?= $row['male_death']; ?></td>

</tr>

<tr>

    <td>Female</td>

    <td><?= $row['female_death']; ?></td>

</tr>

<tr>

    <th colspan="2">
        Birth Statistics
    </th>

</tr>

<tr>

    <td>On Date Male</td>

    <td><?= $row['birth_on_date_male']; ?></td>

</tr>

<tr>

    <td>On Date Female</td>

    <td><?= $row['birth_on_date_female']; ?></td>

</tr>

<tr>

    <td>Late Male</td>

    <td><?= $row['birth_late_male']; ?></td>

</tr>

<tr>

    <td>Late Female</td>

    <td><?= $row['birth_late_female']; ?></td>

</tr>

<tr>

    <td>Married Parents</td>

    <td><?= $row['birth_married_parents']; ?></td>

</tr>

<tr>

    <td>Not Married Parents</td>

    <td><?= $row['birth_not_married_parents']; ?></td>

</tr>

<tr>

    <th colspan="2">
        Adolescent Pregnancy
    </th>

</tr>

<tr>

    <td>Total Cases</td>

    <td><?= $totalAdolescent; ?></td>

</tr>

<tr>

    <td colspan="2">

        <?php

        foreach($ageBreakdown as $age){

            echo $age . "<br>";

        }

        ?>

    </td>

</tr>

<tr>

    <th>Marriage Count</th>

    <td><?= $row['marriages']; ?></td>

</tr>

</table>

<script>

window.onload = function(){

    window.print();

}

</script>

</body>
</html>