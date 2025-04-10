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
$totalPrice = 0;
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $services[] = $row;
        $totalPrice += floatval($row['PRICE']) * intval($row['QUANTITY']);
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
    
    $body = "Thank you for your purchase! Here are your order details:\n\n Your item will delivered in 3 Days" . $itemList . "\nPayment Method: " . strtoupper($payment_method);
    
    // Send email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'merigaddi0008@gmail.com'; // Replace with your email
        $mail->Password = 'yqvqgtuselknvezr '; // Replace with your email password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        
        $mail->setFrom('merigaddi0008@gmail.com', 'Meri Gaddi');
        $mail->addAddress($emailTo);
        
        $mail->Subject = $subject;
        $mail->Body = $body;
        
        // yqvq gtus elkn vezr   PASSWORD
        $mail->send();
        echo "<script>alert('Order placed successfully! Email sent. $payment_message');
        window.location.href = '../home.php';</script>";
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
    <title>Payment - Meri Gaddi</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #3a36e0;
            --primary-dark: #2c29b9;
            --secondary: #f5f5f5;
            --text-dark: #333333;
            --text-light: #767676;
            --white: #ffffff;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            --radius: 12px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f6f9fc;
            color: var(--text-dark);
            line-height: 1.6;
        }
        .background-video {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -1;
    }
    .video-container {
        display: none;
    }
        .container {
            display: flex;
            min-height: 100vh;
            padding: 20px;
        }
        
        .payment-section {
            flex: 1;
            max-width: 1200px;
            margin: 0 auto;
            background-color: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        
        .header {
            background-color: var(--primary);
            color: var(--white);
            padding: 25px 30px;
            position: relative;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.85;
        }
        
        .content {
            display: flex;
            flex-direction: row;
        }
        
        .left-panel {
            flex: 1;
            padding: 30px;
            border-right: 1px solid #eaeaea;
        }
        
        .right-panel {
            flex: 1;
            padding: 30px;
            background-color: #fafafa;
        }
        
        .section-title {
            font-size: 20px;
            margin-bottom: 20px;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 10px;
            color: var(--primary);
        }
        
        .order-summary {
            margin-bottom: 30px;
        }
        
        .order-item {
            padding: 15px;
            background-color: var(--white);
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border-left: 3px solid var(--primary);
        }
        
        .order-item-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .order-item-id {
            font-weight: 600;
            color: var(--primary);
        }
        
        .order-item-vehicle {
            color: var(--text-dark);
            font-weight: 500;
        }
        
        .order-item-details {
            display: flex;
            justify-content: space-between;
        }
        
        .order-item-part {
            font-weight: 500;
        }
        
        .order-item-quantity {
            color: var(--text-light);
        }
        
        .order-item-price {
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .total-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px dashed #ddd;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 16px;
        }
        
        .total-row.grand-total {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #eaeaea;
        }
        
        .payment-methods {
            margin-bottom: 30px;
        }
        
        .payment-option {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: var(--white);
            border-radius: 8px;
            margin-bottom: 12px;
            border: 2px solid #eaeaea;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .payment-option:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
        }
        
        .payment-option input {
            margin-right: 15px;
            width: 20px;
            height: 20px;
            accent-color: var(--primary);
        }
        
        .payment-option-icon {
            margin-right: 15px;
            font-size: 24px;
            color: var(--primary);
            width: 30px;
            text-align: center;
        }
        
        .payment-option-details {
            flex: 1;
        }
        
        .payment-option-title {
            font-weight: 600;
            margin-bottom: 2px;
        }
        
        .payment-option-description {
            font-size: 14px;
            color: var(--text-light);
        }
        
        .checkout-button {
            background-color: var(--primary);
            color: var(--white);
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .checkout-button:hover {
            background-color: var(--primary-dark);
        }
        
        .checkout-button i {
            margin-left: 10px;
        }
        
        .delivery-info {
            background-color: #e8f4fe;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            display: flex;
            align-items: center;
        }
        
        .delivery-info i {
            color: #0984e3;
            font-size: 24px;
            margin-right: 15px;
        }
        
        .delivery-text {
            font-size: 14px;
        }
        
        .delivery-text strong {
            display: block;
            font-weight: 600;
        }
        
        @media (max-width: 900px) {
            .content {
                flex-direction: column;
            }
            
            .left-panel {
                border-right: none;
                border-bottom: 1px solid #eaeaea;
            }
        }
        
        @media (max-width: 600px) {
            .container {
                padding: 0;
            }
            
            .payment-section {
                border-radius: 0;
            }
            
            .left-panel, .right-panel {
                padding: 20px;
            }
        }
    </style>
</head>
<body> 
    <video class="background-video" id="bgVideo" autoplay muted loop>
        <source src="video/payment.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <div class="container">
        <div class="payment-section">
            <div class="header">
                <h1>Complete Your Payment</h1>
                <p>Hello, <strong><?php echo htmlspecialchars($_SESSION['email']); ?></strong></p>
            </div>
            
            <div class="content">
                <div class="left-panel">
                    <h2 class="section-title"><i class="fas fa-clipboard-list"></i> Order Summary</h2>
                    
                    <div class="order-summary">
                        <?php foreach ($services as $service): ?>
                        <div class="order-item">
                            <div class="order-item-header">
                                <div class="order-item-id">ID: <?php echo htmlspecialchars($service['ID']); ?></div>
                                <div class="order-item-vehicle">Vehicle: <?php echo htmlspecialchars($service['V_NUMBER']); ?></div>
                            </div>
                            <div class="order-item-details">
                                <div class="order-item-part"><?php echo htmlspecialchars($service['WANT']); ?></div>
                                <div class="order-item-quantity">Qty: <?php echo htmlspecialchars($service['QUANTITY']); ?></div>
                                <div class="order-item-price">₹<?php echo htmlspecialchars($service['PRICE']); ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="total-section">
                        <div class="total-row">
                            <div>Subtotal:</div>
                            <div>₹<?php echo number_format($totalPrice, 2); ?></div>
                        </div>
                        <div class="total-row">
                            <div>Delivery Fee:</div>
                            <div>₹50.00</div>
                        </div>
                        <div class="total-row grand-total">
                            <div>Grand Total:</div>
                            <div>₹<?php echo number_format($totalPrice + 50, 2); ?></div>
                        </div>
                    </div>
                    
                    <div class="delivery-info">
                        <i class="fas fa-truck"></i>
                        <div class="delivery-text">
                            <strong>Estimated Delivery</strong>
                            Your item(s) will be delivered within 3 days
                        </div>
                    </div>
                </div>
                
                <div class="right-panel">
                    <h2 class="section-title"><i class="fas fa-money-check"></i> Payment Method</h2>
                    
                    <form method="POST">
                        <div class="payment-methods">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="credit_card" required>
                                <div class="payment-option-icon">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="payment-option-details">
                                    <div class="payment-option-title">Credit Card</div>
                                    <div class="payment-option-description">Pay securely with your credit card</div>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="debit_card" required>
                                <div class="payment-option-icon">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="payment-option-details">
                                    <div class="payment-option-title">Debit Card</div>
                                    <div class="payment-option-description">Pay directly from your bank account</div>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="upi" required>
                                <div class="payment-option-icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <div class="payment-option-details">
                                    <div class="payment-option-title">UPI</div>
                                    <div class="payment-option-description">Pay using UPI apps like Google Pay, PhonePe, etc.</div>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="qr_code" required>
                                <div class="payment-option-icon">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                                <div class="payment-option-details">
                                    <div class="payment-option-title">QR Code</div>
                                    <div class="payment-option-description">Scan QR code to complete payment</div>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cash_on_delivery" required>
                                <div class="payment-option-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div class="payment-option-details">
                                    <div class="payment-option-title">Cash on Delivery</div>
                                    <div class="payment-option-description">Pay when you receive your order</div>
                                </div>
                            </label>
                        </div>
                        
                        <button type="submit" class="checkout-button">
                            Proceed to Payment <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Add animation to payment options
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.payment-option').forEach(o => {
                    o.style.borderColor = '#eaeaea';
                });
                this.style.borderColor = '#3a36e0';
            });
        });
    </script>
</body>
</html>