<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer-master/src/Exception.php';
require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/src/SMTP.php';

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

// Handle payment submission and email sending
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_method'])) {
    $payment_method = $_POST['payment_method'];
    $payment_message = "";
    switch ($payment_method) {
        case 'credit_card':
            $payment_message = "Processing Credit Card Payment...";
            break;
        case 'debit_card':
            $payment_message = "Processing Debit Card Payment...";
            break;
        case 'upi':
            $payment_message = "Processing UPI Payment...";
            break;
        case 'cash_on_delivery':
            $payment_message = "Cash on Delivery Selected!";
            break;
        case 'qr_code':
            $payment_message = "Please scan the QR Code to make payment!";
            break;
        default:
            $payment_message = "Invalid payment method!";
            break;
    }
    
    // Prepare email content
    $emailTo = $email; // Send email to logged-in user
    $subject = 'Your Order Details';
    $itemList = "";
    foreach ($services as $service) {
        $itemList .= "- ID: " . $service['ID'] . " | Vehicle No: " . $service['V_NUMBER'] . " | Part: " . $service['WANT'] . " | Quantity: " . $service['QUANTITY'] . " | Price: " . $service['PRICE'] . "\n";
    }
    
    $body = "Thank you for your purchase! Here are your order details:\n\n" . $itemList . "\nPayment Method: " . strtoupper($payment_method);
    
    // Send email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com'; // Replace with your email
        $mail->Password = 'your-email-password'; // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        $mail->setFrom('your-email@example.com', 'Your Store');
        $mail->addAddress($emailTo);
        
        $mail->Subject = $subject;
        $mail->Body = $body;
        
        $mail->send();
        echo "<script>alert('Order placed successfully! Email sent. $payment_message');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Email could not be sent. Error: " . $mail->ErrorInfo . "');</script>";
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
            <li>ID: <?php echo htmlspecialchars($service['ID']); ?></li> 
            <li>Vehicle No: <?php echo htmlspecialchars($service['V_NUMBER']); ?></li>  
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
