<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "final";

$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Data for Editing
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    // Get the appointment data
    $sql = "SELECT * FROM appointment WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // If no record is found
    if ($result->num_rows == 0) {
        die("Appointment not found!");
    }
    
    $appointment = $result->fetch_assoc();
} else {
    die("No appointment ID provided!");
}

// Update Appointment Data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    // Check if form fields are set
    $id = $_POST["ID"];
    $service = $_POST["SERVICE"];
    $date = $_POST["DATE"];
    $time = $_POST["TIME"];
    $name = $_POST["NAME"];
    $vehicle_no = $_POST["VEHICLE_NO"];
    $want = $_POST["WANT"];
    $sphere_part = $_FILES["SPHERE_PART"]["name"];
    $phone_number = $_POST["PHONE_NUMBER"];
    
    // Ensure all required fields are filled
    if (!empty($id) && !empty($service) && !empty($date) && !empty($time) && !empty($name) && !empty($vehicle_no) && !empty($want) && !empty($phone_number)) {
        // File upload logic for SPHERE_PART
        if ($_FILES['SPHERE_PART']['error'] == 0) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["SPHERE_PART"]["name"]);
            move_uploaded_file($_FILES["SPHERE_PART"]["tmp_name"], $target_file);
        }

        // Update the database record
        $sql = "UPDATE appointment SET SERVICE=?, DATE=?, TIME=?, NAME=?, VEHICLE_NO=?, WANT=?, SPHERE_PART=?, PHONE_NUMBER=? WHERE ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $service, $date, $time, $name, $vehicle_no, $want, $sphere_part, $phone_number, $id);
        
        if ($stmt->execute()) {
            // Redirect to the adminIndex.php page after successful update
            header("Location: adminIndex.php");
            exit();
        } else {
            echo "<div class='error-message'>Error updating record: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='error-message'>Please fill all required fields.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment</title>
    <link rel="stylesheet" href="CSS/stud_reg.css">
    <style>
        /* Include the CSS styles from above here */
        /* General Styling */
body {
    font-family: 'Roboto', sans-serif;
    background-color: #f0f4f8;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}

h2 {
    color: #333;
    text-align: center;
    margin-bottom: 20px;
    font-size: 2.2em;
    font-weight: 600;
}

/* Form container with box shadow and rounded corners */
.form-container {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    padding: 40px;
    width: 100%;
    max-width: 650px;
    box-sizing: border-box;
    transition: transform 0.3s ease;
}

.form-container:hover {
    transform: translateY(-10px); /* Slight hover effect to lift the form */
}

/* Label styling */
label {
    font-weight: 600;
    margin-bottom: 5px;
    color: #444;
    font-size: 1.1rem;
    display: block;
}

/* Styling for inputs and text areas */
input[type="text"], input[type="email"], input[type="file"], textarea {
    width: 100%;
    padding: 14px;
    margin: 10px 0;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 1.1rem;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus, input[type="email"]:focus, textarea:focus {
    border-color: #4CAF50;
    outline: none;
}

/* Textarea styling */
textarea {
    resize: vertical;
    min-height: 120px;
}

/* Button styling */
button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 14px 0;
    font-size: 1.1rem;
    cursor: pointer;
    border-radius: 8px;
    width: 100%;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

button:hover {
    background-color: #45a049;
    transform: translateY(-2px);
}

/* Error and success messages */
.error-message, .success-message {
    text-align: center;
    padding: 12px;
    margin-top: 20px;
    border-radius: 8px;
    font-weight: bold;
    color: white;
    font-size: 1.1rem;
}

.error-message {
    background-color: #f44336;
}

.success-message {
    background-color: #4CAF50;
}

/* Custom styles for file input */
.form-container input[type="file"] {
    padding: 12px 14px;
    font-size: 1rem;
    border-radius: 8px;
    border: 1px solid #ddd;
    margin-top: 10px;
}

/* Add spacing between form elements */
.form-container label, .form-container input, .form-container textarea {
    margin-top: 12px;
}

/* Add subtle animations on load */
@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateY(10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-container {
    animation: fadeIn 0.6s ease-in-out;
}

    </style>
</head>
<body>

    <div class="form-container">
        <h2>Edit Appointment Information</h2>
        <!-- Display error/success message if needed -->
        <?php
        if (isset($error_message)) {
            echo "<div class='error-message'>$error_message</div>";
        } elseif (isset($success_message)) {
            echo "<div class='success-message'>$success_message</div>";
        }
        ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="ID" value="<?php echo htmlspecialchars($appointment['ID']); ?>">

            <label for="service">SERVICE:</label>
            <input type="text" id="SERVICE" name="SERVICE" value="<?php echo htmlspecialchars($appointment['SERVICE']); ?>" required>

            <label for="date">DATE:</label>
            <input type="text" id="DATE" name="DATE" value="<?php echo htmlspecialchars($appointment['DATE']); ?>" required>

            <label for="time">TIME:</label>
            <input type="text" id="TIME" name="TIME" value="<?php echo htmlspecialchars($appointment['TIME']); ?>" required>
           
            <label for="name">NAME:</label>
            <input type="text" id="NAME" name="NAME" value="<?php echo htmlspecialchars($appointment['NAME']); ?>" required>
            
            <label for="vehicle_no">VEHICLE NO:</label>
            <input type="text" id="VEHICLE_NO" name="VEHICLE_NO" value="<?php echo htmlspecialchars($appointment['VEHICLE_NO']); ?>" required>
            
            <label for="want">WANT:</label>
            <input type="text" id="WANT" name="WANT" value="<?php echo htmlspecialchars($appointment['WANT']); ?>" required>
            
            <label for="sphere_part">SPHERE PART (Upload if changes):</label>
            <input type="text" id="SPHERE_PART" name="SPHERE_PART">
            <small>Leave blank if no change is required.</small>

            <label for="phone_number">PHONE NUMBER:</label>
            <textarea id="PHONE_NUMBER" name="PHONE_NUMBER" required><?php echo htmlspecialchars($appointment['PHONE_NUMBER']); ?></textarea>

            <button type="submit" name="update">Update Appointment</button>
        </form>
    </div>

</body>
</html>

