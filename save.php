<?php

include 'db.php';

if(isset($_POST['municipality_id'])){

    /* CHECK DUPLICATE */

    $check = mysqli_query($conn, "

        SELECT *

        FROM demographic_datas

        WHERE municipality_id = '$_POST[municipality_id]'

        AND record_month = '$_POST[record_month]'

        AND record_year = '$_POST[record_year]'

    ");

    if(mysqli_num_rows($check) > 0){

        echo "

            <script>

                alert(
                    'Record already exists for this municipality, month, and year.'
                );

                window.location.href =
                    'demographic_data.php';

            </script>

        ";

        exit();

    }

    /* INSERT MAIN DEMOGRAPHIC DATA */

    mysqli_query($conn, "

        INSERT INTO demographic_datas (

            municipality_id,
            record_month,
            record_year,

            male_death,
            female_death,

            birth_on_date_male,
            birth_on_date_female,

            birth_late_male,
            birth_late_female,

            birth_married_parents,
            birth_not_married_parents,

            marriages

        )

        VALUES (

            '$_POST[municipality_id]',
            '$_POST[record_month]',
            '$_POST[record_year]',

            '$_POST[male_death]',
            '$_POST[female_death]',

            '$_POST[birth_on_date_male]',
            '$_POST[birth_on_date_female]',

            '$_POST[birth_late_male]',
            '$_POST[birth_late_female]',

            '$_POST[birth_married_parents]',
            '$_POST[birth_not_married_parents]',

            '$_POST[marriages]'

        )

    ");

    /* GET INSERTED ID */

    $dedaID = mysqli_insert_id($conn);

    /* SAVE ADOLESCENT RECORDS */

    if(isset($_POST['adolescent'])){

        foreach($_POST['adolescent'] as $age => $count){

    /* ONLY SAVE IF HAS VALUE */

    if(!empty($count) && $count > 0){

        mysqli_query($conn, "

            INSERT INTO adolescent_mother_records (

                dedaID,
                age,
                total_count

            )

            VALUES (

                '$dedaID',
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