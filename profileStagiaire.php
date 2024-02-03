<?php
// Paths updated
include('./Php/sideBar.php');
include('./Php/session.php');
try {
  if (isset($_GET['cin'])) {
    $cin = $_GET['cin'];
    $sql = "SELECT *  FROM stagiaire WHERE cin = ?";
    $stmt = $pdo_conn->prepare($sql);
    $stmt->bindParam(1, $cin);
    $stmt->execute();
    $stagiaire = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$stagiaire) {
      throw new Exception("Stagiaire does not exist.");
    }
  } else {
    throw new Exception("CIN parameter not set.");
  }
} catch (Exception $e) {
  echo "<script>alert('{$e->getMessage()}'); history.back();</script>";
  exit();
}

if ($stmt->rowCount() > 0) {
  $sql = "SELECT *  FROM absence 
          WHERE StagiaireCin = ? ";
  $stmt =  $pdo_conn->prepare($sql);
  $stmt->bindParam(1, $cin);
  $stmt->execute();
  $absence = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $sql = "SELECT * FROM avertissement WHERE StagiaireCin = ?";
  $stmt = $pdo_conn->prepare($sql);
  $stmt->bindParam(1, $cin);
  $stmt->execute();

  $avertissements = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $sql = "CALL ShowAbsenceHours(?)";
  $stmt = $pdo_conn->prepare($sql);
  $stmt->bindParam(1, $cin);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  $hoursWithJustification = intval($result['Hours With Justification']);
  $hoursWithJustificationDistance = intval($result['Hours With Justification Distance']);
  $hoursWithoutJustification = intval($result['Hours Without Justification']);
  $hoursWithoutJustificationDistance = intval($result['Hours Without Justification Distance']);



?>

  <!doctype html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ofppt WFS205</title>
    <?php include('styles.php') ?>
    <link rel="stylesheet" href="./assets/css/profileStagiaire.css">
    <link rel="stylesheet" href="./assets/css/ModifierStg.css">
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
      <div class="container-fluid">
        <!--  body -->
        <!-- title bar -->
        <div class="position-relative " style="height: 40px;">
          <div class="position-absolute top-0 start-0">
            <h2 class="card-title text-dark">Profile Stagiaire</h2>
          </div>
          <div class="position-absolute top-0 end-0 w-auto text-end p-1 border border-dark rounded-pill ">
            <a class="nav-link text-dark fw-bold" href="./listeNotesGroup.php?groupe=<?php echo $stagiaire['groupe'] ?>">
              <i>
                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M6 12H18M6 12L11 7M6 12L11 17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </i>
              Retour
            </a>
          </div>
        </div>

        <!-- End Title Bar -->
        <!-- Profile container -->
        <div class="row align-items-start mb-3 shadow-sm p-3 rounded-4 text-white ProfileCard">
          <div class="container mx-0">

            <div class="row">
              <h1 class="text-white">
                <strong>
                  <?php echo $stagiaire['nom'] ?></br><?php echo $stagiaire['prenom'] ?>
                </strong>
              </h1>
            </div>

            <div class="row my-2 ">
              <ul class="list-inline m-0">
                <li class="list-inline-item">Cin: <strong><?php echo $stagiaire['cin'] ?></strong></li>
                <li class="list-inline-item">Né le: <strong><?php echo $stagiaire['dateNaissance'] ?></strong></li>
                <li class="list-inline-item">Annee: <strong><?php echo $stagiaire['Niveau'] ?></strong></li>
                <li class="list-inline-item">Groupe: <strong id="selectedgroupe"><?php echo $stagiaire['groupe'] ?></strong></li>
                <li class="list-inline-item">Telephone: <strong>0<?php echo $stagiaire['NTelephone'] ?></strong></li>
              </ul>
            </div>

            <div class="row gap-2">

              <div class="col p-3 rounded-4 Note">
                <!-- First div -->
                <h1 class="text-white"><strong><?php echo $stagiaire['noteDisciplinaire'] ?></strong></h1>
                <h4 class="text-white">la Note Desciplinaire</h4>
              </div>

              <div class="col p-3 rounded-4 NoJustifier">
                <!-- Second div -->
                <h1 class="text-white">
                  <strong>
                    <?php echo $hoursWithoutJustification ?>
                  </strong>
                  <span>Hr</span>
                  <span class="HrDistance">
                    <b>
                      <?php echo $hoursWithoutJustificationDistance ?>
                    </b>
                    <span> Distance</span>
                  </span>
                </h1>
                <h4 class="text-white">
                  Heures d'absence non justifiées
                </h4>
              </div>

              <div class="col p-3 rounded-4 Justifier">
                <!-- Third div -->
                <h1 class="text-white">
                  <strong><?php echo $hoursWithJustification ?></strong><span>Hr</span>
                  <span class="HrDistance">
                    <b>
                      <?php echo $hoursWithJustificationDistance ?>
                    </b>
                    <span> Distance</span>
                  </span>
                </h1>
                <h4 class="text-white">Heures d'absence justifiées</h4>
              </div>

            </div>
          </div>
        </div>
        <div class="row p-0 px-0 rounded-5 border shadow-sm ">
          <!-- avertissement -->
          <div class="row mb-3 p-0  rounded-5 border shadow-sm ">
            <div class="table-responsive p-0 rounded-5 ">
              <table class="table mb-0 rounded-5 align-middle">
                <thead class="text-left fixed-thead" style="line-height:10px;">
                  <tr>
                    <th class="font-weight-medium">
                      Date Avertissement
                    </th>
                    <th class="font-weight-medium">
                      Status
                    </th>
                    <th class="font-weight-medium">
                      Action
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($avertissements) { ?>
                    <?php foreach ($avertissements as $avertissement) { ?>
                      <tr class="align-middle">
                        <td class=" text-dark fw-bold">
                          <span><?php echo $avertissement['DateAverti'] ?></span>
                        </td>
                        <td class="">
                          <span class="badge text-sm font-weight-medium avertissementText">
                            <?php echo $avertissement['message'] ?>
                          </span>
                        </td>
                        <td class="">
                          <div class="d-flex align-items-center">
                            <a class="click" onclick="confirmDeletionAvertissement('<?php echo $avertissement['code']; ?>', '<?php echo $avertissement['StagiaireCin']; ?>')">
                              <button class="btn btn-link text-primary">
                                <!-- delete -->
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                  <path d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z" />
                                </svg>
                              </button>
                            </a>
                          </div>
                        </td>
                      </tr>
                    <?php  }
                  } else { ?>
                    <tr class="">
                      <td colspan="3">No avertissements available.</td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- end avertissement -->
          <!-- modifier stg and ajouter absence  -->
          <div class="row mb-3 gap-2 p-0 px-2 rounded-5 shadow-sm ">
            <!-- Modifier stagiaire -->
            <div class="col px-0">
              <div id="popup" class="popup">
                <form action="./Php/UpdateStg.php?cin=<?php echo $cin ?>" method="post" onsubmit="return isValide()">
                  <div class="popupContent">
                    <div class="modifier">
                      <strong>Modifier Stagiaire</strong>
                    </div>
                    <div class="inputContainer">
                      <div class="inputs">
                        <div>
                          <label>Nom :</label><input class="ipt" type="text" name="nom" value="<?php echo $stagiaire['nom'] ?>" id="nomStagiair">
                        </div>
                        <div id="groupContainer">
                          <label>Groupe:</label>
                          <select class="ipt" name="groupe" id="groupe" required>
                          </select>
                        </div>
                        <div>
                          <label>Annee:</label>
                          <select class="ipt" name="annee" id="annee" required onchange="getGroups()">
                            <?php
                            if ($stagiaire['Niveau'] == "1ere annee") {
                              echo "<option value='1ere annee' selected>1ere annee</option>
                                                  <option value='2eme annee' >2eme annee</option>";
                            } else {
                              echo "<option value='1ere annee' >1ere annee</option>
                                                  <option value='2eme annee' selected >2eme annee</option>";
                            };
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="inputs">
                        <div>
                          <label>Prenom:</label><input class="ipt" type="text" name="prenom" value="<?php echo $stagiaire['prenom'] ?>" id="prenomStagiaire">
                        </div>
                        <div>
                          <label>DateNaissance:</label><input class="ipt" type="date" name="dateNaissance" value="<?php echo $stagiaire['dateNaissance'] ?>">
                        </div>
                        <div>
                          <label>Note:</label><input class="ipt" type="text" name="noteDisciplinaire" value="<?php echo $stagiaire['noteDisciplinaire'] ?>" id="noteDisiplinaireStagiaire">
                        </div>
                      </div>
                    </div>
                    <div class="buttonCont">
                      <button class="button confirm" id="button-confirm" type="submit" name="submit">
                        <img src="./assets/images/Icons/Vector.svg" alt="">
                      </button>
                      <button class="button cancel" id="button-cancel" type="reset">
                        <img src="./assets/images/Icons/cross.svg" alt="">
                      </button>
                    </div>
                  </div>
                </form>

              </div>
            </div>
            <!-- End Modifier stagiaire -->
            <!-- Ajouter Absence -->
            <div class="col px-0">
              <div class="popup">
                <form action="./Php/insertAbsence.php?cin=<?php echo $cin ?>" method="post">
                  <div class="popupContent">
                    <div>
                      <strong>Ajouter Absence</strong>
                    </div>
                    <div class="inputContainer">
                      <div class="absenceContainer">
                        <div class="inputs">
                          <input class="ipt" min="0" type="number" placeholder="NbrHeures" name="nbHeures" required>
                          <input class="ipt" type="text" placeholder="Justification" name="justification">
                        </div>
                        <div class="inputs">
                          <?php
                          $currentDate = date('Y-m-d');
                          echo '<input required type="date" name="date" class="ipt" value="' . $currentDate . '">';
                          ?>
                          <label for="flexCheckDefault">
                            <span>
                              Distance:<input type="checkbox" name="Distance" class="form-check-input" id="flexCheckDefault">
                            </span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="buttonCont">
                      <button class="button confirm" type="submit" name="submit1" id="button-confirm">
                        <img src="./assets/images/Icons/Vector.svg" alt="">
                      </button>
                      <button class="button cancel" type="reset" id="button-cancel">
                        <img src="./assets/images/Icons/cross.svg" alt="">
                      </button>
                    </div>
                  </div>
              </div>
              </form>
            </div>
            <!-- End Ajouter Absence -->
          </div>
          <!-- End modifier stg and ajouter absence  -->
          <!-- table Absence -->
          <div class="row p-0  rounded-5  border shadow-sm ">
            <!-- table -->
            <div class="table-responsive mb-0 p-0 rounded-5 ">
              <table class="table mb-0 align-middle rounded-5 table-hover">
                <thead class="bg-gray-2 table-light text-left fixed-thead">
                  <tr class="">
                    <th class="font-weight-medium">
                      Date Absence
                    </th>
                    <th class="font-weight-medium">
                      Nombre Heures
                    </th>
                    <th class="font-weight-medium">
                      Justification
                    </th>
                    <th class="font-weight-medium">
                      Action
                    </th>

                </thead>
                <tbody>
                  <?php if (!empty($absence) && is_array($absence) && count($absence) > 0) : ?>
                    <?php foreach ($absence as $abs) : ?>
                      <tr class="">
                        <td class="border-bottom text-dark fw-bold">
                          <span><?php echo $abs['date'] ?></span>
                        </td>
                        <td class="border-bottom text-dark fw-bold">
                          <span>
                            <?php
                            if ($abs['distance'] == null) {
                              echo $abs['nbHeures'];
                            } else {
                              echo $abs['nbHeures'] . " Distance";
                            }
                            ?>
                          </span>
                        </td>
                        <td class="border-bottom text-dark fw-bold">
                          <span><?php echo empty($abs['justification']) ? "Aucune" : $abs['justification']; ?></span>
                        </td>
                        <td class="border-bottom">
                          <div class="d-flex align-items-center">
                            <a class="click" onclick="confirmDeletionAbsence('<?php echo $abs['AbsenceID']; ?>', '<?php echo $abs['StagiaireCin'] ?>')">
                              <button class="btn btn-link text-primary">
                                <!-- delete -->
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                  <path d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z" />
                                </svg>
                              </button>
                            </a>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td colspan="4">No absences available.</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
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
    <script src="./assets/js/getGroups.js"></script>
    <script>
      function confirmDeletionAvertissement(codeAvertissement, cin) {
        // Create a confirmation popup dynamically
        Swal.fire({
          title: "Cet Avertissement sera supprimé",
          text: "Vous pouvez toujours le restaurer depuis votre profil",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Oui, supprimez-le.",
          cancelButtonText: "Annuler",
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user confirmed, navigate to the deletion link
            window.location.href = "./Php/deletelisteavertissment.php?code=" + encodeURIComponent(codeAvertissement) + "&cin=" + encodeURIComponent(cin);
          }
        });
      }

      function confirmDeletionAbsence(absence, cin) {
        // Create a confirmation popup dynamically
        Swal.fire({
          title: "Cette Absence sera supprimée",
          text: "Vous pouvez toujours la restaurer depuis votre profil",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Oui, supprimez-le.",
          cancelButtonText: "Annuler",
        }).then((result) => {
          if (result.isConfirmed) {
            // If the user confirmed, navigate to the deletion link
            window.location.href = "./Php/deletelisteavertissment.php?id=" + encodeURIComponent(absence) + "&cin=" + encodeURIComponent(cin);
          }
        });
      }
    </script>
    <?php
    if (isset($_GET["deleted"]) && $_GET["deleted"] == "true") {
      echo "<script>
            Swal.fire({
                title: 'Avertissement Supprimé!',
                text: 'Visitez Éléments Supprimés pour restaurer.',
                icon: 'success'
            });
        </script>";
    }

    if (isset($_GET["deletedAbsence"]) && $_GET["deletedAbsence"] == "true") {
      echo "<script>
            Swal.fire({
                title: 'Absence Supprimée!',
                text: 'Ajoutez une nouvelle Absence.',
                icon: 'success'
            });
        </script>";
    }

    if (isset($_GET["updated"]) && $_GET["updated"] == "true") {
      echo "<script>
            toastr.success('Les modifications ont été enregistrées avec succès.', 'Stagiaire Modifié');
        </script>";
    }

    // Messages d'erreurs
    if (isset($_GET["configNomPrenomMessage"]) && !empty($_GET["configNomPrenomMessage"])) {
      $configNomPrenomMessage = strip_tags($_GET["configNomPrenomMessage"]);
      if (isset($_GET["updated"]) && $_GET["updated"] == "false") {
        echo "<script>
                toastr.error('" . $configNomPrenomMessage . "', 'Stagiaire non Modifié');
            </script>";
      }
    }

    // Messages d'erreurs pour l'insertion d'absence
    if (isset($_GET["insertAbs"])) {
      if ($_GET["insertAbs"] == "false") {
        echo "<script>
                toastr.error('L'absence n'a pas été insérée.', 'Insérer l'absence');
            </script>";
      } elseif ($_GET["insertAbs"] == "true") {
        echo "<script>
                toastr.success('L'absence a été insérée avec succès.', 'Insérer l'absence');
            </script>";
      }
    }
    ?>

  </body>
  <script>
    window.addEventListener('load', function() {
      getGroups();
    });
  </script>

  </html>
<?php
} else {
  $errorMessage = "Stagiaire n'existe pas.";
  header("Location: error-page.php?error=" . urlencode($errorMessage));
  exit();
}
?>