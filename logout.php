<?php
//unset evere property
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit();
?>
