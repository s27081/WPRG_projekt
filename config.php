<?php

//database connection
$db = mysqli_connect("127.0.0.1", "root", "root", "WPRG_PROJECT");

if (!$db) {
    echo "Connection failed: " . mysqli_connect_error();
}
?>
