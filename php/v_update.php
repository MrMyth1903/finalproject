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
    $level = $_POST["LEVEL"];
    $service = $_POST["SERVICE"];
    $time = $_POST["TIME"];
    $date = $_POST["DATE"];
    $name = $_POST["NAME"];
    $email = $_POST["EMAIL"];
    $vehicle_no = $_POST["VEHICLE_NO"];
    $enginee = $_POST["ENGINEE"];
    $chasis = $_POST["CHASIS"];
    $price = $_POST["PRICE"];
    $phone_number = $_POST["PHONE_NUMBER"];
    $sphere_part = $_FILES["SPHERE_PART"]["name"] ? $_FILES["SPHERE_PART"]["name"] : $appointment["SPHERE_PART"];
    
    // Ensure all required fields are filled
    if (!empty($id) && !empty($service) && !empty($date) && !empty($time) && !empty($name) && !empty($vehicle_no) && !empty($phone_number)) {
        // File upload logic for SPHERE_PART
        if ($_FILES['SPHERE_PART']['error'] == 0) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["SPHERE_PART"]["name"]);
            move_uploaded_file($_FILES["SPHERE_PART"]["tmp_name"], $target_file);
        }

        // Update the database record
        $sql = "UPDATE appointment SET LEVEL=?, SERVICE=?, TIME=?, DATE=?, NAME=?, EMAIL=?, VEHICLE_NO=?, ENGINEE=?, CHASIS=?, PRICE=?, SPHERE_PART=?, PHONE_NUMBER=? WHERE ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssssi", $level, $service, $time, $date, $name, $email, $vehicle_no, $enginee, $chasis, $price, $sphere_part, $phone_number, $id);
        
        if ($stmt->execute()) {
            $success_message = "Appointment updated successfully!";
            // Redirect after 1 second
            header("refresh:1;url=adminIndex.php");
        } else {
            $error_message = "Error updating record: " . $conn->error;
        }
    } else {
        $error_message = "Please fill all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment | Meri Gaddi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        :root {
            --primary: #3a36db;
            --primary-light: #5552e4;
            --primary-dark: #2d2bb0;
            --secondary: #ff9800;
            --text-dark: #333;
            --text-light: #666;
            --bg-light: #f8f9fa;
            --border-light: #e0e0e0;
            --white: #ffffff;
            --success: #28a745;
            --danger: #dc3545;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: var(--text-dark);
        }
        
        .page-container {
            width: 100%;
            max-width: 800px;
            margin: 40px auto;
        }
        
        .form-container {
            background-color: var(--white);
            border-radius: 16px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            padding: 25px 30px;
            position: relative;
            text-align: center;
        }
        
        .form-header h2 {
            font-size: 1.8rem;
            font-weight: 600;
            margin: 0;
        }
        
        .form-header p {
            opacity: 0.8;
            margin-top: 5px;
            font-weight: 300;
        }
        
        .form-body {
            padding: 30px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-dark);
            font-size: 0.9rem;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            font-size: 1rem;
            border: 1px solid var(--border-light);
            border-radius: 8px;
            background-color: var(--bg-light);
            transition: all 0.3s ease;
            color: var(--text-dark);
            font-family: 'Poppins', sans-serif;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(58, 54, 219, 0.1);
            outline: none;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-with-icon .form-control {
            padding-left: 40px;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border: none;
            padding: 14px 20px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            box-shadow: 0 4px 10px rgba(58, 54, 219, 0.2);
            width: 100%;
            margin-top: 10px;
        }
        
        .btn:hover {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(58, 54, 219, 0.3);
        }
        
        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 15px;
        }
        
        .btn-secondary {
            background: #6c757d;
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.2);
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            box-shadow: 0 6px 15px rgba(108, 117, 125, 0.3);
        }
        
        .message {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        
        .message i {
            margin-right: 10px;
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .file-input-container {
            position: relative;
            overflow: hidden;
        }
        
        .file-input-container input[type="file"] {
            position: absolute;
            font-size: 100px;
            opacity: 0;
            right: 0;
            top: 0;
            cursor: pointer;
        }
        
        .file-input-label {
            display: inline-block;
            background-color: var(--bg-light);
            color: var(--text-dark);
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid var(--border-light);
            cursor: pointer;
            width: 100%;
            text-align: left;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .file-input-label i {
            margin-right: 10px;
            color: var(--primary);
        }
        
        .help-text {
            font-size: 0.8rem;
            color: var(--text-light);
            margin-top: 5px;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-container {
                margin: 10px;
            }
            
            .form-header {
                padding: 20px;
            }
            
            .form-body {
                padding: 20px;
            }
            
            .btn-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="page-container">
    <div class="form-container">
        <div class="form-header">
            <h2><i class="fas fa-calendar-edit"></i> Edit Appointment</h2>
            <p>Update vehicle service appointment details</p>
        </div>
        
        <div class="form-body">
            <?php if(isset($error_message)): ?>
                <div class="message error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($success_message)): ?>
                <div class="message success-message">
                    <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="ID" value="<?php echo htmlspecialchars($appointment['ID']); ?>">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="LEVEL"><i class="fas fa-layer-group"></i> Service Level</label>
                        <div class="input-with-icon">
                            <i class="fas fa-layer-group input-icon"></i>
                            <input type="text" id="LEVEL" name="LEVEL" class="form-control" value="<?php echo htmlspecialchars($appointment['LEVEL']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="SERVICE"><i class="fas fa-tools"></i> Service Type</label>
                        <div class="input-with-icon">
                            <i class="fas fa-tools input-icon"></i>
                            <input type="text" id="SERVICE" name="SERVICE" class="form-control" value="<?php echo htmlspecialchars($appointment['SERVICE']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="DATE"><i class="fas fa-calendar"></i> Appointment Date</label>
                        <div class="input-with-icon">
                            <i class="fas fa-calendar input-icon"></i>
                            <input type="date" id="DATE" name="DATE" class="form-control" value="<?php echo htmlspecialchars($appointment['DATE']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="TIME"><i class="fas fa-clock"></i> Appointment Time</label>
                        <div class="input-with-icon">
                            <i class="fas fa-clock input-icon"></i>
                            <input type="time" id="TIME" name="TIME" class="form-control" value="<?php echo htmlspecialchars($appointment['TIME']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="NAME"><i class="fas fa-user"></i> Customer Name</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" id="NAME" name="NAME" class="form-control" value="<?php echo htmlspecialchars($appointment['NAME']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="EMAIL"><i class="fas fa-envelope"></i> Email Address</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="EMAIL" name="EMAIL" class="form-control" value="<?php echo htmlspecialchars($appointment['EMAIL']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="VEHICLE_NO"><i class="fas fa-car"></i> Vehicle Number</label>
                        <div class="input-with-icon">
                            <i class="fas fa-car input-icon"></i>
                            <input type="text" id="VEHICLE_NO" name="VEHICLE_NO" class="form-control" value="<?php echo htmlspecialchars($appointment['VEHICLE_NO']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="PHONE_NUMBER"><i class="fas fa-phone"></i> Contact Number</label>
                        <div class="input-with-icon">
                            <i class="fas fa-phone input-icon"></i>
                            <input type="text" id="PHONE_NUMBER" name="PHONE_NUMBER" class="form-control" value="<?php echo htmlspecialchars($appointment['PHONE_NUMBER']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="ENGINEE"><i class="fas fa-cogs"></i> Engine Number</label>
                        <div class="input-with-icon">
                            <i class="fas fa-cogs input-icon"></i>
                            <input type="text" id="ENGINEE" name="ENGINEE" class="form-control" value="<?php echo htmlspecialchars($appointment['ENGINEE']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="CHASIS"><i class="fas fa-fingerprint"></i> Chassis Number</label>
                        <div class="input-with-icon">
                            <i class="fas fa-fingerprint input-icon"></i>
                            <input type="text" id="CHASIS" name="CHASIS" class="form-control" value="<?php echo htmlspecialchars($appointment['CHASIS']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="PRICE"><i class="fas fa-rupee-sign"></i> Service Price</label>
                        <div class="input-with-icon">
                            <i class="fas fa-rupee-sign input-icon"></i>
                            <input type="text" id="PRICE" name="PRICE" class="form-control" value="<?php echo htmlspecialchars($appointment['PRICE']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="PRICE"><i class="fas fa-rupee-sign"></i> Sphere Parts</label>
                        <div class="input-with-icon">
                            <i class="fas fa-rupee-sign input-icon"></i>
                            <input type="text" id="SPHERE_PART" name="SPHERE_PART" class="form-control" value="<?php echo htmlspecialchars($appointment['SPHERE_PART']); ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="btn-container">
                    <a href="adminIndex.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to List</a>
                    <button type="submit" name="update" class="btn"><i class="fas fa-save"></i> Update Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>