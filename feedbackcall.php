<?php

// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "final";

$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Student Data using prepared statement
$sql = "SELECT ID, NAME, EMAIL, IMAGE, FEEDBACK FROM feedback";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Check for messages from redirects
$message = "";
if (isset($_GET['msg'])) {
    $messages = [
        "update_success" => "Record updated successfully.",
        "delete_success" => "Record deleted successfully.",
        "error" => "An error occurred."
    ];
    $message = $messages[$_GET['msg']] ?? "";
}

if ($result->num_rows > 0) 
{
                    // Output each post
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="post">';
                        echo '<h2>' . htmlspecialchars($row['IMAGE']) . '</h2>';
                        echo '<p><strong>By ' . htmlspecialchars($row['NAME']) . '</strong></p>';
                        echo '<p>' . nl2br(htmlspecialchars($row['FEEDBACK'])) . '</p>';
                        echo '</div><hr>';
                    }
                } else {
                    echo '<p>No posts available.</p>';
                }

                // Close connection
                $conn->close();
?>