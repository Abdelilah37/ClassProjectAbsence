<?php
// Paths Updated
session_start();
include('./Php/config.php');
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
  if (isset($_POST["submit"])) {
    try {
      $usernameOrEmail = $_POST["username"];
      $Password = $_POST["Password"];
      $error = "";

      // Check if both username and password are not empty
      if (!empty($usernameOrEmail) && !empty($Password)) {
        $sql = "SELECT * FROM user WHERE (username = ? OR Email = ?) AND password = ?";
        $stmt = $pdo_conn->prepare($sql);
        $stmt->bindParam(1, $usernameOrEmail);
        $stmt->bindParam(2, $usernameOrEmail);
        $stmt->bindParam(3, $Password);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if ($stmt->rowCount() > 0 && ($usernameOrEmail == $resultat['username'] || $usernameOrEmail == $resultat['Email']) && $Password == $resultat['password']) {
          $_SESSION['id'] = $resultat['id'];
          $_SESSION['username'] = $resultat['username'];
          $_SESSION['Nom'] = $resultat['Nom'];
          $_SESSION['prenom'] = $resultat['prenom'];
          $_SESSION['email'] = $resultat['Email'];
          $_SESSION['Role'] = $resultat['Role'];
          $_SESSION['avatar'] = $resultat['avatar'];
          $_SESSION['is_verified'] = $resultat['is_verified'];
          // $_SESSION['password'] = $resultat['password'];
          header("location: ./index.php");
          exit();
        } else {
          $error = "Identifiants de connexion invalides!";
        }
      } else {
        $error = "Le nom d'utilisateur et le mot de passe sont requis!";
      }
    } catch (PDOException $e) {
      $error = "Une erreur est survenue. Veuillez réessayer plus tard!";
      header("location: ./authentication.php");
      exit();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OFPPT Gestionnaire d'absence</title>
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="icon" type="image/svg+xml" href="./assets/images/Icons/faviconLight.svg">


  <link rel="stylesheet" href="./assets/css/authentification.css" />
  <style>
    * {
      font-family: "Plus Jakarta Sans", "Poppins", sans-serif;
    }

    .error-message {
      width: 320px;
      padding: 12px;
      background: #FCE8DB;
      border-radius: 8px;
      border: 1px solid #EF665B;
      box-shadow: 0px 0px 5px -3px #111;
    }

    .error__title {
      font-weight: 500;
      font-size: 14px;
      color: #71192F;
    }
  </style>
</head>

<body>
  <div class="preloader">
    <img src="./assets/images/Icons/loader-2.svg" alt="loader" class="lds-ripple img-fluid" />
  </div>

  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="./authentication.php" method="post" class="sign-in-form">

          <h2 class="title">Se connecter</h2>
          <!-- Display errors here -->
          <?php
          if (!empty($error)) {
            echo '<div class="error-message">';
            echo '<div class="error__title">' . $error . '</div>';
            echo '</div>';
          }
          ?>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="username" placeholder="Nom d'utilisateur" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" id="exampleInputPassword1" name="Password" placeholder="Mot de passe" />
          </div>
          <div class="fp-link">
            <a class="text-primary" href="./authentication-forgot-password.php">Mot de passe oublié ?</a>
          </div>
          <input type="submit" name="submit" value="Se connecter" class="btn solid" />
        </form>
        <form action="#" class="sign-up-form">
          <h2 class="title">À propos de nous</h2>
          <p class="social-text">
            Bienvenue sur notre plateforme de Gestion des Absences de l'ISTA NTIC SYBA. Nous avons pour mission de simplifier la gestion des absences afin de créer un environnement d'apprentissage optimal. Notre solution propose un suivi précis, des notifications automatisées, des rapports personnalisés, et s'intègre aisément aux systèmes existants. Engagée envers l'excellence éducative, notre équipe est là pour répondre à vos besoins.</p>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <img src="./assets/images/logos/dark-logo.png" class="image" alt="">
          <p>
            Systeme De Gestion D'Absence
          </p>
          <button class="btn transparent" id="sign-up-btn">
            À propos de nous
          </button>
        </div>
        <img src="./assets/images/logos//register.svg" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <img src="./assets/images/logos/dark-logo.png" class="image" alt="">
          <p>
            Systeme De Gestion D'Absence
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Se connecter
          </button>
        </div>
        <img src="./assets/images/logos//log.svg" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="./assets/js/loaderInit.js"></script>
  <script src="./assets/js/authentification.js"></script>
</body>

</html>