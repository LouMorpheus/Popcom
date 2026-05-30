<!-- EDIT MODAL -->

<div class="modal" id="editModal">

    <div class="modal-content">

        <span
            class="close-btn"
            onclick="closeEditModal()"
        >
            &times;
        </span>

        <h2>Edit Demographic Data</h2>

        <form action="update.php" method="POST">

            <!-- HIDDEN ID -->

            <input
                type="hidden"
                name="dedaID"
                id="edit_dedaID"
            >

            <!-- MUNICIPALITY -->

            <div class="form-group">

                <label>Municipality</label>

                <select
                    name="municipality_id"
                    id="edit_municipality"
                    required
                >

                    <?php

                    $mun = mysqli_query(
                        $conn,
                        "SELECT * FROM municipalities"
                    );

                    while($m = mysqli_fetch_assoc($mun)){

                    ?>

                    <option
                        value="<?= $m['municipality_id']; ?>"
                    >

                        <?= $m['mun_name']; ?>

                    </option>

                    <?php } ?>

                </select>

            </div>

            <!-- MONTH & YEAR -->

            <div class="grid-2">

                <div class="form-group">

                    <label>Month</label>

                    <select
                        name="record_month"
                        id="edit_month"
                        required
                    >

                        <?php

                        for($m=1;$m<=12;$m++){

                        ?>

                        <option value="<?= $m; ?>">

                            <?= date(
                                'F',
                                mktime(0,0,0,$m,1)
                            ); ?>

                        </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="form-group">

                    <label>Year</label>

                    <input
                        type="number"
                        name="record_year"
                        id="edit_year"
                        required
                    >

                </div>

            </div>

            <!-- DEATH -->

            <h3>Death Statistics</h3>

            <div class="grid-2">

                <div class="form-group">

                    <label>Male Death</label>

                    <input
                        type="number"
                        name="male_death"
                        id="edit_male_death"
                    >

                </div>

                <div class="form-group">

                    <label>Female Death</label>

                    <input
                        type="number"
                        name="female_death"
                        id="edit_female_death"
                    >

                </div>

            </div>

            <!-- BIRTH ON DATE -->

            <h3>Birth On Date</h3>

            <div class="grid-2">

                <div class="form-group">

                    <label>Male</label>

                    <input
                        type="number"
                        name="birth_on_date_male"
                        id="edit_birth_on_date_male"
                    >

                </div>

                <div class="form-group">

                    <label>Female</label>

                    <input
                        type="number"
                        name="birth_on_date_female"
                        id="edit_birth_on_date_female"
                    >

                </div>

            </div>

            <!-- LATE REGISTRATION -->

            <h3>Late Registration</h3>

            <div class="grid-2">

                <div class="form-group">

                    <label>Male</label>

                    <input
                        type="number"
                        name="birth_late_male"
                        id="edit_birth_late_male"
                    >

                </div>

                <div class="form-group">

                    <label>Female</label>

                    <input
                        type="number"
                        name="birth_late_female"
                        id="edit_birth_late_female"
                    >

                </div>

            </div>

            <!-- PARENTS STATUS -->

            <h3>Parents Status</h3>

            <div class="grid-2">

                <div class="form-group">

                    <label>Married Parents</label>

                    <input
                        type="number"
                        name="birth_married_parents"
                        id="edit_married"
                    >

                </div>

                <div class="form-group">

                    <label>Not Married Parents</label>

                    <input
                        type="number"
                        name="birth_not_married_parents"
                        id="edit_not_married"
                    >

                </div>

            </div>

            <!-- ADOLESCENT MOTHER -->

            <h3>Adolescent Mother Records</h3>

            <div class="grid-2">

                <?php for($age = 10; $age <= 19; $age++) { ?>

                    <div class="form-group">

                        <label>Age <?= $age; ?></label>

                        <input
                            type="number"

                            name="adolescent[<?= $age; ?>]"

                            id="edit_adolescent_<?= $age; ?>"

                            value="0"
                        >

                    </div>

                <?php } ?>

            </div>

            <!-- MARRIAGE -->

            <h3>Marriage Statistics</h3>

            <div class="form-group">

                <label>Total Marriages</label>

                <input
                    type="number"
                    name="marriages"
                    id="edit_marriages"
                >

            </div>

            <!-- UPDATE BUTTON -->

            <button
                type="submit"
                name="update"
                class="save-btn"
            >
                Update Record
            </button>

        </form>

    </div>

</div>