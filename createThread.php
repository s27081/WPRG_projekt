<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include 'config.php';
if (isset($_SESSION['username']) && ($_SESSION['username'] === 'BlogMaster' || $_SESSION['username'] === 'Administrator')){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $image_id = 1;

    //handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $image_tmp = $_FILES['image']['tmp_name'];
    $name = $_FILES['image']['name'];

    $image = base64_encode(file_get_contents($image_tmp));

    $sqlInsertimage = "INSERT INTO images (file_name, file_data, upload_date) VALUES ('$name', '$image', NOW())";

   
    if (mysqli_query($db, $sqlInsertimage)) {
        echo "<br/>Image uploaded successfully.";
        $image_id = mysqli_insert_id($db);
    } else {
        echo "<br/>Image Failed to upload.<br/>";
        echo "Error: " . mysqli_error($db);
    }
}
    //add thread to database
    $sqlAddThread = "INSERT INTO threads (title, content, image_id, publish_date)
                    VALUES ('$title', '$content', $image_id, NOW())";
     
    if (mysqli_query($db,$sqlAddThread)) {
        header("Location: index.php");
        exit();
    } else {
       
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }

    mysqli_close($db);

}
}else{
    echo "<h3>Nie masz wystarczających uprawnień aby dodać wątek</h3>";
    echo "<a href='index.php'>Powrót do strony</a>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create thread</title>
</head>
<body>
    <h1>Stworz wpis</h1>
    <?php if (isset($_SESSION['username']) && ($_SESSION['username'] === 'BlogMaster' || $_SESSION['username'] === 'Administrator')): ?>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="title">Tytuł:</label><br>
        <input type="text" name="title"><br>
        <label for="content">Treść:</label><br>
        <input type="text" name="content"><br>
        <label for="image">Wybierz zdjęcie:</label><br>
        <input type="file" id="image" name="image" accept="image/*"><br><br>
        <input type="submit" value="Stwórz wpis">
    </form>
</body>
<?php endif; ?>
</html>