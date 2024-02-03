<?php
// Paths updated

function log_action($user, $stagiaireCin, $action) {
    include('config.php');
    $sql = "INSERT INTO logs (Username, StagiaireCin, Action) VALUES (?, ?, ?)";
    $stmt = $pdo_conn->prepare($sql);
    $stmt->execute([$user, $stagiaireCin, $action]);
}
?>