<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data if ID is provided
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$row = null;

if ($user_id > 0) {
    $sql = "SELECT * FROM members WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
}

// Assign vehicle if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $user_id = $_POST['id'];
    $vehicle = $_POST['vehicle'];

    $sql = "UPDATE members SET vehicle = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $vehicle, $user_id);

    if ($stmt->execute()) {
        $success_message = "Vehicle assigned successfully!";
        header("Location: adminIndex.php");
    } else {
        $error_message = "Error assigning vehicle.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Vehicle</title>
    <link rel="stylesheet" href="CSS/stud_reg.css">
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f0f4f8; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .form-container { background-color: #fff; border-radius: 12px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); padding: 40px; width: 100%; max-width: 650px; box-sizing: border-box; transition: transform 0.3s ease; }
        .form-container:hover { transform: translateY(-10px); }
        label { font-weight: 600; margin-bottom: 5px; color: #444; font-size: 1.1rem; display: block; }
        input { width: 100%; padding: 14px; margin: 10px 0; border-radius: 8px; border: 1px solid #ddd; font-size: 1.1rem; box-sizing: border-box; }
        button { background-color: #4CAF50; color: white; border: none; padding: 14px 0; font-size: 1.1rem; cursor: pointer; border-radius: 8px; width: 100%; transition: background-color 0.3s ease, transform 0.2s ease; }
        button:hover { background-color: #45a049; transform: translateY(-2px); }
        .error-message, .success-message { text-align: center; padding: 12px; margin-top: 20px; border-radius: 8px; font-weight: bold; color: white; font-size: 1.1rem; }
        .error-message { background-color: #f44336; }
        .success-message { background-color: #4CAF50; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Assign Vehicle</h2>
        <?php if (isset($error_message)) echo "<div class='error-message'>$error_message</div>"; ?>
        <?php if (isset($success_message)) echo "<div class='success-message'>$success_message</div>"; ?>

        <?php if ($row): ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">

            <label for="firstname">First Name:</label>
            <input type="text" name="firstname" value="<?= htmlspecialchars($row['firstname']) ?>" readonly>

            <label for="middlename">Middle Name:</label>
            <input type="text" name="middlename" value="<?= htmlspecialchars($row['middlename']) ?>" readonly>

            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" value="<?= htmlspecialchars($row['lastname']) ?>" readonly>

            <label for="phoneNumber">Phone Number:</label>
            <input type="text" name="phoneNumber" value="<?= htmlspecialchars($row['phoneNumber']) ?>" readonly>

            <label for="aadharNo">Aadhar No:</label>
            <input type="text" name="aadharNo" value="<?= htmlspecialchars($row['aadharNo']) ?>" readonly>

            <label for="vehicle">Assign Vehicle:</label>
            <input type="text" name="vehicle" value="<?= htmlspecialchars($row['vehicle']) ?>" required>

            <button type="submit" name="update">Assign Vehicle</button>
        </form>
        <?php else: ?>
        <p>User not found.</p>
        <?php endif; ?>
    </div>

</body>
</html>
