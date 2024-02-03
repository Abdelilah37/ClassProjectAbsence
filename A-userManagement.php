<?php
// Paths updated
try {
  include('./Php/sideBar.php');
  include('./Php/session.php');
  $usernames = $_SESSION["username"];
  $sqlSelect = "SELECT * FROM user WHERE id != ? ORDER BY Role ASC ";

  $stmtSelect = $pdo_conn->prepare($sqlSelect);
  $stmtSelect->execute([$_SESSION['id']]);
  $users = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
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

    <div class="container-fluid">

      <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
              <h4 class="fw-semibold mb-8">Gestion des utilisateurs</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="./index.php">Home</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">Gestion des utilisateurs</li>
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
      <div class="card" style="z-index: auto;">
        <div class="card-body">
          <div class="row">
            <div class="table-responsive rounded-2 mb-4">
              <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="text-dark fs-4">
                  <tr>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Utilisateur</h6>
                    </th>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Username</h6>
                    </th>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Email</h6>
                    </th>
                    <th>
                      <h6 class="fs-4 fw-semibold mb-0">Password</h6>
                    </th>
                    <th>

                    </th>
                  </tr>
                </thead>
                <tbody style="max-height: 300px; overflow-y: auto;">
                  <?php foreach ($users as $user) : ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <span class="avatar-container" data-width="39px" data-initials="<?php echo extractInitials($user) ?>" data-color="<?php echo $user['avatar'] ?>"></span>
                          <div class="ms-3">
                            <h6 class="fs-4 fw-semibold mb-0">
                              <?php
                              if ($user['Nom'] or $user['prenom']) {
                                echo $user['Nom'] . ' ' . $user['prenom'];
                              } else {
                                echo $user['username'];
                              }
                              ?>
                            </h6>
                            <span class="fw-normal"><?php echo $user['Role'] ?></span>
                          </div>
                        </div>
                      </td>
                      <td><?php echo $user['username'] ?></td>
                      <td><?php echo $user['Email'] ?></td>
                      <td><?php echo $user['password'] ?></td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="#" class="text-muted" id="dropdownMenuButton<?php echo $user['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $user['id']; ?>" style="">
                            <li>
                              <!-- Modal Trigger Link -->
                              <a class="cursor-pointer dropdown-item d-flex align-items-center gap-3" data-bs-toggle="modal" data-bs-target="#editUserModal<?php echo $user['id']; ?>">
                                <i class="fs-4 ti ti-edit"></i> Modifier
                              </a>
                            </li>
                            <li>
                              <!-- Delete Link -->
                              <a class="cursor-pointer dropdown-item d-flex align-items-center gap-3" onclick="confirmDeletionUser(<?php echo $user['id'] ?>)"><i class="fs-4 ti ti-trash"></i> Supprimer</a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>

                    <div class="modal fade" id="editUserModal<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="editUserModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel<?php echo $user['id']; ?>">Modification d'utilisateur <?php echo $user['id']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body  pb-0 px-5">

                            <form action="./Php/UserGestion.php" method="post" id="updateForm<?php echo $user['id']; ?>">
                              <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

                              <div class="row mb-3">
                                <div class="col-md-6">
                                  <label for="nom" class="">Nom</label>
                                  <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $user['Nom']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                  <label for="prenom" class="">Prenom</label>
                                  <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $user['prenom']; ?>" required>
                                </div>
                              </div>
                              <div class="row mb-3">
                                <div class="col-md-6">
                                  <label for="username" class="">Username</label>
                                  <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                  <label for="password" class="">Password</label>
                                  <input type="password" class="form-control" value="<?php echo $user['password'] ?>" id="password" name="password" required>
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-md-6">
                                  <label for="email" class="">Email</label>
                                  <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['Email']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                  <label for="role" class="">Role</label>
                                  <select class="form-select form-control" id="role" name="role" required>
                                    <option value="surveillant" <?php echo ($user['Role'] === 'surveillant') ? 'selected' : ''; ?>>Surveillant</option>
                                    <option value="admin" <?php echo ($user['Role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                  </select>
                                </div>
                              </div>

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" name="modifier" class="btn btn-primary rounded-pill">Enregistrer les modifications</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- Larger Add User Modal Trigger Button -->
          <button class="btn mb-1 bg-primary-subtle text-primary btn-lg px-4 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#addUserModal">
            Ajouter utilisateur
          </button>
        </div>
      </div>
      <!-- Larger Add User Modal -->
      <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addUserModalLabel">Ajouter Nouveau Utilisateur</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body  pb-0 px-5">

              <form action="./Php/UserGestion.php" method="post" id="ajouterUser">
                <div class="row mb-2">
                  <div class="col-md-12 d-flex justify-content-center">
                    <input type="color" class="form-control-color form-control rounded-pill  " name="avatar" id="ColorInput" value="#563d7c" style="height: 35px;width:35px;" title="Choisir la couleur de profile">
                  </div>
                </div>
                <div class="row mb-2 mt-2">
                  <div class="col-md-6">
                    <label for="nom" class="">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                  </div>
                  <div class="col-md-6">
                    <label for="prenom" class="">Prenom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" required>
                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-md-6">
                    <label for="username" class="">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                  </div>
                  <div class="col-md-6">
                    <label for="password" class="">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-md-6">
                    <label for="email" class="">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                  <div class="col-md-6">
                    <label for="role" class="">Role</label>
                    <select class="form-select form-control" id="role" name="role" required>
                      <option value="surveillant">surveillant</option>
                      <option value="admin">Admin</option>
                    </select>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary rounded-pill" form="ajouterUser" name="ajouter">Ajouter utilisateur</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include('FOOTER.php') ?>
  </div>
  </div>

  <?php include('scripts.php') ?>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
    function confirmDeletionUser(id) {
      Swal.fire({
        title: "Cet utilisateur sera supprimé.",
        text: "vous ne pouvez pas le restaurer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Oui, supprimez-le.",
        cancelButtonText: "Annuler",
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "./Php/UserGestion.php?id=" + encodeURIComponent(id);
        }
      });
    }
  </script>

  <?php
  if (isset($_GET["insert"]) && $_GET["insert"] == "true") {
    echo "<script>
        toastr['success']('Utilisateur été Ajouter avec succès.', 'Utilisateur Ajouter')
        </script>";
  }
  if (isset($_GET["insert"]) && $_GET["insert"] == "false") {
    echo "<script>
        toastr['error']('L\'utilisateur n\'a pas été ajouté.', 'Ajout d\'utilisateur échoué')
        </script>";
  }

  if (isset($_GET["deleted"]) && $_GET["deleted"] == "true") {
    echo "<script>
        toastr['success']('Utilisateur été Supprimé avec succès.', 'Utilisateur Supprimé')
        </script>";
  }
  if (isset($_GET["edited"]) && $_GET["edited"] == "true") {
    echo "<script>
        toastr['success']('Utilisateur été Modifié avec succès.', 'Utilisateur Modifié')
        </script>";
  }
  ?>
</body>

</html>