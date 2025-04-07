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

// Fetch service data (vehicle types and their quantities)
$sql2 = "SELECT V_TYPE, SUM(QUANTITY) AS total_quantity, SUM(PRICE) AS total_revenue FROM service GROUP BY V_TYPE";
$result2 = $conn->query($sql2);

$vehicleTypes = [];
$quantities = [];
$revenues = [];

if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $vehicleTypes[] = $row['V_TYPE'];
        $quantities[] = $row['total_quantity'];
        $revenues[] = $row['total_revenue'];
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Service Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --accent-color: #9b59b6;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --shadow: 0 4px 15px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }
        
        body { 
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fa;
            color: #333; 
            margin: 0;
            padding: 0;
        }
        
        header { 
            background: linear-gradient(135deg, var(--dark-color), #34495e);
            padding: 20px;
            color: white;
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
        }
        
        .dashboard-title {
            margin: 0;
            font-weight: 600;
        }
        
        .container {
            width: 95%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px 40px;
        }
        
        .charts-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
            justify-content: center;
        }
        
        .chart-container {
            flex: 1;
            min-width: 300px;
            background-color: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 20px;
            transition: var(--transition);
        }
        
        .chart-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        h2 {
            color: var(--dark-color);
            margin-top: 0;
            font-size: 20px;
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .canvas-holder {
            height: 350px;
            position: relative;
        }
        
        .btn-container {
            text-align: center;
            margin: 30px 0;
        }
        
        .btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            margin: 0 10px;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
        }
        
        .btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(52, 152, 219, 0.4);
        }
        
        .btn-home {
            background-color: var(--secondary-color);
            box-shadow: 0 4px 10px rgba(46, 204, 113, 0.3);
        }
        
        .btn-home:hover {
            background-color: #27ae60;
            box-shadow: 0 6px 12px rgba(46, 204, 113, 0.4);
        }
        
        .stats-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .stat-card {
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: var(--shadow);
            min-width: 180px;
            text-align: center;
            transition: var(--transition);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card.primary {
            border-left: 4px solid var(--primary-color);
        }
        
        .stat-card.secondary {
            border-left: 4px solid var(--secondary-color);
        }
        
        .stat-card.accent {
            border-left: 4px solid var(--accent-color);
        }
        
        .stat-value {
            font-size: 26px;
            font-weight: 600;
            margin: 5px 0;
        }
        
        .stat-label {
            color: #7f8c8d;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .charts-row {
                flex-direction: column;
            }
            
            .chart-container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <br>
<div class="container">
    <!-- Summary Stats -->
    <div class="stats-container">
        <div class="stat-card primary">
            <div class="stat-value"><?php echo count($services); ?></div>
            <div class="stat-label">Active Services</div>
        </div>
        <div class="stat-card secondary">
            <div class="stat-value"><?php echo array_sum($appointmentCounts); ?></div>
            <div class="stat-label">Total Appointments</div>
        </div>
        <div class="stat-card accent">
            <div class="stat-value"><?php echo array_sum($revenues); ?>₹</div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>
    
    <!-- Charts in parallel -->
    <div class="charts-row">
        <div class="chart-container">
            <h2>Appointments Per Service</h2>
            <div class="canvas-holder">
                <canvas id="appointmentChart"></canvas>
            </div>
        </div>
        
        <div class="chart-container">
            <h2>Vehicle Types: Quantity and Revenue</h2>
            <div class="canvas-holder">
                <canvas id="vehicleChart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="btn-container">
        <a href="http://localhost/final%20year/php/adminindex.php" class="btn btn-home">Back to Dashboard</a>
        <a href="#" class="btn" onclick="window.print()">Print Report</a>
    </div>
</div>

<script>
    // Chart configuration with consistent styling
    const chartConfig = {
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 15,
                    font: {
                        family: "'Poppins', sans-serif",
                        size: 12
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(44, 62, 80, 0.8)',
                titleFont: {
                    family: "'Poppins', sans-serif",
                    size: 14
                },
                bodyFont: {
                    family: "'Poppins', sans-serif",
                    size: 13
                },
                padding: 12,
                cornerRadius: 8,
                boxPadding: 6
            }
        }
    };

    // Chart 1: Appointments Per Service
    const ctx1 = document.getElementById('appointmentChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($services); ?>,
            datasets: [{
                label: 'Number of Appointments',
                data: <?php echo json_encode($appointmentCounts); ?>,
                backgroundColor: 'rgba(52, 152, 219, 0.7)',
                borderColor: 'rgba(52, 152, 219, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            ...chartConfig,
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { 
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Count',
                        font: {
                            family: "'Poppins', sans-serif",
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Service Type',
                        font: {
                            family: "'Poppins', sans-serif",
                            size: 12
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });
    
    // Chart 2: Vehicle Types with Quantity and Revenue
    const ctx2 = document.getElementById('vehicleChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($vehicleTypes); ?>,
            datasets: [
                {
                    label: 'Total Quantity',
                    data: <?php echo json_encode($quantities); ?>,
                    backgroundColor: 'rgba(46, 204, 113, 0.7)',
                    borderColor: 'rgba(46, 204, 113, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                    yAxisID: 'y'
                },
                {
                    label: 'Total Revenue',
                    data: <?php echo json_encode($revenues); ?>,
                    backgroundColor: 'rgba(155, 89, 182, 0.7)',
                    borderColor: 'rgba(155, 89, 182, 1)',
                    borderWidth: 2,
                    type: 'line',
                    yAxisID: 'y1',
                    tension: 0.3,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }
            ]
        },
        options: {
            ...chartConfig,
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Quantity',
                        font: {
                            family: "'Poppins', sans-serif",
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false
                    },
                    title: {
                        display: true,
                        text: 'Revenue (₹)',
                        font: {
                            family: "'Poppins', sans-serif",
                            size: 12
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Vehicle Type',
                        font: {
                            family: "'Poppins', sans-serif",
                            size: 12
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });
</script>

</body>
</html>