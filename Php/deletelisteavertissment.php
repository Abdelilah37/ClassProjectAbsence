<?php
// Paths updated
session_start();
include('config.php');
include('userLogs.php');

if ($_SERVER["REQUEST_METHOD"] == 'GET' && isset($_GET["StagiaireCin"])) {
    $StagiaireCin  = $_GET["StagiaireCin"];

    $sql = "DELETE FROM avertissement WHERE StagiaireCin= ?";
    $stmt = $pdo_conn->prepare($sql);
    $stmt->bindValue(1, $StagiaireCin);
    $stmt->execute();

    $user = $_SESSION["username"];
    $action = 'supprimé avertissement de';
    log_action($user, $StagiaireCin, $action);
    header("Location: ../index.php?deleted=true");
    exit();

}

if ($_SERVER["REQUEST_METHOD"] == 'GET' && isset($_GET["code"]) && isset($_GET["cin"])) {
    $calculateNoteSql = "CALL CalculateStudentNote(?)";
    $stmtCalculateNote = $pdo_conn->prepare($calculateNoteSql);
    $stmtCalculateNote->bindParam(1, $cin);
    $stmtCalculateNote->execute();
    $code = $_GET["code"];
    $cin = $_GET["cin"];

    $sql = "DELETE FROM avertissement WHERE  code = ?";
    $stmt = $pdo_conn->prepare($sql);
    $stmt->bindValue(1, $code);
    $stmt->execute();

    $user = $_SESSION["username"];
    $action = 'supprimé avertissement de';
    log_action($user, $cin, $action);
    
    header("Location: ../profileStagiaire.php?cin=$cin&deleted=true");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == 'GET' && isset($_GET["id"]) && isset($_GET["cin"])) {
    $calculateNoteSql = "CALL CalculateStudentNote(?)";
    $stmtCalculateNote = $pdo_conn->prepare($calculateNoteSql);
    $id = $_GET["id"];
    $cin = $_GET["cin"];
    $sql = "DELETE FROM absence WHERE  AbsenceID = ?";
    $stmt = $pdo_conn->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();
    $stmtCalculateNote->bindParam(1, $cin);
    $stmtCalculateNote->execute();

    header("Location: ../profileStagiaire.php?cin=$cin&deletedAbsence=true");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == 'GET' && isset($_GET["cin"]) && isset($_GET['groupe'])) {
    $cin = filter_input(INPUT_GET, 'cin', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $sql = "DELETE FROM stagiaire WHERE cin = ?";
    $stmt = $pdo_conn->prepare($sql);
    $stmt->bindParam(1, $cin);
    $stmt->execute();

    
    $user = $_SESSION["username"];
    $action = 'supprimé le stagiaire';
    log_action($user, $cin, $action);

    // Use proper concatenation for the URL parameter
    $redirectUrl = "../listeNotesGroup.php?groupe=" . urlencode($_GET['groupe']);
    header("Location: $redirectUrl&deleted=true");
    exit();
}

?>