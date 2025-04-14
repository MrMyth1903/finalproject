
<?php
session_start(); // Start the session to use session variables

$con = mysqli_connect('localhost', 'root', '', 'final');
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}



$user = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM inventory WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        die("User  not found.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $firstname = trim($_POST['firstname']);
    $middlename = trim($_POST['lastname']);
    $lastname = trim($_POST['email']);
    $phone_no = trim($_POST['phoneNumber']);
    $total_price = $lastname * $phone_no;

    // Update user details
    $updateQuery = "UPDATE inventory SET product_name=?, vendor_name=?, price=?, quantity=?, total_price=? WHERE id=?";
    $stmt = $con->prepare($updateQuery);
    $stmt->bind_param("ssssss", $firstname, $middlename, $lastname, $phone_no, $total_price, $id);
    $stmt->execute();
    $stmt->close();

    // Set a success message in the session
    $_SESSION['success_message'] = "Inventory updated successfully!";
    
    if (isset($_SESSION['success_message'])) {
        echo '<script>alert("' . $_SESSION['success_message'] . '");</script>';
        unset($_SESSION['success_message']); // Clear the message after displaying it
    }
    // Redirect to admin index page
    header("Location: adminindex.php");
    exit(); // Ensure no further code is executed after redirection
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User | Meri Gaddi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        :root {
            --primary: #3a36db;
            --primary-dark: #2d2bb0;
            --secondary: #ffc107;
            --dark: #333;
            --light: #f8f9fa;
            --success: #28a745;
            --danger: #dc3545;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
        }
        
        .form-container {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
            padding: 2.5rem;
            width: 100%;
            max-width: 700px;
            position: relative;
            overflow: hidden;
        }
        
        .form-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .form-header h2 {
            color: var(--primary);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .form-header p {
            color: #777;
            font-size: 1rem;
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 1rem;
        }
        
        .form-group {
            flex: 1 1 300px;
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #555;
            font-size: 0.9rem;
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: #f8f9fa;
            border: 1px solid #e1e5e8;
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(58, 54, 219, 0.1);
        }
        
        .form-control-icon {
            position: relative;
        }
        
        .form-control-icon .form-control {
            padding-left: 2.8rem;
        }
        
        .form-control-icon i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 1rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 2rem;
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(58, 54, 219, 0.3);
        }
        
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            color: #6c757d;
            text-decoration: none;
            font-weight: 500;
            margin-top: 1rem;
            transition: all 0.2s ease;
        }
        
        .back-link i {
            margin-right: 0.5rem;
        }
        
        .back-link:hover {
            color: var(--primary);
            transform: translateX(-3px);
        }
        
        @media (max-width: 768px) {
            .form-container {
                padding: 1.5rem;
                margin: 1rem;
            }
            
            .form-header h2 {
                font-size: 1.75rem;
            }
        }
    </style>
    <script>
        function calculateTotalPrice() {
            // Get the values of price and quantity
            var price = parseFloat(document.getElementById('email').value) || 0;
            var quantity = parseInt(document.getElementById('phoneNumber').value) || 0;
            // Calculate total price
            var totalPrice = price * quantity;
            // Set the total price in the total price input field
            document.getElementById('aadharNo').value = totalPrice.toFixed(2); // Format to 2 decimal places
        }
    </script>
</head>
<body>

<div class="form-container">
    <div class="form-header">
        <h2><i class="fas fa-user-edit form-title-icon"></i>Edit Inventory details</h2>
        <p>Update inventory information</p>
    </div>
    
    <?php if ($user): ?>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
        
        <div class="form-row">
            <div class="form-group">
                <label for="firstname"><i class="fas fa-user"></i> Product Name</label>
                <input type="text" id="firstname" name="firstname" class="form-control" value="<?= htmlspecialchars($user['product_name']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="lastname"><i class="fas fa-user"></i> Vendor Name:</label>
                <input type="text" id="lastname" name="lastname" class="form-control" value="<?= htmlspecialchars($user['vendor_name']) ?>" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Price:</label>
            <div class="form-control-icon">
                <i class="fas fa-envelope"></i>
                <input type="text" id="email" name="email" class="form-control form-control-with-icon" value="<?= htmlspecialchars($user['price']) ?>" required oninput="calculateTotalPrice()">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="phoneNumber"><i class="fas fa-phone"></i> Quantity:</label>
                <div class="form-control-icon">
                    <i class="fas fa-phone"></i>
                    <input type="text" id="phoneNumber" name="phoneNumber" class="form-control form-control-with-icon" value="<?= htmlspecialchars($user['quantity']) ?>" required oninput="calculateTotalPrice()">
                </div>
            </div>
            
            <div class="form-group">
                <label for="aadharNo"><i class="fas fa-id-card"></i> Total Price:</label>
                <div class="form-control-icon">
                    <i class="fas fa-id-card"></i>
                    <input type="text" id="aadharNo" name="aadharNo" class="form-control form-control-with-icon" value="<?= htmlspecialchars($user['total_price']) ?>" readonly>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn">
            <i class="fas fa-save"></i> Update Inventory
        </button>
        
        <a href="adminindex.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Admin Dashboard
        </a>
    </form>
    <?php else: ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> User data not available.
    </div>
    <a href="adminindex.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Admin Dashboard
    </a>
    <?php endif; ?>
</div>

</body>
</html>
