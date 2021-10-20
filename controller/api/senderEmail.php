<?php
include '../../config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class senderMail
{


    public function send_email($email, $pdf)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $_ENV['MAIL_HOST'];                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $_ENV['MAIL_EMAIL'];                     //SMTP username
            $mail->Password   = $_ENV['MAIL_PASSWORD'];                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = $_ENV['MAIL_PORT'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($_ENV['MAIL_EMAIL'], $_ENV['MAIL_NAME']);   //Add a recipient
            $mail->addAddress($email);


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Invoice SIMAKET';
            $mail->Body    = 'This is your invoice, Thank you';
            $mail->AltBody = '*) Untuk menampilkan isi pesan ini dengan hasil terbaik gunakan mode compatible HTML!';
            if (count($pdf) > 0) {
                foreach ($pdf as $key => $value) {
                    $mail->addStringAttachment($key, $value);
                }
            }

            $mail->send();
            return array("success" => 1, "msg" => "Email Berhasil dikirimkan!");
        } catch (Exception $e) {
            return array("success" => 0, "msg" => $mail->ErrorInfo);
        }
    }
}
