<?php

session_start();

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sqlCheckEmail = "SELECT * FROM users WHERE email = '$email' AND username = '$username'";
    
    $result = mysqli_query($db,$sqlCheckEmail);
    
    //if username and e-mail is valid change password 
    if (mysqli_num_rows($result) > 0) {

        $password = password_hash($password,PASSWORD_DEFAULT);

        $sqlInsertPassword = "UPDATE users SET passcode='$password' WHERE email='$email'";
        
        
        if (mysqli_query($db,$sqlInsertPassword)) {
            echo "Pomyslnie zrestartowano haslo";
            header("Location: login.php");
            exit();
        } else {
            echo "Nie udało się zrestartowac hasla";
        }

    } else {
        echo "Brak konta o podanym mailu";
    }

    mysqli_close($db);
}


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Zapomniałem hasła</title>
</head>
<body>
<nav>
    <ul>
    <?php include 'navBar.php'?>
    </ul>
</nav>
    <h1>Odzyskiwanie hasła</h1>
    <form class="login" action="" method="post">
        <label for="email">Podaj swój adres email</label>
        <input type="mail" name="email" required><br>
        <label for="">Podaj nazwę uzytkownika</label>
        <input type="text" id="username" name="username" required><br>
        <label for="">Podaj nowe hasło</label>
        <input type="password" id="pasword" name="password" required><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
