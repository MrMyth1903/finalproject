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

// Fetch Student Data for Editing
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    // Get student data
    $sql = "SELECT * FROM feedback WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // If student not found
    if ($result->num_rows == 0) {
        die("Student not found!");
    }
    
    $student = $result->fetch_assoc();
} else {
    die("No student ID provided!");
}

// Update Student Data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    // Check if form fields are set and not empty
    $id = isset($_POST["ID"]) ? $_POST["ID"] : '';
    $name = isset($_POST["NAME"]) ? $_POST["NAME"] : '';
    $email = isset($_POST["EMAIL"]) ? $_POST["EMAIL"] : '';
    $image = isset($_POST["IMAGE"]) ? $_POST["IMAGE"] : ''; // For file, ensure it's handled properly
    $feedback = isset($_POST["FEEDBACK"]) ? $_POST["FEEDBACK"] : '';

    // Make sure all required fields are filled in
    if (!empty($id) && !empty($name) && !empty($email) && !empty($feedback)) {
        // Update the student data in the database
        $sql = "UPDATE feedback SET NAME=?, EMAIL=?, IMAGE=?, FEEDBACK=? WHERE ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $image, $feedback, $id);
        
        if ($stmt->execute()) {
            // Redirect to the adminIndex.php page after successful update
            header("Location: adminIndex.php");
            exit(); // Make sure to call exit() to stop further script execution
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
    <title>Edit Student</title>
    <link rel="stylesheet" href="CSS/stud_reg.css"> <!-- Ensure CSS is correctly linked -->
    <style>
        /* General Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
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
            font-size: 2em;
        }

        .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 80%;
            max-width: 600px;
            box-sizing: border-box;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], input[type="email"], input[type="file"], textarea {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 1rem;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            min-height: 150px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 6px;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message, .success-message {
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
        }

        .form-container input[type="file"] {
            padding: 10px;
        }

    </style>
</head>
<body>

    <div class="form-container">
        <h2>Edit Student Information</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="ID" value="<?php echo isset($student['ID']) ? htmlspecialchars($student['ID']) : ''; ?>">

            <label for="name">Name:</label>
            <input type="text" id="name" name="NAME" value="<?php echo isset($student['NAME']) ? htmlspecialchars($student['NAME']) : ''; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="EMAIL" value="<?php echo isset($student['EMAIL']) ? htmlspecialchars($student['EMAIL']) : ''; ?>" required>

            <label for="image">Image:</label>
            <input type="file" id="image" name="IMAGE" value="<?php echo isset($student['IMAGE']) ? htmlspecialchars($student['IMAGE']) : ''; ?>">

            <label for="feedback">Feedback:</label>
            <textarea id="feedback" name="FEEDBACK" required><?php echo isset($student['FEEDBACK']) ? htmlspecialchars($student['FEEDBACK']) : ''; ?></textarea>

            <button type="submit" name="update">Update</button>
        </form>
    </div>

</body>
</html>
