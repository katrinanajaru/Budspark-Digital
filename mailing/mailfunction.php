<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/mailingvariables.php';

function mailfunction($mail_recievers, $mail_msg, $plainTextMsg, $replyToEmail = '', $replyToName = '', $attachment = false){
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();

        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

        $mail->Host = $GLOBALS['mail_host'];
        $mail->Port = (int) $GLOBALS['mail_port'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = $GLOBALS['mail_sender_email'];
        $mail->Password = $GLOBALS['mail_sender_password'];
        $mail->CharSet = 'UTF-8';

        $mail->setFrom($GLOBALS['mail_sender_email'], $GLOBALS['mail_sender_name']);

        foreach ($mail_recievers as $recipient) {
            $recipientEmail = $recipient['email'] ?? '';
            $recipientName = $recipient['name'] ?? '';

            if (!empty($recipientEmail)) {
                $mail->addAddress($recipientEmail, $recipientName);
            }
        }

        if (!empty($replyToEmail)) {
            $mail->addReplyTo($replyToEmail, $replyToName);
        }

        $mail->Subject = 'Someone Contacted You!';
        $mail->isHTML(true);
        $mail->msgHTML($mail_msg);
        $mail->AltBody = $plainTextMsg;

        if ($attachment !== false) {
            $mail->addAttachment($attachment);
        }

        $mail->send();
        return array('success' => true, 'error' => '');
    } catch (Exception $e) {
        return array('success' => false, 'error' => $mail->ErrorInfo ?: $e->getMessage());
    }
}

function buildPlainTextMessage($name, $email, $phone, $project) {
    return "New Consultation Booking\n"
        . "Name: {$name}\n"
        . "Email: {$email}\n"
        . "Phone: {$phone}\n"
        . "Project / Query: {$project}\n";
}

function isMailConfigReady() {
    return !empty($GLOBALS['mail_host']) &&
        !empty($GLOBALS['mail_port']) &&
        !empty($GLOBALS['mail_sender_email']) &&
        !empty($GLOBALS['mail_sender_password']) &&
        !empty($GLOBALS['mail_sender_name']);
}

/* =========================================
   Consultation Form Handling
   ========================================= */

if (isset($_POST['submit'])) {
    if (!isMailConfigReady()) {
        echo "<script>alert('Email delivery is not configured yet. Please add SMTP sender credentials in mailing/mailingvariables.php first.'); window.location='../index.html';</script>";
        exit;
    }

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

    $recipients = array(
        array('email' => 'iankinyua322@gmail.com', 'name' => 'Ian Kinyua'),
        array('email' => 'katrinanajaru1@gmail.com', 'name' => 'Katrina Najaru'),
    );

    $plainTextMessage = buildPlainTextMessage($name, $email, $phone, $project);
    $sendResult = mailfunction($recipients, $message, $plainTextMessage, $email, $name, $attachment);

    if ($sendResult['success']) {
        echo "<script>alert('Thank you! Your consultation request has been sent successfully.'); window.location='../index.html';</script>";
    } else {
        error_log('BudSpark consultation mail error: ' . $sendResult['error']);
        $errorMessage = $sendResult['error'] ?: 'Unknown mail error.';
        $safeErrorMessage = htmlspecialchars($errorMessage, ENT_QUOTES);
        echo "<script>alert('Mail error: {$safeErrorMessage}'); window.location='../index.html';</script>";
    }
}

?>
