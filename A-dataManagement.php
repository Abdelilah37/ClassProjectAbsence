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
              <h4 class="fw-semibold mb-8">Gestion des donnees</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="./index.php">Accueil</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">Gestion des donnees</li>
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

      <form action="./Php/controlDB.php" method="post" enctype="multipart/form-data" id="TelecharcherViderForm">
        <div class="row mx-0">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">1</div>
              <div class="card-body">
                <h5 class="card-title">Télécharger le Modèle Excel :</h5>
                <p class="card-text">
                  Utilisez cette option pour télécharger le modèle Excel préétabli.
                </p>
                <button type="submit" name="install" class="btn mb-1 justify-content-center align-items-baseline w-100 d-flex align-items-center waves-effect waves-light btn-success">
                  <i class="fs-5 ti ti-file-description mx-1"></i>
                  Télécharger
                </button>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">2</div>
              <div class="card-body">
                <h5 class="card-title">Effacer la Base de Données :</h5>
                <p class="card-text">
                  Cette fonction permet de vider entièrement la base de données.
                </p>
                <button type="submit" name="delete" onclick="sendData(this)" class="btn mb-1 justify-content-center align-items-baseline w-100 d-flex align-items-center waves-effect waves-light btn-danger">
                  <i class="fs-5 ti ti-trash mx-1"></i>
                  Vider
                </button>
              </div>
            </div>
          </div>
      </form>
      <form class="mt-3" action="./Php/controlDB.php" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">3</div>
              <div class="card-body">
                <h5 class="card-title">Importer le Fichier Excel :</h5>
                <p class="card-text">
                  Importez vos données en utilisant un fichier Excel grâce à cette fonction.
                </p>
                <input class="form-control" type="file" name="excel_file" accept=".xls, .xlsx" id="formFile" required>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">4</div>
              <div class="card-body">
                <h5 class="card-title">Exécuter l'Importation :</h5>
                <p class="card-text">
                  Une fois le fichier sélectionné, exécutez l'importation des données.
                </p>
                <button type="submit" name="import" class="justify-content-center align-items-baseline w-100 btn mb-1 btn-rounded btn-dark d-flex align-items-center waves-effect waves-light">
                  <i class="fs-5 ti ti-file-check mx-1"></i>
                  Exécuter
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>



    </div>
    <?php include('FOOTER.php') ?>
  </div>
  </div>
  <?php include('scripts.php') ?>
  <script src="./assets/js/getGroups.js"></script>
  <script src="./assets/js/app.min.js"></script>
  <script src="./assets/js/validerAjouterStagiaireProfile.js"></script>
  <script>
    function sendData(clickedButton) {
      const buttonName = $(clickedButton).attr('name');
      event.preventDefault();
      Swal.fire({
        title: "Toutes les données seront supprimées",
        text: "Vous n'aurez pas la possibilité de les restaurer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Oui, supprimer!",
        cancelButtonText: "Annuler",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: 'POST',
            url: './Php/controlDB.php', // Replace with your PHP handler URL
            data: {
              'delete': buttonName
            }, // Pass data as an object
            success: function(response) {
              if (response.status === 'success') {
                // Handle success
                Swal.fire({
                  title: 'Les données ont été supprimées !',
                  text: 'Importez d\'abord les nouveaux stagiaires',
                  icon: 'success'
                });
              } else {
                // Handle other cases
                Swal.fire({
                  title: 'Erreur lors de la suppression des données',
                  text: response.message || 'Veuillez réessayer plus tard',
                  icon: 'error'
                });
              }
            }
          });
        }
      });
    };


    <?php
    if (isset($_GET["insert"]) && $_GET["insert"] == "true") {
      echo "toastr.success('Les nouveaux stagiaires ont été bien insérés', 'Stagiaires insérés')";
    };
    if (isset($_GET["error"]) && $_GET["error"] == "true") {
      echo "toastr.warning('Les nouveaux stagiaires insérés avec des erreurs, veuillez vérifier vos données', 'Stagiaires insérés avec des erreurs')";
    };
    ?>
  </script>
</body>

</html>