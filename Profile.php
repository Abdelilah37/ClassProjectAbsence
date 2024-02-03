<?php
// Paths updated
try {
  include('./Php/session.php');
  include('./Php/sideBar.php');
  $user = $_SESSION['username'];
  $invalid_message_confirm = isset($invalid_message_confirm) ? $invalid_message_confirm : '';
  $invalid_message_current = isset($invalid_message_current) ? $invalid_message_current : '';
  if (isset($_POST['change_password'])) {
    $user = $_SESSION['username'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $pdo_conn->prepare($sql);
    $stmt->bindParam(1, $user);
    $stmt->execute();
    $info = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($current_password == $info['password']) {
      if ($new_password == $confirm_password) {
        $update_sql = "UPDATE user SET password = ? WHERE username = ?";
        $update_stmt = $pdo_conn->prepare($update_sql);
        $update_stmt->bindParam(1, $new_password);
        $update_stmt->bindParam(2, $user);
        $update_stmt->execute();

        $toast = "<script>toastr['success']('Mot de passe changé avec succès !', 'Mot de passe changé')</script>";
      } else {
        // $toast = "<script>toastr['warning']('Le nouveau mot de passe et la confirmation du mot de passe ne correspondent pas','Erreur')</script>";
        $invalid_message_confirm = "Le nouveau mot de passe et la confirmation du mot de passe ne correspondent pas. Veuillez réessayer.";
      }
    } else {
      // $toast = "<script>toastr['warning']('Le mot de passe actuel ne correspond pas. Veuillez vérifier votre mot de passe actuel et réessayer.','Erreur')</script>";
      $invalid_message_current = "Le mot de passe actuel ne correspond pas. Veuillez vérifier votre mot de passe actuel et réessayer.";
    }
  }

  if (isset($_POST['update_profile'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    
    $user = $_SESSION['username'];
    
    $sql = "UPDATE user SET nom = ?, prenom = ?, username = ?, email = ? WHERE username = ?";
    $stmt = $pdo_conn->prepare($sql);
    $stmt->execute([$nom, $prenom, $username, $email, $user]);

    if($_SESSION['email'] != $_POST['email']){
      $_SESSION['is_verified'] = false;
    }
    // Update the session with the new username
    $_SESSION['username'] = $username;
    $_SESSION['Nom'] = $nom;
    $_SESSION['prenom'] = $prenom;
    $_SESSION['email'] = $email;
    
    $toast = "<script>toastr['success']('Profile Updated successfully!', 'Profile updated')</script>";
  }
  
  if (isset($_POST['change_avatar_color'])) {
    $avatar = $_POST['avatar'];
    
    $sql = "UPDATE user SET avatar = ? WHERE username = ?";
    $stmt = $pdo_conn->prepare($sql);
    $stmt->execute([$avatar, $user]);
    $_SESSION['avatar'] = $avatar;

    $toast = "<script>toastr['success']('Profile avatar Changed successfully!', 'Avatar Changed')</script>";
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

    <div class="container-fluid">

      <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
              <h4 class="fw-semibold mb-8">Paramètres du Compte</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="./index.php">Accueil</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">Paramètres du Compte</li>
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
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6 d-flex align-items-stretch">
              <div class="card shadow-sm w-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                  <h5 class="card-title fw-semibold">Change Profile</h5>
                  <p class="card-subtitle mb-4">Change your profile color from here</p>
                  <div class="text-center">
                    <form action="./Profile.php" method="post">
                      <div class="avatar-container justify-content-center" class="img-fluid rounded-circle" data-initials="<?php echo extractInitials($_SESSION) ?>" data-width="120px" data-color="<?php echo $_SESSION["avatar"]  ?>"></div>
                      <form action="./Profile.php" method="post">
                        <div class="d-flex align-items-center justify-content-center my-4 px-5">
                          <input type="color" style="width: 150px;" id="avatar" name="avatar" class="form-control cursor-pointer  rounded rounded-pill" name="avatar" value="<?php echo $_SESSION['avatar'] ?>">
                        </div>
                        <p class="mb-0">Choisissez parmi les options de couleur en utilisant la palette ci-dessus.</p>
                        <button type="submit" name="change_avatar_color" class="btn btn-primary mt-3">Save</button>
                      </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="col d-flex align-items-stretch">
              <div class="card shadow-sm w-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                  <h5 class="card-title fw-semibold">Changer le Mot de Passe</h5>
                  <p class="card-subtitle mb-4">Pour changer votre mot de passe, veuillez confirmer ici.</p>
                  <form action="./Profile.php" class="needs-validation" novalidate="" method="post">
                    <div class="mb-4">
                      <label for="exampleInputPassword1" class="form-label fw-semibold">Mot de passe actuel</label>
                      <input type="password" class="form-control <?php echo $invalid_message_current ? "is-invalid" : " "; ?>  " name="current_password" id="exampleInputPassword1" required>
                      <div class="invalid-feedback">
                        <?php echo $invalid_message_current ? $invalid_message_current : ''; ?>
                      </div>

                    </div>
                    <div class="mb-4">
                      <label for="exampleInputPassword2" class="form-label fw-semibold">Nouveau mot de passe</label>
                      <input type="password" class="form-control" name="new_password" id="exampleInputPassword2" required>
                    </div>
                    <div class="">
                      <label for="exampleInputPassword3" class="form-label fw-semibold">Confirmer le mot de passe</label>
                      <input type="password" class="form-control <?php echo $invalid_message_confirm ? "is-invalid" : " "; ?>" name="confirm_password" id="exampleInputPassword3" required>
                      <div class="invalid-feedback">
                        <?php echo $invalid_message_confirm ? $invalid_message_confirm : ''; ?>

                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" name="change_password">Changer le mot de passe</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card shadow-sm w-100 position-relative overflow-hidden mb-0">
                <div class="card-body p-4">
                  <h5 class="card-title fw-semibold">Informations Personnelles</h5>
                  <p class="card-subtitle mb-4">Pour modifier vos informations personnelles, éditez et enregistrez à partir d'ici.</p>
                  <?php if (!($_SESSION['is_verified'])) { ?>
                    <form method="post" class="needs-validation" novalidate="" action="./Profile.php">
                    <?php } else { ?>
                      <form method="post" class="needs-validation was-validated" novalidate="" action="./Profile.php">
                      <?php } ?>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="inputNom" class="form-label fw-semibold">Nom</label>
                            <input type="text" class="form-control" id="inputNom" required="" name="nom" placeholder="Votre nom" value="<?php echo $_SESSION['Nom'] ?>">
                          </div>
                          <div class="mb-4">
                            <label for="inputEmail" class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                              <input type="email" class="form-control is-invalid " id="inputEmail" name="email" placeholder="info@exemple.com" value="<?php echo $_SESSION['email'] ?>">
                              <?php if (!($_SESSION['is_verified'])) { ?>
                                <button type="button" onclick="verifyEmail()" class="btn btn-warning rounded-end" name="verify_email">Verifier</button>
                                <div class="invalid-feedback">
                                  Veuillez vérifier votre e-mail afin de pouvoir changer votre mot de passe en cas d'oubli.
                                </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="inputPrenom" class="form-label fw-semibold">Prenom</label>
                            <input type="text" class="form-control" id="inputPrenom" name="prenom" required="" placeholder="Votre prenom" value="<?php echo $_SESSION['prenom'] ?>">
                          </div>
                          <div class="mb-4">
                            <label for="inputUsername" class="form-label fw-semibold">username</label>
                            <input type="text" class="form-control" id="inputUsername" name="username" required="" placeholder="Votre nom d'utilisateur" value="<?php echo $_SESSION['username'] ?>">
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="d-flex align-items-center justify-content-end mt-4 gap-3">
                            <button type="submit" class="btn btn-primary" name="update_profile">Enregistrer</button>
                            <button type="reset" class="btn bg-danger-subtle text-danger">Annuler</button>
                          </div>
                        </div>
                      </div>
                      </form>
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
  <?php
  if (!empty($toast)) {
    echo $toast;
  }
  ?>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
    function verifyEmail() {
      let email = document.getElementById("inputEmail").value
      window.location = `http://localhost/ClassProjectAbsence/php/emailVerification.php?email=${email}`
    }
  </script>
  <?php
  // verification request alerts
  if (isset($_GET['etat']) && $_GET['etat'] == 'sent') {
    echo "<script>
            Swal.fire({
                title: 'Lien de vérification envoyé!',
                text: 'Nous avons envoyé un lien de vérification à votre adresse e-mail. Veuillez vérifier votre boîte de réception !',
                icon: 'success'
            });
        </script>";
  }
  if (isset($_GET['etat']) && $_GET['etat'] == 'empty') {
    echo "<script>
            toastr['warning']('Veuillez entrer une adresse e-mail avant la vérification !', 'E-mail requis !');
        </script>";
  }
  if (isset($_GET['etat']) && $_GET['etat'] == 'invalid') {
    echo "<script>toastr['warning']('L\'adresse e-mail fournie n\'est pas valide !', 'E-mail invalide')</script>";
  }
  if (isset($_GET['etat']) && $_GET['etat'] == 'exists') {
    echo "<script>toastr['warning']('Cette adresse e-mail est déjà enregistrée. Veuillez utiliser une autre adresse.', 'E-mail existant')</script>";
  }
  if (isset($_GET['etat']) && $_GET['etat'] == 'false') {
    echo "<script>toastr['warning']('Essayez d\'enregistrer cet e-mail avant de le vérifier', 'Aucun e-mail à vérifier')</script>";
  }

  //after user click to the lik in the his inbox alerts

  if (isset($_GET['validation']) && $_GET['validation'] == 'true') {    
    echo "<script>
            Swal.fire({
                title: 'Vérification réussie!',
                text: 'Félicitations ! Votre adresse e-mail a été vérifiée avec succès.',
                icon: 'success'
            });
        </script>";
  }
  if (isset($_GET['validation']) && $_GET['validation'] == 'already') {
    echo "<script>toastr['warning']('Cette adresse e-mail est déjà associée à un compte.', 'Adresse e-mail déjà enregistrée!')</script>";
  }

  ?>
</body>

</html>