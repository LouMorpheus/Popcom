<?php

include 'db.php';

if(isset($_POST['update'])){

    $id = $_POST['dedaID'];

    /* CHECK DUPLICATE */

    $checkDuplicate = mysqli_query($conn, "

        SELECT *

        FROM demographic_datas

        WHERE municipality_id = '$_POST[municipality_id]'

        AND record_month = '$_POST[record_month]'

        AND record_year = '$_POST[record_year]'

        AND dedaID != '$id'

    ");

    if(mysqli_num_rows($checkDuplicate) > 0){

        echo "

            <script>

                alert(
                    'Another record already exists with the same municipality, month, and year.'
                );

                window.location.href =
                    'demographic_data.php';

            </script>

        ";

        exit();

    }

    /* UPDATE MAIN RECORD */

    mysqli_query($conn, "

        UPDATE demographic_datas SET

        municipality_id = '$_POST[municipality_id]',
        record_month = '$_POST[record_month]',
        record_year = '$_POST[record_year]',

        male_death = '$_POST[male_death]',
        female_death = '$_POST[female_death]',

        birth_on_date_male =
        '$_POST[birth_on_date_male]',

        birth_on_date_female =
        '$_POST[birth_on_date_female]',

        birth_late_male =
        '$_POST[birth_late_male]',

        birth_late_female =
        '$_POST[birth_late_female]',

        birth_married_parents =
        '$_POST[birth_married_parents]',

        birth_not_married_parents =
        '$_POST[birth_not_married_parents]',

        marriages = '$_POST[marriages]'

        WHERE dedaID = '$id'

    ");

    /* DELETE OLD ADOLESCENT DATA */

    mysqli_query($conn, "

        DELETE FROM adolescent_mother_records

        WHERE dedaID = '$id'

    ");

    /* INSERT UPDATED ADOLESCENT DATA */

    if(isset($_POST['adolescent'])){

        foreach($_POST['adolescent'] as $age => $count){

            if(!empty($count) && $count > 0){

                mysqli_query($conn, "

                    INSERT INTO adolescent_mother_records (

                        dedaID,
                        age,
                        total_count

                    )

                    VALUES (

                        '$id',
                        '$age',
                        '$count'

                    )

                ");

            }

        }

    }

    header("Location: demographic_data.php");
    exit();

}

?>