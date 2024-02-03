<?php
// Paths updated
include('./Php/sideBar.php');
include('./Php/session.php');
try {
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
        s.cin, s.nom, s.prenom, s.noteDisciplinaire, av.nbrAvertis;"; // Include av.nbrAvertis in GROUP BY
        $stmt =  $pdo_conn->prepare($sql);
        $stmt->bindParam(1, $groupe);
        $stmt->execute();
        $stagiaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $numStagiaires = $stmt->rowCount();

        if ($stmt->rowCount() > 0) {
            $numStagiaires = $stmt->rowCount();


?>
            <!doctype html>
            <html lang="en">

            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>Ofppt WFS205</title>
                <?php include('styles.php') ?>

            </head>

            <body>
                <div class="preloader">
                    <img src="./assets/images/Icons/loader-2.svg" alt="loader" class="lds-ripple img-fluid" />
                </div>
                <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
                    <!-- SIDEBAR AND NAVBAR  -->
                    <?php include("SIDE&NAV.php") ?>
                    <!--  Main CONTENT -->
                    <div class="container-fluid ">
                        <div class="row">
                            <div class="col-lg-12 mb-3 d-flex align-content-center justify-content-between  printablediv" style="width: -moz-available;width: -webkit-fill-available;">
                                <h6 class="card-title lh-lg text-dark">Liste Des Stagiaires</h6>
                                <h6 class="card-title lh-lg text-dark"><?php echo $groupe ?></h6>
                                <h6 class="card-title lh-lg text-dark">Nombres Stagiaires: <?php echo $numStagiaires ?></h6>


                                <div class="text-center bg-dark rounded-pill align-self-center d-flex flex-nowrap flex-row gap-0 do-not-print" style="transform: scale(0.9);">
                                    <a style="width: 80px;" class="nav-link p-1 border border-dark border-4 btnInactive rounded-start-pill fw-bold" href="./listeStagiaire.php?<?php echo http_build_query(['groupe' => $groupe]); ?>">
                                        Absence
                                    </a>
                                    <a style="width: 80px;" class="nav-link p-1 border border-dark border-4 btnActive rounded-end-pill fw-bold" href="./listeNotesGroup.php?<?php echo http_build_query(['groupe' => $groupe]); ?>">
                                        Infos
                                    </a>
                                </div>

                            </div>
                        </div>

                        <div class="row shadow-xsm bg-body rounded ">
                            <div class="table-container hide-scroll">
                                <form action="#">
                                    <table class="table table-hover align-middle text-center printablediv">
                                        <thead class="bg-gray-2 text-left  fixed-thead">
                                            <tr class="align-middle">
                                                <th scope="min-width-220 py-3 px-4 font-weight-medium">CIN</th>
                                                <th scope="min-width-220 py-3 px-4 font-weight-medium">Nom</th>
                                                <th scope="min-width-220 py-3 px-4 font-weight-medium">Prenom</th>
                                                <th scope="min-width-220 py-3 px-4 font-weight-medium">Nombre Absence</th>
                                                <th scope="min-width-220 py-3 px-4 font-weight-medium">Avertissement</th>
                                                <th scope="min-width-220 py-3 px-4 font-weight-medium">Note Disciplinire</th>
                                                <th scope="min-width-220 py-3 px-4 font-weight-medium" class="do-not-print">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody style="height: 300px; overflow-y: auto;">
                                            <?php foreach ($stagiaires as $stagiaire) : ?>
                                                <tr class="fw-bold align-items-center">
                                                    <th scope="row" name="cin"><?php echo $stagiaire['StagiaireCin'] ?></th>
                                                    <td><?php echo $stagiaire['StagiaireNom'] ?></td>
                                                    <td><?php echo $stagiaire['StagiairePrenom'] ?></td>
                                                    <td><?php echo $stagiaire['TotalNbHeures'] ?> Hr</td>
                                                    <td><?php echo $stagiaire['TotalAvertissements'] ?></td>
                                                    <td><?php echo $stagiaire['noteDisciplinaire'] ?></td>
                                                    <td class="do-not-print">
                                                        <a href="./profileStagiaire.php?<?php echo http_build_query(['cin' => htmlspecialchars($stagiaire['StagiaireCin'], ENT_QUOTES, 'UTF-8')]); ?>" class="button Profile">Profile</a>
                                                        <a class="button  delt click" onclick="confirmDeletionStagiaire('<?php echo $stagiaire['StagiaireCin']; ?>', '<?php echo $groupe; ?>')">Supprimer</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    </form>
                                    <form action="./Php/noteExcel.php?groupe=<?php echo $groupe ?>" method="post">
                                        <button type="submit" name="submit">
                                        <div class="fixed-bottom d-flex justify-content-end mb-3 px-4">
                                            <span class="ImprimerBtn cursor-pointer bg-info d-flex justify-content-center align-items-center rounded-circle" style="width: 40px;height:40px;" ">
                                                <i class="ti ti-file-download" style="color: #fff;font-size:25px;"></i>
                                            </span>
                                        </div>
                                        </button>
                                    </form>
                            </div>
                        </div>

                        <!-- footer
            <?php // include('FOOTER.php') 
            ?> -->
                    </div>
                </div>
                </div>

                <?php include('scripts.php') ?>
                <script>
                    function confirmDeletionStagiaire(cin, groupe) {

                        Swal.fire({
                            title: "Ce stagiaire sera supprimé.",
                            text: "vous pouvez toujours le restaurer depuis votre profil",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Oui, supprimez-le.",
                            cancelButtonText: "Annuler",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "./Php/deletelisteavertissment.php?cin=" + encodeURIComponent(cin) + "&groupe=" + encodeURIComponent(groupe);
                            }
                        });
                    }
                </script>

                <?php
                if (isset($_GET["deleted"]) && $_GET["deleted"] == "true") {
                    echo "<script>
                    Swal.fire({
                        title: 'Stagiaire Supprimé!',
                        text: 'Visitez Éléments Supprimés pour restaurer',
                        icon: 'success'
                    });
                    </script>";
                }
                ?>
            </body>

            </html>
<?php
        } else {
            $errorMessage = "Aucune donnée trouvée pour le groupe spécifié.";
            header("Location: error-page.php?error=" . urlencode($errorMessage));
            exit();
        }
    } else {
        $errorMessage = "Paramètre de groupe invalide ou manquant.";
        header("Location: error-page.php?error=" . urlencode($errorMessage));
        exit();
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    header("Location: error-page.php?error=" . urlencode($errorMessage));
    exit();
}
?>