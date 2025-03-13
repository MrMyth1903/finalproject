<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch posts
$sql = "SELECT * FROM posts ORDER BY DATE DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Blog with PHP</title>
    <link rel="stylesheet" href="admin/css/post.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            display: flex;
            gap: 20px;
        }
        .main-content {
            width: 70%;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .post {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .post img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .post h2 {
            color: #333;
            margin-top: 10px;
        }
        .post p {
            color: #555;
            font-size: 14px;
        }
        .post .btn {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn.edit {
            background: #4CAF50;
            color: white;
        }
        .btn.edit:hover {
            background: #45a049;
        }
        .btn.delete {
            background: #f44336;
            color: white;
        }
        .btn.delete:hover {
            background: #e53935;
        }
        .sidebar {
            width: 30%;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }
        .sidebar h3 {
            text-align: center;
            color: #333;
        }
        .sidebar input, .sidebar textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .sidebar button {
            width: 100%;
            padding: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
        }
        .sidebar button:hover {
            background: #45a049;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .main-content {
                grid-template-columns: 1fr;
                width: 100%;
            }
            .sidebar {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="main-content">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="post">';
                    if (!empty($row['IMAGE'])) {
                        echo '<img src="' . htmlspecialchars($row['IMAGE']) . '" alt="Blog Image">';
                    }
                    echo '<h2>' . htmlspecialchars($row['TITLE']) . '</h2>';
                    echo '<p><strong>By ' . htmlspecialchars($row['NAME']) . '</strong> on ' . date('F j, Y', strtotime($row['DATE'])) . '</p>';
                    echo '<p>' . nl2br(htmlspecialchars($row['CONTENT'])) . '</p>';
                    echo '<a href="post_update.php?id=' . $row['ID'] . '"><button class="btn edit">Edit</button></a>';
                    echo '<a href="post_delete.php?id=' . $row['ID'] . '" onclick="return confirm(\'Are you sure you want to delete this post?\');"><button class="btn delete">Delete</button></a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No posts available.</p>';
            }
            $conn->close();
            ?>
        </div>
        
        <aside class="sidebar">
            <h3>Add a New Post</h3>
            <form action="postdb.php" method="post" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Post Title" required>
                <textarea name="content" placeholder="Post Content" required></textarea>
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="file" name="image" accept="image/*">
                <button type="submit">Add Post</button>
            </form>
        </aside>
    </div>
</body>
</html>
