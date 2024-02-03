<?php
include('./config.php');
include('./session.php');


if (isset($_GET['email']) && isset($_GET['v_code'])) {
      $email = $_GET['email'];
      $v_code = $_GET['v_code'];

      // Using prepared statements to prevent SQL injection
      $query = "SELECT * FROM user WHERE Email = ? AND verification_code = ?";
      $stmt = $pdo_conn->prepare($query);
      $stmt->execute([$email, $v_code]);

      if ($stmt->rowCount() == 1) {
            $result_fetch = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result_fetch['is_verified'] == 0) {
                  // Update user to mark as verified
                  $update = "UPDATE user SET is_verified = 1 WHERE Email = ?";
                  $stmt_update = $pdo_conn->prepare($update);
                  if ($stmt_update->execute([$email])) {
                        $_SESSION['is_verified'] = true;
                        header("Location: ../profile.php?validation=true");
                        exit();
                  } else {
                        echo "Failed to update user status.";
                  }
            } else {
                  header("Location: ../profile.php?validation=already");
                  exit();
            }
      } else {
            echo "Invalid email or verification code.";
      }
} else {
      echo "Invalid parameters.";
}
