<?php
session_start();
if (!isset($_SESSION['email'])) {
    exit();
}

// Database connection
$con = mysqli_connect('localhost', 'root', '', 'final');
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch service data for the logged-in user
$email = $_SESSION['email'];
$query = "SELECT * FROM service WHERE EMAIL = '" . mysqli_real_escape_string($con, $email) . "'";
$result = mysqli_query($con, $query);
$services = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $services[] = $row;
    }
}
mysqli_close($con);

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_method'])) {
    $payment_method = $_POST['payment_method'];
    switch ($payment_method) {
        case 'credit_card':
            echo "Processing Credit Card Payment...";
            break;
        case 'debit_card':
            echo "Processing Debit Card Payment...";
            break;
        case 'upi':
            echo "Processing UPI Payment...";
            break;
        case 'cash_on_delivery':
            echo "Cash on Delivery Selected!";
            break;
        case 'qr_code':
            echo "Please scan the QR Code to make payment!";
            break;
        default:
            echo "Invalid payment method!";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f6fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .container {
            display: flex;
            flex-direction: column;
            max-width: 800px;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            overflow: hidden;
        }
        h2, h3 {
            text-align: center;
        }
        .payment-options label {
            display: block;
            margin: 10px 0;
            font-size: 18px;
            cursor: pointer;
        }
        .payment-btn {
            width: 100%;
            padding: 12px;
            background-color: #0984e3;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background: #f1f1f1;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<DIV>
<strong>Invoice Details</strong>
    <ul>
        <?php foreach ($services as $service): ?>
            <li>Email:<?php echo htmlspecialchars($service['EMAIL']); ?></li> 
            <li>ID:<?php echo htmlspecialchars($service['ID']); ?></li> 
            <li>Vehicle No: <?php echo htmlspecialchars($service['V_NUMBER']); ?></li>  
            <li>Phone: <?php echo htmlspecialchars($service['PHONE']); ?></li>
            <li>Part: <?php echo htmlspecialchars($service['WANT']); ?></li>
            <li>Quantity: <?php echo htmlspecialchars($service['QUANTITY']); ?></li>
            <li>Price: <?php echo htmlspecialchars($service['PRICE']); ?></li>
            <?php endforeach; ?>
    </ul>
</DIV>
<div class="container">
    <h2>Payment Page</h2>
    <p>Hello, <strong><?php echo htmlspecialchars($_SESSION['email']); ?></strong>. Please pay your bill using any method below.</p>
    <h3>Select Your Payment Option</h3>
    <form method="POST">
        <div class="payment-options">
            <label><input type="radio" name="payment_method" value="credit_card" required> Credit Card/Debit Card</label>
            <label><input type="radio" name="payment_method" value="upi" required> UPI (Unified Payments Interface)</label>
            <label><input type="radio" name="payment_method" value="cash_on_delivery" required> Cash on Delivery</label>
            <label><input type="radio" name="payment_method" value="qr_code" required> QR Code Payment</label>
        </div>
        <button type="submit" class="payment-btn">Proceed to Payment</button>
    </form>
</div>
</body>
</html>
