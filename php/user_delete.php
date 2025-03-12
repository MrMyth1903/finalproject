<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "final";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM user WHERE ID = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect with success message
        header("Location: adminindex.php?msg=delete_success");
        exit();
    } else {
        // Redirect with error message
        header("Location: adminindex.php?msg=error");
        exit();
    }
    $stmt->close();
}

$conn->close();
?>
