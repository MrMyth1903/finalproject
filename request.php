<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Page</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(120deg,rgb(129, 24, 115),rgb(133, 253, 197));
            color: #333;
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
        h1 {
            text-align: center;
            padding: 20px;
            margin-bottom: 20px;
            font-size: 38px;
            font-weight: bold;
            background: linear-gradient(120deg,rgb(226, 65, 15),rgb(226, 65, 15));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        section {
            margin: 20px auto;
            padding: 20px;
            max-width: 800px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .container div {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .inline-elements {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        label {
            font-weight: bold;
            color: #fff;
        }
        select, input, textarea {
            padding: 10px;
            font-size: 14px;
            border: none;
            border-radius: 10px;
            width: 100%;
            max-width: 300px;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        textarea {
            resize: none;
        }
        .submit-button {
            text-align: center;
            margin-top: 20px;
        }
        .submit-button button {
            background: linear-gradient(145deg, #ff9966, #ff5e62);
            border: none;
            border-radius: 25px;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        .submit-button button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
        }
        .price-display {
            font-weight: bold;
            font-size: 18px;
            color: #ff5e62;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<video class="background-video" autoplay muted loop>
    <source src="video/istockphoto-1680698591-640_adpp_is.mp4" type="video/mp4">
    Your browser does not support HTML5 video.
</video>

<h1>Request Page</h1>

<section>
<form action="php/service/servicedb.php" method="post">    
    <div class="container">
        <div class="inline-elements">
            <label for="select1">Vehicle Type:</label>
            <select id="select1" name="type">
                <option value="">Select...</option>
                <option value="2 Wheelers">2 Wheelers</option>
                <option value="4 Wheelers">4 Wheelers</option>
            </select>

            <label for="select2">Vehicle No:</label>
            <input type="text" name="vehicle_no" placeholder="Enter your vehicle number" required>

            <label for="select2">Phone No:</label>
            <input type="text" name="phone" placeholder="Enter your phone number" required>

            <label for="want">Sphere Parts:</label>
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

        <div class="inline-elements">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="1" min="1" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="4" cols="30" placeholder="Enter your address here..."></textarea>
        </div>
    </div>

    <!-- Price Display -->
    <div id="price-display" class="price-display"></div>

    <!-- Hidden Price Input -->
    <input type="hidden" id="price" name="price">

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

        function updatePrice() {
            const selectedService = wantField.value;
            const quantity = parseInt(quantityField.value) || 1;

            if (selectedService && servicePrices[selectedService]) {
                const unitPrice = servicePrices[selectedService];
                const totalPrice = unitPrice * quantity;

                // Display price
                priceDisplay.textContent = `Price for ${selectedService}: ₹${unitPrice} (Total Price: ₹${totalPrice})`;

                // Update hidden price field
                priceField.value = totalPrice;
            } else {
                priceDisplay.textContent = 'Please select a valid service';
                priceField.value = ''; // Clear price if no service is selected
            }
        }

        // Attach event listeners
        wantField.addEventListener('change', updatePrice);
        quantityField.addEventListener('input', updatePrice);

        // Initialize price calculation
        updatePrice();
    </script>

    <div class="submit-button">
        <button type="submit" name="submit">Submit</button>
    </div>
</form>
</section>
</body>
</html>
