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

// Fetch Members
$result = $conn->query("SELECT * FROM vendor");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --text-color: #333;
            --border-radius: 8px;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: var(--text-color);
            line-height: 1.6;
        }
        
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Page header styling */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e1e8ed;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .page-stats {
            display: flex;
            gap: 15px;
        }
        
        .stat-card {
            background-color: white;
            padding: 15px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            min-width: 120px;
            text-align: center;
        }
        
        .stat-card i {
            display: block;
            font-size: 24px;
            margin-bottom: 5px;
            color: var(--primary-color);
        }
        
        .stat-card .stat-value {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .stat-card .stat-label {
            font-size: 12px;
            color: #7f8c8d;
            text-transform: uppercase;
        }
        
        /* Card styling */
        .card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 25px;
            overflow: hidden;
        }
        
        .card-header {
            padding: 15px 20px;
            background: var(--light-color);
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark-color);
            display: flex;
            align-items: center;
        }
        
        .card-title i {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* Form styling */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #5a5a5a;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 14px;
            transition: var(--transition);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.25);
        }
        
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        .btn-block {
            display: block;
            width: 100%;
        }
        
        /* Table styling */
        .table-responsive {
            overflow-x: auto;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            background-color: white;
        }
        
        .data-table th, 
        .data-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e1e8ed;
        }
        
        .data-table th {
            background-color: var(--light-color);
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .data-table tbody tr:hover {
            background-color: rgba(236, 240, 241, 0.5);
        }
        
        .data-table td:last-child {
            text-align: center;
        }
        
        /* Badge styling */
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-primary { background-color: #e1f0ff; color: var(--primary-color); }
        .badge-success { background-color: #d4f8e8; color: var(--success-color); }
        .badge-warning { background-color: #fff4de; color: var(--warning-color); }
        .badge-danger { background-color: #ffe9e9; color: var(--danger-color); }
        
        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }
        
        .btn-icon {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .btn-edit {
            background-color: #fff4de;
            color: var(--warning-color);
        }
        
        .btn-edit:hover {
            background-color: var(--warning-color);
            color: white;
        }
        
        .btn-delete {
            background-color: #ffe9e9;
            color: var(--danger-color);
        }
        
        .btn-delete:hover {
            background-color: var(--danger-color);
            color: white;
        }
        
        .btn-view {
            background-color: #e1f0ff;
            color: var(--primary-color);
        }
        
        .btn-view:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        /* Modal styling */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid #e1e8ed;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .modal-close {
            font-size: 20px;
            background: none;
            border: none;
            cursor: pointer;
            color: #95a5a6;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #e1e8ed;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .search-input {
            flex-grow: 1;
        }
        
        /* Responsive styles */
        @media screen and (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .page-stats {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 10px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Vendor Management</h1>
            <div class="page-stats">
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <div class="stat-value"><?php echo $result->num_rows; ?></div>
                    <div class="stat-label">Total Vendors</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-store"></i>
                    <div class="stat-value"><?php echo $result->num_rows; ?></div>
                    <div class="stat-label">Active</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-calendar-check"></i>
                    <div class="stat-value"><?php echo $result->num_rows; ?></div>
                    <div class="stat-label">New This Month</div>
                </div>
            </div>
        </div>
        
        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" id="searchInput" class="form-control search-input" placeholder="Search vendors...">
            <a href="add_vendor.php" class="btn btn-primary"><i class="fas fa-plus"></i>Add Vendor</a>


        </div>
        
        <!-- Vendor Table -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-store"></i> 
                    Vendor List
                </h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="data-table" id="vendorTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Vendor Name</th>
                                <th>Aadhar No</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row["ID"] ?></td>
                                <td><?= $row["VEN_NAME"] ?></td>
                                <td><?= $row["AADHAR_NO"] ?></td>
                                <td><?= $row["EMAIL"] ?></td>
                                <td><?= $row["ADDRESS"] ?></td>
                                <td><?= $row["PHONE"] ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon btn-view" onclick="viewVendor(<?= $row['ID'] ?>)" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-icon btn-edit" onclick="editVendor(<?= $row['ID'] ?>)" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-icon btn-delete" onclick="deleteVendor(<?= $row['ID'] ?>)" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
 
    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteVendorModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Confirm Deletion</h3>
                <button class="modal-close" onclick="closeDeleteModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this vendor? This action cannot be undone.</p>
                <form id="deleteVendorForm" action="delete_vendor.php" method="get">
                    <input type="hidden" id="delete_id" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" onclick="closeDeleteModal()">Cancel</button>
                <button type="submit" form="deleteVendorForm" class="btn btn-primary" style="background-color: var(--danger-color);">Yes, Delete</button>
            </div>
        </div>
    </div>
    
    <script>
        // Modal Function
        
        function deleteVendor(id) {
            document.getElementById('delete_id').value = id;
            document.getElementById('deleteVendorModal').style.display = 'flex';
        }
        
        function closeDeleteModal() {
            document.getElementById('deleteVendorModal').style.display = 'none';
        }
        
        function editVendor(id) {
            window.location.href = 'edit_vendor.php?id=' + id;
        }
        
        function viewVendor(id) {
            // You can implement a view details modal or redirect to a details page
            alert('Viewing vendor details for ID: ' + id);
        }
        
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let input = this.value.toLowerCase();
            let table = document.getElementById('vendorTable');
            let rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                let showRow = false;
                let cells = rows[i].getElementsByTagName('td');
                
                for (let j = 0; j < cells.length - 1; j++) {
                    if (cells[j].textContent.toLowerCase().indexOf(input) > -1) {
                        showRow = true;
                        break;
                    }
                }
                
                rows[i].style.display = showRow ? '' : 'none';
            }
        });
        
        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                event.target.style.display = 'none';
            }
        };
    </script>
</body>
</html>

<?php $conn->close(); ?>