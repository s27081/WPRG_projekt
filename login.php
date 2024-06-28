<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include 'config.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sqlGetPassword = "SELECT passcode FROM users WHERE username = '$username'";

    $result = mysqli_query($db, $sqlGetPassword);

    //retrive hashed password
    if (mysqli_num_rows($result) == 1){
        while ($row = mysqli_fetch_assoc($result)) {
            $dbPassword = $row['passcode'];
        }        
    }else{
        $dbPassword = "";
    }

    $isPassword=password_verify($password, $dbPassword);

    mysqli_free_result($result);

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($db, $sql);

    //validate user
    if (mysqli_num_rows($result) == 1 && $isPassword == true) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else if($username === "guest" && $password === "guest"){
        $_SESSION["username"] = 'guest';
        header("location: index.php");

    }else{
        echo "Błędny uzytkownik lub hasło";
    }

    mysqli_close($db);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zaloguj się</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <ul>
    <?php include 'navBar.php'?>
    </ul>
</nav>
    <div class="login-container">
        <h2>Zaloguj się</h2>
        <form class="login" method="post" action="">
            <label for="username">Nazwa użytkownika</label>
            <input type="text" id="username" name="username"><br>
            <label for="password">Hasło</label>
            <input type="password" id="password" name="password"><br>  
            <input type="submit" value="Zaloguj">
        </form>
        <div class="login-links">
            <a href="createAccount.php">Zarejestruj się</a>
            <a href="resetPassword.php">Zapomniałem hasła</a>
        </div>
    </div>
</body>
</html>