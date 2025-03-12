<?php
// Database Connection
$servername = "localhost";
$username = "root"; // Change if needed
$password = ""; // Change if needed
$dbname = "final";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $middlename = $_POST["middlename"];
    $lastname = $_POST["lastname"];
    $phoneNumber = $_POST["phoneNumber"];
    $aadharNo = $_POST["aadharNo"];

    $sql = "INSERT INTO members (firstname, middlename, lastname, phoneNumber, aadharNo) 
            VALUES ('$firstname', '$middlename', '$lastname', '$phoneNumber', '$aadharNo')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('User added successfully!');</script>";
        header("Location: adminIndex.php");
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
