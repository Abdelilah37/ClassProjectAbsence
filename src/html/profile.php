<?php
include('./Php/sideBar.php');
include('./Php/session.php');

$sql = "SELECT d.*,s.*  FROM deletedavertissement d inner join stagiaire s
                on d.StagiaireCin=s.cin ";
$stmt =  $pdo_conn->prepare($sql);
$stmt->execute();
$deletedAvrt = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ofppt WFS205</title>
  <?php include('styles.php') ?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <link rel="stylesheet" href="../assets/css/Ajouter.css">
  <link rel="stylesheet" href="../assets/css/popup.css">

  <style>
        /* Add your custom styles here */
        .fixed-thead th {
            position: sticky;
            top: 0;
            background-color: #ffffff; /* Adjust the background color as needed */
            z-index: 999; /* Higher z-index than the fixed-header */
        }

        .table-container {
            max-height: 350px;
            overflow-y: auto;
        }
    </style>

</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <!-- SIDEBAR AND NAVBAR  -->
    <?php include("SIDE&NAV.php") ?>
    <!--  Main CONTENT -->
    <div class="body-wrapper">
      <div class="container-fluid">

        <h1 class="card-title fs-8 fw-bold  text-dark ">
          Liste des Stagiaires Supprimée:
        </h1>
        <!-- Search Bar for Stagiaires Supprimée -->
        <form action="#">
        <div class="input-group my-3 position-relative">
            <input class="form-control rounded-3" type="search" value="" id="searchInput1" placeholder="Search">
            <span class="input-group-append">
                <div class="position-absolute top-0 end-0 w-auto text-end ">
                    <button class="btn ms-n10 rounded-0 rounded-end" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-search text-dark">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </div>
            </span>
        </div>
    </form>
    <div class="card-body">
        <!-- table -->
        <div class="table-responsive table-container rounded border border-light shadow-sm">
            <table class="table table-hover" id="dataTable">
                <thead class="bg-gray-2 table-light text-left fixed-thead">
                    <tr>
                        <th class="min-width-220 py-3 px-4 font-weight-medium">
                            CIN
                        </th>
                        <th class="min-width-150 py-3 px-4 font-weight-medium">
                            Stagiaires
                        </th>
                        <th class="min-width-120 py-3 px-4 font-weight-medium">
                            Date Supprimée
                        </th>
                        <th class="min-width-120 py-3 px-4 font-weight-medium">
                            Raison
                        </th>
                        <th class="min-width-120 py-3 px-4 font-weight-medium">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody style="overflow-y: auto;">
                <?php include('./SearchDltConfig.php'); ?>
                </tbody>
            </table>
        </div>
    </div>


        <div class="d-grid gap-2 col-6 mx-auto rounded-pill my-3" style="background-color: #1e905b; ">
          <button class="btn text-light" id="openPopup" type="button" onclick="openPopup()">Ajouter Stagiaire</button>
        </div>
        <h1 class="card-title fs-8 fw-bold  text-dark my-4">
          Liste des avertissements Supprimée:
        </h1>
        <!-- Liste Avertissement Supprimée -->
        <div class="row mt-4">
          <div class="col-7 ">
            <div class="card-body">
              <!-- table -->
              <div class="table-responsive rounded border border-light shadow-sm" style="height:360px;overflow-y: scroll;">
                <table class="table table-hover">
                  <thead class="bg-gray-2 table-light text-left">
                    <tr>
                      <th class="min-width-220 py-3 px-4 font-weight-medium">
                        Avertissement
                      </th>
                      <th class="min-width-150 py-3 px-4 font-weight-medium">
                        Stagiaire
                      </th>
                      <th class="min-width-120 py-3 px-4 font-weight-medium">
                        Date Supprimée
                      </th>
                      <th class="min-width-120 py-3 px-4 font-weight-medium">
                        Action
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($deletedAvrt)) : ?>
                      <?php foreach ($deletedAvrt as $avrt) : ?>
                        <tr>
                          <td class="border-bottom fw-bold py-3 px-4">
                            <span class="avertissementText"><?php echo $avrt['message'] ?></span>
                            <br>
                            <span class="text-grey"><?php echo $avrt['DateAverti'] ?></span>
                          </td>
                          <td class="border-bottom fw-bold py-3 px-4">
                          <a href="./profileStagiaire.php?cin=<?php echo $avrt['cin'] ?>" style="cursor:pointer">
                            <span class="text-dark"><?php echo $avrt['nom'] ?> <?php echo $avrt['prenom'] ?></span>
                          </a>
                            <br>
                            <a href="./listeNotesGroup.php?groupe=<?php echo $avrt['groupe'] ?>" style="cursor:pointer">
                            <span class="text-grey"><?php echo $avrt['groupe'] ?></span>
                            </a>
                          </td>
                          <td class="border-bottom fw-bold py-3 px-4">
                            <span class="text-dark"><?php echo $avrt['DateDeleted'] ?></span>
                          </td>
                          <td class="border-bottom py-3 px-4">
                            <div class="d-flex align-items-center">
                              <a href="./Php/restore.php?code=<?php echo $avrt['code'] ?>" name="restorAv">
                                <button class="btn btn-link text-primary">
                                  <!-- restore -->
                                  <svg xmlns="http://www.w3.org/2000/svg" height="1.3em" viewBox="0 0 512 512">

                                    <path d="M75 75L41 41C25.9 25.9 0 36.6 0 57.9V168c0 13.3 10.7 24 24 24H134.1c21.4 0
                                    32.1-25.9 17-41l-30.8-30.8C155 85.5 203 64 256 64c106 0 192 86 192 192s-86 192-192
                                    192c-40.8 0-78.6-12.7-109.7-34.4c-14.5-10.1-34.4-6.6-44.6 7.9s-6.6 34.4 7.9 44.6C151.2
                                    495 201.7 512 256 512c141.4 0 256-114.6 256-256S397.4 0 256 0C185.3 0 121.3 28.7 75 75zm181
                                    53c-13.3 0-24 10.7-24 24V256c0 6.4 2.5 12.5 7 17l72 72c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6
                                    0-33.9l-65-65V152c0-13.3-10.7-24-24-24z" />
                                  </svg>
                                </button></a>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <tr>
                        <td colspan="4">No deleted avertissements available.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- Historique (log) -->
          <div class="col-5">
            <div class="card-body">
              <!-- table -->
              <div class="table-responsive rounded border border-light shadow-sm">
                <table class="table table-hover">
                  <thead class="bg-gray-2 table-light text-left">
                    <tr>
                      <th class="min-width-150 py-3 px-4 font-weight-medium">
                        Journal d'activités D'utilisateur
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="border-bottom fw-bold py-3 px-4">
                        <span class="text-dark">- Username a crée le profile de Stagiaire: Drai Badre EEE123123 le 14/03/2023 à 10h30.</span>
                      </td>
                    </tr>
                    <tr>
                      <td class="border-bottom fw-bold py-3 px-4">
                        <span class="text-dark">- Username a supprimé le Stagiaire: Drai Badre EEE123123 le 14/03/2023 à 10h30.</span>
                      </td>
                    </tr>
                    <tr>
                      <td class="border-bottom fw-bold py-3 px-4">
                        <span class="text-dark">- Username a restauré le Stagiaire: Drai Badre EEE123123 le 14/03/2023 à 10h30.</span>
                      </td>
                    </tr>
                    <tr>
                      <td class="border-bottom fw-bold py-3 px-4">
                        <span class="text-dark">- Username a supprimé le Stagiaire: Drai Badre EEE123123 le 14/03/2023 à 10h30.</span>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>


      </div>

      <!-- footer -->
      <div class="py-6 px-6 text-center">
        <p class="mb-0 fs-4">Copyright By <a href="#" target="_blank" class="pe-1 text-primary text-decoration-underline">WFS205</a> 2023</p>
      </div>
    </div>
  </div>
  </div>
  <div id="overlay" class="overlay">
    <div id="popup" class="popup">
      <div class="popupContent">
        <div class="modifier">
          <strong>Ajouter Stagiaire</strong>
        </div>
        <form action="./Php/ajouterStg.php" method="post">
          <div class="inputContainer">
            <div class="inputs">
              <div>
                <label>Nom :</label><input type="text" name="nom" required>
              </div>
              <div>
                <label>CIN:</label><input type="text" name="cin" required>
              </div>
              <div>
                <label>Annee:</label>
                <select name="annee" id="annee" onchange="getGroups()" required>
                  <option value="" selected>Selectionner</option>
                  <option value="1ere annee">1ere annee</option>
                  <option value="2eme annee">2eme annee</option>
                </select>
              </div>
              <div>
                <label>Telephone:</label><input type="text" name="tele" required>
              </div>
            </div>
            <div class="inputs">
              <div>
                <label>Prenom:</label><input type="text" name="prenom" required>
              </div>
              <div>
                <label>DateNaissance:</label><input type="date" value="2000-01-01" name="date" required>
              </div>
              <div id="groupContainer">
                <label>Groupe:</label>
                <select name="groupe" id="groupe" required>

                </select>
              </div>
              <div>
                <label>Note:</label><input type="number" name="note" required>
              </div>
              <div id="buttonCont">
                <button class="button btn-hover confirm" name="submit" type="submit" id="button-confirm">
                  <img src="../assets/images/Icons/Vector.svg" alt="">
                </button>
                <button class="button cancel" type="button" id="button-cancel" onclick="closePopup()">
                  <img src="../assets/images/Icons/cross.svg" alt="">
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
<?php include('scripts.php') ?>
<script src="../assets/js/getGroups.js"></script>
<script src="../assets/js/popup.js"></script>

</html>