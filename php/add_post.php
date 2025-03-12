<?php
include 'db.php';

// Check if data is received
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];

    $sql = "INSERT INTO posts (title, content, author) VALUES ('$title', '$content', '$author')";

    if ($conn->query($sql) === TRUE) {
        echo "New post created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
