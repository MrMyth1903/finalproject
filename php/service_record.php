<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .accept {
            background-color: #28a745;
            color: white;
        }
        .decline {
            background-color: #dc3545;
            color: white;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
    <script>
        // Function to handle button clicks
        function handleAction(action, id) {
            // Use Fetch API for AJAX request
            fetch('process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=${action}&id=${id}`
            })
            .then(response => response.text())
            .then(data => {
                const message = document.getElementById('message');
                message.textContent = data;

                // Remove the row dynamically after action
                if (action === 'accept' || action === 'decline') {
                    const row = document.getElementById(`row-${id}`);
                    if (row) row.remove();
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</head>
<body>
    
<?php
include 'signup.php';
error_reporting(E_ALL);

// Fetch records from the database
$query = "SELECT * FROM user";
$run = mysqli_query($con, $query);
$count = mysqli_num_rows($run);

if ($count > 0) {
?>
    <h2 style="text-align: center;">Display All Records</h2>
    <div id="message" class="message"></div>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Date of Birth</th>
            <th>Address</th>
            <th>Accept</th>
            <th>Decline</th>
        </tr>
        <?php while ($call = mysqli_fetch_assoc($run)) { ?>
            <tr id="row-<?php= $call['id']; ?>">
                <td><?= htmlspecialchars($call['FirstName']); ?></td>
                <td><?= htmlspecialchars($call['LastName']); ?></td>
                <td><?= htmlspecialchars($call['Mail']); ?></td>
                <td><?= htmlspecialchars($call['Password']); ?></td>
                <td><?= htmlspecialchars($call['DOB']); ?></td>
                <td><?= htmlspecialchars($call['City']); ?></td>
                <td>
                    <button class="accept" onclick="handleAction('accept', <?php= $call['id']; ?>)">Accept</button>
                </td>
                <td>
                    <button class="decline" onclick="handleAction('decline', <?php= $call['id']; ?>)">Decline</button>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php
} else {
    echo "<p style='text-align: center;'>No records found</p>";
}
?>
</body>
</html>
