<?php 
    //SMTP needs accurate times, and the PHP time zone MUST be set
    //This should be done in your php.ini, but this is how to do it if you don't have access to that
    date_default_timezone_set('Etc/UTC');
    require 'PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer(); // create a new object
    $mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only  
    $mail->IsSMTP(); // enable SMTP
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true; // authentication enabled  
    $mail->Username = ""; //put gmail account here example@gmail.com
    $mail->Password = ""; //your mail accounts
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail 
    $mail->Port = 587; // or 465  
    $mail->AddAddress($to);
    $mail->isHtml(true);
    $mail->Subject = "Booking Confimation";
    $mail->Body = $messagebody;
    $mail->send(); 
?>