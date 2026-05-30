/* =========================
   ADD MODAL
========================= */

const addModal =
    document.getElementById("dataModal");

const openAddBtn =
    document.getElementById("openModal");

const closeAddBtn =
    document.getElementById("closeModal");

/* OPEN ADD MODAL */

if(openAddBtn){

    openAddBtn.onclick = () => {

        addModal.style.display = "block";

    };

}

/* CLOSE ADD MODAL */

if(closeAddBtn){

    closeAddBtn.onclick = () => {

        addModal.style.display = "none";

    };

}

/* =========================
   EDIT MODAL
========================= */

function openEditModal(

    id,
    municipality,
    month,
    year,

    maleDeath,
    femaleDeath,

    onDateMale,
    onDateFemale,

    lateMale,
    lateFemale,

    married,
    notMarried,

    adolescentData,

    marriages

){

    document.getElementById(
        "editModal"
    ).style.display = "block";

    document.getElementById(
        "edit_dedaID"
    ).value = id;

    document.getElementById(
        "edit_municipality"
    ).value = municipality;

    document.getElementById(
        "edit_month"
    ).value = month;

    document.getElementById(
        "edit_year"
    ).value = year;

    document.getElementById(
        "edit_male_death"
    ).value = maleDeath;

    document.getElementById(
        "edit_female_death"
    ).value = femaleDeath;

    document.getElementById(
        "edit_birth_on_date_male"
    ).value = onDateMale;

    document.getElementById(
        "edit_birth_on_date_female"
    ).value = onDateFemale;

    document.getElementById(
        "edit_birth_late_male"
    ).value = lateMale;

    document.getElementById(
        "edit_birth_late_female"
    ).value = lateFemale;

    document.getElementById(
        "edit_married"
    ).value = married;

    document.getElementById(
        "edit_not_married"
    ).value = notMarried;

    if(adolescentData){

    let adolescent =
        JSON.parse(adolescentData);

    for(let age in adolescent){

        let input =
            document.getElementById(
                "edit_adolescent_" + age
            );

        if(input){

            input.value =
                adolescent[age];

        }

    }

}

    document.getElementById(
        "edit_marriages"
    ).value = marriages;

}

/* CLOSE EDIT MODAL */

function closeEditModal(){

    document.getElementById(
        "editModal"
    ).style.display = "none";

}

/* =========================
   CLOSE WHEN CLICK OUTSIDE
========================= */

window.onclick = function(event){

    if(event.target == addModal){

        addModal.style.display = "none";

    }

    if(
        event.target ==
        document.getElementById("editModal")
    ){

        document.getElementById(
            "editModal"
        ).style.display = "none";

    }

}

/* =========================
   SEARCH FILTERS
========================= */

const municipalitySearch =
    document.getElementById(
        "municipalitySearch"
    );

const monthFilter =
    document.getElementById(
        "monthFilter"
    );

const yearFilter =
    document.getElementById(
        "yearFilter"
    );

const rows =
    document.querySelectorAll(
        "#recordsTable tbody tr"
    );

function filterTable(){

    let municipalityValue =
        municipalitySearch.value.toLowerCase();

    let monthValue =
        monthFilter.value.toLowerCase();

    let yearValue =
        yearFilter.value.toLowerCase();

    rows.forEach(row => {

        let municipality =
            row.cells[0].innerText.toLowerCase();

        let month =
            row.cells[1].innerText.toLowerCase();

        let year =
            row.cells[2].innerText.toLowerCase();

        let municipalityMatch =
            municipality.includes(
                municipalityValue
            );

        let monthMatch =
            month.includes(monthValue);

        let yearMatch =
            year.includes(yearValue);

        if(
            municipalityMatch &&
            monthMatch &&
            yearMatch
        ){

            row.style.display = "";

        }
        else{

            row.style.display = "none";

        }

    });

}

/* EVENT LISTENERS */

if(municipalitySearch){

    municipalitySearch.addEventListener(
        "keyup",
        filterTable
    );

}

if(monthFilter){

    monthFilter.addEventListener(
        "change",
        filterTable
    );

}

if(yearFilter){

    yearFilter.addEventListener(
        "keyup",
        filterTable
    );

}