<?php

$conn = mysqli_connect('localhost', 'root', '', 'final');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['name'];

    // Handle image upload
    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        
        // Create the uploads directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image);
    }

    // Insert into database
    $sql = "INSERT INTO posts (TITLE, IMAGE, CONTENT, NAME) VALUES ('$title', '$image', '$content', '$author')";

    if ($conn->query($sql) === TRUE) {
        echo "New post created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header("Location: adminindex.php"); // Redirect back to the blog page
    exit();
}
?>
