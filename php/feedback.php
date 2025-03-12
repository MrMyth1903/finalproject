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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Feedback List</title>
    <link rel="stylesheet" href="CSS/stud_reg.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7fa; color: #333; }
        header { background-color: #34495e; padding: 15px; color: white; text-align: center; font-size: 24px; }
        .message {
            text-align: center; padding: 10px; margin: 10px auto; width: 50%; border-radius: 5px; font-weight: bold;
        }
        .success { background-color: #2ecc71; color: white; }
        .error { background-color: #e74c3c; color: white; }
        table {
            width: 90%; margin: 30px auto; border-collapse: collapse; background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px; text-align: center; border: 1px solid #ddd;
        }
        th { background-color: #2980b9; color: white; font-weight: bold; }
        tr:nth-child(even) { background-color: #ecf0f1; }
        tr:hover { background-color: #bdc3c7; }
        button {
            border: none; padding: 8px 16px; cursor: pointer; transition: background-color 0.3s;
            border-radius: 4px; font-size: 14px; color: white;
        }
        .edit-btn { background-color: #3498db; }
        .edit-btn:hover { background-color: #2980b9; }
        .delete-btn { background-color: #e74c3c; }
        .delete-btn:hover { background-color: #c0392b; }
        img { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; }
    </style>
</head>
<body>



<?php if ($message): ?>
    <div class="message <?php echo ($_GET['msg'] == 'update_success' || $_GET['msg'] == 'delete_success') ? 'success' : 'error'; ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<div class="container">
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Feedback</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo htmlspecialchars($row['NAME']); ?></td>
                <td><?php echo htmlspecialchars($row['EMAIL']); ?></td>
                <td>
                    <img src="<?php echo !empty($row['IMAGE']) ? htmlspecialchars($row['IMAGE']) : 'default-avatar.png'; ?>" alt="Student Image">
                </td>
                <td><?php echo htmlspecialchars($row['FEEDBACK']); ?></td>
                <td>
                    <a href="update.php?id=<?php echo $row['ID']; ?>">
                        <button class="edit-btn">Edit</button>
                    </a>
                    <a href="delete.php?id=<?php echo $row['ID']; ?>" onclick="return confirm('Are you sure you want to delete this record?');">
                        <button class="delete-btn">Delete</button>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
