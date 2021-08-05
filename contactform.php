<?php
    // declare PHP variables out of the form input
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $visitor_message = $_POST['message'];
    $email_body = "<html><body><div>";

    if(isset($_POST['name'])) {
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $email_body .= "Voornaam: ".$name."\r\n";
    }

    if(isset($_POST['lastname'])) {
        $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
        $email_body .= "Achternaam: ".$lastname."\r\n";
    }

    if(isset($_POST['email'])) {
        $visitor_email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['email']);
        $visitor_email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $email_body .= "Email adres: ".$email."\r\n";
    }
      
    if(isset($_POST['phonenumber'])) {
        $phonenumber = filter_var($_POST['phonenumber'], FILTER_SANITIZE_NUMBER_INT);
        $email_body .= "Telefoonnummer: ".$phonenumber."\r\n";
    }
      
    if(isset($_POST['visitor_message'])) {
        $visitor_message = htmlspecialchars($_POST['visitor_message']);
        $email_body .= "Bericht: ".$message."\r\n";
    }

    $from = "no-reply@markslag-opleidingen-advies.nl";
    $to = "info@markslag-opleidingen-advies.nl";
    $subject = "U heeft een nieuw bericht!";
    $message = $email_body;

    $header = "From:" . $from . "\r\n";
    $header .= 'MIME-Version: 1.0' . "\r\n";
    $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";

    mail($to, $subject, $message);

?>