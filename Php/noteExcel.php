<?php
include('config.php');

require '../vendor/autoload.php'; 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['submit'])){
    if (isset($_GET['groupe'])) {
        $groupe = $_GET['groupe'];

        $sql = "SELECT
        s.cin AS StagiaireCin,
        s.nom AS StagiaireNom,
        s.prenom AS StagiairePrenom,
        s.noteDisciplinaire AS noteDisciplinaire,
        COALESCE(SUM(a.nbHeures), 0) AS TotalNbHeures,
        COALESCE(av.nbrAvertis, 0) AS TotalAvertissements
        FROM stagiaire s
        LEFT JOIN absence a ON s.cin = a.StagiaireCin
        LEFT JOIN avertissement av ON s.cin = av.StagiaireCin
        WHERE s.groupe = ? 
        GROUP BY
        s.cin, s.nom, s.prenom, s.noteDisciplinaire, av.nbrAvertis;";
        $stmt =  $pdo_conn->prepare($sql);
        $stmt->bindParam(1, $groupe);
        $stmt->execute();
        $stagiaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();
    
        $worksheet->setCellValue('A1', 'CIN');
        $worksheet->setCellValue('B1', 'Nom');
        $worksheet->setCellValue('C1', 'Prenom');
        $worksheet->setCellValue('D1', 'Nombre Absence');
        $worksheet->setCellValue('E1', 'Avertissement');
        $worksheet->setCellValue('F1', 'Note Disciplinaire');
    
        $row = 2;
        foreach ($stagiaires as $stagiaire) {
            $worksheet->setCellValue('A' . $row, $stagiaire['StagiaireCin']);
            $worksheet->setCellValue('B' . $row, $stagiaire['StagiaireNom']);
            $worksheet->setCellValue('C' . $row, $stagiaire['StagiairePrenom']);
            $worksheet->setCellValue('D' . $row, $stagiaire['TotalNbHeures']);
            $worksheet->setCellValue('E' . $row, $stagiaire['TotalAvertissements']);
            $worksheet->setCellValue('F' . $row, $stagiaire['noteDisciplinaire']);
    
            $row++;
        }
    
        $filename = 'liste_stagiaires_' . $groupe . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        //header("Location: ../listeNotesGroup.php?groupe=" . urlencode($groupe));
        exit();

    }
}
?>