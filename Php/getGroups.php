<?php
// Paths updated
include('config.php');

$selectedYear = $_GET['year'];

// Use a prepared statement to prevent SQL injection
$sql = "SELECT DISTINCT groupe AS trimmed_group
FROM `stagiaire`
WHERE Niveau = :year
ORDER BY trimmed_group ASC;";
$stmt = $pdo_conn->prepare($sql);
$stmt->bindParam(':year', $selectedYear);
$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Return the groups as JSON
echo json_encode($groups);
?>
