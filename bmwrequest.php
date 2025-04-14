
<?php
session_start();
if (!isset($_SESSION['email'])) {
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audi Service Request</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --audi-red: #e20000;
            --audi-dark: #1d1d1b;
            --audi-silver: #d1d1d1;
            --audi-light: #f5f5f5;
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
            background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(226,0,0,0.4) 100%);
            z-index: -1;
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
        
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            margin: 20px 0;
        }
        
        .form-section {
            margin-bottom: 30px;
        }
        
        .form-section h2 {
            font-size: 22px;
            margin-bottom: 20px;
            color: var(--audi-dark);
            padding-bottom: 10px;
            border-bottom: 2px solid var(--audi-red);
            display: inline-block;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--audi-dark);
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
            border-color: var(--audi-red);
            box-shadow: 0 0 0 2px rgba(226, 0, 0, 0.2);
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
        
        .price-display {
            background-color: var(--audi-light);
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: right;
            font-size: 18px;
            font-weight: 600;
            border-left: 4px solid var(--audi-red);
        }
        
        .submit-button {
            text-align: center;
            margin-top: 30px;
        }
        
        button {
            background-color: var(--audi-red);
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
            box-shadow: 0 5px 15px rgba(226, 0, 0, 0.3);
        }
        
        button:hover {
            background-color: #c00000;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(226, 0, 0, 0.4);
        }
        
        .footer {
            text-align: center;
            padding: 20px 0;
            color: #fff;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="background-overlay"></div>
    
    <div class="container">
        <header>
            <img src="servicelogo/audi.png" alt="Audi Logo" class="logo">
            <h1>Audi Service Request</h1>
            <p class="subtitle">Premium Service for Your Premium Vehicle</p>
        </header>
        
        <form action="php/service/servicedb.php" method="post" class="card">
            <div class="form-section">
                <h2>Vehicle Information</h2>
                <div class="form-group">
                    <label for="select1">Vehicle Type</label>
                    <select id="select1" name="type">
                        <option value="2 Wheelers AUDI">Audi Car (4 Wheelers)</option>
                        <option value="Audi SUV">Audi SUV</option>
                        <option value="Audi Sedan">Audi Sedan</option>
                        <option value="Audi Coupe">Audi Coupe</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="vehicle_no">Vehicle Number</label>
                    <input type="text" id="vehicle_no" name="vehicle_no" placeholder="Enter your vehicle number" required>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Contact Information</h2>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div>
                
                <div class="form-group">
                    <label for="address">Service Address</label>
                    <textarea id="address" name="address" placeholder="Enter your complete service address..." required></textarea>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Service Requirements</h2>
                <div class="form-group">
                    <label>Service Type / Spare Parts</label>
                    <div>
                        <label><input type="checkbox" name="want[]" value="Tire Change"> Tire Change</label><br>
                        <label><input type="checkbox" name="want[]" value="Mobil Change"> Oil Change</label><br>
                        <label><input type="checkbox" name="want[]" value="Brake Shoe Change"> Brake Shoe Change</label><br>
                        <label><input type="checkbox" name="want[]" value="Coolent Change"> Coolant Change</label><br>
                        <label><input type="checkbox" name="want[]" value="Brake Issue"> Brake Issue</label><br>
                        <label><input type="checkbox" name="want[]" value="Diesel Tank"> Diesel Tank</label><br>
                        <label><input type="checkbox" name="want[]" value="Mobile Tank"> Mobile Tank</label><br>
                        <label><input type="checkbox" name="want[]" value="Head Light"> Head Light</label><br>
                        <label><input type="checkbox" name="want[]" value="Deeper"> Deeper</label><br>
                        <label><input type="checkbox" name="want[]" value="Engine Control Module"> Engine Control Module (ECM)</label><br>
                        <label><input type="checkbox" name="want[]" value="Timing Belt Kit"> Timing Belt Kit</label><br>
                        <label><input type="checkbox" name="want[]" value="Engine Mounts"> Engine Mounts</label><br>
                        <label><input type="checkbox" name="want[]" value="Crankshaft Sensor"> Crankshaft Position Sensor</label><br>
                        <label><input type="checkbox" name="want[]" value="Camshaft"> Camshaft</label><br>
                        <label><input type="checkbox" name="want[]" value="Pistons"> Pistons</label><br>
                        <label><input type="checkbox" name="want[]" value="Connecting Rods"> Connecting Rods</label><br>
                        <label><input type="checkbox" name="want[]" value="Oil Pump"> Oil Pump</label><br>
                        <label><input type="checkbox" name="want[]" value="Turbocharger"> Turbocharger</label><br>
                        <label><input type="checkbox" name="want[]" value="Intercooler"> Intercooler</label><br>
                        <label><input type="checkbox" name="want[]" value="Transmission Assembly"> Transmission Assembly</label><br>
                        <label><input type="checkbox" name="want[]" value="Clutch Kit"> Clutch Kit</label><br>
                        <label><input type="checkbox" name="want[]" value="Flywheel"> Flywheel</label><br>
                        <label><input type="checkbox" name="want[]" value="Transmission Fluid"> Transmission Fluid</label><br>
                        <label><input type="checkbox" name="want[]" value="Gear Selector"> Gear Selector</label><br>
                        <label><input type="checkbox" name="want[]" value="DSG Mechatronic Unit"> DSG Mechatronic Unit</label><br>
                        <label><input type="checkbox" name="want[]" value="Brake Pads"> Brake Pads</label><br>
                        <label><input type="checkbox" name="want[]" value="Brake Rotors"> Brake Rotors</label><br>
                        <label><input type="checkbox" name="want[]" value="Brake Calipers"> Brake Calipers</label><br>
                        <label><input type="checkbox" name="want[]" value="ABS Control Module"> ABS Control Module</label><br>
                        <label><input type="checkbox" name="want[]" value="Brake Lines"> Brake Lines</label><br>
                        <label><input type="checkbox" name="want[]" value="Brake Master Cylinder"> Brake Master Cylinder</label><br>
                        <label><input type="checkbox" name="want[]" value="Shock Absorbers"> Shock Absorbers</label><br>
                        <label><input type="checkbox" name="want[]" value="Struts"> Struts</label><br>
                        <label><input type="checkbox" name="want[]" value="Control Arms"> Control Arms</label><br>
                        <label><input type="checkbox" name="want[]" value="Tie Rods"> Tie Rods</label><br>
                        <label><input type="checkbox" name="want[]" value="Sway Bar Links"> Sway Bar Links</label><br>
                        <label><input type="checkbox" name="want[]" value="Ball Joints"> Ball Joints</label><br>
                        <label><input type="checkbox" name="want[]" value="Steering Rack"> Steering Rack</label><br>
                        <label><input type="checkbox" name="want[]" value="Power Steering Pump"> Power Steering Pump</label><br>
                        <label><input type="checkbox" name="want[]" value="Wheel Bearings"> Wheel Bearings</label><br>
                        <label><input type="checkbox" name="want[]" value="Battery"> Battery</label><br>
                        <label><input type="checkbox" name="want[]" value="Alternator"> Alternator</label><br>
                        <label><input type="checkbox" name="want[]" value="Starter Motor"> Starter Motor</label><br>
                        <label><input type="checkbox" name="want[]" value="Ignition Coils"> Ignition Coils</label><br>
                        <label><input type="checkbox" name="want[]" value="Spark Plugs"> Spark Plugs</label><br>
                        <label><input type="checkbox" name="want[]" value="Fuse Box"> Fuse Box</label><br>
                        <label><input type="checkbox" name="want[]" value="Headlight Assembly"> Headlight Assembly</label><br>
                        <label><input type="checkbox" name="want[]" value="Tail Light Assembly"> Tail Light Assembly</label><br>
                        <label><input type="checkbox" name="want[]" value="Turn Signal Switch"> Turn Signal Switch</label><br>
                        <label><input type="checkbox" name="want[]" value="Window Regulator"> Window Regulator</label><br>
                        <label><input type="checkbox" name="want[]" value="MMI Control Unit"> MMI Control Unit</label><br>
                        <label><input type="checkbox" name="want[]" value="Radiator"> Radiator</label><br>
                        <label><input type="checkbox" name="want[]" value="Water Pump"> Water Pump</label><br>
                        <label><input type="checkbox" name="want[]" value="Thermostat"> Thermostat</label><br>
                        <label><input type="checkbox" name="want[]" value="Cooling Fan"> Cooling Fan</label><br>
                        <label><input type="checkbox" name="want[]" value="Coolant Reservoir"> Coolant Reservoir</label><br>
                        <label><input type="checkbox" name="want[]" value="Fuel Pump"> Fuel Pump</label><br>
                        <label><input type="checkbox" name="want[]" value="Fuel Injectors"> Fuel Injectors</label><br>
                        <label><input type="checkbox" name="want[]" value="Fuel Filter"> Fuel Filter</label><br>
                        <label><input type="checkbox" name="want[]" value="Fuel Pressure Regulator"> Fuel Pressure Regulator</label><br>
                        <label><input type="checkbox" name="want[]" value="Catalytic Converter"> Catalytic Converter</label><br>
                        <label><input type="checkbox" name="want[]" value="Exhaust Manifold"> Exhaust Manifold</label><br>
                        <label><input type="checkbox" name="want[]" value="Muffler"> Muffler</label><br>
                        <label><input type="checkbox" name="want[]" value="Oxygen Sensor"> Oxygen Sensor</label><br>
                        <label><input type="checkbox" name="want[]" value="Exhaust Pipes"> Exhaust Pipes</label><br>
                        <label><input type="checkbox" name="want[]" value="Front Bumper"> Front Bumper</label><br>
                        <label><input type="checkbox" name="want[]" value="Rear Bumper"> Rear Bumper</label><br>
                        <label><input type="checkbox" name="want[]" value="Hood"> Hood</label><br>
                        <label><input type="checkbox" name="want[]" value="Trunk Lid"> Trunk Lid</label><br>
                        <label><input type="checkbox" name="want[]" value="Doors"> Doors</label><br>
                        <label><input type="checkbox" name="want[]" value="Fenders"> Fenders</label><br>
                        <label><input type="checkbox" name="want[]" value="Grille"> Grille</label><br>
                        <label><input type="checkbox" name="want[]" value="Side Mirrors"> Side Mirrors</label><br>
                        <label><input type="checkbox" name="want[]" value="Windshield"> Windshield</label><br>
                        <label><input type="checkbox" name="want[]" value="Dashboard"> Dashboard</label><br>
                        <label><input type="checkbox" name="want[]" value="Seats"> Seats</label><br>
                        <label><input type="checkbox" name="want[]" value="Steering Wheel"> Steering Wheel</label><br>
                        <label><input type="checkbox" name="want[]" value="Airbag Module"> Airbag Module</label><br>
                        <label><input type="checkbox" name="want[]" value="Climate Control Unit"> Climate Control Unit</label><br>
                        <label><input type="checkbox" name="want[]" value="Door Panels"> Door Panels</label><br>
                        <label><input type="checkbox" name="want[]" value="Center Console"> Center Console</label><br>
                        <label><input type="checkbox" name="want[]" value="Floor Mats"> Floor Mats</label><br>
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
                
                <div class="price-display" id="price-display">
                    Select a service or part to see the price
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
            &copy; <?php echo date('Y'); ?> Audi Service Center. All Rights Reserved.
        </div>
    </div>

    <script>
        // Price data for each service and part
        const servicePrices = {
            "Tire Change": 500,
            "Mobil Change": 300,
            "Brake Shoe Change": 400,
            "Coolent Change": 350,
            "Brake Issue": 600,
            "Diesel Tank": 450,
            "Mobile Tank": 350,
            "Head Light": 150,
            "Deeper": 1000,
            "Engine Control Module": 15000,
            "Timing Belt Kit": 8000,
            "Engine Mounts": 3500,
            "Crankshaft Sensor": 2000,
            "Camshaft": 12000,
            "Pistons": 8000,
            "Connecting Rods": 6000,
            "Oil Pump": 4500,
            "Turbocharger": 25000,
            "Intercooler": 9000,
            "Transmission Assembly": 45000,
            "Clutch Kit": 15000,
            "Flywheel": 12000,
            "Transmission Fluid": 2500,
            "Gear Selector": 5000,
            "DSG Mechatronic Unit": 30000,
            "Brake Pads": 5000,
            "Brake Rotors": 8000,
            "Brake Calipers": 12000,
            "ABS Control Module": 18000,
            "Brake Lines": 3000,
            "Brake Master Cylinder": 7500,
            "Shock Absorbers": 6000,
            "Struts": 8000,
            "Control Arms": 5000,
            "Tie Rods": 3000,
            "Sway Bar Links": 2000,
            "Ball Joints": 3500,
            "Steering Rack": 16000,
            "Power Steering Pump": 8000,
            "Wheel Bearings": 4000,
            "Battery": 12000,
            "Alternator": 8000,
            "Starter Motor": 7000,
            "Ignition Coils": 3000,
            "Spark Plugs": 2000,
            "Fuse Box": 5000,
            "Headlight Assembly": 18000,
            "Tail Light Assembly": 12000,
            "Turn Signal Switch": 3500,
            "Window Regulator": 6000,
            "MMI Control Unit": 25000,
            "Radiator": 11000,
            "Water Pump": 6000,
            "Thermostat": 2500,
            "Cooling Fan": 5000,
            "Coolant Reservoir": 2000,
            "Fuel Pump": 9000,
            "Fuel Injectors": 8000,
            "Fuel Filter": 1500,
            "Fuel Pressure Regulator": 3500,
            "Catalytic Converter": 22000,
            "Exhaust Manifold": 12000,
            "Muffler": 8000,
            "Oxygen Sensor": 3500,
            "Exhaust Pipes": 6000,
            "Front Bumper": 25000,
            "Rear Bumper": 22000,
            "Hood": 30000,
            "Trunk Lid": 25000,
            "Doors": 35000,
            "Fenders": 18000,
            "Grille": 12000,
            "Side Mirrors": 8000,
            "Windshield": 15000,
            "Dashboard": 45000,
            "Seats": 55000,
            "Steering Wheel": 15000,
            "Airbag Module": 20000,
            "Climate Control Unit": 12000,
            "Door Panels": 8000,
            "Center Console": 10000,
            "Floor Mats": 3000,
        };

        // Reference elements
        const quantityField = document.getElementById('quantity');
        const priceDisplay = document.getElementById('price-display');
        const priceField = document.getElementById('price');
        const checkboxes = document.querySelectorAll('input[name="want[]"]');
        const minusBtn = document.querySelector('.minus-btn');
        const plusBtn = document.querySelector('.plus-btn');

        function updatePrice() {
            const selectedServices = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);
            const quantity = parseInt(quantityField.value) || 1;
            let totalPrice = 0;
            let priceDetails = '';

            selectedServices.forEach(service => {
                if (service && servicePrices[service]) {
                    const unitPrice = servicePrices[service];
                    totalPrice += unitPrice * quantity;
                    priceDetails += `
                        Item: <span>${service}</span><br>
                        Unit Price: <span>₹${unitPrice.toLocaleString()}</span><br>
                        Quantity: <span>${quantity}</span><br>
                        <div style="font-size: 22px; margin-top: 10px;">
                            Total: <span>₹${(unitPrice * quantity).toLocaleString()}</span>
                        </div>
                    `;
                }
            });

            if (totalPrice > 0) {
                priceDisplay.innerHTML = priceDetails + `
                    <div style="font-size: 22px; margin-top: 10px;">
                        Grand Total: <span>₹${totalPrice.toLocaleString()}</span>
                    </div>
                `;
                priceField.value = totalPrice;
            } else {
                priceDisplay.textContent = 'Please select a valid service or part';
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

        // Attach event listeners to checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updatePrice);
        });

        // Attach event listener for quantity input
        quantityField.addEventListener('input', updatePrice);

        // Initialize price calculation
        updatePrice();
    </script>
</body>
</html>
