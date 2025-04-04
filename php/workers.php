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

// Assign Vehicle Logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_vehicle'])) {
    $member_id = $_POST['member_id'];
    $vehicle = $_POST['vehicle'];
    $conn->query("UPDATE members SET vehicle='$vehicle' WHERE id=$member_id");
    
    // Redirect to prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch Members
$result = $conn->query("SELECT * FROM members");
$totalMembers = $result->num_rows;

// Count assigned vehicles
$assignedResult = $conn->query("SELECT COUNT(*) as assigned FROM members WHERE vehicle IS NOT NULL AND vehicle != ''");
$assignedRow = $assignedResult->fetch_assoc();
$assignedVehicles = $assignedRow['assigned'];

// Count unassigned vehicles
$unassignedVehicles = $totalMembers - $assignedVehicles;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --success: #2ecc71;
            --warning: #f39c12;
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
            width: 32%;
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

        /* Main Container */
        .main-container {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            gap: 20px;
        }

        /* Form Container */
        .form-container {
            flex: 1;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
        }

        .form-header {
            background-color: var(--primary);
            padding: 15px 20px;
            color: white;
        }

        .form-header h2 {
            font-size: 18px;
            font-weight: 500;
        }

        .form-content {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
            outline: none;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: var(--secondary);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: var(--transition);
            text-align: center;
        }

        .btn-primary {
            background-color: var(--success);
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #27ae60;
        }

        /* Table Container */
        .table-container {
            flex: 2;
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
            font-size: 18px;
            font-weight: 500;
        }

        /* Table Styling */
        .member-table {
            width: 100%;
            border-collapse: collapse;
        }

        .member-table th, 
        .member-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .member-table th {
            background-color: #f8f9fa;
            color: var(--dark);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .member-table tr:hover {
            background-color: #f5f8fa;
        }

        /* Status Badges */
        .badge {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
            display: inline-block;
        }

        .badge-assigned {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-unassigned {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 6px 10px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-success {
            background-color: var(--success);
        }

        .btn-success:hover {
            background-color: #27ae60;
        }

        .btn-warning {
            background-color: var(--warning);
        }

        .btn-warning:hover {
            background-color: #e67e22;
        }

        .btn-danger {
            background-color: var(--accent);
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            width: 90%;
            max-width: 400px;
            z-index: 1001;
        }

        .modal-header {
            background-color: var(--primary);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 500;
        }

        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            padding: 15px 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid #eee;
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
        @media (max-width: 992px) {
            .main-container {
                flex-direction: column;
                padding: 0 20px;
            }
            .dashboard-stats {
                padding: 0 20px;
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
            .stat-card {
                width: 48%;
            }
        }

        @media (max-width: 576px) {
            .stat-card {
                width: 100%;
            }
            .dashboard-stats {
                flex-direction: column;
            }
            .member-table {
                min-width: 800px;
            }
            .table-container {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    
    <!-- Page Title -->
    <h1 class="page-title">Staff Management</h1>

    <!-- Dashboard Stats -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <i class="fas fa-users"></i>
            <h3><?php echo $totalMembers; ?></h3>
            <p>Total Staff Members</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-car-side"></i>
            <h3><?php echo $assignedVehicles; ?></h3>
            <p>Assigned Vehicles</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-car-burst"></i>
            <h3><?php echo $unassignedVehicles; ?></h3>
            <p>Unassigned Staff</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Add Member Form -->
        <div class="form-container">
            <div class="form-header">
                <h2><i class="fas fa-user-plus"></i> Add New Staff Member</h2>
            </div>
            <div class="form-content">
                <form action="workersdb.php" method="post">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Enter first name" required>
                    </div>
                    <div class="form-group">
                        <label for="middlename">Last Name</label>
                        <input type="text" id="middlename" name="lastname" class="form-control" placeholder="Enter last name (optional)">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Email</label>
                        <input type="text" id="lastname" name="email" class="form-control" placeholder="Enter you mail" required>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" placeholder="Enter phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="aadharNo">Aadhar Number</label>
                        <input type="text" id="aadharNo" name="aadharNo" class="form-control" placeholder="Enter aadhar number" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Add Staff Member
                    </button>
                </form>
            </div>
        </div>

        <!-- Member List Table -->
        <div class="table-container">
            <div class="table-header">
                <h2><i class="fas fa-list"></i> Staff Member List</h2>
            </div>
            <div style="overflow-x: auto;">
                <table class="member-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Aadhar No</th>
                            <th>Vehicle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row["id"] ?></td>
                            <td>
                                <?= $row["firstname"] ?> 
                                <?= $row["lastname"] ?>
                            </td>
                            <td><?= $row["email"] ?></td>
                            <td><?= $row["phoneNumber"] ?></td>
                            <td><?= $row["aadharNo"] ?></td>
                            <td>
                                <?php if($row["vehicle"]): ?>
                                    <span class="badge badge-assigned">
                                        <i class="fas fa-car"></i> <?= $row["vehicle"] ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-unassigned">
                                        <i class="fas fa-triangle-exclamation"></i> Not Assigned
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="action-buttons">
                               <a href="assign_vehicle.php?id=<?= $row['id']?>"> <button class="btn btn-sm btn-success" onclick="openAssignModal(<?= $row['id'] ?>)">
                                    <i class="fas fa-car"></i> Assign
                                </button>
                                </a>
                                <a href="edit_member.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="delete_member.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this member?');">
                                    <i class="fas fa-trash"></i> Remove
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Assigning Vehicle -->
    <div class="modal-overlay" id="assignModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title"><i class="fas fa-car"></i> Assign Vehicle</h3>
                <button class="modal-close" onclick="closeAssignModal()">&times;</button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="member_id" id="member_id">
                    <div class="form-group">
                        <label for="vehicle">Vehicle Name/Number</label>
                        <input type="text" id="vehicle" name="vehicle" class="form-control" placeholder="Enter vehicle identification" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="closeAssignModal()">Cancel</button>
                    <button type="submit" name="assign_vehicle" class="btn btn-success">Assign Vehicle</button>
                </div>
            </form>
        </div>
    </div>



    <script>
        // Modal Functions
        function openAssignModal(id) {
            document.getElementById("member_id").value = id;
            document.getElementById("assignModal").style.display = "block";
        }
        
        function closeAssignModal() {
            document.getElementById("assignModal").style.display = "none";
        }
        
        // Close modal when clicking outside the modal
        window.onclick = function(event) {
            const modal = document.getElementById("assignModal");
            if (event.target == modal) {
                closeAssignModal();
            }
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>