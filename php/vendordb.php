<?php
$conn = mysqli_connect('localhost', 'root', '', 'final');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $aadhar = $_POST['aadhar_no'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Check for duplicate Aadhar, Email, or Phone
    $checkQuery = "SELECT * FROM vendor WHERE AADHAR_NO = ? OR EMAIL = ? OR PHONE = ?";
    $stmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($stmt, "sss", $aadhar, $email, $phone);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Vendor already exists!');</script>";
    } else {
        // Insert new vendor using prepared statements
        $insertQuery = "INSERT INTO vendor (VEN_NAME, AADHAR_NO, EMAIL, ADDRESS, PHONE) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "sssss", $name, $aadhar, $email, $address, $phone);
        $run = mysqli_stmt_execute($stmt);

        if ($run) {
            echo"<script>alert('Vendor successfully added');</script>";
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
