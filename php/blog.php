<?php
// Fetch posts from the database (assuming you have a database connection here)

// Sample connection (make sure to update with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch posts
$sql = "SELECT ID, TITLE, CONTENT, NAME, DATE, IMAGE FROM posts";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Blog with PHP</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }
        
        #posts-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            width: 100%;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .post {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .post:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .post h2 {
            color: #333;
        }
        .post p {
            color: #555;
        }
        .post img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
            object-fit: cover;
        }
        .post button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
            transition: background 0.3s;
        }
        .post button:hover {
            background: #45a049;
        }
        @media (max-width: 768px) {
            #posts-container {
                grid-template-columns: repeat(1, 1fr);
            }
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="main-content">
       <h1>Welcome to My Blog</h1>
            <div id="posts-container">
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="post">';
                        if (!empty($row['IMAGE'])) {
                            echo '<img src="' . htmlspecialchars($row['IMAGE']) . '" alt="Blog Image">';
                        }
                        echo '<p><strong>By ' . htmlspecialchars($row['NAME']) . '</strong> on ' . date('F j, Y', strtotime($row['DATE'])) . '</p>';
                        echo '<p>' . nl2br(htmlspecialchars($row['CONTENT'])) . '</p>';
                        echo '<form action="update_post.php" method="post" style="display:inline;">';
                        
                        echo '</form>';
                        echo '</div><hr>';
                    }
                } else {
                    echo '<p>No posts available.</p>';
                }
                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>
</html>