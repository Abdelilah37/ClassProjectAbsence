// adding a class depend on the avertissement type to add somme style from avertissement.css
let avertissementText = document.querySelectorAll(".avertissementText");
avertissementText.forEach((avertissement) => {
      if (
        avertissement.innerText === "Mise en garde 1" ||
        avertissement.innerText === "Mise en garde 2" ||
        avertissement.innerText === "Avertissement 1" ||
        avertissement.innerText === "Avertissement 2"
      ) {
        avertissement.classList.add("avertissement");
      } else if (
        avertissement.innerText === "Exclusion de 2 j (1)" ||
        avertissement.innerText === "Exclusion de 2 j (2)" ||
        avertissement.innerText === "Exclusion temporaire" ||
        avertissement.innerText === "Exclusion d�finitive" ||
        avertissement.innerText === "Exclusion définitive"
      ) {
        if(avertissement.innerText === "Exclusion d�finitive"){
          avertissement.innerHTML = "Exclusion définitive";
        }
        avertissement.classList.add("exclusion");
      } else if (avertissement.innerText === "Blame") {
        avertissement.classList.add("blame");
      }
});

      


