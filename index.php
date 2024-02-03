<?php
try {
  // Paths updated
  include('./Php/config.php');
  include('./Php/session.php');
  include('./Php/sideBar.php');




  $sql = "SELECT S.nom,S.prenom,S.groupe,S.cin,A.message,A.dateAverti,A.StagiaireCin,S.cin from stagiaire S 
          INNER JOIN avertissement A on S.cin=A.StagiaireCin
          order by dateAverti DESC";
  $stmt = $pdo_conn->prepare($sql);
  $stmt->execute();
  $donnees = $stmt->fetchAll();


  // Procedure: GetTodaysAbsences
  $stmt = $pdo_conn->prepare("CALL GetTodaysAbsences()");
  $stmt->execute();
  $todaysAbsences = $stmt->fetch(PDO::FETCH_ASSOC);
  ($todaysAbsences['nbrAbs']) ? $todaysAbsence = $todaysAbsences['nbrAbs'] : $todaysAbsence = 0;


  // Procedure: GetStudentStatistics
  $stmt = $pdo_conn->prepare("CALL GetStudentStatistics()");
  $stmt->execute();
  $studentStatistics = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if (!empty($studentStatistics)) {
    $TotalStudents = $studentStatistics[0]['Total Students'];
    ($studentStatistics[0]['Total Unexcused Absences'])?
    $TotalUnexcusedAbsences = $studentStatistics[0]['Total Unexcused Absences'] : $TotalUnexcusedAbsences = 0;
    ($studentStatistics[0]['Total Excused Absences'])?
    $TotalExcusedAbsences = $studentStatistics[0]['Total Excused Absences'] : $TotalExcusedAbsences = 0;;
    $TotalWarnings = $studentStatistics[0]['Total Warnings'];
  } else {
    $TotalStudents = 0;
    $TotalUnexcusedAbsences = 0;
    $TotalExcusedAbsences = 0;
    $TotalWarnings = 0;
  }

  $stmt = $pdo_conn->prepare("CALL GetPercentageNoAbsences ()");
  $stmt->execute();
  $PercentageNoAbsences = $stmt->fetch(PDO::FETCH_ASSOC);

  $conn = null;
} catch (Exception $e) {
  $errorMessage = $e->getMessage();
  header("Location: error-page.php?error=" . urlencode($errorMessage));
  exit();
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ofppt WFS205</title>
  <link rel="stylesheet" href="./assets/libs/dataTable/dataTables.bootstrap5.min.css">
  <?php include('styles.php') ?>

</head>

<body>
  <div class="preloader">
    <img src="./assets/images/Icons/loader-2.svg" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <!-- SIDEBAR AND NAVBAR  -->
    <!--  Main CONTENT -->
    <?php include("SIDE&NAV.php") ?>

    <div class="container-fluid">
      <!--  body -->
      <div class="card-body">
        <!-- table -->
        <div class="row">
          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card shadow-sm w-100 bg-info-subtle overflow-hidden">
              <div class="card-body position-relative">
                <div class="row">
                  <div class="col-sm-7">
                    <div class="d-flex align-items-center mb-7">
                      <div class="rounded-circle overflow-hidden me-6">
                        <span class="avatar-container" data-initials="<?php echo extractInitials($_SESSION) ?>" data-width="40px" data-color="<?php echo $_SESSION["avatar"] ?>"></span>
                      </div>
                      <h5 class="fw-semibold mb-0 fs-5">Content de te revoir, <?php echo $_SESSION["Nom"] . ' ' . $_SESSION["prenom"] ?>!</h5>
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="border-end pe-4 border-muted border-opacity-10">
                        <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center"><?php echo "" . $todaysAbsence ?> Hrs<i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i></h3>
                        <p class="mb-0 text-dark">Les absences d'aujourd'hui</p>
                      </div>
                      <div class="ps-4">
                        <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center"><?php echo $PercentageNoAbsences['PercentageNoAbsences'] ?>%<i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i></h3>
                        <p class="mb-0 text-dark">Pourcentage de Stagiaires Sans Absence</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <div class="welcome-bg-img mb-n7 text-end">
                      <img src="./assets/images/breadcrumb/welcome-bg.svg" alt="" class="img-fluid">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- <div class="row gx-3">
          <div class="col-md-3 col-lg-3 col-6">
            <div class="card  text-white bg-primary rounded">
              <div class="card-body p-4">
                <span>
                  <i class="ti ti-users-group fs-8"></i>
                </span>
                <h3 class="card-title mt-3 mb-0 text-white"><?php echo $TotalStudents ?></h3>
                <p class="card-text text-white-50 fs-3 fw-normal">
                  Total des stagiaires
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-lg-3 col-6">
            <div class="card  text-white text-bg-success rounded">
              <div class="card-body p-4">
                <span>
                  <i class="ti ti-clock-x fs-8"></i>
                </span>
                <h3 class="card-title mt-3 mb-0 text-white"><?php echo $TotalUnexcusedAbsences . ' Hrs'  ?></h3>
                <p class="card-text text-white-50 fs-3 fw-normal">
                  Absences non justifiées totales
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-lg-3 col-6">
            <div class="card  text-white text-bg-warning rounded">
              <div class="card-body p-4">
                <span>
                  <i class="ti ti-clock-check  fs-8"></i>
                </span>
                <h3 class="card-title mt-3 mb-0 text-white"><?php echo $TotalExcusedAbsences . ' Hrs'  ?></h3>
                <p class="card-text text-white-50 fs-3 fw-normal">
                  Absences justifiées totales
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-lg-3 col-6">
            <div class="card  text-white text-bg-danger rounded">
              <div class="card-body p-4">
                <span>
                  <i class="ti ti-flag fs-8"></i>
                </span>
                <h3 class="card-title mt-3 mb-0 text-white"><?php echo $TotalWarnings  ?></h3>
                <p class="card-text text-white-50 fs-3 fw-normal">
                  Avertissements totaux
                </p>
              </div>
            </div>
          </div>
        </div> -->

        <div class="row">
          <!-- Column -->
          <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm ">
              <div class="card-body">
                <div class="d-flex flex-row align-items-center">
                  <div class="round-40 p-2 rounded-circle text-white d-flex align-items-center justify-content-center text-bg-info">
                    <i class="ti ti-users-group fs-6"></i>
                  </div>
                  <div class="ms-3 align-self-center">
                    <h3 class="mb-0 fs-6"><?php echo $TotalStudents ?></h3>
                    <span class="text-muted fs-2">Total des stagiaires</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Column -->
          <!-- Column -->
          <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm ">
              <div class="card-body">
                <div class="d-flex flex-row align-items-center">
                  <div class="round-40 p-2 rounded-circle text-white d-flex align-items-center justify-content-center text-bg-danger">
                    <i class="ti ti-clock-x fs-6"></i>
                  </div>
                  <div class="ms-3 align-self-center">
                    <h3 class="mb-0 fs-6"><?php echo $TotalUnexcusedAbsences . ' Hrs'  ?></h3>
                    <span class="text-muted fs-2">Absences non justifiées</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Column -->
          <!-- Column -->
          <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm ">
              <div class="card-body">
                <div class="d-flex flex-row align-items-center">
                  <div class="round-40 p-2 rounded-circle text-white d-flex align-items-center justify-content-center text-bg-success">
                    <i class="ti ti-clock-check fs-6"></i>
                  </div>
                  <div class="ms-3 align-self-center">
                    <h3 class="mb-0 fs-6"><?php echo $TotalExcusedAbsences . ' Hrs'  ?></h3>
                    <span class="text-muted fs-2">Absences justifiées</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Column -->
          <!-- Column -->
          <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm ">
              <div class="card-body">
                <div class="d-flex flex-row align-items-center">
                  <div class="round-40 p-2 rounded-circle text-white d-flex align-items-center justify-content-center text-bg-warning ">
                    <i class="ti ti-flag fs-6"></i>
                  </div>
                  <div class="ms-3 align-self-center">
                    <h3 class="mb-0 fs-6"><?php echo $TotalWarnings  ?></h3>
                    <span class="text-muted fs-2">Avertissements totaux</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Column -->
        </div>

        <div class="row">
          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card   w-100">
              <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Gestion des Avertissements pour les Stagiaires</h5>
                    <p class="card-subtitle">Cette table présente les détails des avertissements attribués aux stagiaires.</p>
                  </div>
                </div>
                <div class="table-responsive hide-scroll " style="max-height:350px;overflow-y: scroll;">
                  <table class="table align-middle text-nowrap mb-0" id="dataTable-Index">
                    <thead class="fixed-thead  bg-white">
                      <tr class="text-muted fw-semibold">
                        <th scope="col">Stagiaires</th>
                        <th scope="col">Date Avertissement</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="border-top">
                      <?php
                      if ($stmt->rowCount() > 0) {
                        foreach ($donnees as $donne) {

                      ?>
                          <tr>
                            <td>
                              <div class="d-flex justify-content-center flex-column">
                                <a href="./profileStagiaire.php?cin=<?php echo $donne['cin'] ?>" style="cursor:pointer">
                                  <h5 class="fw-semibold mb-1"><?= $donne["nom"] ?> <?= $donne["prenom"] ?> </h5>
                                </a>

                                <a href="./listeStagiaire.php?groupe=<?php echo $donne['groupe'] ?>" style="cursor:pointer">
                                  <p class="fs-2 mb-0 text-muted"><?= $donne["groupe"] ?></p>
                                </a>
                              </div>
                            </td>

                            <td>
                              <p class="mb-0"><?= $donne["dateAverti"] ?></p>
                            </td>
                            <td>
                              <span class="badge  py-2 px-3 w-85 avertissementText">
                                <?= $donne["message"] ?>
                              </span>
                            </td>

                            <td>
                              <div class="d-flex align-items-center">
                                <button class="btn btn-link text-primary">
                                  <!-- view -->
                                  <a href="profileStagiaire.php?cin=<?php echo $donne['cin'] ?>" style="cursor:pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                      <path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                    </svg>
                                  </a>
                                </button>

                                <button class="btn btn-link text-primary">
                                  <!-- delete -->
                                  <a class="click" onclick="confirmDeletionAvertissement('<?php echo $donne['StagiaireCin']; ?>')">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">

                                      <path d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z" />
                                    </svg>
                                  </a>
                                </button>

                              </div>
                            </td>
                          </tr>
                      <?php
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


     <?php include('FOOTER.php') ?>
    </div>
  </div>


  </div>

  <?php include('scripts.php') ?>
  <script src="./assets/libs/dataTable/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      var dataTableElement = $('#dataTable-Index');

      if (dataTableElement.length) {
        dataTableElement.DataTable({
          "dom": '<"top"lf>rt<"bottom"ip><"clear">',
          "order": [
            [1, 'desc']
          ]
        });
      } else {
        console.error("Table with id 'dataTable' not found.");
      }
    });

    function confirmDeletionAvertissement(cin) {
      // Create a confirmation popup dynamically
      Swal.fire({
        title: "Cette Avertissement sera supprimé",
        text: "vous pouvez toujours le restaurer depuis votre profil",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Oui, supprimez-le.",
        cancelButtonText: "Annuler",
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user confirmed, navigate to the deletion link
          window.location.href = "./Php/deletelisteavertissment.php?StagiaireCin=" + encodeURIComponent(cin);
        }
      });
    }
  </script>

  <?php

  if (isset($_GET["deleted"]) && $_GET["deleted"] == "true") {
    echo "<script>
          Swal.fire({
            title: 'Avertissement Supprimé!',
            text: 'Visitez Éléments Supprimés pour restaurer',
            icon: 'success'
          });
        </script>";
  }
  ?>
</body>

</html>