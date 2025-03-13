<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML Page with Sections</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(120deg, #f6d365, #fda085);
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
    .video-container {
        display: none;
    }
        h1 {
            text-align: center;
            padding: 20px;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        section {
            margin: 20px auto;
            padding: 20px;
            max-width: 800px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
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
            color: #555;
        }
        select, textarea {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 300px;
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
        .submit-button button:active {
            transform: translateY(0);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
<video class="background-video" id="bgVideo" autoplay muted loop>
        <source src="video/istockphoto-1680698591-640_adpp_is.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <br>
<h1> Request Page</h1>

<section >
<form action="php/service/servicedb.php" method="post">    
    <div class="container">
        <!-- First Div -->
        <div class="inline-elements">
            <label for="select1">Vehicle Type:</label>
            <select id="select1" name="type">
                <option value="">Select...</option>
                <option value="2 Wheelers">2 Wheelers</option>
                <option value="3 Wheelers">3 Wheelers</option>
                <option value="4 Wheelers">4 Wheelers</option>
            </select>

            <label for="select2">Vehicle No:</label>
          <input type="text" name="vehicle_no" placeholder="Enter your vehicle number" required>

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

                <script>
                    // Show or hide the "Other" text box when the "Other" option is selected
                    const wantField = document.getElementById('want');
                    const otherServiceField = document.getElementById('other-service');
            
                    wantField.addEventListener('change', function() {
                        if (wantField.value === 'Other') {
                            otherServiceField.style.display = 'block';  // Show the input box
                        } else {
                            otherServiceField.style.display = 'none';   // Hide the input box
                        }
                    });
            
                    // Initialize form with the "Other" service hidden
                    if (wantField.value !== 'Other') {
                        otherServiceField.style.display = 'none';
                    }
                </script>

            <label for="select3">Vendor:</label>
            <select id="select3" name="vendor">
                <option value="">Select...</option>
                <option value="option1"></option>
                <option value="option2"></option>
                <option value="option3"></option>
            </select>
        </div>

        <!-- Second Div -->
        <div class="inline-elements">
        <label for="address">Quantity:</label>
        <input type="text" name="quantity" placeholder="Enter your quantity" required>


            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="4" cols="30" placeholder="Enter your address here..."></textarea>
        </div>
    </div>


<div class="submit-button">
    <button type="submit" name="submit">Submit</button>
</div>
</form>
</section>
</body>
</html>
