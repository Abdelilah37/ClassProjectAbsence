<?php
include('./config.php');
include('./session.php');

if($_SESSION['Role'] == "admin"){
  if ($_SERVER["REQUEST_METHOD"] == 'GET' && isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "DELETE FROM user WHERE id= ?";
    $stmt = $pdo_conn->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();


    header("Location:../A-userManagement.php?deleted=true");
    exit();
  }

  if (isset($_POST["ajouter"])) {
    try {
      $nom = $_POST['nom'];
      $prenom = $_POST['prenom'];
      $username = $_POST['username'];
      $password = $_POST['password']; // Hash the password
      $email = $_POST['email'];
      $role = $_POST['role'];
      $avatar = $_POST['avatar'];

      $sqlInsert = "INSERT INTO user (username, password, Email, Nom, prenom, Role,avatar) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $pdo_statement = $pdo_conn->prepare($sqlInsert);
      $pdo_statement->bindParam(1, $username);
      $pdo_statement->bindParam(2, $password);
      $pdo_statement->bindParam(3, $email);
      $pdo_statement->bindParam(4, $nom);
      $pdo_statement->bindParam(5, $prenom);
      $pdo_statement->bindParam(6, $role);
      $pdo_statement->bindParam(7, $avatar);
      $pdo_statement->execute();
      header("location:../A-userManagement.php?insert=true");
    } catch (Exception $e) {
      header("location:../A-userManagement.php?insert=false");
    }
  }

  if (isset($_POST["modifier"])) {
    $user_id = $_POST['user_id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    // Check if the user exists
    $sqlCheckUser = "SELECT * FROM user WHERE id = ?";
    $stmtCheckUser = $pdo_conn->prepare($sqlCheckUser);
    $stmtCheckUser->bindParam(1, $user_id);
    $stmtCheckUser->execute();
    $existingUser = $stmtCheckUser->fetch(PDO::FETCH_ASSOC);

    if ($_SESSION['id'] == $user_id) {
      $_SESSION['username'] = $username;
      $_SESSION['Nom'] = $nom;
      $_SESSION['prenom'] = $prenom;
      $_SESSION['email'] = $email;
      $_SESSION['Role'] = $role;
    }

    if ($existingUser) {
      // Update the user information
      $sqlUpdate = "UPDATE user SET username = ?, password = ?, Email = ?, Nom = ?, prenom = ?, Role = ? WHERE id = ?";
      $pdo_statement = $pdo_conn->prepare($sqlUpdate);
      $pdo_statement->bindParam(1, $username);
      $pdo_statement->bindParam(2, $password);
      $pdo_statement->bindParam(3, $email);
      $pdo_statement->bindParam(4, $nom);
      $pdo_statement->bindParam(5, $prenom);
      $pdo_statement->bindParam(6, $role);
      $pdo_statement->bindParam(7, $user_id);

      if ($pdo_statement->execute()) {
        // Update session variables


        header("location:../A-userManagement.php?edited=true");
      }
    }
  }
}else{
  header("Location: ./index.php");
  exit();
}
