
<?php
session_start();
include('./config.php');

$email = trim(htmlspecialchars($_GET['email'], ENT_QUOTES, 'UTF-8'));

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendmail($email, $v_code)
{
    require("../PHPMailer/PHPMailer.php");
    require("../PHPMailer/SMTP.php");
    require("../PHPMailer/Exception.php");

    $mail = new PHPMailer(true);

    try {
        if(!($_SESSION['is_verified'])){


            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'anasfalah3@gmail.com';
            $mail->Password   = 'wvwv czwl ynjg cypf';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('anasfalah3@gmail.com', 'anas falah');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Email verification from OFPPT';
            $messageHTML = file_get_contents("../assets/libs/emailTemplates/emailVerificationTop.html") .
                            "<a href='http://localhost/classProjectAbsence/Php/verify.php?email=$email&v_code=$v_code' target='_blank' style='text-decoration: none; display: inline-block; color: #ffffff; background-color: #506bec; border-radius: 16px; width: auto; border: 0; padding: 8px 20px; font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 15px; text-align: center;'>
                                <span style='padding-left: 25px; font-size: 15px;'>
                                    <strong>CONFIRMER</strong>
                                </span>
                        </a>"
                . file_get_contents("../assets/libs/emailTemplates/emailVerificationBottom.html");
            $mail->Body    = $messageHTML;
            $mail->send();
            echo true;
        }else{
        
        }
    } catch (Exception $e) {
        echo false;
    }
}

if (!empty($email)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo_conn->prepare("SELECT Email FROM user WHERE Email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 1) {
            header("Location: ../profile.php?etat=exists");
            exit();
        }elseif ($stmt->rowCount() < 1) {
            header("Location: ../profile.php?etat=false");
            exit();
        }else {
            $v_code = bin2hex(random_bytes(16));
            $user = $_SESSION['username'];

            $stmt2 = $pdo_conn->prepare("UPDATE user SET verification_code = ? WHERE username = ?");
            if ($stmt2->execute([$v_code, $user]) && sendmail($email, $v_code)) {
                $stmt3 = $pdo_conn->prepare("SELECT * FROM user WHERE Email = ?");
                $stmt3->execute([$email]);

                if ($stmt3->rowCount() > 0) {
                    $row = $stmt3->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['username'] = $row['username'];
                    echo "success";
                }
            } else {
                header("Location: ../profile.php?etat=sent");
                exit();
            }
        }
    } else {
        header("Location: ../profile.php?etat=invalid");
        exit();
    }
} else {
    header("Location: ../profile.php?etat=empty");
    exit();
}
?>