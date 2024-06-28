<?php

$currentPage = basename($_SERVER['PHP_SELF']);

//display content at navbar - depends which user or page
if($currentPage === 'createAccount.php' || $currentPage === 'resetPassword.php'){
    echo "<li><a href='login.php'>Powrót do logowania</a></li>";

}else if($currentPage === 'login.php'){}

else if (isset($_SESSION['username']) && ($_SESSION['username'] === 'BlogMaster')) {
    echo "<li>Witaj, {$_SESSION['username']}!</li>";
    echo "<li><a href='logout.php'>Wyloguj</a></li>";

    if ($currentPage !== 'createThreads.php') {
        echo "<li><a href='createThread.php'>Stworz watek</a></li>";
    }

} else if(isset($_SESSION['username']) && $_SESSION['username'] === "Administrator") {
    echo "<li>Witaj, {$_SESSION['username']}!</li>";
    echo "<li><a href='logout.php'>Wyloguj</a></li>";

    if ($currentPage !== 'createThread.php') {
        echo "<li><a href='createThread.php'>Stworz watek</a></li>";
    }
    if ($currentPage !== 'adminPanel.php') {
        echo "<li><a href='adminPanel.php'>Panel administracyjny</a></li>";
    }
    
} else if(isset($_SESSION['username'])) {
    echo "<li>Witaj, {$_SESSION['username']}!</li>";
    echo "<li><a href='logout.php'>Wyloguj</a></li>";
    echo "<li><a href='contactWriter.php'>Napisz do autora</a></li>";

} else {
    echo "<li>Witaj, Guest!</li>";
    echo "<li><a href='login.php'>Zaloguj się</a></li>";
}

if ($currentPage !== 'index.php') {
    echo '<li><a href="index.php">Powrót do strony głównej</a></li>';
}
?>