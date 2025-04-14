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

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare delete statement
    $stmt = $conn->prepare("DELETE FROM inventory WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "
        <script>
            alert('Inventory item deleted successfully.');
            window.location.href = 'adminindex.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Error deleting inventory item.');
            window.location.href = 'adminindex.php';
        </script>";
    }

    $stmt->close();
} else {
    echo "
    <script>
        alert('Invalid inventory ID.');
        window.location.href = 'adminindex.php';
    </script>";
}

$conn->close();
?>
