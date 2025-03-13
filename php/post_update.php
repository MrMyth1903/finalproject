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
    $sql = "SELECT * FROM posts WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        die("Appointment not found!");
    }
    
    $appointment = $result->fetch_assoc();
} else {
    die("No appointment ID provided!");
}

// Update Appointment Data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id = $_POST["ID"];
    $service = $_POST["title"];
    $content = $_POST["content"];
    $name = $_POST["name"];
    
    // Handling Image Upload
    if (!empty($_FILES["image"]["name"])) {
        $image = "uploads/" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image);
    } else {
        // If no new image is uploaded, keep the old image
        $image = $appointment['IMAGE'];
    }

    // Ensure all required fields are filled
    if (!empty($id) && !empty($service) && !empty($content) && !empty($name)) {
        $sql = "UPDATE posts SET TITLE=?, IMAGE=?, CONTENT=?, NAME=? WHERE ID=?";
        $stmt = $conn->prepare($sql);
        
        // Fix: Ensure bind_param matches the placeholders (5 placeholders, 5 variables)
        $stmt->bind_param("ssssi", $service, $image, $content, $name, $id);
        
        if ($stmt->execute()) {
            header("Location: adminIndex.php"); // Redirect after successful update
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
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 650px;
            width: 100%;
            box-sizing: border-box;
            transition: transform 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-10px);
        }

        label {
            font-weight: 600;
            color: #444;
            font-size: 1.1rem;
            display: block;
        }

        input[type="text"], input[type="file"], textarea {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1.1rem;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, textarea:focus {
            border-color: #4CAF50;
            outline: none;
        }

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

        .form-container label, .form-container input, .form-container textarea {
            margin-top: 12px;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Edit Appointment Information</h2>
        
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="ID" value="<?php echo htmlspecialchars($appointment['ID']); ?>">

            <label for="service">SERVICE:</label>
            <input type="text" id="SERVICE" name="title" value="<?php echo htmlspecialchars($appointment['TITLE']); ?>" required>

            <label for="image">IMAGE:</label>
            <input type="file" id="IMAGE" name="image">
            <?php if (!empty($appointment['IMAGE'])): ?>
                <p>Current Image: <br><img src="<?php echo $appointment['IMAGE']; ?>" width="100"></p>
            <?php endif; ?>

            <label for="content">CONTENT:</label>
            <input type="text" id="CONTENT" name="content" value="<?php echo htmlspecialchars($appointment['CONTENT']); ?>" required>

            <label for="name">NAME:</label>
            <input type="text" id="NAME" name="name" value="<?php echo htmlspecialchars($appointment['NAME']); ?>" required>
            
            <button type="submit" name="update">Update Appointment</button>
        </form>
    </div>

</body>
</html>
