<?php
// DB connection
$host = 'localhost';
$db   = 'your_database';
$user = 'your_username';
$pass = 'your_password';

$conn = new mysqli($host, $user, $pass, $db);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// On form submit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payments'])) {
    foreach ($_POST['payments'] as $worker_id => $working_days) {
        $worker_id = intval($worker_id);
        $working_days = intval($working_days);

        if ($working_days > 0) {
            // Fetch daily rate
            $stmt = $conn->prepare("SELECT daily_rate FROM workers WHERE id = ?");
            $stmt->bind_param("i", $worker_id);
            $stmt->execute();
            $stmt->bind_result($daily_rate);
            $stmt->fetch();
            $stmt->close();

            if ($daily_rate) {
                $amount_paid = $daily_rate * $working_days;

                // Insert into payments
                $insert = $conn->prepare("INSERT INTO payments (worker_id, working_days, amount_paid) VALUES (?, ?, ?)");
                $insert->bind_param("iid", $worker_id, $working_days, $amount_paid);
                $insert->execute();
                $insert->close();
            }
        }
    }

    echo "<p><strong>Payments processed successfully!</strong></p>";
}
?>

<!-- Admin Form -->
<h2>Make Payment to Workers</h2>
<form method="post">
    <table border="1" cellpadding="8">
        <tr>
            <th>Worker Name</th>
            <th>Daily Rate</th>
            <th>Enter Working Days</th>
        </tr>
        <?php
        $result = $conn->query("SELECT id, name, daily_rate FROM workers");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['daily_rate']}</td>";
            echo "<td><input type='number' name='payments[{$row['id']}]' min='0' placeholder='0'></td>";
            echo "</tr>";
        }
        ?>
    </table><br>
    <input type="submit" value="Make Payments">
</form>
