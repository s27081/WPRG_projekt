<?php
session_start();

if (isset($_SESSION['username']) && ($_SESSION['username'] === 'BlogMaster' || $_SESSION['username'] === 'Administrator')){
    echo "Witaj, {$_SESSION['username']}! <a href='logout.php'>Wyloguj</a><br>";
    echo "<a href='createThread.php'>Stworz watek</a>";
}else if(isset($_SESSION['username'])){
    echo "Witaj, {$_SESSION['username']}! <a href='logout.php'>Wyloguj</a>";
}
else {
    echo "Witaj, Guest! <a href='login.php'>Login</a>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Glówna</title>
</head>
<body>
    <h1>EURO 2024 BLOG</h1>
    <h2>Wpisy:</h2>
</body>
<?php include 'fetchThreads.php'; ?>
</html>
