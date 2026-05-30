<?php

include 'db.php';

$id = $_GET['id'];

/* DELETE ADOLESCENT */

mysqli_query($conn, "
    DELETE FROM adolescent_mother_records
    WHERE dedaID = '$id'
");

/* DELETE DEMOGRAPHIC */

mysqli_query($conn, "
    DELETE FROM demographic_datas
    WHERE dedaID = '$id'
");

header("Location: demographic_data.php");

?>