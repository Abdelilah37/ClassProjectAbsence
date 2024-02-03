<?php
// Paths updated
session_start();
include('config.php');
include('userLogs.php');

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST["submit"])) {
    try {
        $sql = "INSERT INTO `stagiaire` (`cin`, `nom`, `prenom`, `Niveau`, `groupe`, `dateNaissance`, `NTelephone`, `noteDisciplinaire`) 
        VALUES (?,?,?,?,?,?,?,?);";
        $stmt = $pdo_conn->prepare($sql);

        $cin = filter_input(INPUT_POST, "cin", FILTER_SANITIZE_STRING);

        $nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_STRING);

        $prenom = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_STRING);

        $annee = filter_input(INPUT_POST, "annee", FILTER_SANITIZE_STRING);

        $tele = filter_input(INPUT_POST, "tele", FILTER_SANITIZE_STRING);

        $groupe = $_POST['groupe'];
        $date = filter_input(INPUT_POST, "date");
        $note = filter_input(INPUT_POST, "note",FILTER_SANITIZE_NUMBER_FLOAT,
        FILTER_FLAG_ALLOW_FRACTION);

        $checkGroupSql = "SELECT COUNT(*) FROM `stagiaire` WHERE `groupe` = ?";
        $checkGroupStmt = $pdo_conn->prepare($checkGroupSql);
        $checkGroupStmt->bindParam(1, $groupe);
        $checkGroupStmt->execute();
        $groupExists = $checkGroupStmt->fetchColumn();

        if (!empty($nom) && !empty($prenom) && !empty($cin)) {
            if ($groupExists != 0) {
                $stmt->bindParam(1, $cin);
                $stmt->bindParam(2, $nom);
                $stmt->bindParam(3, $prenom);
                $stmt->bindParam(4, $annee);
                $stmt->bindParam(5, $groupe);
                $stmt->bindParam(6, $date);
                $stmt->bindParam(7, $tele);
                $stmt->bindParam(8, $note);
                $stmt->execute();

                $user = $_SESSION["username"];
                $action = 'ajouté le stagiaire';
                log_action($user, $cin, $action);
            }
            else {
                throw new Exception("Group does not exist.");
            }

            header("Location: ../profile.php?ajouter=true");
            exit();
        }
    } catch (Exception $e) {
      header("Location: ../profile.php?error=true");
      exit();}
}


?>
