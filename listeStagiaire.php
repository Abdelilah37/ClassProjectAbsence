<?php
// Paths updated
include('./Php/sideBar.php');
include('./Php/session.php');
try {
  if (isset($_GET['groupe'])) {
    $groupe = $_GET['groupe'];
    $sql = "SELECT * FROM stagiaire WHERE groupe = ? ";
    $stmt =  $pdo_conn->prepare($sql);
    $stmt->bindParam(1, $groupe);
    $stmt->execute();
    $stagiaires = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if ($stmt->rowCount() > 0) {
      $numStagiaires = $stmt->rowCount();

      if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        $groupe = $_GET['groupe'];
        $sql = "INSERT INTO `absence` (`AbsenceID`, `StagiaireCin`, `date`, `nbHeures`,`distance`, `justification`) VALUES (NULL, ?, ?, ?, ?, ?)";
        $stmt = $pdo_conn->prepare($sql);

        $calculateNoteSql = "CALL CalculateStudentNote(?)";
        $stmtCalculateNote = $pdo_conn->prepare($calculateNoteSql);

        foreach ($stagiaires as $stagiaire) {
          $cin = $stagiaire['cin'];
          $groupe = $stagiaire['groupe'];
          if (isset($_POST["submit_$cin"])) {
            $date = $_POST['date_' . $cin];
            $nbHeures = $_POST['nbHeures_' . $cin];
            $Distance = isset($_POST['Distance_' . $cin]) ? $_POST['Distance_' . $cin] : NULL;
            $justification = filter_input(INPUT_POST, "justification_" . $cin, FILTER_SANITIZE_STRING);
            $justification = empty($justification) ? null : $justification;

            if (!empty($date) && !empty($nbHeures)) {
              $stmt->bindParam(1, $cin);
              $stmt->bindParam(2, $date);
              $stmt->bindParam(3, $nbHeures);
              $stmt->bindParam(4, $Distance);
              $stmt->bindParam(5, $justification);
              $stmt->execute();

              $stmtCalculateNote->bindParam(1, $cin);
              $stmtCalculateNote->execute();

              header("Location: ./listeStagiaire.php?groupe=$groupe&insert=true");
              exit();
            }
          }
        }
      }

      /* var_dump($_POST); */

?>

      <!doctype html>
      <html lang="en">

      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ofppt WFS205</title>
        <link rel="stylesheet" href="./assets/css/print.css">
        <?php include('styles.php') ?>
      </head>

      <body>
        <div class="preloader" >
          <img src="./assets/images/Icons/loader-2.svg" alt="loader" class="lds-ripple img-fluid" />
        </div>
        <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
          <!-- SIDEBAR AND NAVBAR  -->
          <?php include("SIDE&NAV.php") ?>
          <!--  Main CONTENT -->

          <div class="container-fluid ">
            <div class="row">
              <div class="col-lg-12 mb-3 d-flex align-content-center justify-content-between" style="width: -webkit-fill-available;width: -moz-available;">
                <h6 class="card-title lh-lg text-dark">Liste Des Stagiaires</h6>
                <h6 class="card-title lh-lg text-dark"><?php echo $groupe ?></h6>
                <h6 class="card-title lh-lg text-dark">Nombres Stagiaires: <?php echo $numStagiaires ?></h6>

                <div class="text-center bg-dark rounded-pill align-self-center d-flex flex-nowrap flex-row gap-0 do-not-print" style="transform: scale(0.9);">
                  <a style="width: 80px;" class="nav-link p-1 border border-dark border-4 btnActive rounded-start-pill fw-bold" href="./listeStagiaire.php?<?php echo http_build_query(['groupe' => $groupe]); ?>">
                    Absence
                  </a>
                  <a style="width: 80px;" class="nav-link p-1 border border-dark border-4 btnInactive rounded-end-pill fw-bold" href="./listeNotesGroup.php?<?php echo http_build_query(['groupe' => $groupe]); ?>">
                    Infos
                  </a>
                </div>
              </div>

              <div class="row shadow-xsm bg-body rounded ">
                <div class="table-container hide-scroll">
                  <table class="table table-hover align-middle text-center">
                    <thead class="bg-gray-2 text-left fixed-thead">
                      <tr class="align-middle">
                        <th scope="min-width-220 py-3 px-4 font-weight-medium">CIN</th>
                        <th scope="min-width-220 py-3 px-4 font-weight-medium">Nom</th>
                        <th scope="min-width-220 py-3 px-4 font-weight-medium">Prenom</th>
                        <th scope="min-width-220 py-3 px-4 font-weight-medium">Date Absence</th>
                        <th scope="min-width-220 py-3 px-4 font-weight-medium">Nombre Heures</th>
                        <th scope="min-width-220 py-3 px-4 font-weight-medium">Justification</th>
                        <th scope="min-width-220 py-3 px-4 font-weight-medium">Distance</th>
                        <th scope="min-width-220 py-3 px-4 font-weight-medium">Action</th>
                      </tr>
                    </thead>
                    <tbody class="" style="height: 300px; overflow-y: auto;">
                      <?php foreach ($stagiaires as $stagiaire) : ?>
                        <form action="./listeStagiaire.php?groupe=<?php echo $stagiaire['groupe'] ?>" method="post">
                          <tr class="font-weight-bold  align-items-center">
                            <th scope="row" name="cin"><?php echo $stagiaire['cin'] ?></th>
                            <td><?php echo $stagiaire['nom'] ?></td>
                            <td><?php echo $stagiaire['prenom'] ?></td>
                            <td>
                              <?php
                              $currentDate = date('Y-m-d');
                              echo '<input required type="date" id="datepicker" name="date_' . $stagiaire['cin'] . '" class="ipt" value="' . $currentDate . '">';
                              ?>
                            </td>
                            <td><input required min="0" type="number" id="typeNumber" name="nbHeures_<?php echo $stagiaire['cin'] ?>" class=" ipt enable" /></td>
                            <td><input min="0" type="text" id="typetext" name="justification_<?php echo $stagiaire['cin'] ?>" class="ipt enable" /></td>
                            <td><input min="0" type="checkbox" id="flexCheckDefault" name="Distance_<?php echo $stagiaire['cin'] ?>" class="form-check-input" /></td>
                            <td>
                              <a href="./profileStagiaire.php?cin=<?php echo $stagiaire['cin'] ?>" class="button Profile">Profile</a>
                              <button type="submit" id="submit" name="submit_<?php echo $stagiaire['cin'] ?>" class="button Submit">Submit</button>
                            </td>
                          </tr>
                        </form>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                  </form>
                </div>
              </div>
            </div>

            <!-- footer
            <?php // include('FOOTER.php') 
            ?> -->
          </div>
        </div>
        <?php include('scripts.php') ?>
        <?php
        if (isset($_GET["insert"]) && $_GET["insert"] == "true") {
          echo "<script>
          toastr['success']('Visitez <b>le profil de ce stagiaire</b> pour Modifier', 'Absence Ajouter')
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