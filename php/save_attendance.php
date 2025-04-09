<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attendance'])) {
    $attendance = $_POST['attendance'];
    $date = $_POST['date'];

    foreach ($attendance as $email => $status) {
        if (!empty($status)) {
            // Check if record already exists
            $checkStmt = $conn->prepare("SELECT id FROM attendance WHERE email = ? AND date = ?");
            $checkStmt->bind_param("ss", $email, $date);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows == 0) {
                // Insert attendance record only if not exists
                $stmt = $conn->prepare("INSERT INTO attendance (email, date, status) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $email, $date, $status);
                $stmt->execute();
            }

            $checkStmt->close();
        }
    }

    echo "<script>alert('Attendance saved for $date.'); window.location.href='adminindex.php';</script>";
} else {
    echo "No attendance data submitted.";
}
?>
