<?php

include 'config.php';
include 'thread.php';

$username = isset($_GET['username']) ? mysqli_real_escape_string($db, $_GET['username']) : '';


$userQuery = "SELECT username, email FROM users WHERE username = '$username'";
$userResult = mysqli_query($db, $userQuery);
$userData = mysqli_fetch_assoc($userResult);

if ($userData) {
    echo "<h1>{$userData['username']}</h1>";
    echo "<p>Email: {$userData['email']}</p>";
} else {
    echo "Nie znaleziono uzytkownika";
    exit();
}

$commentQuery = "
    SELECT c.content, c.date, t.title, t.id as thread_id
    FROM comments c
    JOIN threads t ON c.thread_id = t.id
    JOIN users u ON c.user_id = u.id
    WHERE u.username = '$username'
    ORDER BY c.date DESC";
$commentResult = mysqli_query($db, $commentQuery);

if (mysqli_num_rows($commentResult) > 0) {
    echo "<h2>Komentarze użytkownika:</h2>";
    echo "<ul>";
    while ($commentRow = mysqli_fetch_assoc($commentResult)) {
        echo "<li><a href='threadPage.php?thread_id={$commentRow['thread_id']}'>{$commentRow['title']}</a><br>";
        echo "<small>Dnia: {$commentRow['date']}</small><br>";
        echo "<p>{$commentRow['content']}</p></li>";
    }
    echo "</ul>";
} else {
    echo "<p>Użytkownik nie dodał jeszcze żadnych komentarzy.</p>";
}


mysqli_close($db);
?>