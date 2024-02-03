<?php
// Paths updated
session_start();
include('./config.php');
include('userLogs.php');
if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST["submit"])) {
  $cin = $_GET['cin'];


  // filtrer les type de donner;
  $nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_STRING);
  $prenom = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_STRING);
  $groupe = filter_input(INPUT_POST, "groupe", FILTER_SANITIZE_STRING);
  $Niveau = filter_input(INPUT_POST, "annee", FILTER_SANITIZE_STRING);
  $dateNaissance = filter_input(INPUT_POST, "dateNaissance");
  $noteDisciplinaire = filter_input(INPUT_POST, "noteDisciplinaire",FILTER_SANITIZE_NUMBER_FLOAT,
  FILTER_FLAG_ALLOW_FRACTION);

  $configNomPrenomMessage = "";

  if (strlen($nom) >= 49 || strlen($prenom) >= 49) { // determiner la longueur de nom et prenom si depasse 49 afficher le message ."la longueur de nom au prenom!!";
    $configNomPrenomMessage = "la longueur de nom au prenom!!";

    header("Location: ../profileStagiaire.php?cin=$cin&configNomPrenomMessage=$configNomPrenomMessage&updated=false");
    exit();
  } // fin de determiner la longueur;
  else {
    if (!preg_match("#^[a-z A-Z]+$#", $nom) || !preg_match("#^[a-z A-Z]+$#", $prenom)) { // determiner la forma de nom et prenom;

      $configNomPrenomMessage = "le forma de nom invalide !! ou le forma de prenom invalide !!";

      header("Location: ../profileStagiaire.php?cin=$cin&configNomPrenomMessage=$configNomPrenomMessage&updated=false");
      exit();
    } // finde determiner la forma;
    else {
      
      if (empty($noteDisciplinaire)) { // tester le champe de noteDisciplinaire si vide ou no;
        $configNomPrenomMessage = "note vide !!";

        header("Location: ../profileStagiaire.php?cin=$cin&configNomPrenomMessage=$configNomPrenomMessage&updated=false");
        exit();
      } // fine de tester le champe de noteDisciplinaire si vide ou no;
      else {


        if (!is_numeric($noteDisciplinaire) || $noteDisciplinaire <1 || $noteDisciplinaire > 20) { // determiner la forma de champes noteDisciplinaire;
          $configNomPrenomMessage = "note invalide";
          header("Location: ../profileStagiaire.php?cin=$cin&configNomPrenomMessage=$configNomPrenomMessage&updated=false");
          exit();
        } // finde determiner la forma de champes noteDisciplinaire;
        else {

          $sql = "UPDATE stagiaire SET nom = ? , prenom = ?, groupe= ?,Niveau=?, dateNaissance=?, noteDisciplinaire= ?   WHERE cin = ?";
          $stmt = $pdo_conn->prepare($sql);
          $stmt->bindParam(1, $nom);
          $stmt->bindParam(2, $prenom);
          $stmt->bindParam(3, $groupe);
          $stmt->bindParam(4, $Niveau);
          $stmt->bindParam(5, $dateNaissance);
          $stmt->bindParam(6, $noteDisciplinaire);
          $stmt->bindParam(7, $cin);
          $stmt->execute();

          $user = $_SESSION["username"];
          $action = 'mis à jour le stagiaire';
          log_action($user, $cin, $action);

          header("Location: ../profileStagiaire.php?cin=$cin&updated=true");
          exit();
        }
      }
    }
  }
}
