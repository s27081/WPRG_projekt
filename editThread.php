<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['thread_id']) && isset($_POST['title']) && isset($_POST['content'])) {
        $threadId = mysqli_real_escape_string($db, $_POST['thread_id']);
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $content = mysqli_real_escape_string($db, $_POST['content']);
        
        $updateThreadSql = "
            UPDATE threads
            SET title = '$title', content = '$content'
            WHERE id = '$threadId'";
        mysqli_query($db, $updateThreadSql);

        header("Location: index.php");
        exit();
    }
} else {
    if (isset($_GET['thread_id'])) {
        $threadId = mysqli_real_escape_string($db, $_GET['thread_id']);
        $fetchThreadSql = "SELECT * FROM threads WHERE id = '$threadId'";
        $threadResult = mysqli_query($db, $fetchThreadSql);
        $threadData = mysqli_fetch_assoc($threadResult);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj wpis</title>
</head>
<body>
    <h1>Edytuj wpis</h1>
    <form method="POST" action="editThread.php">
        <input type="hidden" name="thread_id" value="<?php echo $threadData['id']; ?>">
        <label for="title">Tytul:</label><br>
        <input type="text" name="title" value="<?php echo $threadData['title']; ?>" required>
        <br>
        <label for="content">Zawartosc:</label><br>
        <textarea name="content" required><?php echo $threadData['content']; ?></textarea>
        <br>
        <input type="submit" value="Zaktualizuj wpis">
    </form>
</body>
</html>
