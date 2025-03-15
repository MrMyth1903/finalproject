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

// Fetch Members
$result = $conn->query("SELECT * FROM vendor");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        h2 {
            text-align: center;
            color: #4CAF50;
        }
        form {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .assign, .edit, .remove {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .assign { background-color: #4CAF50; color: white; }
        .edit { background-color: #FFA500; color: white; }
        .remove { background-color: #FF0000; color: white; }
        .assigned-vehicle {
            color: green;
            font-weight: bold;
        }
        /* Modal Styling */
        #assignVehicleModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <h2>Add Member</h2>
    <form action="vendordb.php" method="post">
        <input type="text" name="name" placeholder="Vendor Name" required>
        <input type="text" name="aadhar_no" placeholder="Aadhar No">
        <input type="text" name="email" placeholder="Email address" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <button type="submit" name="submit">Add Member</button>
    </form>

    <h2>Member List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Vendor Name</th>
            <th>Aadhar_No</th>
            <th>Email_Address</th>
            <th>Address</th>
            <th>Phone Number</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row["ID"] ?></td>
            <td><?= $row["VEN_NAME"] ?></td>
            <td><?= $row["AADHAR_NO"] ?></td>
            <td><?= $row["EMAIL"] ?></td>
            <td><?= $row["ADDRESS"] ?></td>
            <td><?= $row["PHONE"] ?></td>
            <td class="action-buttons">
                <a href="edit_vendor.php?id=<?= $row['ID'] ?>" class="edit">Edit</a>
                <a href="delete_vendor.php?id=<?= $row['ID'] ?>" class="remove" onclick="return confirm('Are you sure you want to remove this member?');">Remove</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- Modal for Assigning Vehicle -->
    <div id="assignVehicleModal">
        <h3>Assign Vehicle</h3>
        <form method="POST">
            <input type="hidden" name="member_id" id="member_id">
            <input type="text" name="vehicle" placeholder="Enter Vehicle Name" required>
            <button type="submit" name="assign_vehicle">Save</button>
            <button type="button" onclick="closeModal()">Cancel</button>
        </form>
    </div>

    <script>
        function assignVehicle(id) {
            document.getElementById("member_id").value = id;
            document.getElementById("assignVehicleModal").style.display = "block";
        }
        function closeModal() {
            document.getElementById("assignVehicleModal").style.display = "none";
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
