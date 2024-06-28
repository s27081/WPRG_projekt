<?php
session_start();

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $thread_id = $_POST['thread_id'];
    $content = $_POST['content'];

    //get user id from database if not exisit set 1 (guest)
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $sqlUserId = "SELECT id FROM users WHERE username='$username'";
        $result = mysqli_query($db,$sqlUserId);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['id'];
        } else {
            $user_id = 1; 
        }
    } else {
        $user_id = 1;
    }

    //add comment
    $sql = "INSERT INTO comments (thread_id, content, user_id, date)
            VALUES ('$thread_id', '$content', '$user_id', NOW())";

    if (mysqli_query($db, $sql)) {
        header("Location: index.php#thread-$thread_id");
        exit();
    } else {
       
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
}

mysqli_close($db);
?>
