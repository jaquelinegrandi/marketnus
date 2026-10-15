<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    $mail = new PHPMailer(true);

    try {

        // SMTP de Hostinger
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;

        // TU CORREO
        $mail->Username   = 'contact@marketnus.com';

        // TU CONTRASEÑA DEL EMAIL
        $mail->Password   = 'Marketing3!';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Remitente
        $mail->setFrom('contact@marketnus.com', 'Marketnus Website');

        // Destino
        $mail->addAddress('contact@marketnus.com');

        // Para responder al cliente
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);

        $mail->Subject = 'New Contact Form Submission';

        $mail->Body = "
        <h2>New Contact Request</h2>

        <strong>Name:</strong> {$name}<br><br>

        <strong>Phone:</strong> {$phone}<br><br>

        <strong>Email:</strong> {$email}<br><br>

        <strong>Message:</strong><br>
        {$message}
        ";

        $mail->send();

        header("Location: contact.html?success=1");
        exit();

    } catch (Exception $e) {

        echo "Message could not be sent. Error: {$mail->ErrorInfo}";

    }

}