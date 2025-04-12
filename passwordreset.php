<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'final';

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Data from form or request
$email = $_POST['email']; // or $_GET['email']
// // make sure to sanitize/validate
$new_password = $_POST['confirmPassword'];

// Update query
$sql = "UPDATE user SET Password = ? WHERE Mail = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("ss", $hashed_password, $email);
    if ($stmt->execute()) {
        echo "<script>alert('Password updated successfully.');</script>";
        header("window.location.href = 'http://localhost/final year/login.html'");
    } else {
        echo "Error updating password: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>
