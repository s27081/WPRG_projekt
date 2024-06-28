<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Zarejestruj się</title>
</head>
<body>
<nav>
    <ul>
    <?php include 'navBar.php'?>
    </ul>
    </nav>
    <h3>Formularz rejestracji</h3>
    <form class="login" action="" method="post">
        <label for="">Nazwa uzytkownika</label>
        <input type="text" name="username"><br>
        <label for="">E-mail</label>
        <input type="mail" name="email"><br>
        <label for="">Hasło</label>
        <input type="password" name="password"><br>
        <input type="submit">
    </form>
</body>

<?php


include 'config.php';

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sqlCheckUsername = "SELECT * FROM users WHERE email = '$email'";

    $sqlCheckEmail = "SELECT * FROM users WHERE username = '$username'";
    
    $result = mysqli_query($db,$sqlCheckEmail);

    $resultUsername = mysqli_query($db,$sqlCheckUsername);

    //check if user exists
    if (mysqli_num_rows($result) > 0 || mysqli_num_rows($resultUsername) > 0) {

        echo "<p>Uzytkownik o podanej nazwie lub e-mailu juz istnieje</p>";

    //if not add user
    }else{
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
}
?>
</html>