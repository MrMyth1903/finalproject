<?php
// Simple Payment Page (payment.php)

// If you want to handle payment submission or integration with a payment API, you can use this block
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // You can handle form data here based on the payment method selected
    $payment_method = $_POST['payment_method'];

    switch ($payment_method) {
        case 'credit_card':
            // Process credit card payment
            echo "Processing Credit Card Payment...";
            break;
        case 'debit_card':
            // Process debit card payment
            echo "Processing Debit Card Payment...";
            break;
        case 'upi':
            // Process UPI payment
            echo "Processing UPI Payment...";
            break;
        case 'cash_on_delivery':
            // Handle Cash on Delivery
            echo "Cash on Delivery Selected!";
            break;
        case 'qr_code':
            // Process QR Code Payment (you can display a QR code to the user)
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
        /* Global Styles */
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
            justify-content: space-between;
            align-items: flex-start;
            max-width: 1000px;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            overflow: hidden;
        }

        /* Left Section (Payment Options) */
        .left-section {
            flex: 1;
            margin-right: 30px;
        }
        .left-section h2 {
            font-size: 24px;
            font-weight: 600;
            color: #2d3436;
            text-align: center;
            margin-bottom: 20px;
        }

        .payment-options label {
            display: block;
            margin: 15px 0;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .payment-options input[type="radio"] {
            margin-right: 10px;
            transform: scale(1.2);
            cursor: pointer;
        }
        .payment-options label:hover {
            color: #0984e3;
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
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }
        .payment-btn:hover {
            background-color: #74b9ff;
        }

        /* Right Section (Dynamic Content) */
        .right-section {
            flex: 1;
            padding-left: 30px;
            max-width: 50%;
        }
        .right-section h3 {
            font-size: 22px;
            color: #2d3436;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .card-form input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        .card-form input:focus {
            border-color: #0984e3;
        }

        .qr-code img {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                padding: 20px;
            }
            .right-section {
                margin-top: 20px;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Left Section: Payment Options -->
    <div class="left-section">
        <h2>Select Your Payment Option</h2>
        <form method="POST">
            <div class="payment-options">
                <label>
                    <input type="radio" name="payment_method" value="credit_card" id="credit_card" required>
                    Credit Card/ Debit Card
                </label>
               
                <label>
                    <input type="radio" name="payment_method" value="upi" id="upi" required>
                    UPI (Unified Payments Interface)
                </label>
                <label>
                    <input type="radio" name="payment_method" value="cash_on_delivery" id="cash_on_delivery" required>
                    Cash on Delivery
                </label>
                <label>
                    <input type="radio" name="payment_method" value="qr_code" id="qr_code" required>
                    QR Code Payment
                </label>
            </div>
            <button type="submit" class="payment-btn">Proceed to Payment</button>
        </form>
    </div>

    <!-- Right Section: Dynamic Content -->
    <div class="right-section" id="rightSection">
        <!-- Content will change dynamically based on selected payment method -->
    </div>
</div>

<script>
    // Function to handle the display of form or QR code based on payment method
    function handlePaymentMethodChange() {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        const rightSection = document.getElementById('rightSection');
        
        // Clear the content first
        rightSection.innerHTML = '';
        
        if (paymentMethod === 'credit_card' || paymentMethod === 'debit_card') {
            // Display the card details form
            rightSection.innerHTML = `
                <h3>Enter Your Card Details</h3>
                <div class="card-form">
                    <input type="text" name="card_number" placeholder="Card Number" required>
                    <input type="text" name="card_name" placeholder="Cardholder Name" required>
                    <input type="text" name="expiry_date" placeholder="Expiry Date (MM/YY)" required>
                    <input type="text" name="cvv" placeholder="CVV" required>
                </div>
            `;
        } else if (paymentMethod === 'upi') {
            // Display UPI payment instructions
            rightSection.innerHTML = `
                <h3>Enter Your UPI ID</h3>
                <input type="text" name="upi_id" placeholder="UPI ID" required>
            `;
        } else if (paymentMethod === 'cash_on_delivery') {
            // Display message for cash on delivery
            rightSection.innerHTML = `<h3>Cash on Delivery Selected</h3>`;
        } else if (paymentMethod === 'qr_code') {
            // Display QR code for payment
            rightSection.innerHTML = `
                <h3>Scan the QR Code to Complete the Payment</h3>
                <div class="qr-code">
                    <img src="path/to/qr-code.png" alt="QR Code">
                </div>
            `;
        }
    }

    // Event listener for changes in payment method selection
    document.querySelectorAll('input[name="payment_method"]').forEach((input) => {
        input.addEventListener('change', handlePaymentMethodChange);
    });
</script>

</body>
</html>
