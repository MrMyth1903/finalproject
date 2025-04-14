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
            color: var(--audi-silver);
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
            color: var(--audi-dark);
            padding-bottom: 10px;
            border-bottom: 2px solid var(--audi-red);
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
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .service-options {
            margin-top: 20px;
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
        
        .price-display span {
            color: var(--audi-red);
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

        /* Add styling for optgroup */
        optgroup {
            font-weight: bold;
            color: var(--audi-dark);
            background-color: var(--audi-silver);
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
            <img src="servicelogo/kia.png" alt="Audi Logo" class="logo">
            <h1>KIA Service Request</h1>
            <p class="subtitle">Premium Service for Your Premium Vehicle</p>
        </header>
        
        <form action="php/service/servicedb.php" method="post" class="card">
            <div class="form-section">
                <h2>Vehicle Information</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="select1">Vehicle Type</label>
                        <div class="icon-input">
                            <i class="fas fa-car"></i>
                            <select id="select1" name="type">
                                <option value="4 Wheelers KIA">KIA Car (4 Wheelers)</option>
                              
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
                            <input type="email" id="email" name="email" placeholder="Enter your email address" value="<?php echo htmlspecialchars($_SESSION['email']); ?>"  required>
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
                        <label for="want">Service Type / Spare Parts</label>
                        <div class="icon-input">
                            <i class="fas fa-tools"></i>
                            <select id="want" name="want" required>
                                <option value="">--Select Service or Part--</option>
                                
                                <optgroup label="Service Types">
                                    <option value="Tire Change">Tire Change</option>
                                    <option value="Mobil Change">Oil Change</option>
                                    <option value="Brake Shoe Change">Brake Shoe Change</option>
                                    <option value="Coolent Change">Coolant Change</option>
                                    <option value="Brake Issue">Brake Issue</option>
                                    <option value="Diesel Tank">Diesel Tank</option>
                                    <option value="Mobile Tank">Mobile Tank</option>
                                    <option value="Head Light">Head Light</option>
                                    <option value="Deeper">Deeper</option>
                                </optgroup>
                                
                                <optgroup label="Engine Parts">
                                    <option value="Engine Control Module">Engine Control Module (ECM)</option>
                                    <option value="Timing Belt Kit">Timing Belt Kit</option>
                                    <option value="Engine Mounts">Engine Mounts</option>
                                    <option value="Crankshaft Sensor">Crankshaft Position Sensor</option>
                                    <option value="Camshaft">Camshaft</option>
                                    <option value="Pistons">Pistons</option>
                                    <option value="Connecting Rods">Connecting Rods</option>
                                    <option value="Oil Pump">Oil Pump</option>
                                    <option value="Turbocharger">Turbocharger</option>
                                    <option value="Intercooler">Intercooler</option>
                                </optgroup>
                                
                                <optgroup label="Transmission">
                                    <option value="Transmission Assembly">Transmission Assembly</option>
                                    <option value="Clutch Kit">Clutch Kit</option>
                                    <option value="Flywheel">Flywheel</option>
                                    <option value="Transmission Fluid">Transmission Fluid</option>
                                    <option value="Gear Selector">Gear Selector</option>
                                    <option value="DSG Mechatronic Unit">DSG Mechatronic Unit</option>
                                </optgroup>
                                
                                <optgroup label="Brake System">
                                    <option value="Brake Pads">Brake Pads</option>
                                    <option value="Brake Rotors">Brake Rotors</option>
                                    <option value="Brake Calipers">Brake Calipers</option>
                                    <option value="ABS Control Module">ABS Control Module</option>
                                    <option value="Brake Lines">Brake Lines</option>
                                    <option value="Brake Master Cylinder">Brake Master Cylinder</option>
                                </optgroup>
                                
                                <optgroup label="Suspension & Steering">
                                    <option value="Shock Absorbers">Shock Absorbers</option>
                                    <option value="Struts">Struts</option>
                                    <option value="Control Arms">Control Arms</option>
                                    <option value="Tie Rods">Tie Rods</option>
                                    <option value="Sway Bar Links">Sway Bar Links</option>
                                    <option value="Ball Joints">Ball Joints</option>
                                    <option value="Steering Rack">Steering Rack</option>
                                    <option value="Power Steering Pump">Power Steering Pump</option>
                                    <option value="Wheel Bearings">Wheel Bearings</option>
                                </optgroup>
                                
                                <optgroup label="Electrical System">
                                    <option value="Battery">Battery</option>
                                    <option value="Alternator">Alternator</option>
                                    <option value="Starter Motor">Starter Motor</option>
                                    <option value="Ignition Coils">Ignition Coils</option>
                                    <option value="Spark Plugs">Spark Plugs</option>
                                    <option value="Fuse Box">Fuse Box</option>
                                    <option value="Headlight Assembly">Headlight Assembly</option>
                                    <option value="Tail Light Assembly">Tail Light Assembly</option>
                                    <option value="Turn Signal Switch">Turn Signal Switch</option>
                                    <option value="Window Regulator">Window Regulator</option>
                                    <option value="MMI Control Unit">MMI Control Unit</option>
                                </optgroup>
                                
                                <optgroup label="Cooling System">
                                    <option value="Radiator">Radiator</option>
                                    <option value="Water Pump">Water Pump</option>
                                    <option value="Thermostat">Thermostat</option>
                                    <option value="Cooling Fan">Cooling Fan</option>
                                    <option value="Coolant Reservoir">Coolant Reservoir</option>
                                    <option value="Radiator Hoses">Radiator Hoses</option>
                                </optgroup>
                                
                                <optgroup label="Fuel System">
                                    <option value="Fuel Pump">Fuel Pump</option>
                                    <option value="Fuel Injectors">Fuel Injectors</option>
                                    <option value="Fuel Filter">Fuel Filter</option>
                                    <option value="Fuel Pressure Regulator">Fuel Pressure Regulator</option>
                                    <option value="Fuel Tank">Fuel Tank</option>
                                    <option value="Fuel Lines">Fuel Lines</option>
                                </optgroup>
                                
                                <optgroup label="Exhaust System">
                                    <option value="Catalytic Converter">Catalytic Converter</option>
                                    <option value="Exhaust Manifold">Exhaust Manifold</option>
                                    <option value="Muffler">Muffler</option>
                                    <option value="Oxygen Sensor">Oxygen Sensor</option>
                                    <option value="Exhaust Pipes">Exhaust Pipes</option>
                                    <option value="DPF Filter">DPF Filter</option>
                                </optgroup>
                                
                                <optgroup label="Body Parts">
                                    <option value="Front Bumper">Front Bumper</option>
                                    <option value="Rear Bumper">Rear Bumper</option>
                                    <option value="Hood">Hood</option>
                                    <option value="Trunk Lid">Trunk Lid</option>
                                    <option value="Doors">Doors</option>
                                    <option value="Fenders">Fenders</option>
                                    <option value="Grille">Grille</option>
                                    <option value="Side Mirrors">Side Mirrors</option>
                                    <option value="Windshield">Windshield</option>
                                </optgroup>
                                
                                <optgroup label="Interior">
                                    <option value="Dashboard">Dashboard</option>
                                    <option value="Seats">Seats</option>
                                    <option value="Steering Wheel">Steering Wheel</option>
                                    <option value="Airbag Module">Airbag Module</option>
                                    <option value="Climate Control Unit">Climate Control Unit</option>
                                    <option value="Door Panels">Door Panels</option>
                                    <option value="Center Console">Center Console</option>
                                    <option value="Floor Mats">Floor Mats</option>
                                </optgroup>
                                
                                <optgroup label="HVAC System">
                                    <option value="A/C Compressor">A/C Compressor</option>
                                    <option value="A/C Condenser">A/C Condenser</option>
                                    <option value="Heater Core">Heater Core</option>
                                    <option value="Blower Motor">Blower Motor</option>
                                    <option value="Evaporator">Evaporator</option>
                                    <option value="Expansion Valve">Expansion Valve</option>
                                </optgroup>
                                
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
            // Original Services
            "Tire Change": 500,
            "Mobil Change": 300,
            "Brake Shoe Change": 400,
            "Coolent Change": 350,
            "Brake Issue": 600,
            "Diesel Tank": 450,
            "Mobile Tank": 350,
            "Head Light": 150,
            "Deeper": 1000,
            
            // Engine Parts
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
            
            // Transmission
            "Transmission Assembly": 45000,
            "Clutch Kit": 15000,
            "Flywheel": 12000,
            "Transmission Fluid": 2500,
            "Gear Selector": 5000,
            "DSG Mechatronic Unit": 30000,
            
            // Brake System
            "Brake Pads": 5000,
            "Brake Rotors": 8000,
            "Brake Calipers": 12000,
            "ABS Control Module": 18000,
            "Brake Lines": 3000,
            "Brake Master Cylinder": 7500,
            
            // Suspension & Steering
            "Shock Absorbers": 6000,
            "Struts": 8000,
            "Control Arms": 5000,
            "Tie Rods": 3000,
            "Sway Bar Links": 2000,
            "Ball Joints": 3500,
            "Steering Rack": 16000,
            "Power Steering Pump": 8000,
            "Wheel Bearings": 4000,
            
            // Electrical System
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
            
            // Cooling System
            "Radiator": 11000,
            "Water Pump": 6000,
            "Thermostat": 2500,
            "Cooling Fan": 5000,
            "Coolant Reservoir": 2000,
            "Radiator Hoses": 1500,
            
            // Fuel System
            "Fuel Pump": 9000,
            "Fuel Injectors": 8000,
            "Fuel Filter": 1500,
            "Fuel Pressure Regulator": 3500,
            "Fuel Tank": 15000,
            "Fuel Lines": 4000,
            
            // Exhaust System
            "Catalytic Converter": 22000,
            "Exhaust Manifold": 12000,
            "Muffler": 8000,
            "Oxygen Sensor": 3500,
            "Exhaust Pipes": 6000,
            "DPF Filter": 18000,
            
            // Body Parts
            "Front Bumper": 25000,
            "Rear Bumper": 22000,
            "Hood": 30000,
            "Trunk Lid": 25000,
            "Doors": 35000,
            "Fenders": 18000,
            "Grille": 12000,
            "Side Mirrors": 8000,
            "Windshield": 15000,
            
            // Interior
            "Dashboard": 45000,
            "Seats": 55000,
            "Steering Wheel": 15000,
            "Airbag Module": 20000,
            "Climate Control Unit": 12000,
            "Door Panels": 8000,
            "Center Console": 10000,
            "Floor Mats": 3000,
            
            // HVAC System
            "A/C Compressor": 18000,
            "A/C Condenser": 12000,
            "Heater Core": 15000,
            "Blower Motor": 6000,
            "Evaporator": 14000,
            "Expansion Valve": 4000
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
                    Item: <span>${selectedService}</span><br>
                    Unit Price: <span>₹${unitPrice.toLocaleString()}</span><br>
                    Quantity: <span>${quantity}</span><br>
                    <div style="font-size: 22px; margin-top: 10px;">
                        Total: <span>₹${totalPrice.toLocaleString()}</span>
                    </div>
                `;

                // Update hidden price field
                priceField.value = totalPrice;
            } else if (selectedService === "Other") {
                priceDisplay.textContent = 'Please contact for custom pricing';
                priceField.value = '0'; // For "Other" option, set price to 0 and update later
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

        // Attach event listeners
        wantField.addEventListener('change', updatePrice);
        quantityField.addEventListener('input', updatePrice);

        // Initialize price calculation
        updatePrice();
    </script>
</body>
</html>