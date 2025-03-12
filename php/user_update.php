<?php
include 'signup.php'; // Ensure database connection is established

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Fetch the current user details
    $query = "SELECT * FROM user WHERE id = $id";
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);
    
    if (!$user) {
        die("User not found.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $firstName = mysqli_real_escape_string($con, $_POST['FirstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['LastName']);
    $phone = mysqli_real_escape_string($con, $_POST['Phone']);
    $email = mysqli_real_escape_string($con, $_POST['Mail']);
    $password = mysqli_real_escape_string($con, $_POST['Password']);
    $dob = mysqli_real_escape_string($con, $_POST['DOB']);
    $city = mysqli_real_escape_string($con, $_POST['City']);

    // Update the user record
    $updateQuery = "UPDATE user SET FirstName='$firstName', LastName='$lastName', Phone='$phone', Mail='$email', Password='$password', DOB='$dob', City='$city' WHERE ID=$id";

    
    if (mysqli_query($con, $updateQuery)) {
        header("Location: adminindex.php?message=User updated successfully");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        input[type="text"], input[type="email"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        button:hover {
            background-color: #218838;
        }
        .back-link {
            display: block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit User Details</h2>
        <form method="POST" action="">
    <input type="hidden" name="id" value="<?= htmlspecialchars($user['ID']) ?>">
    <input type="text" name="FirstName" value="<?= htmlspecialchars($user['FirstName']) ?>" required placeholder="First Name">
    <input type="text" name="LastName" value="<?= htmlspecialchars($user['LastName']) ?>" required placeholder="Last Name">
    <input type="text" name="Phone" value="<?= htmlspecialchars($user['Phone']) ?>" required placeholder="Phone Number">
    <input type="email" name="Mail" value="<?= htmlspecialchars($user['Mail']) ?>" required placeholder="Email">
    <input type="text" name="Password" value="<?= htmlspecialchars($user['Password']) ?>" required placeholder="Password">
    <input type="date" name="DOB" value="<?= htmlspecialchars($user['DOB']) ?>" required>
    <input type="text" name="City" value="<?= htmlspecialchars($user['City']) ?>" required placeholder="City">
    <button type="submit">Update</button>
</form>

        
    </div>
</body>
</html>
