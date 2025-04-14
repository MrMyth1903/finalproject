<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "final";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM inventory WHERE product_name LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM inventory";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Add Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #1cc88a;
            --danger-color: #e74a3b;
            --dark-color: #5a5c69;
            --light-color: #f8f9fc;
            --border-color: #e3e6f0;
            --hover-color: #2e59d9;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 95%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background-color: white;
            padding: 1.5rem 2rem;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .header:hover {
            transform: translateY(-5px);
        }
        
        h2 {
            color: var(--dark-color);
            font-size: 1.8rem;
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        h2:after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }
        
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .search-form {
            display: flex;
            background: white;
            border-radius: 50px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .search-form:focus-within {
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.25);
        }
        
        .search-form input[type="text"] {
            border: none;
            padding: 12px 20px;
            flex-grow: 1;
            min-width: 250px;
            font-size: 1rem;
            outline: none;
        }
        
        .search-form button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .search-form button:hover {
            background-color: var(--hover-color);
        }
        
        .add-btn {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(28, 200, 138, 0.3);
        }
        
        .add-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 8px rgba(28, 200, 138, 0.4);
        }
        
        .table-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            overflow: hidden;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 0;
        }
        
        th, td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        th {
            background-color: var(--light-color);
            color: var(--dark-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        tr {
            transition: background-color 0.2s;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }
        
        .actions {
            display: flex;
            gap: 8px;
        }
        
        .btn-edit, .btn-delete {
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
        }
        
        .btn-edit {
            background-color: #4e73df;
        }
        
        .btn-edit:hover {
            background-color: #2e59d9;
            transform: translateY(-2px);
        }
        
        .btn-delete {
            background-color: #e74a3b;
        }
        
        .btn-delete:hover {
            background-color: #be3b2f;
            transform: translateY(-2px);
        }
        
        .price-column, .total-column {
            font-weight: 600;
        }
        
        .quantity-column {
            text-align: center;
        }
        
        .empty-state {
            padding: 30px;
            text-align: center;
            color: var(--dark-color);
        }
        
        
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Loading spinner animation */
        /* .loading {
            display: none; Hidden initially 
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 999;
            display: flex;
            justify-content: center;
            align-items: center;
        } */
        
        /* .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid var(--border-color);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            100% { transform: rotate(360deg); }
        } */
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .top-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .search-form input[type="text"] {
                min-width: 150px;
            }
            th, td {
                padding: 10px;
            }
            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Loading spinner (hidden by default) -->
    <div class="loading" id="loading">
        <div class="spinner"></div>
    </div>

    <div class="container fade-in">
        <div class="header">
            <h2><i class="fas fa-warehouse"></i> Inventory Management</h2>
        

        
            <!-- Search form -->
            <!-- <form method="GET" action="" class="search-form">
                <input type="text" name="search" placeholder="Search inventory items..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit"><i class="fas fa-search"></i> Search</button>
            </form> -->

            <!-- Add inventory button -->
            <a href="inventory_form.php">
                <button class="add-btn"><i class="fas fa-plus-circle"></i> Add New Item</button>
            </a>
        
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item Name</th>
                        <th>Vendor</th>
                        <th>Price (₹)</th>
                        <th class="quantity-column">Quantity</th>
                        <th>Total (₹)</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr class="item-row">
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo htmlspecialchars($row["product_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["vendor_name"]); ?></td>
                            <td class="price-column">₹<?php echo number_format($row["price"], 2); ?></td>
                            <td class="quantity-column"><?php echo $row["quantity"]; ?></td>
                            <td class="total-column">₹<?php echo number_format($row["total_price"], 2); ?></td>
                            <td><?php echo date('M d, Y H:i', strtotime($row["date_time"])); ?></td>
                            <td class="actions">
                                <a href="edit_inventory.php?id=<?php echo $row['id']; ?>" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="delete_inventory.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirmDelete(<?php echo $row['id']; ?>);">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="empty-state">
                            <i class="fas fa-box-open" style="font-size: 3rem; color: #ccc; display: block; margin-bottom: 15px;"></i>
                            <p>No inventory items found. Try a different search or add new items.</p>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Show loading animation when interacting with buttons
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation to rows
            const rows = document.querySelectorAll('.item-row');
            rows.forEach((row, index) => {
                row.style.animation = `fadeIn 0.3s ease-in forwards ${index * 0.05}s`;
                row.style.opacity = '0';
            });
            
            // Enhanced delete confirmation
            window.confirmDelete = function(id) {
                return confirm(`Are you sure you want to delete item #${id}? This action cannot be undone.`);
            };
            
            // Show loading when buttons are clicked
            const actionButtons = document.querySelectorAll('.btn-edit, .btn-delete, .add-btn');
            actionButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Don't show loading for delete if not confirmed
                    if (this.classList.contains('btn-delete')) {
                        if (!confirm(`Are you sure you want to delete this item? This action cannot be undone.`)) {
                            e.preventDefault();
                            return false;
                        }
                    }
                    
                    document.getElementById('loading').style.display = 'flex';
                });
            });
            
            // Show loading when form submitted
            const searchForm = document.querySelector('.search-form');
            searchForm.addEventListener('submit', function() {
                document.getElementById('loading').style.display = 'flex';
            });
        });
    </script>
</body>
</html>

<?php $conn->close(); ?>