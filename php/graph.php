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

// Fetch appointment data (count appointments per service)
$sql = "SELECT SERVICE, COUNT(*) AS count FROM appointment GROUP BY SERVICE";
$result = $conn->query($sql);

$services = [];
$appointmentCounts = [];

while ($row = $result->fetch_assoc()) {
    $services[] = $row['SERVICE'];
    $appointmentCounts[] = $row['count'];
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Appointments Bar Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7fa; color: #333; text-align: center; }
        canvas { max-width: 800px; margin: 20px auto; }
        header { background-color: #34495e; padding: 15px; color: white; font-size: 24px; }
    </style>
</head>
<body>

<header>Appointments Per Service</header>

<canvas id="appointmentChart"></canvas>

<script>
    // Get PHP data into JavaScript
    const services = <?php echo json_encode($services); ?>;
    const appointmentCounts = <?php echo json_encode($appointmentCounts); ?>;

    // Create Chart.js bar graph
    const ctx = document.getElementById('appointmentChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: services,
            datasets: [{
                label: 'Number of Appointments',
                data: appointmentCounts,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>


</body>
</html>


