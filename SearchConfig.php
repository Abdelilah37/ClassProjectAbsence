<?php
include('./Php/config.php');

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $searchTerm = filter_input(INPUT_POST, 'searchTerm');

    if (!empty($searchTerm)) {
        $searchTermsArray = explode(' ', $searchTerm);

        // Combine all words in the search term as the last name
        $nom = implode(' ', $searchTermsArray);
    
        $sql = "SELECT * FROM stagiaire 
                WHERE (CONCAT(nom, ' ', prenom) LIKE ? OR cin LIKE ?)
                LIMIT 8";
        $stmt = $pdo_conn->prepare($sql);
    
        $searchPatternFullName = "%$nom%";
        $searchPatternCin = "%$searchTerm%";
    
        $stmt->bindParam(1, $searchPatternFullName);
        $stmt->bindParam(2, $searchPatternCin);

        try {
            $stmt->execute();
            $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $numResults = $stmt->rowCount();

            if ($numResults > 0) {

                foreach ($searchResults as $result) {
                    $escapedCin = htmlspecialchars($result['cin'], ENT_QUOTES, 'UTF-8');
                    $resultHtml = "<a href='./profileStagiaire.php?cin={$escapedCin}' data-cin='{$escapedCin}'>{$result['nom']} {$result['prenom']} (CIN: {$escapedCin})</a><hr>";
                    echo $resultHtml;
                }
            } else {
                echo '<p>Aucun résultat trouvé.</p>';
            }
        } catch (PDOException $e) {
            echo '<p>Error retrieving search results.</p>';
            error_log('PDOException: ' . $e->getMessage());
        }
    } else {
        echo '<p>Please enter a search term.</p>';
    }
}
