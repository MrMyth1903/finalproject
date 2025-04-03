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
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #0bb783;
            --danger-color: #f64e60;
            --warning-color: #ffa800;
            --info-color: #3699ff;
            --light-color: #f8f9fa;
            --dark-color: #212121;
            --border-color: #e4e6ef;
            --shadow-color: rgba(0, 0, 0, 0.05);
            --body-bg: #f5f8fa;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--body-bg);
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Page Header Styles */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .page-stats {
            display: flex;
            gap: 15px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 15px var(--shadow-color);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card i {
            font-size: 24px;
            margin-right: 15px;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            margin-right: 8px;
        }
        
        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }
        
        /* Search Bar Styles */
        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
        }
        
        .search-input {
            flex-grow: 1;
            padding: 12px 20px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 15px;
            box-shadow: 0 2px 10px var(--shadow-color);
            transition: all 0.3s ease;
            max-width: 500px;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.3);
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
        }
        
        /* Card Styles */
        .card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px var(--shadow-color);
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .card-header {
            padding: 20px 25px;
            background-color: white;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title {
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            color: var(--dark-color);
        }
        
        .card-title i {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .card-body {
            padding: 0;
        }
        
        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table thead tr {
            background-color: #f8f9fa;
        }
        
        .data-table th {
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            font-size: 13px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .data-table td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            color: var(--dark-color);
        }
        
        .data-table tbody tr {
            transition: background-color 0.3s ease;
        }
        
        .data-table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-icon {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-edit {
            background-color: rgba(54, 153, 255, 0.1);
            color: var(--info-color);
        }
        
        .btn-edit:hover {
            background-color: var(--info-color);
            color: white;
        }
        
        .btn-delete {
            background-color: rgba(246, 78, 96, 0.1);
            color: var(--danger-color);
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }
        
        .btn-delete:hover {
            background-color: var(--danger-color);
            color: white;
        }
        
        .btn-icon i {
            margin-right: 5px;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .search-bar {
                flex-direction: column;
                gap: 15px;
            }
            
            .search-input {
                max-width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }
            
            .stat-card {
                padding: 10px 15px;
            }
            
            .stat-value {
                font-size: 20px;
            }
        }
        
        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            display: none;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .modal-title {
            font-size: 20px;
            font-weight: 600;
        }
        
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 25px;
        }
        
        /* Animation for page load */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .container {
            animation: fadeIn 0.5s ease-out;
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
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" id="searchInput" class="search-input" placeholder="Search vendors...">
            <a href="add_vendor.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Vendor</a>
        </div>

        <!-- Vendor Table -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-store"></i> Vendor List</h2>
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
                                        <a href="edit_vendor.php?id=<?= $row['ID'] ?>" class="btn-icon btn-edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="delete_vendor.php?id=<?= $row['ID'] ?>" onclick="return confirm('Are you sure you want to delete this vendor?');">
                                            <button class="btn-delete"><i class="fas fa-trash"></i> Delete</button>
                                        </a>
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

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let input = this.value.toLowerCase();
            let table = document.getElementById('vendorTable');
            let rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                let showRow = false;
                let cells = rows[i].getElementsByTagName('td');

                for (let j = 0; j < cells.length - 1; j++) {
                    if (cells[j].textContent.toLowerCase().includes(input)) {
                        showRow = true;
                        break;
                    }
                }

                rows[i].style.display = showRow ? '' : 'none';
            }
        });
    </script>
</body>
</html>

<?php $conn->close(); ?>