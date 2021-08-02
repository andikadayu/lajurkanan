<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include '../config.php';

$mail = new PHPMailer(true);


if ($_GET['purpose'] == 'cekEmail') {
    $email = $_GET['email'];

    $sql = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$email' AND is_active=1");
    if (mysqli_num_rows($sql) > 0) {
        $six_digit_random_number = random_int(100000, 999999);

        $sq = mysqli_query($conn, "UPDATE tb_user SET code='$six_digit_random_number' WHERE email='$email'");
        if ($sq) {
            try {

                //Server settings
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = $_ENV['EMAIL_USERNAME'];                     //SMTP username
                $mail->Password   = $_ENV['EMAIL_PASSWORD'];                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom($_ENV['EMAIL_USERNAME'], $_ENV['NAME_APP']);   //Add a recipient
                $mail->addAddress($email);


                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Reset your Password';
                $mail->Body    = 'This is your Code OTP : <b>' . $six_digit_random_number . '</b>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                echo 'success';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }
}

if ($_GET['purpose'] == "cekOTP") {
    $email = $_GET['email'];
    $code = $_GET['code'];

    $sql = mysqli_query($conn, "SELECT email FROM tb_user WHERE email='$email' AND code='$code' AND is_active=1");
    if (mysqli_num_rows($sql) > 0) {
        echo "success";
    } else {
        echo "error";
    }
}

$conn->close();
