<?php
session_start();
include 'config.php';

require_once('SMTP.php');
require_once('PHPMailer.php');
require_once('Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject = $_POST['subject'];
    $msg = $_POST['message'];

    $name = $_SESSION['username'];
    
    $mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 's27081@pjwstk.edu.pl';
    $mail->Password   = 'odmi ovrt jwux mpyp';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->addAddress('s27081@pjwstk.edu.pl');

    $mail->isHTML(true);
    $mail->Subject = $name . ": " . $subject;
    $mail->Body = $msg;

    $mail->send();
    echo "Wyslano email pomyslnie";
} catch (Exception $e) {
    echo "Blad w trakcie wysylania {$mail->ErrorInfo}";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Napisz do autora</title>
</head>
<body>
<nav>
        <ul>
        <?php include 'navBar.php'?>
        </ul>
    </nav>
<form class="contactWriter" action="" method="post">
            <label for="">Temat</label>
            <input type="text" name="subject"><br>
            <label for="message">Wiadomość</label>
            <textarea id="message" name="message" rows="5" required></textarea><br>
            <input type="submit" value="Wyślij wiadomość"><br>
        </form>
</body>
</html>