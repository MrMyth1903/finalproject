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

// Fetch Vehicle Appointment Data
$sql = "SELECT ID,LEVEL, SERVICE, DATE, TIME, NAME, VEHICLE_NO,SPHERE_PART,PRICE, PHONE_NUMBER FROM appointment";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Service Appointments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --success: #2ecc71;
            --light: #f8f9fa;
            --dark: #343a40;
            --text: #333;
            --border-radius: 8px;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: var(--text);
            line-height: 1.6;
        }

        /* Header and Navigation */
        .header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 20px;
            box-shadow: var(--box-shadow);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            font-size: 26px;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .logo i {
            margin-right: 10px;
            font-size: 28px;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .nav-links a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Page Title */
        .page-title {
            text-align: center;
            margin: 30px 0;
            color: var(--primary);
            font-size: 32px;
            font-weight: 600;
        }

        /* Dashboard Stats */
        .dashboard-stats {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto 30px;
            flex-wrap: wrap;
        }

        .stat-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--box-shadow);
            width: 23%;
            margin-bottom: 15px;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 30px;
            margin-bottom: 10px;
            color: var(--secondary);
        }

        .stat-card h3 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .stat-card p {
            font-size: 14px;
            color: #666;
        }

        /* Table Container */
        .table-container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        .table-header {
            background-color: var(--primary);
            padding: 15px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h2 {
            font-size: 20px;
            font-weight: 600;
        }

        .add-btn {
            background-color: var(--success);
            color: white;
            border: none;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .add-btn:hover {
            background-color: #27ae60;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
            color: var(--dark);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        tr:hover {
            background-color: #f5f8fa;
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
            display: inline-block;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Button Styling */
        .button-container {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-edit {
            background-color: var(--secondary);
            color: white;
        }

        .btn-edit:hover {
            background-color: #2980b9;
        }

        .btn-delete {
            background-color: var(--accent);
            color: white;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
            gap: 5px;
        }

        .pagination a {
            padding: 8px 12px;
            background-color: white;
            border: 1px solid #ddd;
            color: var(--primary);
            text-decoration: none;
            border-radius: 4px;
            transition: var(--transition);
        }

        .pagination a.active {
            background-color: var(--secondary);
            color: white;
            border: 1px solid var(--secondary);
        }

        .pagination a:hover:not(.active) {
            background-color: #f1f1f1;
        }

        /* Footer */
        .footer {
            background-color: var(--primary);
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .dashboard-stats {
                padding: 0 20px;
            }
            .table-container {
                margin: 0 20px;
            }
        }

        @media (max-width: 992px) {
            .stat-card {
                width: 48%;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }
            .nav-links {
                width: 100%;
                justify-content: center;
            }
            .table-container {
                overflow-x: auto;
            }
            table {
                min-width: 800px;
            }
        }

        @media (max-width: 576px) {
            .stat-card {
                width: 100%;
            }
            .dashboard-stats {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    

    <!-- Page Title -->
    <h1 class="page-title">Appointment Management</h1>

    <!-- Dashboard Stats -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <i class="fas fa-calendar-check"></i>
            <h3><?php echo $result->num_rows; ?></h3>
            <p>Total Appointments</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-clock"></i>
            <h3>8</h3>
            <p>Pending Appointments</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-check-circle"></i>
            <h3>24</h3>
            <p>Completed Services</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-tools"></i>
            <h3>5</h3>
            <p>Available Services</p>
        </div>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <div class="table-header">
            <h2>Appointment List</h2>
            <button class="add-btn">
                <a href="../appointment.html"><i class="fas fa-plus"></i> Add New Appointment</a>
            </button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>LEVEL</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Name</th>
                    <th>Vehicle No.</th>
                    <th>Want</th>
                    <th>Parts</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['ID']; ?></td>
                        <td><?php echo htmlspecialchars($row['LEVEL']); ?></td>
                        <td><?php echo htmlspecialchars($row['SERVICE']); ?></td>
                        <td><?php echo htmlspecialchars($row['DATE']); ?></td>
                        <td><?php echo htmlspecialchars($row['TIME']); ?></td>
                        <td><?php echo htmlspecialchars($row['NAME']); ?></td>
                        <td><?php echo htmlspecialchars($row['VEHICLE_NO']); ?></td>
                        <td>
                            <span class="status-badge <?php echo strtolower($row['PRICE']) == 'urgent' ? 'status-pending' : 'status-completed'; ?>">
                                <?php echo htmlspecialchars($row['PRICE']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($row['SPHERE_PART']); ?></td>
                        <td><?php echo htmlspecialchars($row['PHONE_NUMBER']); ?></td>
                        <td>
                            <div class="button-container">
                                <a href="v_update.php?id=<?php echo $row['ID']; ?>">
                                    <button class="btn btn-edit"><i class="fas fa-edit"></i> Edit</button>
                                </a>
                                <a href="v_delete.php?id=<?php echo $row['ID']; ?>" onclick="return confirm('Are you sure you want to delete this appointment?');">
                                    <button class="btn btn-delete"><i class="fas fa-trash"></i> Delete</button>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <a href="#">&laquo;</a>
        <a href="#" class="active">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#">&raquo;</a>
    </div>

    

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this appointment?")) { 
                window.location.href = "v_delete.php?id=" + id;
            }
        }
    </script>
</body>
</html>