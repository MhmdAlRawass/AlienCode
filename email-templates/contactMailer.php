<?php
header('Content-Type: application/json');

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; 
    $mail->SMTPAuth   = true;
    $mail->Username   = 'smash.team.p@gmail.com';
    $mail->Password   = 'nodk ocxm hacz avtb'; 
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587; 

    
    $name    = $_POST['name'] ?? 'Anonymous';
    $email   = $_POST['email'] ?? 'no-reply@yourdomain.com'; 
    $phone   = $_POST['phone'] ?? '00000';
    $subject = "New Contact Message from AlienCode Website"; 
    $message = $_POST['comment'] ?? 'No message provided.';

    
    $mail->setFrom('smash.team.p@gmail.com', 'AlienCode-Mailer');

    
    $mail->addAddress('smash.team.p@gmail.com');

    
    if (
    filter_var($email, FILTER_VALIDATE_EMAIL) &&
    strtolower($email) !== 'smash.team.p@gmail.com'
    ) {
        $mail->addReplyTo($email, $name);
    }


    // $mail->SMTPDebug = 2; // or use 3 for more detail
    // $mail->Debugoutput = 'html';


    
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = "
        <h3>New Contact Form Submission</h3>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone Number:</strong> {$phone}</p>
        <p><strong>Subject:</strong> {$subject}</p>
        <p><strong>Message:</strong><br>{$message}</p>
    ";

    
    
    if ($mail->send()) {
        echo json_encode([
            'alert' => 'alert alert-success alert-dismissable',
            'message' => 'Your message has been sent successfully!'
        ]);
    } else {
        echo json_encode([
            'alert' => 'alert alert-danger alert-dismissable',
            'message' => 'Your message could not be sent!'
        ]);
    }
} catch (Exception $e) {
    echo '{ "alert": "alert alert-danger alert-dismissable", "message": "Mail Error: ' . $mail->ErrorInfo . '" }';
}
?>
