<?php
use PHPMailer\PHPMailer\PHPMailer;


require_once dirname(__DIR__) . '/vendor/autoload.php';

require_once dirname(__DIR__) . '/phpmailer/src/Exception.php';
require_once dirname(__DIR__) . '/phpmailer/src/PHPMailer.php';
require_once dirname(__DIR__) . '/phpmailer/src/SMTP.php';

function sendmymail($monnom, $monmail, $subject, $message){
    
    global $me; 

    $mail = new PHPMailer();
    $mail->SMTPDebug = 0; 
    $mail->SMTPSecure = 'ssl';    //Enable verbose debug output
    $mail->isSMTP();       //Send using SMTP
    $mail->Host       = 'smtp.gmail.com'; //Set the SMTP server to send through
    $mail->SMTPAuth   = true;       //Enable SMTP authentication
    $mail->Username   = 'hpnyckit@gmail.com';   //SMTP username
    $mail->Password   = 'odbjvcmjedptvgmx';   //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;//Enable implicit TLS encryption
    $mail->Port       = 465;  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $mail->setFrom($monmail, $monnom);
    $mail->addAddress($me, 'NYC Test'); //Add a recipient
    
    $mail->isHTML(true);    //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;

    if($mail->send()){
        $success = 'Un mail récapitulatif vous a été envoyé<br>';
            }
        else{
        echo "Erreur d'envoi du mail";
    }
    
}
?>