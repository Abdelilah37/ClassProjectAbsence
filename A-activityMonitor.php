<?php
// Paths updated
try {
  include('./Php/sideBar.php');
  include('./Php/session.php');

  $user = $_SESSION["username"];
  $role = $_SESSION["Role"];
  if ($role != "admin") {
    header("Location: ./index.php");
    exit();
  }
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
  <?php include('styles.php') ?>

  <link rel="stylesheet" href="./assets/css/Ajouter.css">
  <link rel="stylesheet" href="./assets/libs/dataTable/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="./assets/css/popup.css">

</head>

<body>
  <div class="preloader">
    <img src="./assets/images/Icons/loader-2.svg" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <!-- SIDEBAR AND NAVBAR  -->
    <?php include("SIDE&NAV.php") ?>
    <!--  Main CONTENT -->
    <div class="container-fluid d-flex flex-column">
      <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
              <h4 class="fw-semibold mb-8">Surveillance d'Activité</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="./index.php">Accueil</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">Surveillance d'Activité</li>
                </ol>
              </nav>
            </div>
            <div class="col-3">
              <div class="text-center mb-n5">
                <img src="./assets/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <ul class="nav nav-pills user-profile-tab" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-4 active" id="pills-account-tab" data-bs-toggle="pill" data-bs-target="#pills-account" type="button" role="tab" aria-controls="pills-account" aria-selected="true">
              <i class="ti ti-user-circle me-2 fs-6"></i>
              <span class="d-none d-md-block">Mes Activités</span>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-4" id="pills-notifications-tab" data-bs-toggle="pill" data-bs-target="#pills-notifications" type="button" role="tab" aria-controls="pills-notifications" aria-selected="false" tabindex="-1">
              <i class="ti ti-bell me-2 fs-6"></i>
              <span class="d-none d-md-block">Activités des Autres Utilisateurs</span>
            </button>
          </li>
        </ul>
        <div class="card-body tab-content">
          <div class="tab-pane fade active show" id="pills-account" aria-labelledby="pills-account-tab" tabindex="1">
            <!-- SG activity -->
            <?php include('./Php/SG_Activity.php');
            ?>
          </div>
          <div class="tab-pane fade" id="pills-notifications" role="tabpanel" aria-labelledby="pills-notifications-tab" tabindex="2">

            <?php include('./Php/Admin_Activity.php') ?>

            <!-- Admin activity -->
          </div>
        </div>
      </div>



      <?php include('FOOTER.php') ?>
    </div>
  </div>
  </div>
  <?php include('scripts.php') ?>
  <script src="./assets/libs/dataTable/jquery.dataTables.min.js"></script>
  <?php

  if (isset($_SESSION['import_error'])) {
    echo "<script>alert('" . $_SESSION['import_error'] . "');</script>";

    // Clear the session variable
    unset($_SESSION['import_error']);
  }
  ?>

  <script>
    $(document).ready(function() {
      var dataTableElement = $('#dataTable');

      if (dataTableElement.length) {
        dataTableElement.DataTable({
          "dom": '<"top"lf>rt<"bottom"ip><"clear">',
          "order": [
            [2, 'desc']
          ]
        });
      } else {
        console.error("Table with id 'dataTable' not found.");
      }
    });
  </script>


</body>

</html>