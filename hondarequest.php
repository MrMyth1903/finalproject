<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Honda Service Request</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --honda-red: #cc0000;
            --honda-dark: #1d1d1b;
            --honda-silver: #d1d1d1;
            --honda-light: #f5f5f5;
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
            background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(204,0,0,0.4) 100%);
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
            color: var(--honda-silver);
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
            color: var(--honda-dark);
            padding-bottom: 10px;
            border-bottom: 2px solid var(--honda-red);
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
            color: var(--honda-dark);
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
            border-color: var(--honda-red);
            box-shadow: 0 0 0 2px rgba(204, 0, 0, 0.2);
        }
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .service-options {
            margin-top: 20px;
        }
        
        .price-display {
            background-color: var(--honda-light);
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: right;
            font-size: 18px;
            font-weight: 600;
            border-left: 4px solid var(--honda-red);
        }
        
        .price-display span {
            color: var(--honda-red);
        }
        
        .submit-button {
            text-align: center;
            margin-top: 30px;
        }
        
        button {
            background-color: var(--honda-red);
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
            box-shadow: 0 5px 15px rgba(204, 0, 0, 0.3);
        }
        
        button:hover {
            background-color: #a30000;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(204, 0, 0, 0.4);
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

        /* Added styles for category grouping in select dropdown */
        optgroup {
            font-weight: bold;
            color: var(--honda-red);
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
            <img src="servicelogo/honda.png" alt="Honda Logo" class="logo">
            <h1>Honda Service Request</h1>
            <p class="subtitle">Quality Service for Your Honda Vehicle</p>
        </header>
        
        <form action="php/service/servicedb.php" method="post" class="card">
            <div class="form-section">
                <h2>Vehicle Information</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="select1">Vehicle Type</label>
                        <div class="icon-input">
                            <i class="fas fa-motorcycle"></i>
                            <select id="select1" name="type" onchange="updateServiceOptions()">
                                <option value="2 Wheelers HONDA">2 Wheelers, BIKE</option>
                                <option value="4 Wheelers HONDA">4 Wheelers, CAR</option>
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
                        <label for="want">Service Type / Spare Parts</label>
                        <div class="icon-input">
                            <i class="fas fa-tools"></i>
                            <select id="want" name="want" required>
                                <option value="">--Select Service--</option>
                                
                                <optgroup label="Car Specific Parts"></optgroup>
                                <optgroup label="Regular Maintenance">
                                    <option value="Tire Change">Tire Change</option>
                                    <option value="Oil Change">Oil Change</option>
                                    <option value="Brake Shoe Change">Brake Shoe Change</option>
                                    <option value="Coolant Change">Coolant Change</option>
                                    <option value="Air Filter Replacement">Air Filter Replacement</option>
                                    <option value="Spark Plug Replacement">Spark Plug Replacement</option>
                                    <option value="Battery Replacement">Battery Replacement</option>
                                    <option value="Wiper Blade Replacement">Wiper Blade Replacement</option>
                                </optgroup>
                                
                                <optgroup label="Engine & Transmission">
                                    <option value="Engine Oil">Engine Oil</option>
                                    <option value="Diesel Filter">Diesel Filter</option>
                                    <option value="Petrol Filter">Petrol Filter</option>
                                    <option value="CVT Fluid">CVT Fluid</option>
                                    <option value="Timing Belt">Timing Belt</option>
                                    <option value="Timing Chain">Timing Chain</option>
                                    <option value="Camshaft">Camshaft</option>
                                    <option value="Crankshaft">Crankshaft</option>
                                    <option value="Engine Mounts">Engine Mounts</option>
                                    <option value="Clutch Kit">Clutch Kit</option>
                                    <option value="Clutch Cable">Clutch Cable</option>
                                    <option value="Gearbox Oil">Gearbox Oil</option>
                                    <option value="Piston Rings">Piston Rings</option>
                                    <option value="Head Gasket">Head Gasket</option>
                                </optgroup>
                                
                                <optgroup label="Brake System">
                                    <option value="Brake Pads">Brake Pads</option>
                                    <option value="Brake Discs">Brake Discs</option>
                                    <option value="Brake Fluid">Brake Fluid</option>
                                    <option value="Brake Calipers">Brake Calipers</option>
                                    <option value="Brake Lines">Brake Lines</option>
                                    <option value="ABS Sensor">ABS Sensor</option>
                                    <option value="Brake Master Cylinder">Brake Master Cylinder</option>
                                </optgroup>
                                
                                <optgroup label="Electrical System">
                                    <option value="Head Light">Head Light</option>
                                    <option value="Tail Light">Tail Light</option>
                                    <option value="Indicator Light">Indicator Light</option>
                                    <option value="Fog Lamp">Fog Lamp</option>
                                    <option value="LED DRL">LED DRL</option>
                                    <option value="Light Bulbs">Light Bulbs</option>
                                    <option value="Horn">Horn</option>
                                    <option value="Alternator">Alternator</option>
                                    <option value="Starter Motor">Starter Motor</option>
                                    <option value="ECU">ECU</option>
                                    <option value="Fuse Box">Fuse Box</option>
                                    <option value="Ignition Coil">Ignition Coil</option>
                                </optgroup>
                                
                                <optgroup label="Fuel System">
                                    <option value="Fuel Pump">Fuel Pump</option>
                                    <option value="Fuel Injector">Fuel Injector</option>
                                    <option value="Diesel Tank">Diesel Tank</option>
                                    <option value="Petrol Tank">Petrol Tank</option>
                                    <option value="Fuel Lines">Fuel Lines</option>
                                    <option value="Carburetor">Carburetor (Bike)</option>
                                    <option value="Fuel Gauge Sensor">Fuel Gauge Sensor</option>
                                </optgroup>
                                
                                <optgroup label="Suspension & Steering">
                                    <option value="Shock Absorbers">Shock Absorbers</option>
                                    <option value="Struts">Struts</option>
                                    <option value="Suspension Springs">Suspension Springs</option>
                                    <option value="Control Arms">Control Arms</option>
                                    <option value="Ball Joints">Ball Joints</option>
                                    <option value="Tie Rod Ends">Tie Rod Ends</option>
                                    <option value="Stabilizer Bar">Stabilizer Bar</option>
                                    <option value="Power Steering Pump">Power Steering Pump</option>
                                    <option value="Steering Rack">Steering Rack</option>
                                    <option value="Wheel Bearings">Wheel Bearings</option>
                                </optgroup>
                                
                                <optgroup label="Cooling System">
                                    <option value="Radiator">Radiator</option>
                                    <option value="Water Pump">Water Pump</option>
                                    <option value="Thermostat">Thermostat</option>
                                    <option value="Cooling Fan">Cooling Fan</option>
                                    <option value="Coolant Reservoir">Coolant Reservoir</option>
                                    <option value="Radiator Cap">Radiator Cap</option>
                                    <option value="Radiator Hoses">Radiator Hoses</option>
                                </optgroup>
                                
                                <optgroup label="Exhaust System">
                                    <option value="Catalytic Converter">Catalytic Converter</option>
                                    <option value="Muffler">Muffler</option>
                                    <option value="Exhaust Manifold">Exhaust Manifold</option>
                                    <option value="Exhaust Pipe">Exhaust Pipe</option>
                                    <option value="Oxygen Sensor">Oxygen Sensor</option>
                                    <option value="DPF">Diesel Particulate Filter (DPF)</option>
                                </optgroup>
                                
                                <optgroup label="Bike Specific Parts">
                                    <option value="Chain Kit">Chain Kit</option>
                                    <option value="Sprocket">Sprocket</option>
                                    <option value="Handle Bar">Handle Bar</option>
                                    <option value="Clutch Plates">Clutch Plates</option>
                                    <option value="Bike Brake Cable">Brake Cable</option>
                                    <option value="Accelerator Cable">Accelerator Cable</option>
                                    <option value="Fork Seals">Fork Seals</option>
                                    <option value="Bike Footrest">Footrest</option>
                                    <option value="Bike Mirrors">Mirrors</option>
                                    <option value="Bike Seat">Seat</option>
                                </optgroup>
                                
                                <optgroup label="Climate Control">
                                    <option value="AC Compressor">AC Compressor</option>
                                    <option value="AC Condenser">AC Condenser</option>
                                    <option value="AC Gas Refill">AC Gas Refill</option>
                                    <option value="Cabin Air Filter">Cabin Air Filter</option>
                                    <option value="Heater Core">Heater Core</option>
                                    <option value="Blower Motor">Blower Motor</option>
                                </optgroup>
                                
                                <optgroup label="Body Parts">
                                    <option value="Bumper">Bumper</option>
                                    <option value="Hood">Hood</option>
                                    <option value="Doors">Doors</option>
                                    <option value="Window Regulator">Window Regulator</option>
                                    <option value="Windshield">Windshield</option>
                                    <option value="Side Mirror">Side Mirror</option>
                                    <option value="Wiper Arms">Wiper Arms</option>
                                </optgroup>
                                
                                <optgroup label="Interior Accessories">
                                    <option value="Floor Mats">Floor Mats</option>
                                    <option value="Seat Covers">Seat Covers</option>
                                    <option value="Steering Cover">Steering Cover</option>
                                    <option value="Car Perfume">Car Perfume</option>
                                    <option value="Dashboard Cover">Dashboard Cover</option>
                                </optgroup>
                                
                                <optgroup label="Other Services">
                                    <option value="Complete Service">Complete Service</option>
                                    <option value="Full Car Detailing">Full Car Detailing</option>
                                    <option value="Paint Job">Paint Job</option>
                                    <option value="Denting & Painting">Denting & Painting</option>
                                    <option value="ECU Tuning">ECU Tuning</option>
                                    <option value="Wheel Alignment">Wheel Alignment</option>
                                    <option value="Wheel Balancing">Wheel Balancing</option>
                                    <option value="Other">Other (Please Specify)</option>
                                </optgroup>
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
            &copy; <?php echo date('Y'); ?> Honda Service Center. All Rights Reserved.
        </div>
    </div>

    <script>
        // Price data for each service/part
        const servicePrices = {
            // Regular Maintenance
            "Tire Change": 500,
            "Oil Change": 300,
            "Brake Shoe Change": 400,
            "Coolant Change": 350,
            "Air Filter Replacement": 250,
            "Spark Plug Replacement": 200,
            "Battery Replacement": 2500,
            "Wiper Blade Replacement": 400,
            
            // Engine & Transmission
            "Engine Oil": 800,
            "Diesel Filter": 600,
            "Petrol Filter": 500,
            "CVT Fluid": 1200,
            "Timing Belt": 2000,
            "Timing Chain": 4500,
            "Camshaft": 6000,
            "Crankshaft": 8000,
            "Engine Mounts": 1800,
            "Clutch Kit": 3500,
            "Clutch Cable": 450,
            "Gearbox Oil": 900,
            "Piston Rings": 5000,
            "Head Gasket": 3000,
            
            // Brake System
            "Brake Pads": 1200,
            "Brake Discs": 2500,
            "Brake Fluid": 350,
            "Brake Calipers": 3000,
            "Brake Lines": 1000,
            "ABS Sensor": 1500,
            "Brake Master Cylinder": 2000,
            "Brake Issue": 600,
            
            // Electrical System
            "Head Light": 1500,
            "Tail Light": 800,
            "Indicator Light": 400,
            "Fog Lamp": 1200,
            "LED DRL": 2000,
            "Light Bulbs": 150,
            "Horn": 300,
            "Alternator": 4500,
            "Starter Motor": 3500,
            "ECU": 15000,
            "Fuse Box": 1500,
            "Ignition Coil": 1200,
            
            // Fuel System
            "Fuel Pump": 3000,
            "Fuel Injector": 2500,
            "Diesel Tank": 8000,
            "Petrol Tank": 7000,
            "Fuel Lines": 1200,
            "Carburetor": 1800,
            "Fuel Gauge Sensor": 1000,
            
            // Suspension & Steering
            "Shock Absorbers": 2500,
            "Struts": 3500,
            "Suspension Springs": 2000,
            "Control Arms": 3000,
            "Ball Joints": 1200,
            "Tie Rod Ends": 1000,
            "Stabilizer Bar": 1500,
            "Power Steering Pump": 4000,
            "Steering Rack": 6000,
            "Wheel Bearings": 1200,
            
            // Cooling System
            "Radiator": 4500,
            "Water Pump": 2800,
            "Thermostat": 800,
            "Cooling Fan": 2000,
            "Coolant Reservoir": 600,
            "Radiator Cap": 200,
            "Radiator Hoses": 500,
            
            // Exhaust System
            "Catalytic Converter": 8000,
            "Muffler": 3500,
            "Exhaust Manifold": 4000,
            "Exhaust Pipe": 2500,
            "Oxygen Sensor": 1500,
            "Diesel Particulate Filter (DPF)": 10000,
            
            // Bike Specific Parts
            "Chain Kit": 1200,
            "Sprocket": 800,
            "Handle Bar": 1500,
            "Clutch Plates": 1200,
            "Bike Brake Cable": 300,
            "Accelerator Cable": 250,
            "Fork Seals": 900,
            "Bike Footrest": 500,
            "Bike Mirrors": 600,
            "Bike Seat": 1500,
            
            // Climate Control
            "AC Compressor": 7500,
            "AC Condenser": 4000,
            "AC Gas Refill": 1500,
            "Cabin Air Filter": 500,
            "Heater Core": 3500,
            "Blower Motor": 2000,
            
            // Body Parts
            "Bumper": 5000,
            "Hood": 7000,
            "Doors": 9000,
            "Window Regulator": 1800,
            "Windshield": 6000,
            "Side Mirror": 2000,
            "Wiper Arms": 800,
            
            // Interior Accessories
            "Floor Mats": 1200,
            "Seat Covers": 2500,
            "Steering Cover": 500,
            "Car Perfume": 300,
            "Dashboard Cover": 1000,
            
            // Other Services
            "Complete Service": 5000,
            "Full Car Detailing": 3500,
            "Paint Job": 15000,
            "Denting & Painting": 8000,
            "ECU Tuning": 10000,
            "Wheel Alignment": 800,
            "Wheel Balancing": 600,
            "Deeper": 1000
        };

        // Default prices if not specified
        const defaultPrice = 1500;

        // Reference elements
        const wantField = document.getElementById('want');
        const quantityField = document.getElementById('quantity');
        const priceDisplay = document.getElementById('price-display');
        const priceField = document.getElementById('price');
        const minusBtn = document.querySelector('.minus-btn');
        const plusBtn = document.querySelector('.plus-btn');
        const vehicleTypeSelect = document.getElementById('select1');

        function updateServiceOptions() {
            const vehicleType = vehicleTypeSelect.value;
            const wantSelect = document.getElementById('want');
            const bikeOptgroup = wantSelect.querySelector('optgroup[label="Bike Specific Parts"]');
            
            if (vehicleType === "2 Wheelers HONDA") {
                bikeOptgroup.style.display = '';
                // Hide car-only options
                wantSelect.querySelectorAll('optgroup[label="Climate Control"], optgroup[label="Body Parts"]').forEach(group => {
                    group.style.display = 'none';
                });
            } else {
                bikeOptgroup.style.display = 'none';
                // Show car-only options
                wantSelect.querySelectorAll('optgroup[label="Climate Control"], optgroup[label="Body Parts"]').forEach(group => {
                    group.style.display = '';
                });
            }
        }

        function updatePrice() {
            const selectedService = wantField.value;
            const quantity = parseInt(quantityField.value) || 1;

            if (selectedService) {
                const unitPrice = servicePrices[selectedService] || defaultPrice;
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
        vehicleTypeSelect.addEventListener('change', updateServiceOptions);

        // Initialize the form
        updateServiceOptions();
        updatePrice();
    </script>
</body>
</html>