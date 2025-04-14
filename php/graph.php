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

// Calculate total revenue from all services
$totalQuery = "SELECT SUM(PRICE) AS total FROM appointment";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalRevenue = $totalRow['total'] ?? 0;

// Calculate total service revenue
$totalServiceRevenue = array_sum($revenues) + $totalRevenue;

// Fetch inventory total cost
$inventoryQuery = "SELECT SUM(total_price) AS total_inventory_cost FROM inventory";
$inventoryResult = $conn->query($inventoryQuery);
$inventoryRow = $inventoryResult->fetch_assoc();
$totalInventoryCost = $inventoryRow['total_inventory_cost'] ?? 0;

// Fetch payment data - Monthly payment analysis
$sql3 = "SELECT 
            DATE_FORMAT(created_at, '%b %Y') AS month,
            SUM(amount_paid) AS total_payment,
            COUNT(*) AS payment_count
         FROM payments
         WHERE created_at IS NOT NULL
         GROUP BY DATE_FORMAT(created_at, '%Y-%m')
         ORDER BY MIN(created_at)";

// If created_at doesn't exist in the database, use this alternative query
if (!$conn->query("SHOW COLUMNS FROM payments LIKE 'created_at'")->num_rows) {
    $sql3 = "SELECT 
                DATE_FORMAT(NOW(), '%b %Y') AS month,
                SUM(amount_paid) AS total_payment,
                COUNT(*) AS payment_count
             FROM payments
             GROUP BY DATE_FORMAT(NOW(), '%Y-%m')";
}

$result3 = $conn->query($sql3);

$paymentMonths = [];
$paymentTotals = [];
$paymentCounts = [];

// Default data if no results
if ($result3->num_rows == 0) {
    // Create sample data for the current month
    $currentMonth = date('M Y');
    $sql3Alt = "SELECT SUM(amount_paid) AS total_payment, COUNT(*) AS payment_count FROM payments";
    $result3Alt = $conn->query($sql3Alt);
    
    if ($row = $result3Alt->fetch_assoc()) {
        $paymentMonths[] = $currentMonth;
        $paymentTotals[] = $row['total_payment'] ? $row['total_payment'] : 0;
        $paymentCounts[] = $row['payment_count'] ? $row['payment_count'] : 0;
    } else {
        // If still no data, provide placeholder
        $paymentMonths = [date('M Y', strtotime('-2 months')), date('M Y', strtotime('-1 months')), date('M Y')];
        $paymentTotals = [0, 0, 0];
        $paymentCounts = [0, 0, 0];
    }
} else {
    while ($row = $result3->fetch_assoc()) {
        $paymentMonths[] = $row['month'];
        $paymentTotals[] = $row['total_payment'];
        $paymentCounts[] = $row['payment_count'];
    }
}

// Get total from payments
$sql4 = "SELECT SUM(amount_paid) AS total_payments FROM payments";
$result4 = $conn->query($sql4);
$row4 = $result4->fetch_assoc();
$totalPayments = $row4['total_payments'] ? $row4['total_payments'] : 0;

// Calculate net profit (service revenue minus worker payments AND inventory costs)
$netProfit = $totalServiceRevenue - $totalPayments - $totalInventoryCost;

// Get inventory trend data (monthly)
$inventoryTrendQuery = "SELECT 
                          DATE_FORMAT(date_time, '%b %Y') AS month,
                          SUM(total_price) AS monthly_inventory_cost,
                          COUNT(*) AS purchase_count
                       FROM inventory
                       GROUP BY DATE_FORMAT(date_time, '%Y-%m')
                       ORDER BY MIN(date_time)";
$inventoryTrendResult = $conn->query($inventoryTrendQuery);

$inventoryMonths = [];
$inventoryCosts = [];
$inventoryCounts = [];

