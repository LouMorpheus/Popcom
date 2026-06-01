<?php

include 'db.php';

$month = $_GET['month'];
$year = date('Y');

$data = [];

$query = mysqli_query($conn,"
    SELECT
        amr.age,
        SUM(amr.total_count) AS total
    FROM adolescent_mother_records amr
    INNER JOIN demographic_datas dd
        ON amr.dedaID = dd.dedaID
    WHERE dd.record_month = '$month'
    AND dd.record_year = '$year'
    GROUP BY amr.age
    ORDER BY amr.age
");

while($row = mysqli_fetch_assoc($query)){

    $data[] = $row;
}

echo json_encode($data);