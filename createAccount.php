<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarejestruj się</title>
</head>
<body>
    <h3>Formularz rejestracji</h3>
    <form action="" method="post">
        <label for="">Nazwa uzytkownika</label><br>
        <input type="text" name="username"><br>
        <label for="">E-mail</label><br>
        <input type="mail" name="email"><br>
        <label for="">Hasło</label><br>
        <input type="password" name="password"><br>
        <input type="submit">
    </form>
</body>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include 'config.php';

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $password = password_hash($password,PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, passcode, email) VALUES ('$username','$password','$email')";

    if(mysqli_query($db, $sql)){
        echo "<p>Dodano uzytkownika</p>";
        header("Location: login.php");
        exit();
    }else{
        echo "Error";
    }
}
?>
</html>