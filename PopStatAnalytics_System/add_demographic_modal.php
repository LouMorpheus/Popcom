<!-- MODAL -->

<div class="modal" id="dataModal">

    <div class="modal-content">

        <span class="close-btn" id="closeModal">&times;</span>

        <h2>Add Demographic Data</h2>

        <form action="save.php" method="POST">

            <!-- MUNICIPALITY -->

            <div class="form-group">

                <label>Municipality</label>

                <select name="municipality_id" required>

                    <option value="">Select Municipality</option>

                    <?php

                    $query = mysqli_query($conn, "SELECT * FROM municipalities");

                    while($row = mysqli_fetch_assoc($query)){

                    ?>

                        <option value="<?= $row['municipality_id']; ?>">
                            <?= $row['mun_name']; ?>
                        </option>

                    <?php } ?>

                </select>

            </div>

            <!-- MONTH -->

            <div class="grid-2">

                <div class="form-group">

                    <label>Month</label>

                    <select name="record_month" required>

                        <option value="">Select Month</option>

                        <?php

                        for($m = 1; $m <= 12; $m++){

                            echo "<option value='$m'>"
                                . date('F', mktime(0,0,0,$m,1))
                                . "</option>";

                        }

                        ?>

                    </select>

                </div>

                <div class="form-group">

                    <label>Year</label>

                    <input
                        type="number"
                        name="record_year"
                        value="<?= date('Y'); ?>"
                        required
                    >

                </div>

            </div>

            <!-- DEATH -->

            <h3>Death Statistics</h3>

            <div class="grid-2">

                <div class="form-group">
                    <label>Male Death</label>
                    <input type="number" name="male_death" value="">
                </div>

                <div class="form-group">
                    <label>Female Death</label>
                    <input type="number" name="female_death" value="">
                </div>

            </div>

            <!-- BIRTH ON DATE -->

            <h3>Birth On Date</h3>

            <div class="grid-2">

                <div class="form-group">
                    <label>Male</label>
                    <input type="number" name="birth_on_date_male" value="">
                </div>

                <div class="form-group">
                    <label>Female</label>
                    <input type="number" name="birth_on_date_female" value="">
                </div>

            </div>

            <!-- BIRTH LATE -->

            <h3>Late Registration</h3>

            <div class="grid-2">

                <div class="form-group">
                    <label>Male</label>
                    <input type="number" name="birth_late_male" value="">
                </div>

                <div class="form-group">
                    <label>Female</label>
                    <input type="number" name="birth_late_female" value="">
                </div>

            </div>

            <!-- PARENTS -->

            <h3>Parents Status</h3>

            <div class="grid-2">

                <div class="form-group">
                    <label>Married Parents</label>
                    <input type="number" name="birth_married_parents" value="">
                </div>

                <div class="form-group">
                    <label>Not Married Parents</label>
                    <input type="number" name="birth_not_married_parents" value="">
                </div>

            </div>

            <!-- ADOLESCENT -->

            <h3>Adolescent Mother Records</h3>

            <div class="grid-2">

                <?php for($age = 10; $age <= 19; $age++) { ?>

                    <div class="form-group">

                        <label>Age <?= $age; ?></label>

                        <input
                            type="number"
                            name="adolescent[<?= $age; ?>]"
                            value=""
                        >

                    </div>

                <?php } ?>

            </div>

            <!-- MARRIAGE -->

            <h3>Marriage Statistics</h3>

            <div class="form-group">

                <label>Number of Marriages</label>

                <input
                    type="number"
                    name="marriages"
                    value=""
                >

            </div>

            <button type="submit" class="save-btn">
                Save Data
            </button>

        </form>

    </div>

</div>

<!-- JAVASCRIPT -->

<script>

    const modal = document.getElementById("dataModal");
    const openBtn = document.getElementById("openModal");
    const closeBtn = document.getElementById("closeModal");

    openBtn.onclick = () => {
        modal.style.display = "block";
    }

    closeBtn.onclick = () => {
        modal.style.display = "none";
    }

    window.onclick = (e) => {
        if(e.target == modal){
            modal.style.display = "none";
        }
    }

</script>