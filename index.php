<?php
session_start();

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
    <nav>
        <ul>
        <?php include 'navBar.php'?>
        </ul>
    </nav>
    <h1>EURO 2024 BLOG</h1>
    <h2>Wpisy</h2>
    <?php include 'fetchThreads.php'; ?>
</body>

</html>