if ($inventoryTrendResult->num_rows > 0) {
    while ($row = $inventoryTrendResult->fetch_assoc()) {
        $inventoryMonths[] = $row['month'];
        $inventoryCosts[] = $row['monthly_inventory_cost'];
        $inventoryCounts[] = $row['purchase_count'];
    }
} else {
    // If no data, use the same months as payment data for comparison
    $inventoryMonths = $paymentMonths;
    $inventoryCosts = array_fill(0, count($paymentMonths), 0);
    $inventoryCounts = array_fill(0, count($paymentMonths), 0);
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --accent-color: #9b59b6;
            --success-color: #f1c40f;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --danger-color: #e74c3c;
            --profit-color: #16a085;
            --inventory-color: #e67e22;
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
            padding: 25px 20px;
            color: white;
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }
        
        header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, transparent 30%, rgba(0,0,0,0.1) 70%);
            opacity: 0.3;
        }
        
        .dashboard-title {
            margin: 0;
            font-weight: 600;
            position: relative;
            display: inline-block;
        }
        
        .dashboard-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 25%;
            width: 50%;
            height: 3px;
            background-color: var(--secondary-color);
            border-radius: 2px;
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
            position: relative;
            overflow: hidden;
        }
        
        .chart-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--accent-color));
            opacity: 0;
            transition: var(--transition);
        }
        
        .chart-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .chart-container:hover::after {
            opacity: 1;
        }
        
        h2 {
            color: var(--dark-color);
            margin-top: 0;
            font-size: 20px;
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
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
            display: inline-flex;
            align-items: center;
            gap: 8px;
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
        
        .btn-print {
            background-color: var(--accent-color);
            box-shadow: 0 4px 10px rgba(155, 89, 182, 0.3);
        }
        
        .btn-print:hover {
            background-color: #8e44ad;
            box-shadow: 0 6px 12px rgba(155, 89, 182, 0.4);
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
            padding: 18px 25px;
            border-radius: 10px;
            box-shadow: var(--shadow);
            min-width: 200px;
            text-align: center;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at top right, rgba(255,255,255,0.8) 0%, transparent 70%);
            opacity: 0;
            transition: var(--transition);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .stat-card:hover::before {
            opacity: 1;
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
        
        .stat-card.success {
            border-left: 4px solid var(--success-color);
        }
        
        .stat-card.danger {
            border-left: 4px solid var(--danger-color);
        }
        
        .stat-card.profit {
            border-left: 4px solid var(--profit-color);
        }
        
        .stat-card.inventory {
            border-left: 4px solid var(--inventory-color);
        }
        
        .stat-value {
            font-size: 26px;
            font-weight: 600;
            margin: 5px 0;
            position: relative;
        }
        
        .stat-label {
            color: #7f8c8d;
            font-size: 14px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        
        .finance-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 30px 0;
            justify-content: center;
        }
        
        .finance-card {
            flex: 1;
            min-width: 300px;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: var(--shadow);
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .finance-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at bottom right, rgba(255,255,255,0.2) 0%, transparent 70%);
            opacity: 0.4;
        }
        
        .finance-card.revenue {
            background: linear-gradient(135deg, var(--accent-color), #8e44ad);
            animation: pulse-purple 3s infinite;
        }
        
        .finance-card.expenses {
            background: linear-gradient(135deg, var(--danger-color), #c0392b);
            animation: pulse-red 3s infinite;
        }
        
        .finance-card.inventory {
            background: linear-gradient(135deg, var(--inventory-color), #d35400);
            animation: pulse-orange 3s infinite;
        }
        
        .finance-card.profit {
            background: linear-gradient(135deg, var(--profit-color), #1abc9c);
            animation: pulse-green 3s infinite;
        }
        
        @keyframes pulse-purple {
            0% { box-shadow: 0 0 0 0 rgba(155, 89, 182, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(155, 89, 182, 0); }
            100% { box-shadow: 0 0 0 0 rgba(155, 89, 182, 0); }
        }
        
        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(231, 76, 60, 0); }
            100% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0); }
        }
        
        @keyframes pulse-orange {
            0% { box-shadow: 0 0 0 0 rgba(230, 126, 34, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(230, 126, 34, 0); }
            100% { box-shadow: 0 0 0 0 rgba(230, 126, 34, 0); }
        }
        
        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(22, 160, 133, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(22, 160, 133, 0); }
            100% { box-shadow: 0 0 0 0 rgba(22, 160, 133, 0); }
        }
        
        .finance-title {
            font-size: 18px;
            margin: 0 0 10px 0;
            opacity: 0.9;
        }
        
        .finance-amount {
            font-size: 32px;
            font-weight: 600;
            margin: 0;
        }
        
        .report-info {
            display: none;
        }
        
        /* Print styles */
        @media print {
            body {
                background-color: white;
                padding: 0;
                margin: 0;
            }
            
            header {
                background: #f8f8f8 !important;
                color: #333 !important;
                box-shadow: none;
                padding: 15px 0;
            }
            
            .dashboard-title::after {
                background-color: #333;
            }
            
            .container {
                width: 100%;
                padding: 0;
            }
            
            .charts-row {
                display: block;
                page-break-inside: avoid;
            }
            
            .chart-container {
                width: 100%;
                margin-bottom: 20px;
                box-shadow: none;
                border: 1px solid #eee;
                page-break-inside: avoid;
            }
            
            .btn-container {
                display: none;
            }
            
            .stat-card {
                box-shadow: none;
                border: 1px solid #eee;
            }
            
            .finance-container {
                display: block;
                page-break-inside: avoid;
            }
            
            .finance-card {
                background: #f8f8f8 !important;
                color: #333 !important;
                box-shadow: none;
                border: 1px solid #eee;
                animation: none;
                margin-bottom: 15px;
                width: 100%;
            }
            
            .report-info {
                display: block;
                margin: 10px 0 20px;
                text-align: center;
            }
            
            .canvas-holder {
                height: 300px;
            }
        }
        
        @media (max-width: 768px) {
            .charts-row {
                flex-direction: column;
            }
            
            .chart-container {
                width: 100%;
            }
            
            .stats-container {
                flex-direction: column;
                align-items: center;
            }
            
            .stat-card {
                width: 100%;
                max-width: 300px;
            }
            
            .finance-container {
                flex-direction: column;
            }
            
            .finance-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1 class="dashboard-title">Analytic Dashboard</h1>
    </header>
    
    <div class="container">
        <div class="report-info">
            <h2>Meri Gaddi Analytics Report</h2>
            <p>Generated on: <?php echo date('F j, Y'); ?></p>
        </div>
        
        <!-- Summary Stats -->
        <div class="stats-container">
            <div class="stat-card primary">
                <div class="stat-label"><i class="fas fa-clipboard-list"></i> Active Services</div>
                <div class="stat-value"><?php echo count($services); ?></div>
            </div>
            <div class="stat-card secondary">
                <div class="stat-label"><i class="fas fa-calendar-check"></i> Total Appointments</div>
                <div class="stat-value"><?php echo array_sum($appointmentCounts); ?></div>
            </div>
            <div class="stat-card accent">
                <div class="stat-label"><i class="fas fa-car-mechanic"></i> Service Revenue</div>
                <div class="stat-value">₹<?php echo number_format($totalServiceRevenue, 2); ?></div>
            </div>
            <div class="stat-card inventory">
                <div class="stat-label"><i class="fas fa-boxes"></i> Inventory Cost</div>
                <div class="stat-value">₹<?php echo number_format($totalInventoryCost, 2); ?></div>
            </div>
            <div class="stat-card danger">
                <div class="stat-label"><i class="fas fa-user-hard-hat"></i> Worker Payments</div>
                <div class="stat-value">₹<?php echo number_format($totalPayments, 2); ?></div>
            </div>
            <div class="stat-card profit">
                <div class="stat-label"><i class="fas fa-chart-line"></i> Net Profit</div>
                <div class="stat-value">₹<?php echo number_format($netProfit, 2); ?></div>
            </div>
        </div>
        
        <!-- First row of charts -->
        <div class="charts-row">
            <div class="chart-container">
                <h2><i class="fas fa-chart-bar"></i> Appointments Per Service</h2>
                <div class="canvas-holder">
                    <canvas id="appointmentChart"></canvas>
                </div>
            </div>
            
            <div class="chart-container">
                <h2><i class="fas fa-car"></i> Vehicle Types: Quantity and Revenue</h2>
                <div class="canvas-holder">
                    <canvas id="vehicleChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Third row of charts - Inventory Analysis -->
        <div class="charts-row">
            <div class="chart-container">
                <h2><i class="fas fa-boxes"></i> Monthly Inventory Cost</h2>
                <div class="canvas-holder">
                    <canvas id="inventoryChart"></canvas>
                </div>
            </div>
        </div>
        <!-- New chart for payment data -->
        <div class="charts-row">
            <div class="chart-container">
                <h2><i class="fas fa-money-bill-wave"></i> Monthly Worker Payments</h2>
                <div class="canvas-holder">
                    <canvas id="paymentChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="btn-container">
            <a href="http://localhost/final%20year/php/adminindex.php" class="btn btn-home">
                <i class="fas fa-home"></i> Back to Dashboard
            </a>
            <button class="btn btn-print" onclick="window.print()">
                <i class="fas fa-print"></i> Print Report
            </button>
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

// Chart 4: Monthly Inventory Cost
        const ctx4 = document.getElementById('inventoryChart').getContext('2d');
        new Chart(ctx4, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($inventoryMonths); ?>,
                datasets: [{
                    label: 'Monthly Inventory Cost (₹)',
                    data: <?php echo json_encode($inventoryCosts); ?>,
                    backgroundColor: 'rgba(46, 204, 113, 0.2)',
                    borderColor: 'rgba(46, 204, 113, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(46, 204, 113, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
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
                            text: 'Cost (₹)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                }
            }
        });
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
        
        // Chart 3: Payment Data
        const ctx3 = document.getElementById('paymentChart').getContext('2d');
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($paymentMonths); ?>,
                datasets: [
                    {
                        label: 'Monthly Payments (₹)',
                        data: <?php echo json_encode($paymentTotals); ?>,
                        backgroundColor: 'rgba(231, 76, 60, 0.2)',
                        borderColor: 'rgba(231, 76, 60, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(231, 76, 60, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Payment Count',
                        data: <?php echo json_encode($paymentCounts); ?>,
                        backgroundColor: 'rgba(241, 196, 15, 0.7)',
                        borderColor: 'rgba(241, 196, 15, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(241, 196, 15, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.4,
                        yAxisID: 'y1',
                        type: 'bar'
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
                            text: 'Payment Amount (₹)',
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
                            text: 'Payment Count',
                            font: {
                                family: "'Poppins', sans-serif",
                                size: 12
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month',
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
        
        // Animation for stats cards on page load
        document.addEventListener('DOMContentLoaded', function() {
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.opacity = 0;
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = 1;
                    card.style.transform = 'translateY(0)';
                }, 100 * index);
            });
        });
    </script>
</body>
</html>
