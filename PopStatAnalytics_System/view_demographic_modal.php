<div class="modal" id="viewModal">

    <div class="modal-content">

        <span
            class="close-btn"
            onclick="closeViewModal()"
        >
            &times;
        </span>

        <h2>Demographic Record</h2>

        <div class="view-grid">

            <p>
                <strong>Municipality:</strong>
                <span id="view_municipality"></span>
            </p>

            <p>
                <strong>Month:</strong>
                <span id="view_month"></span>
            </p>

            <p>
                <strong>Year:</strong>
                <span id="view_year"></span>
            </p>

        </div>

        <hr>

        <h3>Death Statistics</h3>

        <p>
            Male:
            <span id="view_male_death"></span>
        </p>

        <p>
            Female:
            <span id="view_female_death"></span>
        </p>

        <h3>Birth Statistics</h3>

        <p>
            On Date Male:
            <span id="view_birth_on_date_male"></span>
        </p>

        <p>
            On Date Female:
            <span id="view_birth_on_date_female"></span>
        </p>

        <p>
            Late Male:
            <span id="view_birth_late_male"></span>
        </p>

        <p>
            Late Female:
            <span id="view_birth_late_female"></span>
        </p>

        <p>
            Married Parents:
            <span id="view_married"></span>
        </p>

        <p>
            Not Married Parents:
            <span id="view_not_married"></span>
        </p>

        <h3>Adolescent Pregnancy</h3>

        <p>
            Total Cases:
            <span id="view_adolescent"></span>
        </p>

        <div id="view_adolescent_breakdown">

        </div>

        <h3>Marriage Statistics</h3>

        <p>
            Total Marriages:
            <span id="view_marriages"></span>
        </p>

    </div>

</div>