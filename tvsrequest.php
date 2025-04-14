
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
            max-width: 1200px;
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
            color: #fff;
            font-size: 18px;
            margin-top: 10px;
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
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }
        
        .form-col {
            flex: 1;
            padding: 0 15px;
            min-width: 250px;
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
        
        .service-categories {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .category-tab {
            padding: 10px 20px;
            background-color: #f1f1f1;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .category-tab.active {
            background-color: var(--audi-red);
            color: white;
        }
        
        .service-category {
            display: none;
            margin-top: 20px;
        }
        
        .service-category.active {
            display: block;
        }
        
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .service-checkbox {
            margin-bottom: 10px;
        }
        
        .service-checkbox label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .service-checkbox input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            width: 150px;
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
            width: 70px;
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
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 16px;
            border-left: 4px solid var(--audi-red);
        }
        
        .price-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-weight: 600;
            font-size: 18px;
        }
        
        .selected-items {
            margin-top: 15px;
        }
        
        .selected-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #ddd;
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

        .search-box {
            margin-bottom: 20px;
            position: relative;
        }

        .search-box input {
            padding-left: 40px;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }

        .no-results {
            padding: 20px;
            text-align: center;
            color: #777;
        }
        .background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            opacity: 0.5;
        }
    </style>
</head>
<body>
<video class="background-video" id="bgVideo" autoplay muted loop>
        <source src="video/istockphoto-1680698591-640_adpp_is.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <div class="background-overlay"></div>
    
    <div class="container">
        <header>
            <img src="servicelogo/tVS.png" alt="Audi Logo" class="logo">
            <h1>TVS Service Request</h1>
            <p class="subtitle">Premium Service for Your Premium Vehicle</p>
        </header>
        
        <form action="php/service/servicedb.php" method="post" class="card">
            <div class="form-section">
                <h2>Vehicle Information</h2>
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="select1">Vehicle Type</label>
                            <select id="select1" name="type">
                                <option value="2 Wheelers TVS">TVS (2 Wheelers)</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="vehicle_no">Vehicle Number</label>
                            <input type="text" id="vehicle_no" name="vehicle_no" placeholder="Enter your vehicle number" required>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Contact Information</h2>
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email address" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Service Address</label>
                    <textarea id="address" name="address" placeholder="Enter your complete service address..." required></textarea>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Service Requirements</h2>
                
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="service-search" placeholder="Search for services or parts...">
                </div>
                
                <div class="service-categories">
                    <div class="category-tab active" data-category="engine">Engine</div>
                    <div class="category-tab" data-category="transmission">Transmission</div>
                    <div class="category-tab" data-category="brakes">Brakes</div>
                    <div class="category-tab" data-category="suspension">Suspension & Steering</div>
                    <div class="category-tab" data-category="electrical">Electrical</div>
                    <div class="category-tab" data-category="cooling">Cooling System</div>
                    <div class="category-tab" data-category="fuel">Fuel System</div>
                    <div class="category-tab" data-category="exhaust">Exhaust System</div>
                    <div class="category-tab" data-category="exterior">Exterior</div>
                    <div class="category-tab" data-category="interior">Interior</div>
                    <div class="category-tab" data-category="maintenance">Regular Maintenance</div>
                </div>
                
                <!-- Engine Category -->
                <div class="service-category active" id="engine-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Engine Control Module"> Engine Control Module</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Timing Belt Kit"> Timing Belt Kit</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Engine Mounts"> Engine Mounts</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Crankshaft Sensor"> Crankshaft Position Sensor</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Camshaft"> Camshaft</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Pistons"> Pistons</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Connecting Rods"> Connecting Rods</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Oil Pump"> Oil Pump</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Turbocharger"> Turbocharger</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Intercooler"> Intercooler</label>
                        </div>
                    </div>
                </div>
                
                <!-- Transmission Category -->
                <div class="service-category" id="transmission-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Transmission Assembly"> Transmission Assembly</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Clutch Kit"> Clutch Kit</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Flywheel"> Flywheel</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Transmission Fluid"> Transmission Fluid</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Gear Selector"> Gear Selector</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="DSG Mechatronic Unit"> DSG Mechatronic Unit</label>
                        </div>
                    </div>
                </div>
                
                <!-- Brakes Category -->
                <div class="service-category" id="brakes-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Brake Pads"> Brake Pads</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Brake Rotors"> Brake Rotors</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Brake Calipers"> Brake Calipers</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="ABS Control Module"> ABS Control Module</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Brake Lines"> Brake Lines</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Brake Master Cylinder"> Brake Master Cylinder</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Brake Shoe Change"> Brake Shoe Change</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Brake Issue"> Brake Issue</label>
                        </div>
                    </div>
                </div>
                
                <!-- Suspension Category -->
                <div class="service-category" id="suspension-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Shock Absorbers"> Shock Absorbers</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Struts"> Struts</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Control Arms"> Control Arms</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Tie Rods"> Tie Rods</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Sway Bar Links"> Sway Bar Links</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Ball Joints"> Ball Joints</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Steering Rack"> Steering Rack</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Power Steering Pump"> Power Steering Pump</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Wheel Bearings"> Wheel Bearings</label>
                        </div>
                    </div>
                </div>
                
                <!-- Electrical Category -->
                <div class="service-category" id="electrical-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Battery"> Battery</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Alternator"> Alternator</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Starter Motor"> Starter Motor</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Ignition Coils"> Ignition Coils</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Spark Plugs"> Spark Plugs</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Fuse Box"> Fuse Box</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Headlight Assembly"> Headlight Assembly</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Tail Light Assembly"> Tail Light Assembly</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Turn Signal Switch"> Turn Signal Switch</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Window Regulator"> Window Regulator</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="MMI Control Unit"> MMI Control Unit</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Head Light"> Head Light</label>
                        </div>
                    </div>
                </div>
                
                <!-- Cooling Category -->
                <div class="service-category" id="cooling-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Radiator"> Radiator</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Water Pump"> Water Pump</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Thermostat"> Thermostat</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Cooling Fan"> Cooling Fan</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Coolant Reservoir"> Coolant Reservoir</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Coolent Change"> Coolant Change</label>
                        </div>
                    </div>
                </div>
                
                <!-- Fuel Category -->
                <div class="service-category" id="fuel-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Fuel Pump"> Fuel Pump</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Fuel Injectors"> Fuel Injectors</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Fuel Filter"> Fuel Filter</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Fuel Pressure Regulator"> Fuel Pressure Regulator</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Diesel Tank"> Diesel Tank</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Mobile Tank"> Mobile Tank</label>
                        </div>
                    </div>
                </div>
                
                <!-- Exhaust Category -->
                <div class="service-category" id="exhaust-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Catalytic Converter"> Catalytic Converter</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Exhaust Manifold"> Exhaust Manifold</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Muffler"> Muffler</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Oxygen Sensor"> Oxygen Sensor</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Exhaust Pipes"> Exhaust Pipes</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Deeper"> Deeper</label>
                        </div>
                    </div>
                </div>
                
                <!-- Exterior Category -->
                <div class="service-category" id="exterior-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Front Bumper"> Front Bumper</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Rear Bumper"> Rear Bumper</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Hood"> Hood</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Trunk Lid"> Trunk Lid</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Doors"> Doors</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Fenders"> Fenders</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Grille"> Grille</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Side Mirrors"> Side Mirrors</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Windshield"> Windshield</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Tire Change"> Tire Change</label>
                        </div>
                    </div>
                </div>
                
                <!-- Interior Category -->
                <div class="service-category" id="interior-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Dashboard"> Dashboard</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Seats"> Seats</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Steering Wheel"> Steering Wheel</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Airbag Module"> Airbag Module</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Climate Control Unit"> Climate Control Unit</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Door Panels"> Door Panels</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Center Console"> Center Console</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Floor Mats"> Floor Mats</label>
                        </div>
                    </div>
                </div>
                
                <!-- Maintenance Category -->
                <div class="service-category" id="maintenance-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Mobil Change"> Oil Change</label>
                        </div>
                    </div>
                </div>
                
                <div id="search-results" class="service-category">
                    <div class="service-grid" id="search-results-grid">
                        <!-- Search results will appear here -->
                    </div>
                </div>
                
                <div class="form-group" style="margin-top: 30px;">
                    <label for="quantity">Quantity</label>
                    <div class="quantity-control">
                        <button type="button" class="quantity-btn minus-btn">-</button>
                        <input type="number" name="quantity" id="quantity" class="quantity-input" value="1" min="1" required>
                        <button type="button" class="quantity-btn plus-btn">+</button>
                    </div>
                </div>
                
                <div class="price-display" id="price-display">
                    <div class="selected-items" id="selected-items">
                        <div>Select services or parts to see the price</div>
                    </div>
                    <div class="price-summary">
                        <span>Total:</span>
                        <span id="total-price">₹0</span>
                    </div>
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
            
            &copy; <?php echo date('Y'); ?> TVS Service Center. All Rights Reserved.
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

            // Reference to category tabs
const categoryTabs = document.querySelectorAll('.category-tab');
const serviceCategories = document.querySelectorAll('.service-category');

// Function to handle category tab click
categoryTabs.forEach(tab => {
    tab.addEventListener('click', function() {
        // Remove active class from all tabs
        categoryTabs.forEach(t => t.classList.remove('active'));
        // Hide all service categories
        serviceCategories.forEach(category => category.classList.remove('active'));
        
        // Add active class to the clicked tab
        this.classList.add('active');
        
        // Show the corresponding service category
        const selectedCategory = this.getAttribute('data-category');
        document.getElementById(`${selectedCategory}-category`).classList.add('active');
    });
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
