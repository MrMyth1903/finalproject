<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Records</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #dbe7f3;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .edit {
            background-color: #ffc107;
            color: white;
        }
        .edit:hover {
            background-color: #e0a800;
        }
        .delete {
            background-color: #dc3545;
            color: white;
        }
        .delete:hover {
            background-color: #c82333;
        }
        .message {
            font-weight: bold;
            margin-bottom: 20px;
            color: #28a745;
        }
    </style>
</head>
<body>
    
    <div id="message" class="message"></div>
    
    <?php
    include 'signup.php';
    error_reporting(E_ALL);
    $query = "SELECT * FROM user";
    $run = mysqli_query($con, $query);
    $count = mysqli_num_rows($run);

    if ($count > 0) {
    ?>
        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Password</th>
                <th>Date of Birth</th>
                <th>City</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php while ($call = mysqli_fetch_assoc($run)) { ?>
                <tr>
                    <td><?= htmlspecialchars($call['ID']); ?></td>
                    <td><?= htmlspecialchars($call['FirstName']); ?></td>
                    <td><?= htmlspecialchars($call['LastName']); ?></td>
                    <td><?= htmlspecialchars($call['Phone']); ?></td>
                    <td><?= htmlspecialchars($call['Mail']); ?></td>
                    <td><?= htmlspecialchars($call['Password']); ?></td>
                    <td><?= htmlspecialchars($call['DOB']); ?></td>
                    <td><?= htmlspecialchars($call['City']); ?></td>
                    <td>
                        <a href="user_update.php?id=<?= $call['ID']; ?>">
                            <button class="btn edit">Edit</button>
                        </a>
                    </td>
                    <td>
                        <a href="user_delete.php?id=<?= $call['ID']; ?>" onclick="return confirm('Are you sure you want to delete this record?');">
                            <button class="btn delete">Delete</button>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php
    } else {
        echo "<p>No records found</p>";
    }
    ?>
</body>
</html>
