<?php
$conn = mysqli_connect('localhost', 'root', '', 'final');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $name = trim($_POST['vendor_name']);
    $aadhar = trim($_POST['aadhaar']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Input Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!'); window.history.back();</script>";
        exit;
    }

    if (!preg_match('/^[0-9]{12}$/', $aadhar)) {
        echo "<script>alert('Invalid Aadhar number! It must be 12 digits.'); window.history.back();</script>";
        exit;
    }

    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo "<script>alert('Invalid phone number! It must be 10 digits.'); window.history.back();</script>";
        exit;
    }

    // Check for duplicate Aadhar, Email, or Phone
    $checkQuery = "SELECT 1 FROM vendor WHERE AADHAR_NO = ? OR EMAIL = ? OR PHONE = ?";
    $stmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($stmt, "sss", $aadhar, $email, $phone);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Vendor already exists!'); window.history.back();</script>";
    } else {
        // Insert new vendor using prepared statements
        $insertQuery = "INSERT INTO vendor (VEN_NAME, AADHAR_NO, EMAIL, ADDRESS, PHONE) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "sssss", $name, $aadhar, $email, $address, $phone);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Vendor successfully added');</script>";
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: adminindex.php");
            exit;
        } else {
            echo "<script>alert('Error adding vendor. Please try again.');</script>";
        }
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
