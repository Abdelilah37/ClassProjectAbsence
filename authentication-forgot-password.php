<?php
session_start();
include('./Php/config.php');
$resultat = '';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['recuperer'])) {
  if (!empty($_POST['email'])) {
    $email = trim(htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'));

    $stmt = $pdo_conn->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->execute([$email]);
    $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() <= 0) {
      $resultat = "<script>toastr['warning']('Cette adresse e-mail n\'existe pas.', 'E-mail invalide')</script>";
    } elseif ($fetch["is_verified"] == 0) {
      $resultat = "<script>toastr['warning']('Votre adresse e-mail n\'a pas encore été vérifiée. Veuillez Consulter L\'admin.', 'E-mail invalide')</script>";
    } else {
      // generate token by binaryhexa 
      $token = bin2hex(random_bytes(50));

      // session_start ();
      $_SESSION['token'] = $token;
      $_SESSION['email'] = $email;

      // Load Composer's autoloader
      require("./PHPMailer/PHPMailer.php");
      require("./PHPMailer/SMTP.php");
      require("./PHPMailer/Exception.php");

      // Create an instance; passing `true` enables exceptions
      $mail = new PHPMailer(true);

      // Server settings
      $mail->isSMTP();                                   // Send using SMTP
      $mail->Host       = 'smtp.gmail.com';              // Set the SMTP server to send through
      $mail->SMTPAuth   = true;                          // Enable SMTP authentication
      $mail->Username   = 'anasfalah3@gmail.com';       // SMTP username
      $mail->Password   = 'wvwv czwl ynjg cypf';        // SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   // Enable implicit TLS encryption
      $mail->Port       = 465;

      // Recipients
      $mail->setFrom('anasfalah3@gmail.com', 'anas falah');
      $mail->addAddress($email);                        // Add a recipient

      // Content
      $mail->isHTML(true);                               // Set email format to HTML
      $mail->Subject = "Recover your ChatApp password";
      $mail->Body = file_get_contents("./assets/libs/emailTemplates/resetPassword.html");
      // $mail->Body = "<b>Cher utilisateur</b>
      //             <h3>Nous avons reçu une demande de réinitialisation de votre mot de passe.</h3>
      //             <p>Veuillez cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe</p>
      //             <a href='http://localhost/ClassProjectAbsence/authentication-reset-password.php'>Réinitialiser le mot de passe</a>
      //             <br><br>
      //             <p>Cordialement,</p>
      //             <b>Abcence Ntic</b>";


      if (!$mail->send()) {
        $resultat = "<script>toastr['warning']('L\'adresse e-mail fournie n\'est pas valide !', 'E-mail invalide')</script>";
      } else {
        $resultat = "<script>toastr['success']('Nous avons envoyé un e-mail de réinitialisation de mot de passe.', 'Lien de réinitialisation envoyé!')</script>";
      }
    }
  } else {
    $resultat = "<script>toastr['warning']('Veuillez entrer une adresse e-mail!', 'E-mail requis !')</script>";
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ofppt WFS205</title>
  <?php include('styles.php') ?>
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="./assets/images/Icons/loader-2.svg" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
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
                    Veuillez saisir l'adresse e-mail associée à votre compte. Nous vous enverrons un lien pour réinitialiser votre mot de passe.
                  </p>
                </div>
                <form action="./authentication-forgot-password.php" method="post">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" required>
                  </div>
                  <button type="submit" name="recuperer" class="btn btn-primary w-100 py-8 mb-3">Récupérer le mot de passe</button>
                  <a href="./authentication.php" class="btn bg-primary-subtle text-primary w-100 py-8">Retour à la connexion</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include('FOOTER.php') ?>
</div>
  <!-- Import Js Files -->
  <?php include('scripts.php') ?>
  <?php if ($resultat != '') {
    echo $resultat;
  }
  ?>
</body>

</html>