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

    $sql = "SELECT * FROM users WHERE username = '$username' AND passcode = '$password'";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else if($username === "guest" && $password === "guest"){
        $_SESSION["username"] = 'guest';
        header("location: index.php");

    }else{
        echo "Invalid username or password";
    }

    mysqli_close($db);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="">
        <label for="username">Nazwa uzytkownika:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Haslo:</label><br>
        <input type="password" id="password" name="password"><br>  
        <input type="submit" value="Zaloguj">
    </form>
</body>
</html>