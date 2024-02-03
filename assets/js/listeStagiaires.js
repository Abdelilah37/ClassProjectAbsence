document.getElementById("datepicker").addEventListener("change", function() {
    var datepicker = document.getElementById("datepicker");
    var typeNumber = document.getElementById("typeNumber");
    var typetext = document.getElementById("typetext");
    var submit = document.getElementById("submit");

    if (datepicker.value !== "") {
        typeNumber.disabled = false;
        typetext.disabled = false;
        submit.disabled = false;
    } else {
        typeNumber.disabled = true;
        typetext.disabled = true;
        submit.disabled = true;
    }
});

