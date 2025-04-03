<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'final');

// Check if connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Retrieve and sanitize form inputs
    $name = trim(mysqli_real_escape_string($conn, $_POST['vendor_name']));
    $aadhar = trim(mysqli_real_escape_string($conn, $_POST['aadhaar']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $phone = trim(mysqli_real_escape_string($conn, $_POST['phone']));
    $address = trim(mysqli_real_escape_string($conn, $_POST['address']));

    // Validate required fields
    if (empty($name) || empty($aadhar) || empty($email) || empty($phone) || empty($address)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit;
    }

    // Check for duplicate Aadhar or Email
    $checkQuery = "SELECT * FROM vendor WHERE AADHAR_NO = ? OR EMAIL = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $aadhar, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Error: Aadhar number or Email already exists!'); window.history.back();</script>";
        exit;
    } else {
        // Insert query using prepared statement
        $insertQuery = "INSERT INTO vendor (VEN_NAME, AADHAR_NO, EMAIL, ADDRESS, PHONE) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssss", $name, $aadhar, $email, $address, $phone);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Vendor added successfully!'); window.location.href='adminindex.php';</script>";
            exit;
        } else {
            echo "<script>alert('Error inserting vendor: " . $stmt->error . "'); window.history.back();</script>";
            exit;
        }
    }

    // Close the statement and connection
    $stmt->close();
}

mysqli_close($conn);
?>
