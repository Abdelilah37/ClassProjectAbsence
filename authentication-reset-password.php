<?php
session_start();
include('./Php/config.php');
$resultat = '';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['reset'])) {
  if (!empty(trim($_POST['NewPassword']))) {
    $NewPassword = trim(htmlspecialchars($_POST['NewPassword']));
    $Email = $_SESSION['email'];

    if (!empty($NewPassword)) {
      $stmt = $pdo_conn->prepare("SELECT * FROM user WHERE Email = :email");
      $stmt->bindParam(':email', $Email);
      $stmt->execute();

      $rowCount = $stmt->rowCount();

      if ($rowCount > 0) {
        $updateStmt = $pdo_conn->prepare("UPDATE user SET password = :password WHERE Email = :email");
        $updateStmt->bindParam(':password', $NewPassword);
        $updateStmt->bindParam(':email', $Email);
        $updateStmt->execute();

        $resultat = "<script>toastr['success']('Votre mot de passe a été réinitialisé avec succès.', 'Réinitialisation réussie!')</script>";
        $resultat .= "<script>setTimeout(function(){ window.location.href = './authentication.php'; }, 3000);</script>";
      } else {
        $resultat = "<script>toastr['warning']('Veuillez saisir un nouveau mot de passe!', 'Veuillez réessayer!')</script>";
      }
    } else {
      $resultat = "<script>toastr['warning']('Veuillez saisir un nouveau mot de passe!', 'Nouveau mot de passe requis!')</script>";
    }
  } else {
    $resultat = "<script>toastr['warning']('Veuillez saisir un nouveau mot de passe!', 'Nouveau mot de passe requis!')</script>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ofppt WFS205</title>
  <link rel="stylesheet" href="./assets/libs/dataTable/dataTables.bootstrap5.min.css">
  <?php include('styles.php') ?>
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="./assets/images/Icons/loader-2.svg" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div class="container-fluid">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body pt-5">
                <a href="./index.php" class="text-nowrap logo-img text-center d-block mb-4 w-100">
                  <img src="./assets/images/logos/dark-logo.png" width="200px" class="dark-logo" alt="Logo-Dark" />
                </a>
                <div class="mb-5 text-center">
                  <p class="mb-0 ">
                    Veuillez définir un nouveau mot de passe pour votre compte.
                  </p>
                </div>
                <form action="./authentication-reset-password.php" method="post">
                  <div class="mb-3">
                    <label for="NewPassword" class="form-label">New Password</label>
                    <input type="password" onchange="validatePasswords()" class="form-control" id="NewPassword" name="NewPassword" required>
                  </div>
                  <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" onchange="validatePasswords()" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    <span id="passwordMismatch" style="color: red;"></span>
                  </div>
                  <button type="submit" name="reset" id="reset" class="btn btn-primary w-100 py-8 mb-3" disabled>Confirmer le changement</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include('FOOTER.php') ?>
  <!-- Import Js Files -->
  <?php include('scripts.php') ?>
  <?php if ($resultat != '') {
    echo $resultat;
  }
  ?>
  <script>
    function validatePasswords() {
      // Get the values of the new password and confirmation password fields
      let newPassword = document.getElementById("NewPassword").value;
      let confirmPassword = document.getElementById("confirmPassword").value;

      // Check if passwords match

      if (newPassword != confirmPassword) {
        document.getElementById("passwordMismatch").style.display = 'block';
        document.getElementById("passwordMismatch").innerHTML = "**Passwords are not same";
        document.getElementById("reset").disabled = true

      } else {
        document.getElementById("passwordMismatch").style.display = 'none';
        document.getElementById("reset").disabled = false
      }

    }
  </script>

</body>

</html>