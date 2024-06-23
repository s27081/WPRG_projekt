<?php

function showUsers(){
    include 'config.php';
    //get data from database
    $sql = "SELECT username FROM users";
    $result = mysqli_query($db, $sql);
    

    if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<a href='userPage.php?username={$row['username']}'>{$row['username']}</a><br>";
    }
}
}

function showThreads(){
    include 'config.php';


    $sql = "SELECT * FROM threads ORDER BY publish_date DESC";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='thread-box'>";
            echo "<h2>{$row['title']}</h2>";
            echo "<p>{$row['content']}</p>";

            //edit thread
            echo "<a href='editThread.php?thread_id={$row['id']}'>Edit</a>";

            //delete thread 
            echo "<form method='POST' action='' style='display:inline; margin-left: 10px;'>";
            echo "<input type='hidden' name='delete_thread_id' value='{$row['id']}'>";
            echo "<input type='submit' value='Usun' onclick='return confirm(\"Czy na pewno checsz usunąć wpis?\");'>";
            echo "</form>";


            $commentSql = "
                SELECT c.id as comment_id, c.content, c.date, u.username
                FROM comments c
                JOIN users u ON c.user_id = u.id
                WHERE c.thread_id = '{$row['id']}'
                ORDER BY c.date DESC";
            $commentResult = mysqli_query($db, $commentSql);

            if (mysqli_num_rows($commentResult) > 0) {
                echo "<h3>Komentarze:</h3>";
                echo "<ul>";
                while ($commentRow = mysqli_fetch_assoc($commentResult)) {
                    echo "<li>";
                    echo "<p>{$commentRow['content']}<br><small>Uzytkownik: {$commentRow['username']} dnia: {$commentRow['date']}</small></p>";

                    //delete single comment
                    echo "<form method='POST' action='' style='display:inline;'>";
                    echo "<input type='hidden' name='delete_comment_id' value='{$commentRow['comment_id']}'>";
                    echo "<input type='submit' value='Delete Comment' onclick='return confirm(\"Czy na pewno chcesz usunąć ten komentarz?\");'>";
                    echo "</form>";

                    echo "</li>";
                }
                echo "</ul>";
            }
            echo "</div><hr>";
        }
    } else {
        echo "No threads found.";
    }

    mysqli_close($db);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'config.php';

    //delete thread and comment
    if (isset($_POST['delete_thread_id'])) {
        $threadId = mysqli_real_escape_string($db, $_POST['delete_thread_id']);
        $deleteThreadSql = "DELETE FROM threads WHERE id = '$threadId'";
        mysqli_query($db, $deleteThreadSql);


        $deleteCommentsSql = "DELETE FROM comments WHERE thread_id = '$threadId'";
        mysqli_query($db, $deleteCommentsSql);
    }


    if (isset($_POST['delete_comment_id'])) {
        $commentId = mysqli_real_escape_string($db, $_POST['delete_comment_id']);
        $deleteCommentSql = "DELETE FROM comments WHERE id = '$commentId'";
        mysqli_query($db, $deleteCommentSql);
    }

    mysqli_close($db);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel admina</title>
</head>
<body>
    <a href="index.php">Powrot do strony glownej</a>
    <div>
        <h2>Uzytkownicy</h2>
        <?php showUsers()?>
    </div>
    <div>
        <h2>Wpisy</h2>
        <?php showThreads()?>
    </div>   
</body>
</html>