<?php
$con = mysqli_connect('localhost', 'root', '', 'final');

if (isset($_POST['submit'])) {
    $NAME = mysqli_real_escape_string($con, $_POST['name']);
    $EMAIL = mysqli_real_escape_string($con, $_POST['email']);
    $FEEDBACK = mysqli_real_escape_string($con, $_POST['feedback']);

    $IMAGE = ""; // Default image path

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $filename = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $filename;

        // Optionally check file type here (jpg/png etc.)
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        $IMAGE = $filename; // Save only the filename in DB
    }

    $stmt = "INSERT INTO feedback(NAME, EMAIL, IMAGE, FEEDBACK) VALUES('$NAME', '$EMAIL', '$IMAGE', '$FEEDBACK')";
    mysqli_query($con, $stmt);

    echo "<script>alert('Thank you for your feedback!');</script>";
    header('refresh:1; url=../index.php');
}
?>
