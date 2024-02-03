
    function getGroups() {
        var selectedYear = document.getElementById("annee").value;
        var selectedgroupe = document.getElementById("selectedgroupe").innerHTML;
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Parse the JSON response
                var groups = JSON.parse(this.responseText);
                console.log(groups)

                // Update the options in the groupe select element
                var groupeSelect = document.getElementById("groupe");
                groupeSelect.innerHTML = "";

                for (var i = 0; i < groups.length; i++) {
                    if ((selectedgroupe)){
                        if (groups[i] == selectedgroupe){
                            var option = document.createElement("option");
                            option.value = groups[i];
                            option.text = groups[i];
                            option.selected = true;
                            groupeSelect.add(option);
                        }else{
                            var option = document.createElement("option");
                            option.value = groups[i];
                            option.text = groups[i];
                            groupeSelect.add(option);
                        }
                    }else{
                        var option = document.createElement("option");
                            option.value = groups[i];
                            option.text = groups[i];
                            groupeSelect.add(option);
                    }
                }
            }
        };

        // Send a GET request to the server with the selected year
        xhttp.open("GET", "./Php/getGroups.php?year=" + selectedYear, true);
        xhttp.send();
    }