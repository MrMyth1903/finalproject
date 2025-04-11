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

// Pagination setup
$results_per_page = 10; // Number of appointments per page
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $results_per_page;

// Get filter, sort and search parameters
$service_filter = isset($_GET['service']) ? $_GET['service'] : '';
$date_filter = isset($_GET['date']) ? $_GET['date'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'ID';
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// Validate sort parameters to prevent SQL injection
$allowed_sort_columns = ['ID', 'LEVEL', 'SERVICE', 'DATE', 'TIME', 'NAME', 'VEHICLE_NO', 'PRICE'];
if (!in_array($sort_by, $allowed_sort_columns)) {
    $sort_by = 'ID';
}
if ($sort_order !== 'ASC' && $sort_order !== 'DESC') {
    $sort_order = 'ASC';
}

// Build base query
$sql = "SELECT ID, LEVEL, SERVICE, DATE, TIME, NAME,EMAIL, VEHICLE_NO, SPHERE_PART, PRICE, ENGINEE, CHASIS, PHONE_NUMBER FROM appointment";

// Add WHERE clauses if filters or search are set
$where_clauses = [];
if (!empty($service_filter)) {
    $where_clauses[] = "SERVICE LIKE '%" . $conn->real_escape_string($service_filter) . "%'";
}
if (!empty($date_filter)) {
    $where_clauses[] = "DATE = '" . $conn->real_escape_string($date_filter) . "'";
}
if (!empty($search)) {
    $search_condition = "NAME LIKE '%" . $conn->real_escape_string($search) . "%' OR 
                         VEHICLE_NO LIKE '%" . $conn->real_escape_string($search) . "%' OR 
                         PHONE_NUMBER LIKE '%" . $conn->real_escape_string($search) . "%'";
    $where_clauses[] = "(" . $search_condition . ")";
}

if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

// Add ORDER BY
$sql .= " ORDER BY " . $sort_by . " " . $sort_order;

// Clone the query for counting total filtered records
$count_sql = str_replace("SELECT ID, LEVEL, SERVICE, DATE, TIME, NAME,EMAIL, VEHICLE_NO, SPHERE_PART, PRICE, ENGINEE, CHASIS, PHONE_NUMBER", "SELECT COUNT(*) as total", $sql);

// Execute count query
$count_result = $conn->query($count_sql);
$row_count = $count_result->fetch_assoc();
$total_records = $row_count['total'];
$total_pages = ceil($total_records / $results_per_page);

// Add LIMIT for pagination to the main query
$sql .= " LIMIT $offset, $results_per_page";

// Execute main query
$result = $conn->query($sql);

// Get stats counts
$sql_total = "SELECT COUNT(*) as count FROM appointment";
$total_result = $conn->query($sql_total);
$total_count = $total_result->fetch_assoc()['count'];

$sql_pending = "SELECT COUNT(*) as count FROM appointment WHERE LOWER(PRICE) = 'urgent'";
$pending_result = $conn->query($sql_pending);
$pending_count = $pending_result->fetch_assoc()['count'];

$sql_completed = "SELECT COUNT(*) as count FROM appointment WHERE LOWER(PRICE) != 'urgent'";
$completed_result = $conn->query($sql_completed);
$completed_count = $completed_result->fetch_assoc()['count'];

$sql_services = "SELECT COUNT(DISTINCT SERVICE) as count FROM appointment";
$services_result = $conn->query($sql_services);
$services_count = $services_result->fetch_assoc()['count'];
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

        /* Filter and Search */
        .controls-container {
            max-width: 1200px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
            flex: 1;
        }

        .filter-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .filter-item label {
            font-size: 14px;
            font-weight: 500;
        }

        .filter-item input, .filter-item select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .filter-btn, .reset-btn, .export-btn {
            padding: 8px 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }

        .filter-btn {
            background-color: var(--secondary);
            color: white;
        }

        .filter-btn:hover {
            background-color: #2980b9;
        }

        .reset-btn {
            background-color: #6c757d;
            color: white;
        }

        .reset-btn:hover {
            background-color: #5a6268;
        }

        .export-btn {
            background-color: var(--success);
            color: white;
            margin-left: 5px;
        }

        .export-btn:hover {
            background-color: #27ae60;
        }

        .search-container {
            display: flex;
            margin-left: auto;
        }

        .search-container form {
            display: flex;
            gap: 5px;
        }

        .search-container input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
            font-size: 14px;
            width: 200px;
        }

        .search-btn {
            padding: 8px 12px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: var(--transition);
        }

        .search-btn:hover {
            background-color: #1a252f;
        }

        .export-options {
            display: flex;
            gap: 5px;
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

        .add-btn a {
            color: white;
            text-decoration: none;
        }

        /* Table Styling */
        .table-responsive {
            overflow-x: auto;
        }

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
            position: relative;
            cursor: pointer;
        }

        th i {
            margin-left: 5px;
            font-size: 10px;
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
            flex-wrap: wrap;
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

        /* No results */
        .no-results {
            padding: 30px;
            text-align: center;
            color: #666;
        }

        .no-results i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #ddd;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .dashboard-stats, .controls-container, .table-container {
                padding-left: 20px;
                padding-right: 20px;
                box-sizing: border-box;
            }
        }

        @media (max-width: 992px) {
            .stat-card {
                width: 48%;
            }
            .controls-container {
                flex-direction: column;
                align-items: stretch;
            }
            .search-container {
                margin-left: 0;
                width: 100%;
            }
            .search-container form {
                width: 100%;
            }
            .search-container input {
                flex: 1;
            }
            .export-options {
                justify-content: flex-end;
                margin-top: 10px;
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
            .table-responsive {
                overflow-x: auto;
            }
            table {
                min-width: 800px;
            }
            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }
            .filter-item {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .stat-card {
                width: 100%;
            }
            .dashboard-stats {
                flex-direction: column;
            }
            .button-container {
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
            <h3><?php echo $total_count; ?></h3>
            <p>Total Appointments</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-clock"></i>
            <h3><?php echo $pending_count; ?></h3>
            <p>Urgent Appointments</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-check-circle"></i>
            <h3><?php echo $completed_count; ?></h3>
            <p>Regular Services</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-tools"></i>
            <h3><?php echo $services_count; ?></h3>
            <p>Available Services</p>
        </div>
    </div>

    
    <!-- Table Container -->
    <div class="table-container">
        <div class="table-header">
            <h2>Appointment List</h2>
            <!-- <button class="add-btn">
                <a href="../appointment.php"><i class="fas fa-plus"></i> Add New Appointment</a>
            </button> -->
        </div>
        
        <div class="table-responsive">
            <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'ID', 'order' => $sort_by === 'ID' && $sort_order === 'ASC' ? 'DESC' : 'ASC'])); ?>">
                                ID <?php echo ($sort_by === 'ID') ? ($sort_order === 'ASC' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>'; ?>
                            </a>
                        </th>
                        <th>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'LEVEL', 'order' => $sort_by === 'LEVEL' && $sort_order === 'ASC' ? 'DESC' : 'ASC'])); ?>">
                                LEVEL <?php echo ($sort_by === 'LEVEL') ? ($sort_order === 'ASC' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>'; ?>
                            </a>
                        </th>
                        <th>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'SERVICE', 'order' => $sort_by === 'SERVICE' && $sort_order === 'ASC' ? 'DESC' : 'ASC'])); ?>">
                                Service <?php echo ($sort_by === 'SERVICE') ? ($sort_order === 'ASC' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>'; ?>
                            </a>
                        </th>
                        <th>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'DATE', 'order' => $sort_by === 'DATE' && $sort_order === 'ASC' ? 'DESC' : 'ASC'])); ?>">
                                Date <?php echo ($sort_by === 'DATE') ? ($sort_order === 'ASC' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>'; ?>
                            </a>
                        </th>
                        <th>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'TIME', 'order' => $sort_by === 'TIME' && $sort_order === 'ASC' ? 'DESC' : 'ASC'])); ?>">
                                Time <?php echo ($sort_by === 'TIME') ? ($sort_order === 'ASC' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>'; ?>
                            </a>
                        </th>
                        <th>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'NAME', 'order' => $sort_by === 'NAME' && $sort_order === 'ASC' ? 'DESC' : 'ASC'])); ?>">
                                Name <?php echo ($sort_by === 'NAME') ? ($sort_order === 'ASC' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>'; ?>
                            </a>
                        </th>
                        <th>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'EMAIL', 'order' => $sort_by === 'EMAIL' && $sort_order === 'ASC' ? 'DESC' : 'ASC'])); ?>">
                                EMAIL <?php echo ($sort_by === 'EMAIL') ? ($sort_order === 'ASC' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>'; ?>
                            </a>
                        </th>
                        <th>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'VEHICLE_NO', 'order' => $sort_by === 'VEHICLE_NO' && $sort_order === 'ASC' ? 'DESC' : 'ASC'])); ?>">
                                Vehicle No. <?php echo ($sort_by === 'VEHICLE_NO') ? ($sort_order === 'ASC' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>'; ?>
                            </a>
                        </th>
                        <th>Engine No.</th>
                        <th>Chesis No.</th>
                        <th>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'PRICE', 'order' => $sort_by === 'PRICE' && $sort_order === 'ASC' ? 'DESC' : 'ASC'])); ?>">
                                Price <?php echo ($sort_by === 'PRICE') ? ($sort_order === 'ASC' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>'; ?>
                            </a>
                        </th>
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
                            <td><?php echo htmlspecialchars($row['EMAIL']); ?></td>
                            <td><?php echo htmlspecialchars($row['VEHICLE_NO']); ?></td>
                            <td><?php echo htmlspecialchars($row['ENGINEE']); ?></td>
                            <td><?php echo htmlspecialchars($row['CHASIS']); ?></td>
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
                                    <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['ID']; ?>);">
                                        <button class="btn btn-delete"><i class="fas fa-trash"></i> Delete</button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <h3>No appointments found</h3>
                    <p>Try clearing filters or search terms</p>
                </div>
            <?php endif; ?>
        </div>
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