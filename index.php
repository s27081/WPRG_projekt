<?php
session_start();

if (isset($_SESSION['username'])) {
    echo "Welcome, {$_SESSION['username']}! <a href='logout.php'>Logout</a>";
} else {
    echo "Welcome, Guest! <a href='login.php'>Login</a>";
}
?>
