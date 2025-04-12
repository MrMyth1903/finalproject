<?php
// Basic DB connection
$conn = new mysqli('localhost', 'root', '', 'final');

// Stop if connection fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Run update query
$sql = "UPDATE user SET Password = ? WHERE Mail = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $password, $email);

if ($stmt->execute()) {
    header("Location: http://localhost/final%20year/login.html");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
