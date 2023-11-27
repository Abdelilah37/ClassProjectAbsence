<?php
// Include your database connection configuration
include('./Php/config.php');

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    // Validate and sanitize user input
    $searchTerm1 = filter_input(INPUT_POST, 'searchTerm1');

    if (!empty($searchTerm1)) {
        // Use a prepared statement to prevent SQL injection
        $sql = "SELECT * FROM deletedstagiaire WHERE nom LIKE ? OR prenom LIKE ? OR cin LIKE ?";
        $stmt = $pdo_conn->prepare($sql);

        // Bind parameters
        $searchPattern = "%$searchTerm1%";
        $stmt->bindParam(1, $searchPattern);
        $stmt->bindParam(2, $searchPattern);
        $stmt->bindParam(3, $searchPattern); // Assuming cin is an exact match

        try {
            $stmt->execute();
            $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $numResults = $stmt->rowCount();

            // Output search results or "No results found."
            if ($numResults > 0) {
                foreach ($searchResults as $result) {
                    // Use htmlspecialchars to prevent XSS attacks
                    $escapedCin = htmlspecialchars($result['cin'], ENT_QUOTES, 'UTF-8');
                    echo "<tr>";
                    echo "<td class='border-bottom fw-bold py-3 px-4'><span class='text-dark'>{$result['cin']}</span></td>";
                    echo "<td class='border-bottom fw-bold py-3 px-4'><span class='text-dark'>{$result['nom']} {$result['prenom']}</span><br>";
                    echo "<a href='./listeNotesGroup.php?groupe={$result['groupe']}' style='cursor:pointer'><span class='text-grey'>{$result['groupe']}</span></a></td>";
                    echo "<td class='border-bottom fw-bold py-3 px-4'><span class='text-dark'>{$result['date_deleted']}</span></td>";
                    echo "<td class='border-bottom fw-bold py-3 px-4'><span class='text-dark'>{$result['raison']}</span></td>";
                    echo "<td class='border-bottom py-3 px-4'><div class='d-flex align-items-center'>";
                    echo "<a href='./Php/restore.php?cin={$result['cin']}' name='restorAv'><button class='btn btn-link text-primary'>";
                    echo "<button class='btn btn-link text-primary'>";
                    echo "<svg xmlns='http://www.w3.org/2000/svg' height='1.3em' viewBox='0 0 512 512'><path d='M75 75L41 41C25.9 25.9 0 36.6 0 57.9V168c0 13.3 10.7 24 24 24H134.1c21.4 0
                        32.1-25.9 17-41l-30.8-30.8C155 85.5 203 64 256 64c106 0 192 86 192 192s-86 192-192
                        192c-40.8 0-78.6-12.7-109.7-34.4c-14.5-10.1-34.4-6.6-44.6 7.9s-6.6 34.4 7.9 44.6C151.2
                        495 201.7 512 256 512c141.4 0 256-114.6 256-256S397.4 0 256 0C185.3 0 121.3 28.7 75 75zm181
                        53c-13.3 0-24 10.7-24 24V256c0 6.4 2.5 12.5 7 17l72 72c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6
                        0-33.9l-65-65V152c0-13.3-10.7-24-24-24z' />";
                    echo "</svg>";
                    echo "</button></a>";
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo '<tr><td colspan="5">No results found.</td></tr>';
            }
        } catch (PDOException $e) {
            // Handle database errors
            echo '<tr><td colspan="5">Error retrieving search results.</td></tr>';
            error_log('PDOException: ' . $e->getMessage());
        }
    } else {
        echo '<tr><td colspan="5">Please enter a search term.</td></tr>';
    }
}
?>
