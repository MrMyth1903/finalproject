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

// Fetch Student Data
$sql = "SELECT ID,SERVICE, DATE, TIME, NAME, VEHICLE_NO, WANT, SPHERE_PART, PHONE_NUMBER FROM appointment";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="CSS/stud_reg.css"> <!-- Ensure CSS is correctly linked -->
    <style>
        /* General Body Style */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            color: #333;
        }

        /* Navbar Style */
        header {
            background-color: #34495e;
            padding: 15px;
            color: white;
            text-align: center;
            font-size: 24px;
        }

        /* Table Styling */
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2980b9;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #ecf0f1;
        }

        tr:hover {
            background-color: #bdc3c7;
        }

        /* Action Buttons Styling */
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 4px;
            font-size: 14px;
        }

        button:hover {
            background-color: #2980b9;
        }

        a {
            text-decoration: none;
        }

        /* Styling for "Delete" Button */
        .delete-btn {
            background-color: #e74c3c;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        /* Form Container */
        .form-container {
            width: 80%;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container input, .form-container select, .form-container textarea {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #27ae60;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                width: 100%;
            }
            .form-container {
                width: 95%;
            }
        }
        /* Style the container to align buttons horizontally */
.button-container {
    display: flex;
    justify-content: space-around; /* You can also use 'space-between' if you prefer more space between buttons */
    gap: 10px; /* Adds space between the buttons */
}

/* Optional: If you want to add a little space between the buttons and the cell */
td {
    padding: 10px;
}

    </style>
</head>
<body>

    <!-- Table displaying students -->
    <div class="container">
        <table>
            <tr>
                <th>ID</th>
                <th>SERVICE</th>
                <th>DATE</th>
                <th>TIME</th>
                <th>NAME</th>
                <th>VEHICLE_NO</th>
                <th>WANT</th>
                <th>SPHERE_PART</th>
                <th>PHONE_NO</th>
                <th>ACTION</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['ID']; ?></td>
                    <td><?php echo htmlspecialchars($row['SERVICE']); ?></td>
                    <td><?php echo htmlspecialchars($row['DATE']); ?></td>
                    <td><?php echo htmlspecialchars($row['TIME']); ?></td>
                    <td><?php echo htmlspecialchars($row['NAME']); ?></td>
                    <td><?php echo htmlspecialchars($row['VEHICLE_NO']); ?></td>
                    <td><?php echo htmlspecialchars($row['WANT']); ?></td>
                    <td><?php echo htmlspecialchars($row['SPHERE_PART']); ?></td>
                    <td><?php echo htmlspecialchars($row['PHONE_NUMBER']); ?></td>

                    <td>
                        <div class="button-container">
                            <a href="v_update.php?id=<?php echo $row['ID']; ?>"><button>Edit</button></a>
                            <a href="v_delete.php?id=<?php echo $row['ID']; ?>" onclick="return confirm('Are you sure you want to delete this record?');">
                        <button class="delete-btn">Delete</button>
                        </div>
                    </td>

                </tr>
            <?php } ?>
        </table>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this record?")) { 
                window.location.href = "delete.php?id=" + id; // Redirect to delete.php with the student ID
            }
        }
    </script>

</body>
</html>
