<?php

require_once '../PHP_Mailer/src/Exception.php';
require_once '../PHP_Mailer/src/PHPMailer.php';
require_once '../PHP_Mailer/src/SMTP.php';
require_once '../constant.php';


// Instantiation and passing `true` enables exceptions
function send_mail(){
$mail = new \PHPMailer\PHPMailer\PHPMailer(true);


//Server settings
$mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_OFF;    // Enable verbose debug output
$mail->isSMTP();                                            // Send using SMTP
$mail->Host       = 'tls://smtp.gmail.com';                 // Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
$mail->Username   = MAIL_USERNAME;            // SMTP username
$mail->Password   = MAIL_PASSWORD;                     // SMTP password
$mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHP_Mailer::ENCRYPTION_SMTPS` encouraged
$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHP_Mailer::ENCRYPTION_SMTPS` above

//Recipients
$mail->setFrom('khatritechnical@gmail.com', 'Parth Khatri');
$mail->addAddress($_POST['customer_email'], $_POST['customer_name']); // Add a recipient
//  $mail->addAddress('ellen@example.com');               // Name is optional
//  $mail->addReplyTo('info@example.com', 'Information');
//  $mail->addCC('cc@example.com');
//  $mail->addBCC('bcc@example.com');

// Attachments
//  $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

// Content
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

$mail->send();

}
