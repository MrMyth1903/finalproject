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
$sql = "SELECT * FROM posts";
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
            width: 80%;
            margin: 20px auto;
        }
        .main-content {
            display: flex;
            gap: 20px;
        }
        #posts-container {
            width: 70%;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .post {
            background: #fff;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .post h2 {
            color: #333;
        }
        .post p {
            color: #555;
        }
        .post button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
            transition: 0.3s;
        }
        .post button:hover {
            background: #45a049;
        }
        .sidebar {
            width: 30%;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .sidebar input, .sidebar textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .sidebar button {
            width: 100%;
            padding: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .sidebar button:hover {
            background: #45a049;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 1rem;
        }
        .right-header {
            margin-left: auto;
            display: flex;
            gap: 15px;
        }
        .right-header a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            padding: 8px 15px;
            background: linear-gradient(145deg, rgb(94, 165, 209), rgb(162, 96, 198));
            border-radius: 4px;
        }
        .right-header a:hover {
            background: linear-gradient(145deg, rgb(68, 152, 42), rgb(83, 165, 144));
        }
        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
            }
            #posts-container, .sidebar {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="main-content">
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
                        echo '<input type="hidden" name="post_id" value="' . $row['ID'] . '">';
                        echo '<button type="submit">Update</button>';
                        echo '</form>';
                        echo '<form action="delete_post.php" method="post" style="display:inline;">';
                        echo '<input type="hidden" name="post_id" value="' . $row['ID'] . '">';
                        echo '<button type="submit" onclick="return confirm(\'Are you sure you want to delete this post?\')">Delete</button>';
                        echo '</form>';
                        echo '</div><hr>';
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
    </div>
</body>
</html>
