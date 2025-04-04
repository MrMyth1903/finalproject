<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TVS Service Request</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --tvs-blue: #1d4f91;
            --tvs-red: #e63c2f;
            --tvs-dark: #1d1d1b;
            --tvs-silver: #d1d1d1;
            --tvs-light: #f5f5f5;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        
        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(29,79,145,0.4) 100%);
            z-index: -1;
        }
        
        .background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            text-align: center;
            padding: 30px 0;
            position: relative;
        }
        
        .logo {
            width: 120px;
            margin-bottom: 15px;
        }
        
        h1 {
            font-size: 32px;
            font-weight: 600;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .subtitle {
            color: var(--tvs-silver);
            font-size: 16px;
            margin-top: 10px;
        }
        
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            margin: 20px 0;
        }
        
        .form-section {
            margin-bottom: 30px;
        }
        
        .form-section h2 {
            font-size: 22px;
            margin-bottom: 20px;
            color: var(--tvs-dark);
            padding-bottom: 10px;
            border-bottom: 2px solid var(--tvs-blue);
            display: inline-block;
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }
        
        .form-group {
            flex: 1 0 250px;
            padding: 0 15px;
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--tvs-dark);
        }
        
        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--tvs-blue);
            box-shadow: 0 0 0 2px rgba(29, 79, 145, 0.2);
        }
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .service-options {
            margin-top: 20px;
        }
        
        .price-display {
            background-color: var(--tvs-light);
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: right;
            font-size: 18px;
            font-weight: 600;
            border-left: 4px solid var(--tvs-blue);
        }
        
        .price-display span {
            color: var(--tvs-blue);
        }
        
        .submit-button {
            text-align: center;
            margin-top: 30px;
        }
        
        button {
            background-color: var(--tvs-blue);
            color: white;
            border: none;
            padding: 14px 30px;
            font-size: 16px;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(29, 79, 145, 0.3);
        }
        
        button:hover {
            background-color: #143a70;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(29, 79, 145, 0.4);
        }
        
        .icon-input {
            position: relative;
        }
        
        .icon-input i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #777;
        }
        
        .icon-input input, .icon-input select {
            padding-left: 40px;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .quantity-btn {
            background-color: #f1f1f1;
            border: none;
            width: 40px;
            height: 40px;
            font-size: 18px;
            cursor: pointer;
            color: #555;
            transition: all 0.2s ease;
        }
        
        .quantity-btn:hover {
            background-color: #e0e0e0;
        }
        
        .quantity-input {
            width: 60px;
            text-align: center;
            border: none;
            padding: 10px 0;
            font-size: 16px;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            border-radius: 0;
        }
        
        .footer {
            text-align: center;
            padding: 20px 0;
            color: #fff;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .form-group {
                flex: 0 0 100%;
            }
            
            h1 {
                font-size: 28px;
            }
            
            .card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="background-overlay"></div>
    <video class="background-video" autoplay muted loop>
        <source src="video/istockphoto-1680698591-640_adpp_is.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    
    <div class="container">
        <header>
            <img src="servicelogo/tvs.png" alt="TVS Logo" class="logo">
            <h1>TVS Service Request</h1>
            <p class="subtitle">Quality Service for Your TVS Vehicle</p>
        </header>
        
        <form action="php/service/servicedb.php" method="post" class="card">
            <div class="form-section">
                <h2>Vehicle Information</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="select1">Vehicle Type</label>
                        <div class="icon-input">
                            <i class="fas fa-motorcycle"></i>
                            <select id="select1" name="type">
                                <option value="2 Wheelers TVS">2 Wheelers BIKE</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="vehicle_no">Vehicle Number</label>
                        <div class="icon-input">
                            <i class="fas fa-id-card"></i>
                            <input type="text" id="vehicle_no" name="vehicle_no" placeholder="Enter your vehicle number" required>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Contact Information</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="icon-input">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <div class="icon-input">
                            <i class="fas fa-phone"></i>
                            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address">Service Address</label>
                    <div class="icon-input">
                        <i class="fas fa-map-marker-alt"></i>
                        <textarea id="address" name="address" placeholder="Enter your complete service address..." required></textarea>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Service Requirements</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="want">Sphere Parts</label>
                        <div class="icon-input">
                            <i class="fas fa-tools"></i>
                            <select id="want" name="want" required>
                                <option value="">--Select Service--</option>
                                <option value="Tire Change">Tire Change</option>
                                <option value="Mobil Change">Mobil Change</option>
                                <option value="Brake Shoe Change">Brake Shoe Change</option>
                                <option value="Coolent Change">Coolent Change</option>
                                <option value="Brake Issue">Brake Issue</option>
                                <option value="Diesel Tank">Diesel Tank</option>
                                <option value="Mobile Tank">Mobile Tank</option>
                                <option value="Head Light">Head Light</option>
                                <option value="Deeper">Deeper</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <div class="quantity-control">
                            <button type="button" class="quantity-btn minus-btn">-</button>
                            <input type="number" name="quantity" id="quantity" class="quantity-input" value="1" min="1" required>
                            <button type="button" class="quantity-btn plus-btn">+</button>
                        </div>
                    </div>
                </div>
                
                <div class="price-display" id="price-display">
                    Select a service to see the price
                </div>
                
                <!-- Hidden Price Input -->
                <input type="hidden" id="price" name="price">
            </div>
            
            <div class="submit-button">
                <button type="submit" name="submit">
                    <i class="fas fa-paper-plane"></i> Submit Service Request
                </button>
            </div>
        </form>
        
        <div class="footer">
            &copy; <?php echo date('Y'); ?> TVS Motors Service Center. All Rights Reserved.
        </div>
    </div>

    <script>
        // Price data for each service
        const servicePrices = {
            "Tire Change": 500,
            "Mobil Change": 300,
            "Brake Shoe Change": 400,
            "Coolent Change": 350,
            "Brake Issue": 600,
            "Diesel Tank": 450,
            "Mobile Tank": 350,
            "Head Light": 150,
            "Deeper": 1000
        };

        // Reference elements
        const wantField = document.getElementById('want');
        const quantityField = document.getElementById('quantity');
        const priceDisplay = document.getElementById('price-display');
        const priceField = document.getElementById('price');
        const minusBtn = document.querySelector('.minus-btn');
        const plusBtn = document.querySelector('.plus-btn');

        function updatePrice() {
            const selectedService = wantField.value;
            const quantity = parseInt(quantityField.value) || 1;

            if (selectedService && servicePrices[selectedService]) {
                const unitPrice = servicePrices[selectedService];
                const totalPrice = unitPrice * quantity;

                // Display price
                priceDisplay.innerHTML = `
                    Service: <span>${selectedService}</span><br>
                    Unit Price: <span>₹${unitPrice.toLocaleString()}</span><br>
                    Quantity: <span>${quantity}</span><br>
                    <div style="font-size: 22px; margin-top: 10px;">
                        Total: <span>₹${totalPrice.toLocaleString()}</span>
                    </div>
                `;

                // Update hidden price field
                priceField.value = totalPrice;
            } else {
                priceDisplay.textContent = 'Please select a valid service';
                priceField.value = ''; // Clear price if no service is selected
            }
        }

        // Quantity increment/decrement
        minusBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityField.value) || 1;
            if (currentValue > 1) {
                quantityField.value = currentValue - 1;
                updatePrice();
            }
        });

        plusBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityField.value) || 1;
            quantityField.value = currentValue + 1;
            updatePrice();
        });

        // Attach event listeners
        wantField.addEventListener('change', updatePrice);
        quantityField.addEventListener('input', updatePrice);

        // Initialize price calculation
        updatePrice();
    </script>
</body>
</html>