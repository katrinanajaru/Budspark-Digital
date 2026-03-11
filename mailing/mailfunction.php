<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require('./vendor/autoload.php');
require 'mailingvariables.php';

function mailfunction($mail_reciever_email, $mail_reciever_name, $mail_msg, $attachment = false){

    $mail = new PHPMailer();
    $mail->isSMTP();

    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

    $mail->Host = $GLOBALS['mail_host'];

    $mail->Port = $GLOBALS['mail_port'];

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->SMTPAuth = true;

    $mail->Username = $GLOBALS['mail_sender_email'];

    $mail->Password = $GLOBALS['mail_sender_password'];

    $mail->setFrom($GLOBALS['mail_sender_email'], $GLOBALS['mail_sender_name']);

    $mail->addAddress($mail_reciever_email, $mail_reciever_name);

    $mail->Subject = 'Someone Contacted You!';

    $mail->isHTML($isHtml = true );

    $mail->msgHTML($mail_msg);


    if($attachment !== false){
        $mail->AddAttachment($attachment);
    }
    
    $mail->AltBody = 'This is a plain-text message body';
 
    if (!$mail->send()) {
        return false;
    } else {
        return true;
    }
}

/* =========================================
   Consultation Form Handling
   ========================================= */

if (isset($_POST['submit'])) {
    // Sanitize form inputs
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $phone   = htmlspecialchars($_POST['phone']);
    $project = htmlspecialchars($_POST['project']);

    // Build the email message
    $message = "
        <h2>New Consultation Booking</h2>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone:</strong> {$phone}</p>
        <p><strong>Project / Query:</strong> {$project}</p>
    ";

    // Handle optional attachment
    $attachment = false;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        $attachment = $_FILES['attachment']['tmp_name'];
    }

    // Send email to Ian
    $sent = mailfunction('iankinyua322@gmail.com', 'Ian Kinyua', $message, $attachment);

    if ($sent) {
        echo "<script>alert('Thank you! Your consultation request has been sent successfully.'); window.location='../index.html';</script>";
    } else {
        echo "<script>alert('Oops! Something went wrong. Please try again later.'); window.location='../index.html';</script>";
    }
}

?>
