<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $vendor_name = $_POST['vendor_name'];
    $current_time = date("Y-m-d H:i:s");

    // Database connection
    $conn = new mysqli("localhost", "root", "", "final");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $total_price = $price * $quantity;

    $stmt = $conn->prepare("INSERT INTO inventory (product_name, price, quantity, vendor_name, total_price, date_time) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdisss", $product_name, $price, $quantity, $vendor_name, $total_price, $current_time);

    if ($stmt->execute()) {
        echo "
        <script>
            alert('Inventory Added Successfully!');
            window.location.href = 'adminindex.php';
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Inventory | Inventory Management System</title>
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
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.25);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px 30px;
            position: relative;
            overflow: hidden;
        }
        
        .card-header h2 {
            font-size: 1.8rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 70%);
            opacity: 0;
            transform: scale(0.5);
            transition: transform 0.6s, opacity 0.6s;
        }
        
        .card-header:hover::before {
            opacity: 1;
            transform: scale(1);
        }
        
        .card-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
            font-size: 0.95rem;
            transform: translateY(0);
            transition: all 0.3s;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
            outline: none;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
        }
        
        .form-control:focus + .form-icon {
            color: var(--primary-color);
            transform: translateY(-5px);
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .form-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #aaa;
            transition: all 0.3s;
        }
        
        .btn-container {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            min-width: 150px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 10px rgba(78, 115, 223, 0.3);
        }
        
        .btn-primary:hover {
            background-color: var(--hover-color);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(78, 115, 223, 0.4);
        }
        
        .btn-secondary {
            background-color: white;
            color: var(--dark-color);
            border: 1px solid var(--border-color);
        }
        
        .btn-secondary:hover {
            background-color: var(--light-color);
            transform: translateY(-3px);
        }
        
        /* Animation classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .slide-in {
            animation: slideIn 0.5s ease;
        }
        
        @keyframes slideIn {
            from { transform: translateX(-30px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        /* Loading spinner */
        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 999;
            justify-content: center;
            align-items: center;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid var(--border-color);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            100% { transform: rotate(360deg); }
        }
        
        /* Error state */
        .error-message {
            color: var(--danger-color);
            font-size: 0.85rem;
            margin-top: 5px;
            display: none;
        }
        
        .form-control.error {
            border-color: var(--danger-color);
        }
        
        /* Success feedback */
        .success-feedback {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: var(--secondary-color);
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(28, 200, 138, 0.3);
            z-index: 1000;
            animation: slideInRight 0.5s ease;
        }
        
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 0 10px;
            }
            
            .card-header {
                padding: 15px 20px;
            }
            
            .card-body {
                padding: 20px;
            }
            
            .btn-container {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Loading spinner (hidden by default) -->
    <div class="loading" id="loading">
        <div class="spinner"></div>
    </div>
    
    <!-- Success feedback message (hidden by default) -->
    <div class="success-feedback" id="successMessage">
        <i class="fas fa-check-circle"></i> Item added successfully!
    </div>

    <div class="container">
        <div class="card fade-in">
            <div class="card-header">
                <h2><i class="fas fa-plus-circle"></i> Add New Inventory Item</h2>
            </div>
            
            <div class="card-body">
                <form method="post" action="" id="inventoryForm">
                    <div class="form-group slide-in" style="animation-delay: 0.1s;">
                        <label for="product_name">Product Name</label>
                        <div class="input-with-icon">
                            <input type="text" id="product_name" name="product_name" class="form-control" required placeholder="Enter product name">
                            <i class="fas fa-box form-icon"></i>
                        </div>
                        <div class="error-message" id="productNameError">Please enter a valid product name</div>
                    </div>
                    
                    <div class="form-group slide-in" style="animation-delay: 0.2s;">
                        <label for="price">Price (₹)</label>
                        <div class="input-with-icon">
                            <input type="number" step="0.01" id="price" name="price" class="form-control" required placeholder="Enter price">
                            <i class="fas fa-rupee-sign form-icon"></i>
                        </div>
                        <div class="error-message" id="priceError">Please enter a valid price</div>
                    </div>
                    
                    <div class="form-group slide-in" style="animation-delay: 0.3s;">
                        <label for="quantity">Quantity</label>
                        <div class="input-with-icon">
                            <input type="number" id="quantity" name="quantity" class="form-control" required placeholder="Enter quantity">
                            <i class="fas fa-cubes form-icon"></i>
                        </div>
                        <div class="error-message" id="quantityError">Please enter a valid quantity</div>
                    </div>
                    
                    <div class="form-group slide-in" style="animation-delay: 0.4s;">
                        <label for="vendor_name">Vendor Name</label>
                        <div class="input-with-icon">
                            <input type="text" id="vendor_name" name="vendor_name" class="form-control" required placeholder="Enter vendor name">
                            <i class="fas fa-truck form-icon"></i>
                        </div>
                        <div class="error-message" id="vendorNameError">Please enter a valid vendor name</div>
                    </div>
                    
                    <div class="form-group slide-in" style="animation-delay: 0.5s;">
                        <label>Total Price</label>
                        <div class="input-with-icon">
                            <input type="text" id="total_price" class="form-control" disabled placeholder="Auto-calculated">
                            <i class="fas fa-calculator form-icon"></i>
                        </div>
                    </div>
                    
                    <div class="btn-container slide-in" style="animation-delay: 0.6s;">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save"></i> Save Item
                        </button>
                        <a href="adminindex.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const priceInput = document.getElementById('price');
            const quantityInput = document.getElementById('quantity');
            const totalPriceInput = document.getElementById('total_price');
            const form = document.getElementById('inventoryForm');
            
            // Calculate total price on input change
            function calculateTotal() {
                const price = parseFloat(priceInput.value) || 0;
                const quantity = parseInt(quantityInput.value) || 0;
                const total = price * quantity;
                
                totalPriceInput.value = '₹ ' + total.toFixed(2);
            }
            
            priceInput.addEventListener('input', calculateTotal);
            quantityInput.addEventListener('input', calculateTotal);
            
            // Input validation
            function validateForm() {
                let isValid = true;
                
                // Product name validation
                const productName = document.getElementById('product_name').value.trim();
                if (productName === '') {
                    document.getElementById('productNameError').style.display = 'block';
                    document.getElementById('product_name').classList.add('error');
                    isValid = false;
                } else {
                    document.getElementById('productNameError').style.display = 'none';
                    document.getElementById('product_name').classList.remove('error');
                }
                
                // Price validation
                const price = priceInput.value;
                if (price === '' || parseFloat(price) <= 0) {
                    document.getElementById('priceError').style.display = 'block';
                    priceInput.classList.add('error');
                    isValid = false;
                } else {
                    document.getElementById('priceError').style.display = 'none';
                    priceInput.classList.remove('error');
                }
                
                // Quantity validation
                const quantity = quantityInput.value;
                if (quantity === '' || parseInt(quantity) <= 0) {
                    document.getElementById('quantityError').style.display = 'block';
                    quantityInput.classList.add('error');
                    isValid = false;
                } else {
                    document.getElementById('quantityError').style.display = 'none';
                    quantityInput.classList.remove('error');
                }
                
                // Vendor name validation
                const vendorName = document.getElementById('vendor_name').value.trim();
                if (vendorName === '') {
                    document.getElementById('vendorNameError').style.display = 'block';
                    document.getElementById('vendor_name').classList.add('error');
                    isValid = false;
                } else {
                    document.getElementById('vendorNameError').style.display = 'none';
                    document.getElementById('vendor_name').classList.remove('error');
                }
                
                return isValid;
            }
            
            // Form submission
            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return false;
                }
                
                // Show loading spinner
                document.getElementById('loading').style.display = 'flex';
                
                // For demo purposes, we're not actually preventing form submission
                // In a real app, you might use AJAX here
                return true;
            });
            
            // Focus effect on inputs
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.querySelector('.form-icon').style.color = 'var(--primary-color)';
                });
                
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentElement.querySelector('.form-icon').style.color = '#aaa';
                    }
                });
            });
            
            // Initialize total price field
            calculateTotal();
        });
    </script>
</body>
</html>