<?php
include 'config.php';
include 'thread.php';

//get data from database
$sql = "SELECT t.*, i.file_path
        FROM threads t
        LEFT JOIN images i ON t.image_id = i.id
        ORDER BY t.publish_date DESC";

$result = mysqli_query($db, $sql);

$threads = [];

//get threads
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $commentSql = "
            SELECT c.content, c.date, u.username
            FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.thread_id = " . $row['id'];

$commentResult = mysqli_query($db, $commentSql);
$comments = [];

//get comments
if (mysqli_num_rows($commentResult) > 0) {
    while ($commentRow = mysqli_fetch_assoc($commentResult)) {
        $comments[] = [
            'content' => $commentRow['content'],
            'user' => $commentRow['username'],
            'date' => $commentRow['date']
        ];
    }
}



$threads[] = new Thread(
    $row['id'],
    $row['title'],
    $row['content'],
    $row['file_path'],
    $row['publish_date'],
    $comments
    );
}

} else {
    echo "No threads found";
}

mysqli_close($db);

//display the threads
foreach ($threads as $thread) {
    echo "<div class='thread-box'>";
    echo "<h2>" . $thread->title . "</h2>";
    echo "<p>" . $thread->content . "</p>";
    if ($thread->image) {
        echo "<img src='" . $thread->image . "' alt='" . $thread->title . "'>";
    }
    echo "<p><small>Opublikowano:  " . $thread->publishDate . "</small></p>";

    if (!empty($thread->commentList)) {
        echo "<h3>Komentarze:</h3>";
        echo "<ul>";
        foreach ($thread->commentList as $comment) {
            echo "<li>" . $comment['content'] . "<br><small>Uzytkownik: " . $comment['user'] . " dnia: " . $comment['date'] . "</small></li>";
        }
        echo "</ul>";
    }
    echo "<p><small>Dodaj komentarz</small></p>";
    echo "<form action='addComment.php' method='POST'>";
    echo "<input type='hidden' name='thread_id' value='" . $thread->id . "'>";
    echo "<input type='text' name='content'>";
    echo "<input type='submit' value='Dodaj komentarz'>";
    echo "</form>";

    echo "</div>";
}
?>