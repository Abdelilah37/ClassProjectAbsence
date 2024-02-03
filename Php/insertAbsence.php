<?php
// Paths updated
include('./config.php');

/* from profile */
if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST["submit1"])) {
  $cin = $_GET['cin'];
  $date = $_POST["date"];
  $Distance = isset($_POST["Distance"]) ? $_POST['Distance'] : NULL;
  $nbHeures = filter_input(INPUT_POST, "nbHeures", FILTER_SANITIZE_NUMBER_INT);
  $justification = filter_input(INPUT_POST, "justification", FILTER_SANITIZE_STRING);
  $justification = empty($justification) ? null : $justification;

  $calculateNoteSql = "CALL CalculateStudentNote(?)";
  $stmtCalculateNote = $pdo_conn->prepare($calculateNoteSql);

  // var_dump($_POST);
  $configNbHeures = "";
  if (!preg_match("#^[0-9]$#", $nbHeures) && !preg_match("#^[0-9][0-9]$#", $nbHeures) && !preg_match("#^[0-9][0-9][0-9]$#", $nbHeures) || $nbHeures <=0) { // determiner la forma de nombre d'heures est nombre d'heureus >0;
    $configNbHeures = "nombre d'heures ivalide";

    header("Location: ../profileStagiaire.php?cin=$cin&configNbHeures=$configNbHeures&insertAbs=false");
    exit();
  } // fine de determiner la forma de nombre d'heures est nombre d'heureus >0;
  else {


    $sql = "INSERT INTO `absence` (`AbsenceID`, `StagiaireCin`, `date`, `nbHeures`, `distance`, `justification`) VALUES (NULL, ?, ?, ?, ?, ?)";
    $stmt = $pdo_conn->prepare($sql);
    if (!empty($date) && !empty($nbHeures)) {
      $stmt->bindParam(1, $cin);
      $stmt->bindParam(2, $date);
      $stmt->bindParam(3, $nbHeures);
      $stmt->bindParam(4, $Distance);
      $stmt->bindParam(5, $justification);
      $stmt->execute();

      $stmtCalculateNote->bindParam(1, $cin);
      $stmtCalculateNote->execute();
      $result = $stmtCalculateNote->fetch(PDO::FETCH_ASSOC);
      header("Location: ../profileStagiaire.php?cin=$cin&insertAbs=true");
      exit();
    }
  }
}
?>