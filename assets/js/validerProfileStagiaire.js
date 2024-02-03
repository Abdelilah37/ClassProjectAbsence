let nomStagiair = document.getElementById("nomStagiair");
let prenomStagiaire = document.getElementById("prenomStagiaire");
let noteDisiplinaireStagiaire = document.getElementById(
  "noteDisiplinaireStagiaire"
);

let NbrHeures = document.getElementById("NbrHeures");

function isValide() {
  let isvalideNom = valideNom();
  let isvalidePrenom = validePrenom();
  let isValidNote = valideNote();

  if (isvalideNom == false || isvalidePrenom == false) {
    toastr["error"](
      "Le format du nom est invalide !! ou le format du prénom est invalide !!",
      "Stagiaire non modifié"
    );

    return false;
  } else if (isValidNote == false) {
    toastr["error"]("La note est invalide !!.", "Stagiaire non ajouté !");

    return false;
  }
}

function valideNom() {
  let nom = nomStagiair.value;

  if (
    nom.length < 2 ||
    nom.trim() == "" ||
    nom.includes("0") ||
    nom.includes("1") ||
    nom.includes("2") ||
    nom.includes("3") ||
    nom.includes("4") ||
    nom.includes("5") ||
    nom.includes("6") ||
    nom.includes("7") ||
    nom.includes("8") ||
    nom.includes("9")
  ) {
    return false;
  }
}
function validePrenom() {
  let prenom = prenomStagiaire.value;

  if (
    prenom.length < 2 ||
    prenom.trim() == "" ||
    prenom.includes("0") ||
    prenom.includes("1") ||
    prenom.includes("2") ||
    prenom.includes("3") ||
    prenom.includes("4") ||
    prenom.includes("5") ||
    prenom.includes("6") ||
    prenom.includes("7") ||
    prenom.includes("8") ||
    prenom.includes("9")
  ) {
    return false;
  }
}

function valideNote() {
  let note = noteDisiplinaireStagiaire.value;
  if (!isNaN(note)) {
    if (note > 20 || note <= 0) {
      return false;
    }
  }
}
