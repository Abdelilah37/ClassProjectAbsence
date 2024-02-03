<?php
$errorMessage = isset($_GET['error']) ? urldecode($_GET['error']) : "An unknown error occurred.";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/svg+xml" href="./assets/images/Icons/faviconLight.svg">
  <link rel="stylesheet" href="./assets/css/styles.min.css" />


  <title>404</title>
</head>

<body>
  <!-- Preloader -->

  <div class="preloader" >
    <img src="./assets/images/Icons/loader-2.svg" alt="loader" class="lds-ripple img-fluid" />
  </div>

  <div id="main-wrapper">
    <div class="position-relative overflow-hidden min-vh-100 w-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-lg-4">
            <div class="text-center">
              <img src="./assets/images/backgrounds/errorimg.svg" alt="" class="img-fluid" width="500">
              <h1 class="fw-semibold mb-7 fs-9">Opps!!!</h1>
              <h4 class="fw-semibold mb-2">La page que vous recherchez est introuvable.</h4>
              <h6 class="fw-semibold mb-6"><?php echo $errorMessage; ?></h6>
              <a class="btn btn-primary" href="./index.php" role="button">Go Back to Home</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->
  <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="./assets/libs/jquery/dist/jquery.slim.min.js"></script>
  <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/loaderInit.js"></script>

</body>

</html>