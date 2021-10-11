function addDescription() {
    var descripButton = document.getElementById("more_description");
    var description = document.getElementById("description");

    if (description.style.display == "inline") {
        descripButton.innerHTML = "More Description";
        description.style.display = "none";
    }
    else {
        descripButton.innerHTML = "Less Description";
        description.style.display = "inline";
    }
}